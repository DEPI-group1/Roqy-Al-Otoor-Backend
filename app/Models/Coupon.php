<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount_type',
        'fixed_amount',
        'discount_percentage',
        'max_discount_amount',
        'category_id',
        'usage_limit',
        'status',
        'expires_at',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }

    // علاقة بالفئات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}