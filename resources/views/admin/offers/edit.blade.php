@extends('layouts.sideBar')
@section('title', 'تعديل العرض')

@section('content')
    <div class="max-w-4xl mx-auto my-5 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">تعديل العرض</h2>

        <form action="{{ route('offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- عنوان العرض -->
            <div>
                <label for="title" class="block text-gray-700 font-medium">عنوان العرض</label>
                <input type="text" id="title" name="title" value="{{ $offer->title }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- وصف العرض -->
            <div>
                <label for="description" class="block text-gray-700 font-medium">وصف العرض</label>
                <textarea id="description" name="description" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $offer->description }}</textarea>
            </div>

            <!-- السعر قبل وبعد الخصم -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="original_price" class="block text-gray-700 font-medium">السعر الأصلي</label>
                    <input type="number" id="original_price" name="original_price" value="{{ $offer->original_price }}"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div>
                    <label for="discounted_price" class="block text-gray-700 font-medium">السعر بعد الخصم</label>
                    <input type="number" id="discounted_price" name="discounted_price"
                        value="{{ $offer->discounted_price }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- تاريخ انتهاء العرض -->
            <div>
                <label for="expiry_date" class="block text-gray-700 font-medium">تاريخ انتهاء العرض</label>
                <input type="datetime-local" id="expiry_date" name="expiry_date"
                    value="{{ \Carbon\Carbon::parse($offer->expiry_date)->format('Y-m-d\TH:i') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <!-- عرض الصور الحالية -->
            <div class="mt-4">
                <p class="text-gray-700 font-medium">الصور الحالية:</p>
                <div class="flex space-x-4 mt-2">
                    @if ($offer->images)
                        @foreach (json_decode($offer->images, true) as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="صورة العرض"
                                class="w-20 h-20 rounded-lg border">
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- رفع صور جديدة -->
            <div>
                <label for="offer_images" class="block text-gray-700 font-medium">تحديث الصور (يمكنك رفع صور متعددة)</label>
                <input type="file" id="offer_images" name="offer_images[]" accept="image/*" multiple
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <!-- زر الإرسال -->
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                تحديث العرض
            </button>
        </form>
    </div>
@endsection
