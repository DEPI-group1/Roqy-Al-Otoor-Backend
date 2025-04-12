<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_data',
        'cart_items',
        'final_total',
        'order_reference',
    ];

    protected $casts = [
        'customer_data' => 'array',
        'cart_items' => 'array',
    ];
}
