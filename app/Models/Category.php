<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'parent_id', 'description', 'status', 'slug', 'image',
    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                // function($attribute,$value,$fails){
                //     if(strtolower($value)=='laravel'){
                //         $fails('this value is not allowed');
                //     }
                // },
                // new Filter(['laravel','php','html']),
                'filter:laravel,php,html',
            ],
            'parent_id' => [
                'nullable', 'int', 'exists:categories,id'
            ],
            'image' => [
                'image', 'max:10485765', 'dimensions:min_width=100,min_height=100',
            ],
            'status' => 'in:active,archived',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault([
                'name' => '-'
            ]);
    }

    public function childern()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
