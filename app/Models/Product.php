<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name', 'description', 'price', 'old_price', 'discount', 'category_id'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'product_id', 'id');
    }

    // public function packages()
    // {
    //     return $this->belongsToMany(Package::class, 'package_products');
    // }
}
