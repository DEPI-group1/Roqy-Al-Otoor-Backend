@extends('layouts.sideBar')
@section('title', 'الفئات')

@section('content')

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-700">إدارة الفئات</h2>
                <a href="{{ route('categories.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    + إضافة فئة
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 shadow-md">
                    <thead class="bg-gray-200">
                        <tr class="text-gray-700">
                            <th class="border border-gray-300 px-4 py-2 text-right">الصورة</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">الاسم</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">الوصف</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-100 transition">
                                <td class="border border-gray-300 px-4 py-2">
                                    <img src="{{ asset('storage/categories/' . $category->image) }}"
                                        class="w-16 h-16 rounded-md object-cover" alt="صورة الفئة">
                                </td>
                                <td class="border border-gray-300 px-4 py-2 font-semibold">{{ $category->name }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">
                                    {{ $category->description ?? 'لا يوجد وصف' }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition shadow-md">
                                            ✏️ تعديل
                                        </a>
                                        <!-- زر الحذف -->
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition shadow-md">
                                                🗑️ حذف
                                            </button>
                                        </form>

                                        <!-- زر عرض المنتجات -->
                                        <a href="{{ route('categories.products', $category->id) }}"
                                            class="text-green-500 font-semibold hover:text-green-700 px-4 py-2 border-r-4 border-green-500 transition">
                                            👀 عرض منتجات الفئة
                                        </a>

                                        <!-- زر رفع ملف المنتجات -->
                                        <a href="{{ route('categories.import', $category->name) }}"
                                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow-md">
                                            ⬆️ + رفع ملف منتجات
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
