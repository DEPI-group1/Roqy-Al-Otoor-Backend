<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/favicon.ico') }}">
    <title>تسجيل حساب جديد</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="flex w-screen flex-wrap text-slate-800">
        <!-- القسم الأيسر -->
        <div class="hidden md:flex md:w-1/2 h-screen flex-col justify-center bg-blue-600 text-center text-white p-8">
            <div class="flex justify-center md:justify-center">
                <a href="#" class="text-2xl font-bold text-white-600">
                    <img src="{{ asset('storage/ALAYHAM.png') }}" alt="dfnqdfn" class="w-40"></a>
            </div>

            <span class="rounded-full bg-white px-3 py-1 font-medium text-blue-600">ميزة جديدة</span>
            <p class="my-6 text-3xl font-semibold leading-10" style="direction: rtl;">
                مرحبًا بك في ALAYHAM – وجهتك الأولى للصحة والجمال!
                <span class="block w-56 mx-auto bg-orange-400 text-white rounded-lg py-2 my-1">السحب والإفلات</span>
            </p>
            {{-- <p class="mb-4">هذا نص تجريبي يمكن استبداله بالمحتوى الفعلي.</p> --}}
        </div>

        <!-- القسم الأيمن (التسجيل) مع إمكانية التمرير -->
        <div class="flex w-full md:w-1/2 flex-col h-screen overflow-y-auto">
            {{-- <div class="flex justify-center pt-12 md:justify-start md:pl-12">
                <a href="#" class="text-2xl font-bold text-blue-600">YAZAN .</a>
            </div> --}}

            <div class="mx-auto flex flex-col px-6 py-8 lg:w-[28rem]">
                <p class="text-center text-3xl font-bold">إنشاء حساب جديد</p>
                <p class="mt-6 text-center font-medium">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" class="text-blue-700 font-semibold">تسجيل الدخول</a>
                </p>

                <form class="flex flex-col items-stretch pt-8" method="POST" action="{{ route('register.sendOtp') }}">
                    @csrf

                    <!-- الحقول -->
                    <div class="flex flex-col pt-4">
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border-2 p-2 rounded-md focus:border-blue-600" placeholder="الاسم" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col pt-4">
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required
                            class="w-full border-2 p-2 rounded-md focus:border-blue-600" placeholder="رقم الهاتف" />
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col pt-4">
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border-2 p-2 rounded-md focus:border-blue-600"
                            placeholder="البريد الإلكتروني" />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col pt-4">
                        <input type="password" name="password" required
                            class="w-full border-2 p-2 rounded-md focus:border-blue-600"
                            placeholder="كلمة المرور (8 أحرف على الأقل)" />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col pt-4">
                        <input type="password" name="password_confirmation" required
                            class="w-full border-2 p-2 rounded-md focus:border-blue-600"
                            placeholder="تأكيد كلمة المرور" />
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center pt-4">
                        <input type="checkbox" class="h-5 w-5 mr-2" checked>
                        <label>أوافق على <a href="#" class="underline">الشروط والأحكام</a></label>
                    </div>

                    <button type="submit"
                        class="mt-6 bg-blue-600 text-white font-semibold p-2 rounded-md hover:bg-blue-700">
                        تسجيل
                    </button>
                </form>
            </div>
        </div>
    </div>




    {{-- <section class="w-full max-w-md bg-white rounded-lg shadow-md p-6 sm:p-8 border border-gray-200">
        <div class="text-center mb-6">
            <img class="w-16 h-16 mx-auto mb-2" src="{{ asset('storage/MAINLOGO.jpg') }}" alt="logo">
            <h2 class="text-2xl font-bold text-gray-700">تسجيل حساب جديد</h2>
        </div>
        <form method="POST" action="{{ route('register.sendOtp') }}">
            @csrf

            <!-- First Name -->
            <div class="mb-4">
                <label for="first_name" class="block text-gray-700 font-medium mb-1">الاسم الأول</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Name -->
            <div class="mb-4">
                <label for="last_name" class="block text-gray-700 font-medium mb-1">الإسم الأخير</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-medium mb-1">رقم الهاتف</label>
                <input type="tel" id="phone" name="phone_number" value="{{ old('phone_number') }}" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('phone_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">كلمة المرور</label>
                <input type="password" id="password" name="password" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">تأكيد كلمة
                    المرور</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-blue-600 text-sm hover:underline">لديك حساب بالفعل؟ تسجيل
                    الدخول</a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-all">تسجيل</button>
            </div>
        </form>
    </section> --}}
</body>

</html>















{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register.sendOtp') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Phone Number  -->
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="number" name="phone_number" :value="old('phone_number')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
