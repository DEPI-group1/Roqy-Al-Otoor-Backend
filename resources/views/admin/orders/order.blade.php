@extends('layouts.sideBar')
@section('title', 'الطلبات')
@section('content')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <div class="container mx-auto ">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Order Details -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                    <div class="font-bold text-gray-800">تفاصيل العميل</div>
                    <div class="text-sm text-gray-600">
                        <p><strong>الاسم:</strong><span class="text-lg text-red-700">
                                {{ $order->first_name . $order->last_name }} </span></p>
                        <p><strong>البريد الإلكتروني:</strong><span class="text-lg text-red-700"> {{ $order->email }} </span>
                        </p>
                        <p><strong>رقم الهاتف:</strong><span class="text-lg text-red-700">{{ $order->phone_number }} </span>
                        </p>
                        <p><strong>العنوان:</strong> <span
                                class="text-lg text-red-700">{{ $order->governorate . ' - ' . $order->city . ' - ' . $order->village }}
                                </class=>
                        </p>
                        <p><strong> عنوان الشحن: </strong><span class="text-lg text-red-700"> {{ $order->shipping_address }}
                            </span></p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                    <div class="font-bold text-gray-800">تفاصيل الطلب</div>
                    <div class="text-lg text-gray-600">
                        <p><strong>تاريخ الطلب:</strong> {{ $order->created_at }}</p>
                        <p><strong>حالة الدفع:</strong> {{ $order->payment_status }} </p>
                        <p><strong> نوع الدفع: </strong><span class="text-red-900 text-2xl"> {{ $order->payment_method }}
                            </span></p>
                        <p><strong>التكلفة الإجمالية: </strong><span class="text-green-800 text-2xl">
                                {{ $order->total_amount }} </span></p>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="font-bold text-gray-800">ملخص الطلب</div>
                    <table class="w-full border-collapse border border-gray-300 mt-2">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700">
                                <th class="border border-gray-300 p-2">الصورة</th>
                                <th class="border border-gray-300 p-2">المنتج</th>
                                <th class="border border-gray-300 p-2">الكمية</th>
                                <th class="border border-gray-300 p-2">السعر</th>
                                <th class="border border-gray-300 p-2">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr class="text-center">
                                    <td>
                                        @foreach ($order->items as $item)
                                            @if ($item->product && $item->product->images->isNotEmpty())
                                                <img src="{{ asset('storage/products/' . $item->product->images->first()->image) }}"
                                                    class="w-full object-contain" />
                                            @elseif ($item->package && $item->package->images->isNotEmpty())
                                                <img src="{{ asset('storage/packages/' . $item->package->images->first()->image) }}"
                                                    alt="{{ $item->package->name }}">
                                            @else
                                                <span class="text-red-500">No Image</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 p-2"> {{ $item->product_name ?? 'N/A' }} </td>
                                    <td class="border border-gray-300 p-2"> {{ $item->quantity }} </td>
                                    <td class="border border-gray-300 p-2"> {{ $item->price }} </td>
                                    <td class="border border-gray-300 p-2"> {{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Status Update Section -->
        <div class="bg-white rounded-lg shadow-md p-4 mt-6">
            <div class="font-bold text-gray-800">تحديث حالة الطلب</div>
            <form id="statusForm">
                <div class="mb-3">
                    <label for="orderStatus" class="block text-sm font-medium text-gray-700">حالة الطلب</label>
                    <select id="orderStatus" class="w-full p-2 mt-1 border border-gray-300 rounded">
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>قيد المعالجه
                        </option>
                        <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>قيد التحضير
                        </option>
                        <option value="shipped"{{ $order->order_status == 'shipped' ? 'selected' : '' }}>خرج للشحن</option>
                        <option value="delivered"{{ $order->order_status == 'delivered' ? 'selected' : '' }}>تم التسليم
                        </option>
                        <option value="canceled"{{ $order->order_status == 'canceled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="block text-sm font-medium text-gray-700">تعليق</label>
                    <textarea id="comment" class="w-full p-2 mt-1 border border-gray-300 rounded" rows="3"
                        placeholder="أضف تعليقًا هنا..."></textarea>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">تحديث
                    الحالة</button>
            </form>
            <div id="statusMessage"></div>
        </div>
    </div>






    <script>
        document.getElementById('orderStatus').addEventListener('change', function() {
            let orderStatus = this.value; // الحصول على القيمة المختارة
            let orderId = '{{ $order->id }}'; // تأكد من تمرير الـ ID الخاص بالطلب من الـ controller

            // إرسال الطلب إلى السيرفر باستخدام AJAX
            //Route
            fetch(`/order/${orderId}/update-status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // لتأمين الطلب ضد الهجمات
                    },
                    body: JSON.stringify({
                        status: orderStatus
                    }) // البيانات التي سيتم إرسالها
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // عرض توست عند نجاح التحديث
                        Toastify({
                            text: "تم تحديث الحالة بنجاح!",
                            backgroundColor: "green",
                            duration: 3000, // مدة عرض التوست
                            close: true, // عرض زر الإغلاق
                            gravity: "top", // تحديد مكان عرض التوست (أعلى الصفحة)
                            position: "center" // تحديد جهة عرض التوست
                        }).showToast();
                    } else {
                        // عرض توست في حالة حدوث خطأ
                        Toastify({
                            text: "حدث خطأ أثناء تحديث الحالة.",
                            backgroundColor: "red",
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "center"
                        }).showToast();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // عرض توست في حالة حدوث خطأ في الاتصال
                    Toastify({
                        text: "حدث خطأ أثناء الاتصال بالسيرفر.",
                        backgroundColor: "red",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center"
                    }).showToast();
                });
        });
    </script>

@endsection
