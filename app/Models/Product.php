<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'category_id', 'name', 'slug',
        'description', 'image', 'price', 'compare_price',
        'options', 'featured', 'rating', 'status'
    ];

    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);
            }
        });
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag', // pivot table
            'product_id',  // FK in pivot, of the current model
            'tag_id',      // FK in pivot, of the related model  
            'id',          // PK of current
            'id'           // PK of related
        );
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute(){

        if(!$this->compare_price){
            return 0;
        }

        return round(100 - ( 100 * $this->price / $this->compare_price),1);
    }
}
