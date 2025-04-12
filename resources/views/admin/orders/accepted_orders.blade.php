@extends('layouts.sideBar')
@section('title', 'الطلبات المقبولة')
@section('content')


{{--  --}}
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        {{-- <a href="" class="text-blue-500 hover:underline text-md float-left">عرض الكل</a> --}}
        <h2 class="text-2xl font-bold text-center mb-6">قائمة الطلبات المكتملة</h2>

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
        <!-- مثال على البيانات -->
        @foreach ($paid_orders as $order)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2 text-sm text-gray-700">#{{ $order->id }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $order->name }}</td>
            <td class="px-4 py-2 text-sm text-green-500">
                {{ $order->payment_status }}
            </td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $order->total_amount }} ج.م</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $order->order_date }}</td>
            <td class="px-4 py-2 text-sm">
                {{-- , 'id' => $id --> order id --}} 
                <a href="{{route('orders.show', $order->id)}}" class="text-blue-500 hover:underline">عرض</a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
    </div>




@endsection