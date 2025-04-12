@extends('layouts.sideBar')
@section('title', 'عرض المنتج')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">{{ $product->name }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">صور المنتج</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @if (!empty($products->images))
                        @foreach ($product->images as $image)
                            <div class="overflow-hidden rounded-lg shadow-md relative">
                                <img src="{{ asset('storage/products/' . $image->image) }}" />
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>

            <!-- Product Details -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">تفاصيل المنتج</h2>

                <!-- Price Section -->
                <div class="flex items-center mb-4">
                    <span class="text-2xl font-bold text-gray-800">${{ $product->price }}</span>
                    @if ($product->old_price)
                        <span class="text-lg text-gray-500 line-through ml-3">${{ $product->old_price }}</span>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">وصف المنتج</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Stock Status -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">الحالة</h3>
                    <span class="text-lg font-bold {{ $product->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{-- {{ $product->stock > 0 ? 'متوفر' : 'غير متوفر' }} --}}
                    </span>
                </div>

                <!-- Additional Information -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">معلومات إضافية</h3>
                    <ul class="list-disc list-inside text-gray-600">
                        <li><span class="font-semibold">الوزن:</span> {{ $product->weight }} كجم</li>
                        <li><span class="font-semibold">العلامة التجارية:</span> {{ $product->brand }}</li>
                        <li><span class="font-semibold">التصنيف:</span> {{ $category->name ?? 'غير محدد' }}</li>
                    </ul>
                </div>

                <!-- Admin Actions -->
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('products.edit', $product->id) }}"
                        class="bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition-colors shadow-md">
                        تعديل المنتج
                    </a>

                    <form action="{{ route('products.delete', $product->id) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition-colors shadow-md">
                            حذف المنتج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
