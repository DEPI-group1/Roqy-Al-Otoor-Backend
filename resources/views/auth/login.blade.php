<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/favicon.ico') }}">
    <title>تسجيل الدخول</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <section class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a  class="flex items-center text-2xl font-semibold text-gray-900">
            <img class="w-32 h-32" src="{{ asset('storage/ALAYHAM.png') }}" alt="logo">

        </a>
        <div class="w-full bg-white rounded-lg shadow sm:max-w-xl xl:p-0 border border-gray-300">
            <div class="p-8 sm:p-10 space-y-6">
                <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl">
                    تسجيل الدخول إلى حسابك
                </h1>
                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                            البريد الإلكتروني
                        </label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            placeholder="name@company.com" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                            كلمة المرور
                        </label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" name="remember"
                                    class="w-5 h-5 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500">تذكرني</label>
                            </div>
                        </div>
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-blue-600 hover:underline">
                            هل نسيت كلمة المرور؟
                        </a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-6 py-3 text-center">
                        تسجيل الدخول
                    </button>
                    <p class="text-sm font-light text-gray-500">
                        لا تملك حسابًا؟ <a href="{{ route('register') }}"
                            class="font-medium text-blue-600 hover:underline">
                            إنشاء حساب جديد
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </section>
</body>

</html>





















{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline m-3 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                <a class="underline p-3 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    {{ __('Create account?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
