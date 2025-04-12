        <footer class="bg-white rounded-lg shadow-sm dark:bg-gray-900 bg-gray-800 text-white py-4 text-center mt-auto">
            <div class="w-full max-w-screen-xl mx-auto  md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    {{-- <a href="{{ route('/') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('storage/ALAYHAM.png') }}" class="h-8" alt="ALAYHAM Logo" />
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">ALAYHAM</span>
                    </a> --}}

                    <a href="{{ route('/') }}" class="flex items-center space-x-3 w-[130px] h-[95px] py-0">
                        <img src="{{ asset('storage/ALAYHAM.png') }}" alt="شعار الموقع" class="object-contain">
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">ALAYHAM</span>
                    </a>


                    <ul
                        class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                        <li><a href="#" class="hover:underline me-4 md:me-6">About</a></li>
                        <li><a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a></li>
                        <li><a href="#" class="hover:underline me-4 md:me-6">Licensing</a></li>
                        <li><a href="#" class="hover:underline">Contact</a></li>
                    </ul>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
                    © {{ date('Y') }} <a href="https://flowbite.com/" class="hover:underline">Alayhan™</a>. All
                    Rights
                    Reserved.
                </span>
                <a href="{{ route('team-work') }}" target="_blank" class="text-white">فريق العمل</a>
            </div>
        </footer>
