{{-- code 1 --}}
{{-- <form method="POST" action="{{ route('register.verifyOtp') }}">
    @csrf

    <div class="mt-4">
        <x-input-label for="otp" :value="__('Enter OTP Code')" />
        <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autocomplete="off" />
        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ms-4">
            {{ __('Verify OTP') }}
        </x-primary-button>
    </div>
</form> --}}






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

{{-- <body class="flex items-center justify-center min-h-screen bg-gray-100 px-2"> --}}

<body class="flex items-center justify-center min-h-[70vh] bg-gray-100 px-2">
    <div class="w-full max-w-sm mx-auto text-center bg-white px-2 py-8 rounded-xl shadow-lg">
        <header class="mb-4">
            <h1 class="text-2xl font-bold mb-1">OTP Email Verification</h1>
            <p class="text-[15px] text-slate-500">بعتنالك كود على الإيميل بتاعك</p>
            <span class="text-indigo-600 font-medium">{{ Session::get('user_registration')['email'] }}</span>
        </header>

        <form id="otp-form" method="POST" action="{{ route('register.verifyOtp') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="otp" id="otp-hidden">

            <div class="flex justify-center gap-2">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text"
                        class="otp-input w-12 h-12 text-center text-lg font-extrabold text-slate-900 bg-slate-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        maxlength="1" required />
                @endfor
            </div>

            @if ($errors->has('otp'))
                <p class="text-red-500 text-sm mt-2">{{ $errors->first('otp') }}</p>
            @endif

            <button type="submit"
                class="w-full bg-indigo-500 text-white py-3 rounded-lg text-lg font-semibold shadow-md hover:bg-indigo-600 focus:ring focus:ring-indigo-300 transition duration-150">
                Verify Account
            </button>
        </form>

        <div class="text-sm text-gray-600 mt-4">
            مجالكش كود؟
            <a id="resend-otp" class="font-medium text-indigo-500 hover:text-indigo-600 cursor-pointer">
                ابعت تاني
            </a>
            <div id="otp-message" class="mt-2 text-sm hidden"></div>
            <span id="resend-timer" class="text-gray-400 ml-2 hidden"> (انتظر 30 ثانية)</span>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let resendBtn = document.getElementById("resend-otp");
                let resendTimer = document.getElementById("resend-timer");
                let messageBox = document.getElementById("otp-message");
                let email = "{{ request()->email }}"; // تأكد أن الإيميل متاح في الصفحة
                let canResend = true;

                resendBtn.addEventListener("click", function() {
                    if (!canResend) return;

                    fetch("{{ route('resend.otp') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                email: email
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            showMessage(data.message, "text-green-600");
                            startResendCooldown();
                        })
                        .catch(error => {
                            showMessage("حدث خطأ أثناء إعادة الإرسال.", "text-red-600");
                            console.error("حدث خطأ:", error);
                        });
                });

                function showMessage(message, colorClass) {
                    messageBox.textContent = message;
                    messageBox.className = `mt-2 text-sm ${colorClass}`;
                    messageBox.classList.remove("hidden");
                }

                function startResendCooldown() {
                    canResend = false;
                    resendBtn.classList.add("text-gray-400");
                    resendBtn.classList.remove("text-indigo-500", "hover:text-indigo-600");
                    resendTimer.classList.remove("hidden");

                    let seconds = 120;
                    resendTimer.textContent = `(انتظر ${seconds} ثانية)`;

                    let countdown = setInterval(() => {
                        seconds--;
                        resendTimer.textContent = `(انتظر ${seconds} ثانية)`;

                        if (seconds <= 0) {
                            clearInterval(countdown);
                            canResend = true;
                            resendBtn.classList.remove("text-gray-400");
                            resendBtn.classList.add("text-indigo-500", "hover:text-indigo-600");
                            resendTimer.classList.add("hidden");
                        }
                    }, 1000);
                }
            });
        </script>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('otp-form');
            const inputs = [...document.querySelectorAll('.otp-input')]; // تأكد أن الحقول لها هذا الكلاس
            const hiddenInput = document.getElementById('otp-hidden');

            form.addEventListener('submit', (e) => {
                e.preventDefault(); // منع الإرسال الافتراضي لضمان جمع القيم بشكل صحيح
                hiddenInput.value = inputs.map(input => input.value).join('');
                form.submit(); // إرسال النموذج بعد تحديث القيمة
            });

            inputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (!/^\d$/.test(e.target.value)) {
                        e.target.value = '';
                        return;
                    }
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && index > 0 && e.target.value === '') {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('focus', (e) => e.target.select());
            });
        });
    </script>

</body>

</html>
