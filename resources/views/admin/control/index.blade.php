@extends('layouts.sideBar')
@section('title', 'التحكم')

@section('content')
    <div class="max-w-4xl mx-auto bg-white text-gray-900 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">إدارة عرض الفئات والصور</h2>

        {{-- @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif --}}

        <form action="{{ route('control.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">اختر الفئة:</label>
                <select name="category_id" class="w-full bg-gray-200 border border-gray-400 p-2 rounded-md">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">رفع صورة الكاروسيل:</label>
                <input type="file" name="image" class="w-full bg-gray-200 border border-gray-400 p-2 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">ترتيب العرض:</label>
                <input type="number" name="order" class="w-full bg-gray-200 border border-gray-400 p-2 rounded-md"
                    value="0">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-md transition">إضافة</button>
        </form>

        <hr class="my-6 border-gray-300">

        <h3 class="text-xl font-semibold mb-4">العناصر المضافة</h3>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 text-right text-gray-900">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3">الفئة</th>
                        <th class="p-3">الصورة</th>
                        <th class="p-3">الترتيب</th>
                        <th class="p-3">حذف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($controls as $control)
                        <tr class="border-b border-gray-300">
                            <td class="p-3">{{ $control->category->name }}</td>
                            <td class="p-3">
                                <img src="{{ asset('storage/' . $control->image) }}" class="w-20 rounded-md cursor-pointer"
                                    onclick="openModal('{{ asset('storage/' . $control->image) }}')">
                            </td>
                            <td class="p-3">{{ $control->order }}</td>
                            <td class="p-3">
                                <form action="{{ route('control.destroy', $control->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md transition">
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

    <!-- مودال عرض الصورة -->
    <div id="imageModal"
        class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-75 hidden"
        onclick="closeModal()">
        <img id="modalImage" class="max-w-2xl max-h-2xl rounded-lg shadow-lg">
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
@endsection
