<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ];

    protected $hidden = [
        'image',
        'created_at', 'updated_at', 'deleted_at',
    ];

    // relation /////////////////////////////////////

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    // end relation //////////////////////////////////


    // scops

    function scopeActive(Builder $builder) {
        $builder->where('status','active') ;
    }

    // end scops

    // observer for creating slug

    protected static function booted(){
        static::creating(function(Product $product){
            $product->slug = STR::slug($product->name);
        });
    }

    // end observer for creating slug


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


    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['category_id'], function($builder, $value) {
            $builder->where('category_id', $value);
        });

    }
}
