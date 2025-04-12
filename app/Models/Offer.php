<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'old_price',
        'expiry_date',
        'images',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'offer_id');
    }
}