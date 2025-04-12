@extends('layouts.sideBar')

@section('title', 'تعديل بيانات المنتج')


@section('content')
    <body class="bg-gray-100 font-sans">
        <div class="container mx-auto mt-6 p-6">
            <div class="bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-2xl font-semibold mb-6">تعديل بيانات المنتج</h2>

                <form action="{{ route('product.update', $product->id) }}" id="editform" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- اسم المنتج -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700">اسم المنتج</label>
                            <input type="text" id="name" name="name" value="{{ $product->name }}"
                                   placeholder="أدخل اسم المنتج"
                                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- وصف المنتج -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700">وصف المنتج</label>
                            <textarea id="description" name="description" placeholder="أدخل وصف المنتج"
                                      class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" rows="4"
                                      required>{{ $product->description }}</textarea>
                        </div>

                        <!-- سعر المنتج -->
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700">سعر المنتج</label>
                            <input type="number" id="price" name="price" value="{{ $product->price }}"
                                   placeholder="مثال: 150"
                                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" step="0.01" required>
                        </div>

                        <!-- السعر القديم -->
                        <div>
                            <label for="old_price" class="block text-sm font-semibold text-gray-700">السعر القديم</label>
                            <input type="number" id="old_price" name="old_price" value="{{ $product->old_price }}"
                                   placeholder="مثال: 200"
                                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500" step="0.01">
                        </div>

                        <!-- رفع الصور -->
                        <div class="col-span-2">
                            <label for="images" class="block text-gray-700 font-medium">رفع الصور</label>
                            <input type="file" id="images" name="images[]" multiple
                                   class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <small class="text-gray-500 block mt-2">يمكنك رفع أكثر من صورة وسيتم عرضها أدناه.</small>

                            <!-- عرض الصور المحفوظة مسبقًا -->
                            <div class="mt-4">
                                <h3 class="text-gray-700 font-medium mb-2">الصور الحالية:</h3>
                                <div id="preview-container" class="flex flex-nowrap gap-3 overflow-x-auto p-2">
                                    @foreach ($product->images as $image)
                                        <div class="relative group w-32">
                                            <img src="{{ asset('storage/products/' . $image->image) }}" alt="صورة المنتج"
                                                 class="w-32 h-32 object-cover rounded-lg shadow-md">
                                            <form action="{{ route('products.image.delete', $image->id) }}" method="POST"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                                    ×
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- الكلمات الدلالية -->
                        <div>
                            <label for="keywords" class="block text-sm font-semibold text-gray-700">الكلمات الدلالية</label>
                            <textarea id="keywords" name="keywords" placeholder="مثال: هاتف، ذكي، سامسونج"
                                      class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                      rows="3">{{ $product->keywords }}</textarea>
                        </div>

                    </div>

                    <!-- زر الإرسال -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                            تعديل المنتج
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection
