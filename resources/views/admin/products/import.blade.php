@extends('layouts.sideBar')
@section('title', 'رفع ملف منتجات')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">رفع ملف المنتجات (Excel)</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">اختر ملف المنتجات (Excel)</label>
                <input type="file" name="file" required class="border border-gray-300 p-2 rounded w-full">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                رفع الملف
            </button>
        </form>
    </div>
@endsection
