<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;    //
    protected $fillable = ['name', 'description', 'image'];
    // علاقة بين الفئة والمنتجات (One To Many)
    public function products()
    {
        return $this->hasMany(product::class);
    }

    public function images()
    {
        return $this->hasMany(images::class);
    }
}
