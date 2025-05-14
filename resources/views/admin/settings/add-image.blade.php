@extends('layouts.sideBar')
@section('title', 'رفع صورة جديدة')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">رفع صورة جديدة</h2>
        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">اختر صورة:</label>
                <input type="file" name="image" required
                    class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">مكان الصورة:</label>
                <select name="location" class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-300">
                    <option value="carousel">كاروسيل</option>
                    <option value="banner">بانر</option>
                    <option value="ad">إعلان</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                رفع الصورة
            </button>
        </form>

        @if(session('error'))
            <div class="alert alert-danger mt-4">{{ session('error') }}</div>
        @endif
        {{-- @if(session('success'))
            <div class="alert alert-success mt-4">{{ session('success') }}</div>
        @endif --}}
    </div>

    <!-- عرض الصور المرفوعة -->
    <div class="max-w-4xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">الصور المرفوعة</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach ($images as $image)
                <div class="relative group" id="image-{{ $image->id }}">
                    <img src="{{ asset('storage/' . $image->image) }}"
                        class="w-full h-32 object-cover rounded-lg cursor-pointer shadow-md transition transform hover:scale-105"
                        onclick="openModal('{{ asset('storage/' . $image->image) }}')">
                    <form method="POST" action="{{ route('images.destroy', $image->id) }}" class="absolute top-2 left-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="delete-button bg-red-600 text-white text-xs p-2 rounded-full shadow-md hover:bg-red-700 transition duration-300">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    <p class="text-xs text-gray-600 mt-1 text-center">{{ $image->location }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- مودال عرض الصورة -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center p-4">
        <div class="relative">
            <button type="button" class="absolute top-2 right-2 text-red text-4xl bg-white" onclick="closeModal()">
                &times;
            </button>
            <img id="modalImage" class="max-w-full max-h-[80vh] rounded-lg shadow-lg">
        </div>
    </div>

    <script>
        function openModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>

@endsection