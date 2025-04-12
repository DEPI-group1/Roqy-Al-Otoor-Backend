@extends('layouts.sideBar')
@section('title', 'إدارة الباكدجات')

@section('content')
    <div class="max-w-6xl mx-auto mt-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-700">إدارة الباكدجات</h2>
            <a href="{{ route('packages.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة باكدج
            </a>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <table class="w-full text-center border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border">#</th>
                        <th class="py-3 px-4 border">الاسم</th>
                        <th class="py-3 px-4 border">السعر</th>
                        <th class="py-3 px-4 border">الحالة</th>
                        <th class="py-3 px-4 border">الصور</th>
                        <th class="py-3 px-4 border">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr class="border">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $package->name }}</td>
                            <td class="py-3 px-4 text-green-600 font-bold">{{ $package->price }} جنيه</td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-3 py-1 text-sm font-semibold rounded-lg 
                                    {{ $package->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $package->status ? 'مفعل' : 'غير مفعل' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <button onclick="openModal({{ $package->id }})"
                                    class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                    عرض الصور
                                </button>
                            </td>
                            <td class="py-3 px-4 flex justify-center space-x-2">
                                <a href="{{ route('packages.edit', $package->id) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                                    تعديل
                                </a>

                                <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الباكدج؟ لا يمكن التراجع!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Modal for package images --}}
                        <div id="modal-{{ $package->id }}"
                            class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg w-1/2">
                                <h2 class="text-xl font-semibold mb-4">صور الباكدج - {{ $package->name }}</h2>
                                <div class="flex flex-wrap">
                                    @if (is_iterable($package->images) && count($package->images) > 0)
                                        @foreach ($package->images as $image)
                                            <img src="{{ asset('storage/packages/' . $image['image_path']) }}"
                                                class="w-32 h-32 object-cover m-2 rounded-md shadow-md">
                                        @endforeach
                                    @else
                                        <p class="text-gray-500">لا توجد صور متاحة لهذا الباكدج.</p>
                                    @endif
                                </div>
                                <button onclick="closeModal({{ $package->id }})"
                                    class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">
                                    إغلاق
                                </button>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- JavaScript للتحكم في المودال --}}
    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
        }
    </script>
@endsection
