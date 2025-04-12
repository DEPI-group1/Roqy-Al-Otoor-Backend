@extends('layouts.sideBar')

@section('title', 'تقرير الأرباح')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">📊 تقرير الأرباح</h2>

        <!-- كارت إجمالي الأرباح -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-green-600 text-white p-3 rounded-lg shadow-md">
                <h5 class="text-lg font-semibold">إجمالي الأرباح</h5>
                <h3 class="text-xl font-bold">جنيهاََ مصرياََ : {{ number_format($totalEarnings, 2) }}</h3>
            </div>
        </div>

        <!-- زر لتغيير نوع التقرير -->
        <div class="mt-6 flex gap-3">
            <a href="{{ route('earningsReport', ['type' => 'monthly']) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center gap-1">
                📅 شهري
            </a>
            <a href="{{ route('earningsReport', ['type' => 'daily']) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center gap-1">
                📆 يومي
            </a>
        </div>

        <!-- رسم بياني باستخدام Chart.js -->
        <div class="mt-6">
            <canvas id="earningsChart" class="w-full"></canvas>
        </div>

        <!-- جدول الأرباح -->
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-gray-800 text-white border border-gray-700 rounded-lg">
                <thead>
                    <tr class="bg-gray-900 text-gray-300">
                        <th class="py-2 px-4">{{ $type == 'daily' ? 'التاريخ' : 'الشهر / السنة' }}</th>
                        <th class="py-2 px-4">💰 إجمالي الأرباح</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($earnings as $earning)
                        <tr class="border-b border-gray-700 hover:bg-gray-700">
                            <td class="py-2 px-4">{{ $type == 'daily' ? $earning->date : $earning->year . '-' . $earning->month }}</td>
                            <td class="py-2 px-4">${{ number_format($earning->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- إضافة سكريبت الرسم البياني -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('earningsChart').getContext('2d');
        var earningsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($earnings->pluck($type == 'daily' ? 'date' : 'month')) !!},
                datasets: [{
                    label: 'الأرباح',
                    data: {!! json_encode($earnings->pluck('total')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
