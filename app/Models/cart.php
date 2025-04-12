<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $fillable = ['user_id', 'product_id', 'type', 'quantity', 'itemTotal'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    // العلاقة مع الباكدج
    public function package()
    {
        return $this->belongsTo(Package::class, 'product_id');
    }
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}