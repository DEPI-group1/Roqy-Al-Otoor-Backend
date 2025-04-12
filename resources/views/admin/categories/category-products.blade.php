@extends('layouts.sideBar')
@section('title', 'الفئات')

@section('content')

    <div class="container mx-auto p-6 bg-white text-gray-900 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center border-b pb-4">إدارة المنتجات حسب الفئة</h2>

        <!-- جدول المنتجات -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg shadow-sm">
                <thead class="bg-gray-2000">
                    <tr class="text-right">
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">الصورة</th>
                        <th class="p-3 border-b">اسم المنتج</th>
                        <th class="p-3 border-b">السعر</th>
                        <th class="p-3 border-b">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($products as $product)
                        <tr class="hover:bg-gray-100 transition">
                            <td class="p-3 border-b text-center">{{ $loop->iteration }}</td>
                            <td class="p-3 border-b">
                                <img src="{{ asset('storage/products/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}" class="w-14 h-14 rounded-md border">
                            </td>
                            <td class="p-3 border-b">{{ $product->name }}</td>
                            <td class="p-3 border-b font-semibold text-green-600">${{ number_format($product->price, 2) }}
                            </td>
                            <td class="p-3 border-b flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded shadow hover:bg-blue-600 transition">
                                    تعديل
                                </a>
                                <form action="{{ route('products.delete', $product->id) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من حذف المنتج؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded shadow hover:bg-red-600 transition">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
