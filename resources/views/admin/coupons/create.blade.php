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
                <label for="category_id" class="block">الفئة</label>
                <select name="category_id" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">اختر الفئة</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="usage_limit" class="block">حد الاستخدام (اختياري)</label>
                <input type="number" name="usage_limit" class="w-full p-2 border border-gray-300 rounded"
                    value="{{ old('usage_limit') }}">

                <label for="valid_from" class="block">تاريخ بداية صلاحية الكوبون</label>
                <input type="date" name="valid_from" class="w-full p-2 border border-gray-300 rounded"
                    value="{{ old('valid_from') }}">

                <label for="valid_until" class="block">تاريخ نهاية صلاحية الكوبون</label>
                <input type="date" name="expires_at" class="w-full p-2 border border-gray-300 rounded"
                    value="{{ old('expires_at') }}" required>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">حفظ</button>
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
