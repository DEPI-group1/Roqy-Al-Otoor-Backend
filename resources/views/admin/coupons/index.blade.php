@extends('layouts.sideBar')
@section('title', 'الفئات')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-700">إدارة الكوبونات</h2>
                <a href="{{ route('coupons.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    + إضافة كوبون
                </a>
            </div>

            <table class="table-auto w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Code</th>
                        <th class="border border-gray-300 px-4 py-2">Discount</th>
                        <th class="border border-gray-300 px-4 py-2">Type</th>
                        <th class="border border-gray-300 px-4 py-2">On-Category</th>
                        <th class="border border-gray-300 px-4 py-2">Usage Limit</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $coupon->code }}</td>
                            @if ($coupon->discount_type == 'fixed')
                                <td class="border border-gray-300 px-4 py-2">{{ $coupon->fixed_amount }}</td>
                            @else
                                <td class="border border-gray-300 px-4 py-2">{{ $coupon->discount_percentage }}%</td>
                            @endif
                            <td class="border border-gray-300 px-4 py-2">{{ $coupon->discount_type }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-red-700">{{ $coupon->category_name }}</td>

                            <td class="border border-gray-300 px-4 py-2">{{ $coupon->usage_limit }}</td>
                            <td class="border border-gray-300 px-2 py-2 flex items-center gap-2">
                                <!-- زر الحذف -->
                                <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded flex items-center gap-1"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                        حذف
                                    </button>
                                </form>

                                <!-- رابط التفاصيل -->
                                <a href="{{ route('coupons.show', $coupon) }}"
                                    class="text-blue-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25a2.25 2.25 0 0 0-2.25-2.25h-3a2.25 2.25 0 0 0-2.25 2.25V9m-3 0a3 3 0 0 0-3 3v5.25a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V12a3 3 0 0 0-3-3m-9 0V5.25" />
                                    </svg>
                                    التفاصيل
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
