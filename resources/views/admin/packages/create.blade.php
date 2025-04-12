@extends('layouts.sideBar')
@section('title', 'الباكدجات')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-gray-100 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">إضافة باكدج جديدة</h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-200 border border-green-400 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">اسم الباكدج</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                <textarea id="description" name="description" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required></textarea>
            </div>

            <div class="mb-4">
                <label for="detailed_description" class="block text-sm font-medium text-gray-700">الوصف المٌفصل</label>
                <textarea id="detailed_description" name="detailed_description" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required></textarea>
            </div>
            <div class="mb-4">
                <label for="components" class="block text-sm font-medium text-gray-700">المكونات</label>
                <textarea id="components" name="components" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required></textarea>
            </div>
            <div class="mb-4">
                <label for="Usage_method" class="block text-sm font-medium text-gray-700">طريقة الإستخدام</label>
                <textarea id="Usage_method" name="Usage_method" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">السعر</label>
                <input type="number" id="price" name="price"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required>
            </div>
            <div class="mb-4">
                <label for="old_price" class="block text-sm font-medium text-gray-700">السعر القديم</label>
                <input type="number" id="old_price" name="old_price"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">حالة الباكدج</label>
                <div class="flex items-center space-x-4 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="status" value="active" class="form-radio text-red-600" checked>
                        <span class="ml-2 text-gray-700">مُفعّل</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status" value="inactive" class="form-radio text-red-600">
                        <span class="ml-2 text-gray-700">غير مُفعّل</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700">صور الباكدج</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <p class="text-sm text-gray-600 mt-1">يمكنك رفع أكثر من صورة.</p>
                <div id="image-preview" class="mt-3 flex flex-wrap gap-2"></div>
            </div>

            <!-- اختيار المنتجات -->
            {{-- <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">اختر المنتجات</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
                    @foreach ($products as $product)
                        <label class="flex items-center space-x-2 border p-2 rounded-lg bg-white shadow-sm">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}" class="form-checkbox text-blue-600">
                            <span class="text-gray-700">{{ $product->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div> --}}

            <div class="flex justify-center">
                <button type="submit"
                    class="w-full md:w-1/2 px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow-md transition duration-300">
                    إضافة الباكدج
                </button>
            </div>
        </form>
    </div>
@endsection

<script>
    document.getElementById('images').addEventListener('change', function(event) {
        let previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = "";
        Array.from(event.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement("img");
                img.src = e.target.result;
                img.className =
                    "h-24 w-24 object-cover rounded-md border border-gray-300 shadow-sm";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
