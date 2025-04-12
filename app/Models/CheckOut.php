<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    //
    protected $fillable = [
        'user_id',
        'user_name',
        'email',
        'phone_number',
        'payment_status',
        'payment_method',
        'order_status',
        'total_amount',
        'governorate',
        'city',
        'village',
        'shipping_address',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
