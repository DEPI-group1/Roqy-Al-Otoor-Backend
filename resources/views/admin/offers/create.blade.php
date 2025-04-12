@extends('layouts.sideBar')
@section('title',
    'العروض
    ')
@section('content')
    <div class="max-w-6xl mx-auto my-5 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">إضافة عرض جديد</h2>

        <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- عنوان العرض -->
            <div>
                <label for="title" class="block text-gray-700 font-medium">عنوان العرض</label>
                <input type="text" id="title" name="title" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- وصف العرض -->
            <div>
                <label for="description" class="block text-gray-700 font-medium">وصف العرض</label>
                <textarea id="description" name="description" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- السعر قبل وبعد الخصم -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="original_price" class="block text-gray-700 font-medium">السعر الأصلي</label>
                    <input type="number" id="original_price" name="original_price" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div>
                    <label for="discounted_price" class="block text-gray-700 font-medium">السعر بعد الخصم</label>
                    <input type="number" id="discounted_price" name="discounted_price" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- تاريخ انتهاء العرض -->
            <div>
                <label for="expiry_date" class="block text-gray-700 font-medium">تاريخ انتهاء العرض</label>
                <input type="datetime-local" id="expiry_date" name="expiry_date" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <!-- رفع صور العرض -->
            <div>
                <label for="offer_images" class="block text-gray-700 font-medium">صور العرض</label>
                <input type="file" id="offer_images" name="offer_images[]" accept="image/*" multiple required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <!-- زر الإرسال -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                إضافة العرض
            </button>
        </form>
    </div>
@endsection
