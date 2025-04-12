@extends('layouts.sideBar')
@section('title', 'الطلبات')

@section('content')
    <div class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">إضافة فئة جديدة</h2>

            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">اسم الفئة</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="أدخل اسم الفئة">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">الوصف</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="أدخل وصف الفئة"></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium mb-2">الصورة</label>
                    <input type="file" id="image" name="image"
                        class="w-full border p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="images" class="block text-gray-700 font-medium mb-2">صور إضافية للكاروسيل</label>
                    <input type="file" id="images" name="images[]" multiple
                        class="w-full border p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        إضافة الفئة
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
