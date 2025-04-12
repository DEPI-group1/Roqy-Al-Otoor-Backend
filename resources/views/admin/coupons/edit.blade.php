{{-- @extends('layouts.sideBar')
@section('title', 'الفئات')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">

            <h2 class="text-lg font-bold">Create New Coupon</h2>
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                @csrf

                <label for="code" class="block">Coupon Code</label>
                <input type="text" name="code" required class="w-full p-2 border border-gray-300 rounded">

                <label for="discount" class="block">Discount</label>
                <input type="number" name="discount" required class="w-full p-2 border border-gray-300 rounded">

                <label for="type" class="block">Discount Type</label>
                <select name="type" required class="w-full p-2 border border-gray-300 rounded">
                    <option value="fixed">Fixed Amount</option>
                    <option value="percentage">Percentage</option>
                </select>

                <label for="usage_limit" class="block">Usage Limit (Optional)</label>
                <input type="number" name="usage_limit" class="w-full p-2 border border-gray-300 rounded">

                <label for="expires_at" class="block">Expiration Date (Optional)</label>
                <input type="date" name="expires_at" class="w-full p-2 border border-gray-300 rounded">

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            </form>

        </div>
    </div>
@endsection --}}
{{-- ----------------------------------------------------- --}}

@extends('layouts.sideBar')
@section('title', 'الكوبونات')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-bold">إنشاء كوبون جديد</h2>
            <form action="{{ route('coupons.store') }}" method="POST" class="space-y-4">
                @csrf

                <label for="code" class="block">كود الكوبون</label>
                <input type="text" name="code" required class="w-full p-2 border border-gray-300 rounded"
                    value="{{ old('code') }}">

                <label for="discount_type" class="block">نوع الخصم</label>
                <select name="discount_type" id="discount_type" required class="w-full p-2 border border-gray-300 rounded">
                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>نسبة مئوية
                    </option>
                </select>

                <!-- حقل المبلغ الثابت، هيظهر لو اختار "مبلغ ثابت" -->
                <div id="fixed_amount_field" class="hidden">
                    <label for="fixed_amount" class="block">المبلغ الثابت</label>
                    <input type="number" name="fixed_amount" class="w-full p-2 border border-gray-300 rounded"
                        placeholder="أدخل المبلغ الثابت" value="{{ old('fixed_amount') }}">
                </div>

                <!-- حقل النسبة المئوية وحد أقصى، هيظهر لو اختار "نسبة مئوية" -->
                <div id="percentage_field" class="hidden">
                    <label for="discount_percentage" class="block">النسبة المئوية</label>
                    <input type="number" name="discount_percentage" class="w-full p-2 border border-gray-300 rounded"
                        placeholder="أدخل النسبة المئوية" value="{{ old('discount_percentage') }}">

                    <label for="max_discount_amount" class="block">أقصى خصم</label>
                    <input type="number" name="max_discount_amount" class="w-full p-2 border border-gray-300 rounded"
                        placeholder="أقصى خصم ممكن" value="{{ old('max_discount_amount') }}">
                </div>

                <label for="usage_limit" class="block">حد الاستخدام (اختياري)</label>
                <input type="number" name="usage_limit" class="w-full p-2 border border-gray-300 rounded"
                    value="{{ old('usage_limit') }}">

                <label for="valid_from" class="block">تاريخ بداية صلاحية الكوبون</label>
                <input type="date" name="valid_from" class="w-full p-2 border border-gray-300 rounded"
                    value="{{ $coupon->created_at }}">

                <label for="valid_until" class="block">تاريخ نهاية صلاحية الكوبون</label>
                <input type="date" name="expires_at" class="w-full p-2 border border-gray-300 rounded"
                    value="{{ $coupon->expires_at }}" required>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">تعديل</button>
            </form>

        </div>
    </div>

    <!-- JavaScript لتغيير حالة ظهور الحقول بناءً على نوع الخصم -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountType = document.getElementById('discount_type');
            const fixedAmountField = document.getElementById('fixed_amount_field');
            const percentageField = document.getElementById('percentage_field');

            // التحقق من الحالة الأولية
            if (discountType.value == 'fixed') {
                fixedAmountField.classList.remove('hidden');
                percentageField.classList.add('hidden');
            } else if (discountType.value == 'percentage') {
                percentageField.classList.remove('hidden');
                fixedAmountField.classList.add('hidden');
            }

            // الاستماع للتغيير في اختيار "نوع الخصم"
            discountType.addEventListener('change', function() {
                if (this.value == 'fixed') {
                    fixedAmountField.classList.remove('hidden');
                    percentageField.classList.add('hidden');
                } else if (this.value == 'percentage') {
                    percentageField.classList.remove('hidden');
                    fixedAmountField.classList.add('hidden');
                }
            });
        });
    </script>

    <!-- عرض رسائل النجاح أو الخطأ باستخدام Toastr -->
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        </script>
    @endif
@endsection
