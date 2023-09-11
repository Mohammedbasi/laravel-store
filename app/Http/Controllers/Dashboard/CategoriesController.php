<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        $request = request();

        $categories = Category::with('parent')
            /*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])*/
            ->withCount([
                'products as products_number' => function ($query) {
                    $query->where('status', '=', 'active');
                }
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('categories.create')) {
            abort(403);
        }
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('categories.create')) {
            abort(403);
        }

        $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) is required',
            'name.unique' => 'The name is exist',
        ]);

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        $category = Category::create($data);
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }

        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');
        try {
            $category = Category::findOrfail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')
                ->with('info', 'Page Not Found');
        }
        // select * from category where id <> id AND parent_id <> id or parent_id ISNULL
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            })
            ->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrfail($id);

        $old_image = $category->image;

        $data = $request->except('image');
        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }
        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }




        // $category->fill($request->all())->save();
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');

        $category = Category::findOrfail($id);
        $category->delete();



        // Category::where('id','=',$id)->delete();

        //Category::destroy($id);
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category Deleted!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public',
        ]);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(string $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category restored');
    }

    public function forceDelete(Request $request, string $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('success', 'Category deleted forever');
    }
}
