@extends('layouts.sideBar')
@section('title', 'الرئيسية')
@section('content')

    <div class="container mx-auto mt-4">
        {{--  --}}
        <div class="container mx-auto mt-4">
            {{--  --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-blue-500 text-white p-2 rounded-lg shadow-md">
                    <div class="font-bold text-lg">عدد المنتجات</div>
                    <div class="text-2xl my-1">{{ $products_count }}</div>
                    <a href="{{route('products')}}" class="bg-white text-blue-500 px-3 py-2 rounded">عرض </a>
                </div>
                {{--  --}}
                <div class="bg-green-500 text-white p-2 rounded-lg shadow-md">
                    <div class="font-bold text-lg">عدد الفئات</div>
                    <div class="text-2xl my-1">{{ $categories_count }}</div>
                    <a href="{{route('categories')}}" class="bg-white text-green-500 px-3 py-2 rounded">عرض </a>
                </div>
                {{--  --}}
                <div class="bg-red-500 text-white p-2 rounded-lg shadow-md">
                    <div class="font-bold text-lg">إجمالي الأرباح</div>
                    <div class="text-2xl my-1">{{ $total_earnings }}</div>
                    <a href="{{route('earningsReport')}}" class="bg-white text-red-500 px-3 py-2 rounded">عرض </a>
                </div>
                {{--  --}}
                <div class="bg-green-500 text-white p-2 rounded-lg shadow-md">
                    <div class="font-bold text-lg">الطلبات المدفوعة </div>
                    <div class="text-2xl my-1">{{ $OrdersCount }}</div>
                    <a href="{{ route('accepted_orders') }}" class="bg-white text-red-500 px-3 py-2 rounded">عرض </a>
                </div>
                {{--  --}}

                <div class="bg-yellow-500 text-white p-2 rounded-lg shadow-md">
                    <div class="font-bold text-lg">الطلبات المعلقة</div>
                    <div class="text-2xl my-1">{{ $PendingOrders }}</div>
                    <a href="{{ route('orders') }}" class="bg-white text-red-500 px-3 py-2 rounded">عرض </a>
                </div>
                {{--  --}}
                <div class="bg-red-500 text-white p-2 rounded-lg shadow-md">
                    <div class="font-bold text-lg"> طلبات كاش COD</div>
                    <div class="text-2xl my-1">{{ $COD_orders }}</div>
                    <a href="" class="bg-white text-red-500 px-3 py-2 rounded">عرض </a>
                </div>
            </div>
        </div>
    </div>


    {{--  --}}
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-5">
        <a href="{{ route('orders') }}" class="text-blue-500 hover:underline text-md float-left">عرض الكل</a>
        <h2 class="text-2xl font-bold text-center mb-6">قائمة الطلبات</h2>

        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">رقم الطلب</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">المستخدم</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">الحالة</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">المبلغ الإجمالي</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">التاريخ</th>
                    <th class="px-4 py-2 text-right text-md font-medium text-gray-600">تفاصيل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($LimitOrders as $order)
                    <!-- مثال على البيانات -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">#{{ $order->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $order->first_name }}</td>
                        <td
                            class="px-4 py-2 text-sm 
                        @if ($order->payment_status == 'paid') text-green-500
                        @elseif ($order->payment_status == 'unpaid') text-red-500
                        @else text-yellow-500 @endif">
                            {{ $order->payment_status }}
                        </td>
                        <td class="px-4 py-2 text-sm text-green-700">{{ $order->total_amount }} ج.م</td>
                        <td class="px-4 py-2 text-sm text-gray-700"> {{ $order->created_at }} </td>
                        <td class="px-4 py-2 text-sm">
                            <a href="{{ route('orders.show', ['id' => $order->id]) }}"
                                class="text-blue-500 hover:underline">عرض</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- more content --}}
@endsection
