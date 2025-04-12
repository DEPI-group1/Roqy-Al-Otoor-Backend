@extends('layouts.sideBar')

@section('title', 'إضافة منتج جديد')


@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">إضافة منتج جديد</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- اسم المنتج -->
            <div>
                <label class="block text-sm font-medium text-gray-700">اسم المنتج</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300"
                    required>
            </div>

            <!-- الوصف -->
            <div>
                <label class="block text-sm font-medium text-gray-700">الوصف</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300"></textarea>
            </div>

            <!-- السعر والسعر القديم -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">السعر</label>
                    <input type="number" step="0.01" name="price"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">السعر القديم</label>
                    <input type="number" step="0.01" name="old_price"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300">
                </div>
            </div>

            <!-- الخصم -->
            <div>
                <label class="block text-sm font-medium text-gray-700">الخصم (%)</label>
                <input type="number" step="0.01" name="discount"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300">
            </div>

            <!-- الكاتيجوري -->
            <div>
                <label class="block text-sm font-medium text-gray-700">الفئة</label>
                <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300"
                    required>
                    @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                </select>
            </div>
            {{-- <input type="hidden" name="category_id" value="{{ $category->id }}"> --}}
            <!-- الصور -->
            <div>
                <label class="block text-sm font-medium text-gray-700">الصور</label>
                <input type="file" name="images[]" multiple
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300" required>
            </div>

            <!-- زر الإرسال -->
            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg transition">
                إضافة المنتج
            </button>
        </form>
    </div>
    <script>
        @if (session('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "4000", // 4 ثوانٍ
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.success("{{ session('success') }}");
        @endif
    </script>

@endsection
