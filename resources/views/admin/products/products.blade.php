@extends('layouts.sideBar')
@section('title', 'المنتجات')

@section('content')
    {{--  --}}
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-5">
        <div class="flex justify-between items-center">
            <a href="{{ route('products.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                + إضافة منتج
            </a>

            <a href="{{ route('products.import') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                + رفع ملف منتجات
            </a>
        </div>

        <h2 class="text-2xl font-bold text-center mb-6">قائمة المنتجات</h2>

        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">اسم المنتج</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">السعر</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">الصورة</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $product->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $product->price }} ج.م</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <img src="{{ asset('storage/products/' . $product->images->first()->image) }}"
                                alt="{{ $product->name }}" class="w-20 h-20 object-contain rounded">
                            {{-- <span class="text-gray-500">لا توجد صورة</span> --}}
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="text-blue-500 hover:underline border-r-4 border-blue-500 px-3">تعديل
                            </a>
                            <form action="{{ route('products.delete', $product->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:underline ml-4 border-r-4 border-red-500 px-3">
                                    حذف
                                </button>
                            </form>
                            <form action="{{ route('products.show', $product->id) }}" method="get"
                                style="display:inline;">
                                @csrf
                                @method('get')
                                <button type="submit"
                                    class="text-green-500 hover:underline ml-4 border-r-4 border-green-500 px-3">
                                    عرض التفاصيل
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
