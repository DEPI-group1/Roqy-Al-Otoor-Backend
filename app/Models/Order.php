<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'mid',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'governorate',
        'city',
        'village',
        'shipping_address',
        'payment_method',
        'payment_status',
        'order_status',
        'total_amount',
        'created_at',
        'updated_at',
    ];


    // Eloquent Relationshp
    // One Order has on item or more
    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id');
    }

    // public function user()
    // {
    //     return $this->hasMany(User::class, 'foreign_key', 'local_key');
    // }
    // protected $fillable = ['user_id', 'user_name', 'email', 'phone_number', 'payment_status', 'order_status', 'total_amount', 'governorate', 'city', 'village', 'shipping_address'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
