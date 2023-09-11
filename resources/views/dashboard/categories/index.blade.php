@extends('layouts.dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Categories</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="mb-2 ml-3">
        @if (Auth::user()->can('categories.create'))
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-primary ml-3">New</a>
        @endif
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-dark">Trash</a>
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>

        <button class="btn btn-dark mx-2">Filter</button>

    </form>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Parent</th>
                <th>Products #</th>
                <th>Created_at</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td> <img height="60" src="{{ asset('storage/' . $category->image) }}" alt=""> </td>
                    <td>{{ $category->id }}</td>
                    <td> <a href="{{ route('dashboard.categories.show', $category->id) }}"> {{ $category->name }}</a></td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->parent->name }}</td>
                    <td> {{ $category->products_number }} </td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        @can('categories.update')
                            <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('categories.delete')
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No categories defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection
