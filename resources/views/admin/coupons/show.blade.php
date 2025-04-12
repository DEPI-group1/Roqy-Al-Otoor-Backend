@extends('layouts.sideBar')
@section('title', $coupon->code)

@section('content')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-50 to-blue-100 p-6">
    <div class="bg-white shadow-2xl rounded-xl p-8 w-full max-w-lg relative overflow-hidden">
        <!-- ديكور خلفي -->
        <div class="absolute inset-0 bg-blue-500 opacity-10 rounded-xl"></div>

        <!-- عنوان الصفحة -->
        <h2 class="text-3xl font-bold text-blue-600 text-center mb-6">تفاصيل الكوبون</h2>

        <!-- أيقونة الكوبون -->
        <div class="flex justify-center mb-4">
            <div class="bg-blue-100 text-blue-600 p-4 rounded-full shadow-md">
                🏷️
            </div>
        </div>

        <!-- بيانات الكوبون -->
        <div class="space-y-5 relative z-10">
            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-gray-600 font-semibold flex items-center gap-2">
                    🔖 كود الكوبون:
                </span>
                <span class="text-gray-800 font-bold bg-gray-200 px-3 py-1 rounded">
                    {{ $coupon->code }}
                </span>
            </div>

            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-gray-600 font-semibold flex items-center gap-2">
                    💰 نوع الخصم:
                </span>
                <span class="text-gray-800">{{ $coupon->discount_type }}</span>
            </div>

            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-gray-600 font-semibold flex items-center gap-2">
                    💵 قيمة الخصم:
                </span>
                <span class="text-gray-800">{{ $coupon->fixed_amount }} جنيه</span>
            </div>

            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-gray-600 font-semibold flex items-center gap-2">
                    🔢 عدد مرات الاستخدام:
                </span>
                <span class="text-gray-800">{{ $coupon->usage_limit }}</span>
            </div>

            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-gray-600 font-semibold flex items-center gap-2">
                    ⏳ تاريخ الانتهاء:
                </span>
                <span class="text-red-600 font-semibold">{{ $coupon->expires_at }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-gray-600 font-semibold flex items-center gap-2">
                    🏷️ الفئة:
                </span>
                <span class="text-gray-800">{{ $coupon->category ? $coupon->category->name : 'غير محددة' }}</span>
            </div>
        </div>

        <!-- أزرار التحكم -->
        <div class="flex justify-between mt-8">
            <a href="{{ route('coupons.edit', $coupon) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg flex items-center gap-2 transition">
                ✏️ تعديل
            </a>

            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg flex items-center gap-2 transition">
                    🗑 حذف
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
