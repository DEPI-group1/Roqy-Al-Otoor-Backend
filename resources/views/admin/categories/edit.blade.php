@extends('layouts.sideBar')
@section('title', 'تعديل الفئه')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">تعديل الفئة</h2>

            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">اسم الفئة</label>
                    <input type="text" id="name" name="name" value="{{ $category->name }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">الوصف</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $category->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-medium mb-2">الصورة</label>
                    <input type="file" id="image" name="image"
                        class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        onchange="previewImage(event)">
                </div>
                {{-- <!-- عرض الصورة المختارة --> --}}
                <div id="imagePreview" class="my-4">
                    @if ($category->image)
                        <img src="{{ asset('storage/categories/' . $category->image) }}" alt="صورة الفئة"
                            class="w-32 h-32 rounded-md shadow-md">
                    @endif
                </div>

                <div class="mb-4">
                    <label for="carousel_images" class="block text-gray-700 font-medium mb-2">صور الكاروسيل</label>
                    <input type="file" id="carousel_images" name="carousel_images[]" multiple
                        class="w-full border border-gray-300 p-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        onchange="previewCarouselImages(event)">
                </div>

                <!-- عرض الصور المختارة -->
                <div id="carouselImagesPreview" class="flex flex-wrap gap-2 mt-4"></div>

                <script>
                    function previewCarouselImages(event) {
                        const output = document.getElementById('carouselImagesPreview');
                        output.innerHTML = '';

                        const files = event.target.files;
                        if (files.length > 0) {
                            Array.from(files).forEach(file => {
                                const reader = new FileReader();
                                reader.onload = function() {
                                    const img = document.createElement('img');
                                    img.src = reader.result;
                                    img.classList.add('w-64', 'h-48', 'rounded-md', 'shadow-md');
                                    output.appendChild(img);
                                };
                                reader.readAsDataURL(file);
                            });
                        }
                    }
                </script>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold">صور الكاروسيل:</h3>
                    <div class="flex space-x-2 mt-2">
                        @foreach ($category->images as $image)
                            <div class="relative">
                                <!-- أيقونة الحذف -->
                                <form action="{{ route('categories.deleteImage', $image->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="absolute top-1 left-1 bg-red-600 text-white p-1 rounded-full text-xs deleteImageBtn"
                                        data-id="{{ $image->id }}">
                                        &times;
                                    </button>
                                </form>
                                <!-- الصورة -->
                                <img src="{{ asset('storage/categories/' . $image->image) }}" alt="صورة الكاروسيل"
                                    class="w-64 h-32 rounded-md shadow-md m-1 cursor-pointer"
                                    onclick="openModal('{{ asset('storage/categories/' . $image->image) }}', {{ $image->id }})">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        تحديث
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- مودال عرض الصورة -->
    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-lg w-11/12 md:w-2/3 lg:w-1/2">
            <!-- زر إغلاق -->
            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">
                &times;
            </button>

            <!-- زر الحذف -->
            {{-- <button id="deleteImageBtn"
                class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
                حذف
            </button> --}}

            <div class="flex justify-center mt-4">
                <img id="modalImage" class="max-w-full h-auto rounded-md shadow-lg">
            </div>
        </div>
    </div>

    <script>
        function openModal(imageSrc, imageId) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('deleteImageBtn').setAttribute('data-id', imageId);
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        document.getElementById('deleteImageBtn').addEventListener('click', function() {
            let imageId = this.getAttribute('data-id');

            fetch(`/categories/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم حذف الصورة بنجاح');
                        document.getElementById('imageModal').classList.add('hidden');
                        document.querySelector(`[data-id='${imageId}']`).parentElement.remove();
                    } else {
                        alert('حدث خطأ أثناء الحذف');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('تعذر الاتصال بالخادم');
                });
        });
    </script>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewImage(event) {
            const output = document.getElementById('imagePreview');
            output.innerHTML = '';

            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.classList.add('w-32', 'h-24', 'rounded-md', 'shadow-md');
                    output.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
