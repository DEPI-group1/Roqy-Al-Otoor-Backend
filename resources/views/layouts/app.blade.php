<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <meta name="user-logged-in" content="{{ Auth::check() ? 'true' : 'false' }}">
    <title>{{ config('app.name', 'Alayham') }} || @yield('title', 'الرئيسية')</title>
    <link rel="icon" href="{{ asset('storage/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}


    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

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
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen">
    <div class="min-h-screen">
        @include('layouts.navigation')
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>
        <!-- الفوتر الثابت في الأسفل -->
        @include('layouts.footer')
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setupImageGallery();
            setupCart();
        });

        // ✅ إعداد معرض الصور
        function setupImageGallery() {
            const mainImage = document.getElementById("mainImage");
            const thumbnails = document.querySelectorAll(".thumbnail");
            const modalImage = document.getElementById("modalImage");
            const imageModal = document.getElementById("imageModal");
            const closeModalButton = document.querySelector("#imageModal button");

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener("click", function() {
                    mainImage.src = this.src;
                });
            });

            mainImage.addEventListener("click", function() {
                modalImage.src = this.src;
                imageModal.classList.remove("hidden");
            });

            closeModalButton.addEventListener("click", function() {
                imageModal.classList.add("hidden");
            });
        }

        // ✅ إعداد عربة التسوق
        function setupCart() {
            updateCartCount();
            restoreCartCountFromStorage();
            setupCartEventListeners();
        }

        // ✅ تحديث عدد المنتجات في عربة التسوق
        function updateCartCount() {
            fetch("{{ route('cart.count') }}")
                .then(response => response.json())
                .then(data => {
                    let count = parseInt(data.count) || 0;
                    localStorage.setItem("cartCount", count);
                    updateCartDisplay(count);
                })
                .catch(error => console.error("❌ خطأ في تحديث عدد المنتجات:", error));
        }

        // ✅ استعادة عدد المنتجات المحفوظ بعد إعادة تحميل الصفحة
        function restoreCartCountFromStorage() {
            let savedCount = localStorage.getItem("cartCount") || 0;
            updateCartDisplay(savedCount);
        }

        // ✅ تحديث عرض العدد في الأيقونات المختلفة
        function updateCartDisplay(count) {
            document.querySelectorAll("#cart-count-lg, #cart-count").forEach(el => {
                el.textContent = count;
            });
        }

        // ✅ إضافة الأحداث لعربة التسوق
        function setupCartEventListeners() {
            document.addEventListener("click", function(event) {
                let target = event.target;

                if (target.classList.contains("delete-btn")) {
                    removeFromCart(target);
                } else if (target.classList.contains("add-to-cart-btn")) {
                    addToCart(target);
                } else if (target.classList.contains("shopping-cart-icon")) {
                    handleCartIconClick(target);
                }
            });
        }

        // ✅ إضافة منتج إلى العربة
        let isAddingToCart = false;
        async function addToCart(button) {
            if (isAddingToCart) return;
            isAddingToCart = true;

            let productId = button.dataset.productId;
            let productType = button.dataset.type;

            // التحقق من حالة المستخدم (مسجل دخول أم لا)
            let isLoggedIn = document.querySelector("meta[name='user-logged-in']").getAttribute("content") === "true";

            if (!isLoggedIn) {
                showToast("يرجى إنشاء حساب أولاً لتتمكن من إضافة المنتج إلى السلة.", "error");
                isAddingToCart = false;
                return; // إيقاف الدالة إذا لم يكن المستخدم مسجل الدخول
            }

            try {
                let response = await fetch("/add-to-cart", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute(
                            "content")
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        type: productType
                    })
                });

                let data = await response.json();
                if (data.success) {
                    let newCount = parseInt(localStorage.getItem("cartCount") || 0) + 1;
                    localStorage.setItem("cartCount", newCount);
                    updateCartDisplay(newCount); // ✅ تحديث العرض فورًا
                    showToast(data.message, "success");
                } else {
                    showToast("خطأ: " + data.message, "error");
                }
            } catch (error) {
                showToast("❌ حدث خطأ أثناء إضافة المنتج!", "error");
            }

            isAddingToCart = false;
        }

        // ✅ التعامل مع النقر على أيقونة العربة
        async function handleCartIconClick(icon) {
            await addToCart(icon);
        }

        // ✅ إنشاء وإدارة التوست (إشعارات تنبيهية)
        function showToast(message, type) {
            let toast = document.querySelector(".toast") || createToast();
            toast.textContent = message;
            toast.className = "toast " + type;
            toast.style.display = "block";

            setTimeout(() => {
                toast.style.opacity = "1";
                setTimeout(() => {
                    toast.style.opacity = "0";
                    setTimeout(() => {
                        toast.style.display = "none";
                    }, 500);
                }, 2000);
            }, 100);
        }

        function createToast() {
            const toast = document.createElement("div");
            toast.classList.add("toast");
            toast.style.display = "none";
            document.body.appendChild(toast);
            return toast;
        }
        // ✅ تهيئة عربة التسوق عند تحميل الصفحة
        document.addEventListener("DOMContentLoaded", setupCart);
    </script>
</body>

</html>
