@extends('layouts.sideBar')
@section('title', 'العروض')

@section('content')
    <div class="max-w-7xl mx-auto bg-gray-50 p-8 rounded-lg shadow-lg">
        <!-- زر إضافة عرض -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">🛍️ العروض المتاحة</h2>
            <a href="{{ route('offers.create') }}"
                class="bg-green-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-green-700 transition">
                + إضافة عرض جديد
            </a>
        </div>

        <!-- قائمة العروض -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($offers as $offer)
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition duration-300">
                    <!-- عرض الصور (تدعم تعدد الصور) -->
                    <div class="relative overflow-hidden rounded-lg">
                        @php
                            $images = json_decode($offer->images, true);
                            $firstImage = $images[0] ?? 'default.jpg'; // عرض الصورة الأولى أو صورة افتراضية
                        @endphp
                        <img src="{{ asset('storage/' . $firstImage) }}" alt="عرض {{ $offer->title }}"
                            class="w-full h-56 object-cover rounded-lg hover:scale-105 transition duration-500">
                    </div>

                    <!-- معلومات العرض -->
                    <div class="mt-4">
                        <h3 class="text-2xl font-semibold text-blue-600">{{ $offer->title }}</h3>
                        <p class="text-gray-700 mt-2 line-clamp-2">{{ $offer->description }}</p>

                        <!-- الأسعار -->
                        <div class="flex items-center justify-between mt-3 text-lg">
                            <span class="text-gray-500 line-through">{{ $offer->original_price }} جنيه</span>
                            <span class="text-green-600 font-bold">{{ $offer->discounted_price }} جنيه</span>
                        </div>

                        <!-- العد التنازلي -->
                        <div class="mt-4 p-3 bg-gray-100 rounded-md text-center">
                            <p class="text-red-500 font-bold text-lg">⏳ ينتهي خلال:</p>
                            <span id="timer-{{ $offer->id }}" class="text-gray-800 font-semibold text-lg"></span>
                        </div>

                        <!-- أزرار التحكم -->
                        <div class="flex justify-between mt-4">
                            <!-- زر التعديل -->
                            <a href="{{ route('offers.edit', $offer->id) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">
                                ✏️ تعديل
                            </a>

                            <!-- زر الحذف -->
                            <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا العرض؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-600 transition">
                                    🗑️ حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- سكريبت العد التنازلي -->
                <script>
                    function startCountdown(offerId, expiryDate) {
                        const countdownElement = document.getElementById(`timer-${offerId}`);
                        const countDownDate = new Date(expiryDate).getTime();

                        const x = setInterval(() => {
                            const now = new Date().getTime();
                            const distance = countDownDate - now;

                            if (distance < 0) {
                                clearInterval(x);
                                countdownElement.innerHTML = "⚠️ انتهى العرض!";
                                countdownElement.classList.add("text-red-600");
                                return;
                            }

                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            countdownElement.innerHTML = `${days} يوم ${hours} ساعة ${minutes} دقيقة ${seconds} ثانية`;
                        }, 1000);
                    }

                    startCountdown({{ $offer->id }}, "{{ $offer->expiry_date }}");
                </script>
            @endforeach
        </div>
    </div>
@endsection
