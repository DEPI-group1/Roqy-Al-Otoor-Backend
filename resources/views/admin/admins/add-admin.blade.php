@extends('layouts.sideBar')
@section('title', 'الأدمن')

@section('content')
    <div class="max-w-lg mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">إضافة أدمن جديد</h2>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.store') }}">
            @csrf
            @method('post')
            <div class="mb-4">
                <label class="block text-gray-700">الاسم</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label class="block text-gray-700">البريد الإلكتروني</label>
                <input type="email" name="email" class="w-full border p-2 rounded" required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label class="block text-gray-700">رقم التليفون</label>
                <input type="text" name="phone_number" class="w-full border p-2 rounded" required>
                @error('phone_number')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label class="block text-gray-700">كلمة المرور</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white p-2 rounded">إضافة</button>
        </form>
    </div>
@endsection
