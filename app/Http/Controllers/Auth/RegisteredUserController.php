<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// --------------------
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SendOtpMail;




class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function sendOtp(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|digits:11',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // توليد كود OTP عشوائي
        $otp = rand(100000, 999999);

        // تخزين الـ OTP في الجلسة لمدة معينة
        Session::put('user_registration', [
            'name' => $request->name, //
            'email' => $request->email, //
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password), // تشفير كلمة المرور
            'otp_code' => $otp, // الرمز العشوائي
            'otp_expires_at' => now()->addMinutes(4), // شغال لحد 4 دقائق 
        ]);

        // بنبعت الـ OTP على الإيميل
        // بس بنحتاج نعمل ميل بنستدعيه من الـ App\Mail
        //  وبنستدعيه بالطريقة دي فوق
        // use Illuminate\Support\Facades\Mail;
        // use App\Mail\SendOtpMail;
        Mail::to($request->email)->send(new SendOtp($otp));

        // التوجيه إلى صفحة إدخال OTP
        return redirect()->route('verify.otp');
    }
    // 
    public function resendOtp()
    {
        if (!Session::has('user_registration')) {
            return response()->json(['error' => 'لم يتم العثور على بيانات التسجيل. حاول مرة أخرى.'], 400);
        }

        $userData = Session::get('user_registration');

        // التحقق مما إذا كان المستخدم قد طلب إعادة إرسال الرمز قبل 60 ثانية
        if (isset($userData['otp_last_sent']) && now()->diffInSeconds(Carbon::parse($userData['otp_last_sent'])) < 60) {
            return response()->json(['error' => 'يجب الانتظار قبل إعادة إرسال الكود.'], 400);
        }

        // توليد كود OTP جديد
        $otp = rand(100000, 999999);

        // تحديث بيانات الجلسة مع وقت إعادة الإرسال الجديد
        Session::put('user_registration', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone_number' => $userData['phone_number'],
            'password' => $userData['password'],
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(4),
            'otp_last_sent' => now(),
        ]);

        // إرسال الـ OTP عبر البريد الإلكتروني
        // Mail::to($userData['email'])->send(new SendOtp($otp));

        return response()->json(['message' => 'تم إعادة إرسال رمز التحقق إلى بريدك الإلكتروني.'], 200);
    }

    public function verifyOtp(Request $request)
    {
        // التحقق من صحة الـ OTP المدخل
        if (is_array($request->otp)) {
            $request->merge([
                'otp' => implode('', $request->otp)
            ]);
        }

        // التحقق من صحة الإدخال (يجب أن يكون رقمًا من 6 خانات)
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = Session::get('user_registration')['otp_code'];
        $otpExpiresAt = Session::get('user_registration')['otp_expires_at'];

        if ($request->otp == $otp && now()->lessThan($otpExpiresAt)) {
            // إذا كان OTP صحيحًا ولم تنتهي صلاحية الكود

            // تخزين البيانات في قاعدة البيانات
            $user = User::create([
                'name' => Session::get('user_registration')['name'],
                'email' => Session::get('user_registration')['email'],
                'phone_number' => Session::get('user_registration')['phone_number'],
                'password' => Session::get('user_registration')['password'],
                'role' => 'user',

            ]);

            // تسجيل الدخول تلقائيًا بعد التسجيل
            Auth::login($user);

            // إتمام العملية بنجاح
            Session::forget('user_registration');
            return redirect()->route('user');
        }

        // في حالة الخطأ
        return redirect()->back()->withErrors(['otp' => 'الرمز غير صحيح أو منتهي الصلاحية']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|digits:11',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // إنشاء رمز OTP
        $otp = rand(100000, 999999);

        // تخزين بيانات المستخدم في الجلسة بدلًا من قاعدة البيانات
        Session::put('user_registration', [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10), // صلاحية OTP لمدة 10 دقائق
        ]);

        // إرسال OTP إلى البريد الإلكتروني
        // إرسال OTP إلى البريد الإلكتروني
        Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otp));
        return redirect()->route('verify.otp');
        // return response()->json(['message' => 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.'], 200);
    }
}