<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\OrderItems;
use App\Models\Order;
use App\Models\User;
use App\Http\Controllers\PaymobController;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;


// 
class CheckOutController extends Controller
{


    // public function index()
    // {
    //     $user = auth::user();
    //     $nameParts = explode(' ', trim($user->name));
    //     $first_name = isset($nameParts[0]) ? $nameParts[0] : '';
    //     $first_name .= isset($nameParts[1]) ? ' ' . $nameParts[1] : '';
    //     $last_name = isset($nameParts[2]) ? implode(' ', array_slice($nameParts, 2)) : '';

    //     // جلب عناصر العربة مع المنتجات والباكدجات
    //     $cartItems = Cart::where('user_id', $user->id)
    //         ->with(['product.images', 'package.images', 'offer']) // جلب المنتجات والباكدجات مع الصور
    //         ->get();

    //     // حساب السعر الإجمالي قبل الخصم
    //     $totalPrice = $cartItems->sum(function ($item) {
    //         return $item->product ? $item->product->price * $item->quantity : $item->package->price * $item->quantity;
    //     });


    //     return view('user.check-out', compact('cartItems', 'user', 'first_name', 'last_name'))->with('title', 'اتمام الطلب');
    // }
}




// 
        // تطبيق الكوبون لو موجود
        // $discount = session('applied_coupon')['discount'] ?? 0;
        // $finalTotal = $totalPrice - $discount; // إجمالي السعر بعد الخصم

        // session([
        //     'applied_coupon' => [
        //         'discount' => $discount,
        //         'final_total' => $finalTotal,
        //         'expires_at' => now()->addMinutes(30) // ينتهي بعد 30 دقيقة
        //     ]
        // ]);
        // بعد نجاح الدفع مباشرة
        // session()->forget('applied_coupon');