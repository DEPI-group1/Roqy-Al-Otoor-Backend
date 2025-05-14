<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رُقي العطور
        | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- مكتبة Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <style>
        body {
            overflow-x: hidden;
            direction: rtl;
        }

        /* السايد بار مفتوح افتراضيًا */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            /* السايد بار مفتوح عند بدء الصفحة */
            background: #343a40;
            color: white;
            transition: 0.3s ease-in-out;
            padding-top: 10px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #6c757d transparent;
        }

        /* تخصيص شكل شريط التمرير للسايد بار */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #6c757d;
            border-radius: 5px;
        }

        .content {
            transition: margin-right 0.3s ease-in-out;
            margin-right: 280px;
            /* تحريك المحتوى ليأخذ مساحة السايد بار */
            height: 100vh;
            overflow-y: auto;
            padding: 20px;
        }

        .sidebar a:hover {
            background: #495057;
        }

        /* عند إغلاق السايد بار */
        .sidebar.closed {
            right: -250px;
        }

        .content.shift {
            margin-right: 40px;
        }

        /* زر التحكم */
        .toggle-btn {
            position: fixed;
            right: 260px;
            /* متناسق مع السايد بار المفتوح */
            top: 15px;
            background: #343a40;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            border-radius: 5px;
            z-index: 1000;
        }

        .toggle-btn:hover {
            background: #495057;
        }

        /* عند إغلاق السايد بار */
        .sidebar.closed+.toggle-btn {
            right: 10px;
        }
    </style>
</head>

<body>
    <!-- السايد بار -->
    <div class="sidebar" id="sidebar">
        <h3 class="text-center m-1 text-2xl">رُقي العطور</h3>
        <hr>
        <ul>
            <li class="mb-4">
                <a href="{{ route('dashboard') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-home ml-3"></i> الرئيسية
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('products') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-box-open ml-3"></i> المنتجات
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('categories') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-tags ml-3"></i> الفئات
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('earningsReport') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-chart-line ml-3"></i> تقرير الأرباح
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('packages.index') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-box ml-3"></i> باكدجات
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('offers.index') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-gift ml-3"></i>
                    العروض
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('add-image') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-image ml-3"></i> إعدادات الصور
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('orders') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-shopping-cart ml-3"></i> الطلبات
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('coupons.index') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-ticket-alt ml-2"></i> الكوبونات
                </a>
            </li>
            @if (Auth::id() === 1)
                <li class="mb-4">
                    <a href="{{ route('index.admins') }}"
                        class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                        <i class="fas fa-user-cog ml-3"></i> الأدمن
                    </a>
                </li>
            @endif
            <li class="mb-4">
                <a href="{{ route('profile.edit') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center">
                    <i class="fas fa-user-cog ml-3"></i> الإعدادات
                </a>
            </li>
            <li class="mt-6">
                <a href="{{ route('logout') }}"
                    class="hover:bg-gray-700 p-2 block rounded-lg text-white flex items-center"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt ml-3"></i> تسجيل الخروج
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- زر الفتح والإغلاق -->
    <button class="toggle-btn" id="toggleBtn" onclick="toggleSidebar()">☰</button>


    <!-- المحتوى الرئيسي -->
    <div class="content" id="content">
        <!-- Content Area -->
        <div class="flex-1 p-1 overflow-y-auto mb-4">
            <div class="bg-white p-4 shadow-md rounded-lg text-right relative">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-700"> أهلا، </span>
                        <span class="font-bold"> {{ Auth::user()->name }} </span>
                    </div>

                    <!-- أيقونة الإشعارات -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative text-gray-700 hover:text-blue-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V10a6 6 0 00-12 0v4c0 .386-.146.735-.405 1.002L4 17h5m6 0a3 3 0 11-6 0">
                                </path>
                            </svg>
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0 right-0 block w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </button>

                        <!-- قائمة الإشعارات -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg">
                            <div class="p-2 text-sm font-semibold text-gray-700 border-b">الإشعارات</div>
                            <ul class="p-2 space-y-2 max-h-60 overflow-y-auto">
                                @foreach (auth()->user()->unreadNotifications as $notification)
                                    <div class="alert alert-info">
                                        {{ $notification->data['message'] }}
                                        <a
                                            href="{{ route('orders.show.notification', ['id' => $notification->data['order_id'], 'notification' => $notification->id]) }}">
                                            عرض الطلب
                                        </a>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-semibold text-gray-700 hover:text-blue-800">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                            </a>
                        </li>

                        @php
$segments = Request::segments();
$url = '';
                        @endphp

                        @foreach ($segments as $index => $segment)
                                                @php
    $url .= '/' . $segment;
    $isLast = $loop->last;
    $segmentName = $segment == 'admin' ? ' Dashboard' : ucfirst($segment);
    $segmentUrl = $segment == 'admin' ? '/dashboard' : $url;
                                                @endphp

                                                <li class="flex items-center">
                                                    <svg class="w-3 h-3 text-gray-400 mx-1 rotate-180" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                                    </svg>

                                                    @if (!$isLast)
                                                        <a href="{{ url($segmentUrl) }}" class="ms-1 text-sm font-semibold hover:text-green-800">
                                                            {{ $segmentName }}
                                                        </a>
                                                    @else
                                                        <span class="ms-1 text-sm font-bold text-red-500">
                                                            {{ $segmentName }}
                                                        </span>
                                                    @endif
                                                </li>
                        @endforeach
                    </ol>
                </nav>
            </div>

            <!-- تضمين Alpine.js -->
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

            <!-- Script لتفعيل الدروب داون -->
            <script>
                document.getElementById('notification-btn').addEventListener('click', function () {
                    let dropdown = document.getElementById('notification-dropdown');
                    dropdown.classList.toggle('hidden');
                });

                // إغلاق القائمة عند الضغط خارجها
                document.addEventListener('click', function (event) {
                    let dropdown = document.getElementById('notification-dropdown');
                    let button = document.getElementById('notification-btn');

                    if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            </script>

            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let content = document.getElementById("content");
            let toggleBtn = document.getElementById("toggleBtn");

            sidebar.classList.toggle("closed");
            content.classList.toggle("shift");

            // تعديل موقع الزر حسب حالة السايد بار
            if (sidebar.classList.contains("closed")) {
                toggleBtn.style.right = "10px";
            } else {
                toggleBtn.style.right = "260px";
            }
        }
    </script>


    <!-- jQuery (Toastr يحتاجه) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "timeOut": "3000"
        };

        $(document).ready(function () {
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif
        });
    </script>

</body>

</html>