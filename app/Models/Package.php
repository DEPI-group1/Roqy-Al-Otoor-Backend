<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'detailed_description', 'components', 'Usage_method', 'price', 'old_price', 'status'];

    public function images()
    {
        return $this->hasMany(PackageImages::class, 'package_id');
    }
    // العلاقة بين الباكدج والعربة
    public function carts()
    {
        return $this->hasMany(Cart::class, 'package_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class, 'package_id', 'id');
    }
}