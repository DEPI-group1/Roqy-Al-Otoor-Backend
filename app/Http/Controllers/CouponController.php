<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Category;
use App\Models\Product;
use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $coupons = Coupon::all();
        $coupons = Coupon::all()->map(function ($coupon) {
            $coupon->category_name = $coupon->category_id ? Category::where('id', $coupon->category_id)->value('name') : 'No';
            return $coupon;
        });

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.coupons.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons|max:255',
            'discount_type' => 'required|in:fixed,percentage',
            'fixed_amount' => 'nullable|numeric|required_if:discount_type,fixed',
            'discount_percentage' => 'nullable|numeric|required_if:discount_type,percentage',
            'max_discount_amount' => 'nullable|numeric|required_if:discount_type,percentage',
            'category_id' => 'nullable|numeric',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);

        // إذا فشل التحقق من الصحة، يتم إرجاع الأخطاء
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // إنشاء كوبون جديد
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;

        if ($request->discount_type == 'fixed') {
            $coupon->fixed_amount = $request->fixed_amount;
        } else {
            $coupon->discount_percentage = $request->discount_percentage;
            $coupon->max_discount_amount = $request->max_discount_amount;
        }
        $coupon->category_id = $request->category_id;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->expires_at = $request->expires_at;
        $coupon->save();
        // dd($coupon);
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('coupons.index')->with('success', 'تم إنشاء الكوبون بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:255|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:fixed,percentage',
            'fixed_amount' => 'nullable|numeric|required_if:discount_type,fixed',
            'discount_percentage' => 'nullable|numeric|required_if:discount_type,percentage',
            'max_discount_amount' => 'nullable|numeric|required_if:discount_type,percentage',
            'usage_limit' => 'nullable|integer',
            'expires_at' => 'nullable|date',
        ]);

        // إذا فشل التحقق من الصحة، يتم إرجاع الأخطاء
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // تحديث بيانات الكوبون
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;

        if ($request->discount_type == 'fixed') {
            $coupon->fixed_amount = $request->fixed_amount;
            $coupon->discount_percentage = null;
            $coupon->max_discount_amount = null;
        } else {
            $coupon->discount_percentage = $request->discount_percentage;
            $coupon->max_discount_amount = $request->max_discount_amount;
            $coupon->fixed_amount = null;
        }

        $coupon->usage_limit = $request->usage_limit;
        $coupon->expires_at = $request->expires_at;
        $coupon->save();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('admin.coupons.index')->with('success', 'تم تحديث الكوبون بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'تم حذف الكوبون بنجاح!');
    }


    public function applyCoupon(Request $request)
    {
        $user = Auth::user();  // التحقق من المستخدم عبر التوكن
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على التوكن، الرجاء تسجيل الدخول'
            ], 401);
        }

        // التحقق من وجود الكوبون
        $coupon = Coupon::where('code', $request->coupon)
            ->where('expires_at', '>=', Carbon::now())  // تحقق من أن الكوبون لم ينتهِ
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'الكوبون غير صالح   .']);
        }

        // التحقق إذا كان المستخدم قد استخدم الكوبون سابقًا
        $usedBefore = CouponUsage::where('coupon_id', $coupon->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($usedBefore) {
            return response()->json(['success' => false, 'message' => 'لقد قمت باستخدام هذا الكوبون من قبل.']);
        }

        // التحقق من عدد الاستخدامات المسموح بها
        $usageCount = CouponUsage::where('coupon_id', $coupon->id)
            ->where('user_id', Auth::id())
            ->count();

        if ($coupon->usage_limit && $usageCount >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'لقد قمت باستخدام هذا الكوبون من قبل.']);
        }

        // التحقق من نوع الخصم
        $discount = 0;

        if ($coupon->discount_type == 'fixed') {
            $discount = $coupon->fixed_amount;
        } elseif ($coupon->discount_type == 'percentage') {
            $discount = ($request->subtotal * $coupon->discount_percentage) / 100;
            // التحقق من الحد الأقصى للخصم
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }
        }

        // حفظ استخدام الكوبون في جدول `coupon_usage`
        DB::table('coupon_usage')->insert([
            'user_id' => Auth::id(),
            'coupon_id' => $coupon->id,
            'used_at' => now(),
            'original_price' => $request->subtotal,  // حفظ السعر الأصلي
            'discount_value' => $discount,  // حفظ قيمة الخصم
            'final_price' => $request->subtotal - $discount,  // حفظ السعر النهائي بعد الخصم
            'created_at' => now()
        ]);

        // التحقق من انتهاء صلاحية الكوبون بعد حفظه في `coupon_usage`
        if (Carbon::now()->gt($coupon->expires_at)) {
            // إلغاء الخصم لأنه انتهت صلاحيته
            DB::table('coupon_usage')->where('user_id', Auth::id())
                ->where('coupon_id', $coupon->id)
                ->delete();
            return response()->json(['success' => false, 'message' => 'الكوبون انتهت صلاحيته.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق الكوبون بنجاح.',
            'discount' => $discount
        ]);
    }

    // التحقق من صلاحية الكوبون
    public function validateCoupon($couponCode)
    {
        // تحقق من وجود الكوبون وصلاحية التاريخ
        $coupon = Coupon::where('code', $couponCode)
            ->where('expires_at', '>=', Carbon::now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'تم إلغاء الكوبون بسبب انتهاء صلاحيته أو عدم وجوده.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'الكوبون صالح.',
            'discount_type' => $coupon->discount_type,
            'discount' => $coupon->discount_type == 'fixed'
                ? $coupon->fixed_amount
                : $coupon->discount_percentage,
        ]);
    }
}