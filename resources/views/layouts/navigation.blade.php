<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>

    <style>
        .line-clamp {
            font-size: 14px;
            /* تصغير حجم الخط */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* تحديد عدد الأسطر إلى سطرين */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            /* إظهار (...) عند القطع */
            height: 2.8em;
            /* ضبط الارتفاع حسب حجم الخط */
        }

        .cart-container {
            display: flex;
            justify-content: flex-end;
            /* جعل الأيقونة في اليسار */
            align-items: center;
            margin-top: 10px;
            border-bottom: 1px solid #27d117;
        }

        .cart-icon {
            font-family: 'Figtree', sans-serif;
            font-size: 24px;
            /* color: #007bff; */
            cursor: pointer;
            bottom: 1;
            transition: transform 0.3s ease-in-out;
        }

        .cart-icon:hover {
            transform: scale(1.2);
        }

        /* ----------- */
        /* ستايل التوست */
        .toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            display: none;
            z-index: 9999;
        }

        .toast.success {
            background-color: #28a745;
            /* اللون الأخضر للنجاح */
        }

        .toast.error {
            background-color: #dc3545;
            /* اللون الأحمر للفشل */
        }

        #animation-carousel {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('/') }}" class="flex items-center space-x-3 w-[130px] h-[95px] py-0">
                <img src="{{ asset('storage/ALAYHAM.png') }}" alt="ALAYHAM" class="object-contain">
            </a>
            <!-- Mobile Search Bar -->
            <!-- Search Bar in large screens -->
            <div class="hidden md:flex flex-1 mx-6 max-w-lg relative">
                <input type="text" id="search-desktop" placeholder="ابحث عن منتج..."
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div id="search-results-desktop"
                    class="absolute left-0 mt-1 w-full bg-white text-black rounded-lg shadow-lg hidden"></div>
            </div>
            <!-- Navigation Links -->
            <ul class="hidden md:flex space-x-8 space-x-reverse text-gray-600 font-medium">
                <li><a href="{{ route('user/products') }}" class="hover:text-blue-600 transition">جميع المنتجات</a>
                </li>
                <li><a href="{{ route('offers') }}" class="hover:text-blue-600 transition">العروض</a></li>
                <li><a href="{{ route('MyOrders') }}" class="hover:text-green-600 transition">طلباتي</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-blue-600 transition">اتصل بنا</a></li>
            </ul>

            <!-- Icons in large screens-->
            <div class="hidden md:flex items-center space-x-6 space-x-reverse">
                <!-- زر الإشعارات للشاشات الكبيرة -->
                <button class="relative flex items-center notification-btn-lg">
                    <i data-lucide="bell" class="text-gray-600 w-6 h-6"></i> <span
                        class="absolute -top-2 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                        {{-- {{ Auth::user()->unreadNotifications->count() ?? 0 }} --}}
                        @auth
                            {{ auth()->user()->unreadNotifications->count() }}
                        @endauth
                        @guest
                            0
                        @endguest

                    </span>
                </button>
                {{-- cart icon in large screen --}}
                <a href="{{ route('user.cart') }}" class="relative">
                    <i data-lucide="shopping-cart" class="text-gray-600 w-6 h-6"></i>
                    <span id="cart-count-lg"
                        class="count absolute -top-2 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                        0
                    </span>
                </a>
                {{-- if user has no account --}}
                <div class="flex items-center space-x-6 space-x-reverse">
                    @auth
                        <!-- إذا كان المستخدم مسجلاً، أظهر أيقونة الحساب -->
                        <a href="{{ route('profile.edit') }}">
                            <i data-lucide="user" class="w-6 h-6 text-gray-600"></i>
                        </a>
                    @else
                        <!-- إذا لم يكن المستخدم مسجلاً، أظهر زر "إنشاء حساب" -->
                        <a href="{{ route('register') }}"
                            class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                            <span>إنشاء حساب</span>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Mobile top icons search and bar -->
            <div class="flex items-center space-x-4 space-x-reverse md:hidden">
                <button id="search-toggle" class="px-2">
                    <i data-lucide="search" class="w-6 h-6 text-gray-600"></i>
                </button>

                {{-- create account in mobile --}}
                <div class="flex items-center space-x-reverse">
                    @auth
                        <!-- إذا كان المستخدم مسجلاً، أظهر أيقونة الحساب -->
                        <!-- زر الإشعارات -->
                        <button class="relative flex items-center notification-btn me-2">
                            <!-- أيقونة الإشعارات -->
                            <i data-lucide="bell" class="text-gray-600 w-6 h-6"></i> <span
                                class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        </button>
                    @else
                        <!-- إذا لم يكن المستخدم مسجلاً، أظهر زر "إنشاء حساب" -->
                        <a href="{{ route('register') }}"
                            class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i data-lucide="user-plus" class="w-5 h-5"></i>
                            <span>إنشاء حساب</span>
                        </a>
                    @endauth
                </div>

                {{-- <button id="search-toggle" class="px-2">
                        <i data-lucide="search" class="w-6 h-6 text-gray-600"></i>
                    </button> --}}
                {{-- <button class="text-gray-600 pe-2" id="menu-toggle">
                    <i data-lucide="menu" class="w-7 h-7"></i>
                </button> --}}
            </div>
        </div>
        <!-- Mobile Search Bar -->
        <div id="mobile-search" class="hidden md:hidden p-4 bg-white relative">
            <input type="text" id="search-mobile" placeholder="ابحث عن منتج..."
                class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div id="search-results-mobile"
                class="absolute left-0 mt-1 w-full bg-white text-black rounded-lg shadow-lg hidden"></div>
        </div>
        <!-- Mobile Menu -->
        <ul class="md:hidden hidden flex-col bg-white mt-2 p-4 space-y-2 text-gray-600" id="mobile-menu">
            <li><a href="{{ route('user') }}" class="block hover:text-blue-600 transition">الرئيسية</a></li>
            <li><a href="{{ route('user/products') }}" class="block hover:text-blue-600 transition">جميع
                    المنتجات</a>
            </li>
            <li><a href="{{ route('offers') }}" class="block hover:text-blue-600 transition">العروض</a></li>
            <li><a href="{{ route('contact') }}" class="block hover:text-blue-600 transition">اتصل بنا</a></li>
        </ul>
    </nav>
    <div
        class="fixed bottom-0 left-0 w-full bg-white shadow-md py-3 flex justify-around items-center md:hidden border-t z-50">
        <a href="{{ route('user') }}">
            <i data-lucide="home" class="w-6 h-6 text-gray-600"></i>
        </a>
        <a href="{{ route('user.cart') }}" class="relative">
            <i data-lucide="shopping-cart" class="text-gray-600 w-6 h-6"></i>
            <span id="cart-count"
                class="count absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full px-1">
                0
            </span>
        </a>
        <a href="{{ route('MyOrders') }}">
            <i data-lucide="shopping-bag" class="w-7 h-7 text-gray-600"></i>
        </a>

        <a href="{{ route('profile.edit') }}">
            <i data-lucide="user" class="w-7 h-7 text-gray-600"></i>
        </a>
        <button class="text-gray-600" id="menu-toggle">
            <i data-lucide="menu" class="w-7 h-7"></i>
        </button>
    </div>

    <div class="relative">
        <!-- قائمة الإشعارات -->
        <div
            class="hidden absolute left-2 top-full mt-2 w-72 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200 z-50 dropdown-menu">
            <div class="px-4 py-3 bg-gray-100 text-gray-700 font-semibold">
                الإشعارات
            </div>
            <ul class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
                @if (!empty(auth()->user()->unreadNotifications))
                    @forelse (auth()->user()->unreadNotifications as $notification)
                        @php
                            $data = is_array($notification->data)
                                ? $notification->data
                                : json_decode($notification->data, true);
                        @endphp
                        <li class="p-3 hover:bg-gray-50 flex justify-between items-center">
                            <a href="{{ route('MyOrders', $data['order_id'] ?? '#') }}" class="flex-1">
                                <p class="text-sm font-medium">{{ $data['message'] ?? 'لديك طلب جديد' }}</p>
                                <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}
                                </p>
                            </a>
                            <!-- زر مسح إشعار واحد -->
                            <form action="{{ route('notifications.markOneAsRead', $notification->id) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 text-xs hover:underline">مسح</button>
                            </form>
                        </li>
                    @empty
                        <li class="p-3 text-center text-gray-500">لا توجد إشعارات جديدة</li>
                    @endforelse
                @endif
            </ul>

            <!-- زر مسح كل الإشعارات -->
            @if (!empty(auth()->user()->unreadNotifications) && auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST"
                    class="p-3 border-t border-gray-200">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 text-white p-2 rounded hover:bg-red-600">مسح
                        الكل</button>
                </form>
            @endif
        </div>
    </div>

    <script>
        lucide.createIcons();
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll('.notification-btn');
            const menus = document.querySelectorAll('.dropdown-menu');

            buttons.forEach((btn, index) => {
                btn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    // تأكد من وجود قائمة لهذا الزر
                    if (menus[index]) {
                        menus[index].classList.toggle('hidden');
                    }
                });
            });

            document.addEventListener('click', (event) => {
                menus.forEach((menu) => {
                    if (!menu.contains(event.target) &&
                        !event.target.classList.contains('notification-btn') &&
                        !event.target.classList.contains('notification-btn-lg')) {
                        menu.classList.add('hidden');
                    }
                });
            });
        });
        // 

        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll('.notification-btn-lg');
            const menus = document.querySelectorAll('.dropdown-menu');

            buttons.forEach((btn, index) => {
                btn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    // تأكد من وجود قائمة لهذا الزر
                    if (menus[index]) {
                        menus[index].classList.toggle('hidden');
                    }
                });
            });

            document.addEventListener('click', (event) => {
                menus.forEach((menu) => {
                    if (!menu.contains(event.target) &&
                        !event.target.classList.contains('notification-btn-lg')) {
                        menu.classList.add('hidden');
                    }
                });
            });
        });
    </script>

    @guest
        {{-- موديل يظهر لليوزر بعد 13 ثانية لو لم يكن مسجل دخول --}}
        <div id="registerModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center relative">
                <img src="{{ asset('storage/ALAYHAM.png') }}" alt="ALAYHAM" class="w-32 h-32 mx-auto mb-4">
                <h2 class="text-lg font-semibold mb-4">انضم إلينا الآن!</h2>
                <p class="text-gray-600 mb-4">قم بإنشاء حساب للاستفادة من جميع الميزات.</p>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    إنشاء حساب
                </a>
                <button id="closeModal"
                    class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    let modal = document.getElementById("registerModal");
                    if (modal) {
                        modal.classList.remove("hidden");
                    }
                }, 13000); // بعد 13 ثانية

                let closeModal = document.getElementById("closeModal");
                if (closeModal) {
                    closeModal.addEventListener("click", function() {
                        document.getElementById("registerModal").classList.add("hidden");
                    });
                }
            });
        </script>
    @endguest



    <!-- إضافة padding لمنع المحتوى من التغطية -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        lucide.createIcons();
        document.getElementById("menu-toggle").addEventListener("click", function() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });
        document.getElementById("search-toggle").addEventListener("click", function() {
            document.getElementById("mobile-search").classList.toggle("hidden");
        });
    </script>

    <style>
        #search-results-mobile,
        #search-results-desktop {
            position: absolute;
            /* يجعل النتائج تطفو فوق باقي العناصر */
            top: 100%;
            /* يظهر النتائج أسفل شريط البحث مباشرة */
            left: 0;
            width: 100%;
            background-color: white;
            z-index: 9999;
            /* تأكد أن القيمة أكبر من أي عنصر آخر */
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    {{-- JavaScript for AJAX Search --}}

    <script>
        $(document).ready(function() {
            let searchTimeout; // متغير لتحديد المهلة الزمنية

            $('input[id^="search"]').on("keyup", function() {
                clearTimeout(searchTimeout); // إلغاء أي مؤقت سابق

                let query = $(this).val().trim();
                let resultsBox = $(this).attr('id') === "search-mobile" ? $("#search-results-mobile") : $(
                    "#search-results-desktop");

                if (query.length > 2) {
                    searchTimeout = setTimeout(() => { // تأخير البحث قليلاً
                        $.ajax({
                            url: "/search",
                            method: "GET",
                            data: {
                                query: query
                            },
                            success: function(data) {
                                resultsBox.html(""); // مسح النتائج القديمة

                                if (data.length > 0) {
                                    data.forEach(product => {
                                        let imageUrl = product.images.length >
                                            0 ?
                                            `/storage/products/${product.images[0].image}` :
                                            "/default.jpg";

                                        let item = `
    <div class="result-item p-2 border-b hover:bg-gray-200 cursor-pointer flex items-center">
        <a href="/product/${product.name}" class="flex items-center space-x-3 w-full">
            <img src="${imageUrl}" class="w-12 h-12 object-cover rounded-lg border" alt="${product.name}">
            <span class="text-sm font-medium mx-2">${product.name}</span>
        </a>
    </div>
`;
                                        resultsBox.append(item);
                                    });
                                    resultsBox.slideDown(); // تحسين عرض النتائج
                                } else {
                                    resultsBox.html(
                                        '<p class="p-2 text-gray-500">لا توجد نتائج</p>'
                                    ).slideDown();
                                }
                            },
                            error: function() {
                                resultsBox.html(
                                    '<p class="p-2 text-red-500">حدث خطأ أثناء البحث</p>'
                                ).slideDown();
                            }
                        });
                    }, 300); // تأخير البحث 300 مللي ثانية
                } else {
                    resultsBox.slideUp(); // إخفاء النتائج إذا كانت المدخلة غير كافية
                }
            });

            // إخفاء نتائج البحث عند النقر خارجها
            $(document).on("click", function(e) {
                if (!$(e.target).closest('input[id^="search"], div[id^="search-results"]').length) {
                    $('div[id^="search-results"]').slideUp();
                }
            });
        });
    </script>

    {{-- <script>
        lucide.createIcons();
    </script> --}}

</body>

</html>
