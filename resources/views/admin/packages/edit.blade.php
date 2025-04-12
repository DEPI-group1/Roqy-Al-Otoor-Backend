@extends('layouts.sideBar')
@section('title', 'تعديل الباكدج')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-gray-100 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">تعديل الباكدج</h2>

        <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- اسم الباكدج -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">اسم الباكدج</label>
                <input type="text" id="name" name="name" value="{{ $package->name }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required>
            </div>

            <!-- وصف الباكدج -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                <textarea id="description" name="description" rows="3"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required>{{ $package->description }}</textarea>
            </div>

            <!-- سعر الباكدج -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">السعر</label>
                <input type="number" id="price" name="price" value="{{ $package->price }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white"
                    required>
            </div>

            <!-- حالة الباكدج -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">حالة الباكدج</label>
                <div class="flex items-center space-x-6 mt-2">
                    <label class="flex items-center">
                        <input type="radio" name="status" value="active"
                            class="form-radio w-6 h-6 text-red-600 focus:ring-red-600"
                            {{ $package->status == 'active' ? 'checked' : '' }}>
                        <span class="ml-3 text-gray-700 text-lg">مُفعّل</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status" value="inactive"
                            class="form-radio w-6 h-6 text-red-600 focus:ring-red-600"
                            {{ $package->status == 'inactive' ? 'checked' : '' }}>
                        <span class="ml-3 text-gray-700 text-lg">غير مُفعّل</span>
                    </label>
                </div>
            </div>

            <!-- عرض الصور المرفوعة مسبقًا -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">الصور الحالية</label>
                <div id="current-images" class="mt-3 flex flex-wrap gap-2">
                    @foreach ($package->images as $image)
                        <div class="relative">
                            <img src="{{ asset('storage/packages/' . $image['image_path']) }}"
                                class="h-24 w-24 object-cover rounded-md border border-gray-300 shadow-sm">
                            <button type="button"
                                class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full text-xs delete-image"
                                data-id="{{ $image->id }}">&times;</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- رفع صور جديدة -->
            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700">رفع صور جديدة</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                <p class="text-sm text-gray-600 mt-1">يمكنك رفع أكثر من صورة.</p>
                <div id="image-preview" class="mt-3 flex flex-wrap gap-2"></div>
            </div>

            <!-- زر التحديث -->
            <div class="flex justify-center">
                <button type="submit"
                    class="w-full md:w-1/2 px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow-md transition duration-300">
                    تحديث الباكدج
                </button>
            </div>
        </form>
    </div>
@endsection

<!-- سكريبت عرض الصور الجديدة قبل الرفع وحذف الصور المرفوعة مسبقًا -->
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

    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            let imageId = this.dataset.id;
            let parentDiv = this.parentElement;

            fetch(`/delete-image/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    parentDiv.remove();
                }
            });
        });
    });
</script>
