<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
use App\Models\Otp;
use App\Mail\SendOtp;


class AuthController extends Controller
{

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $otp = rand(100000, 999999);
        // حفظ OTP في قاعدة البيانات
        Otp::updateOrCreate(
            ['email' => $request->email],
            ['code' => $otp, 'expires_at' => now()->addMinutes(10)]
        );

        // إرسال البريد الإلكتروني
        Mail::to($request->email)->send(new SendOtp($otp));

        return response()->json(['message' => 'تم إرسال رمز التحقق']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|unique:users', // إضافة التحقق من تكرار رقم الهاتف
            'password' => 'required|min:8',
            'otp' => 'required|digits:6'
        ]);

        // التحقق إذا كان المستخدم موجود من قبل باستخدام الإيميل
        $existingUserByEmail = User::where('email', $request->email)->first();
        if ($existingUserByEmail) {
            return response()->json(['error' => 'هذا البريد الإلكتروني مسجل مسبقًا.'], 409);
        }

        // التحقق إذا كان المستخدم موجود من قبل باستخدام رقم الهاتف
        $existingUserByPhone = User::where('phone_number', $request->phone_number)->first();
        if ($existingUserByPhone) {
            return response()->json(['error' => 'هذا الرقم مسجل مسبقًا.'], 409);
        }

        // التحقق من OTP
        $otpRecord = Otp::where('email', $request->email)
            ->where('code', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['error' => 'رمز التحقق غير صحيح أو انتهت صلاحيته.'], 422);
        }

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        // إنشاء التوكن
        $token = $user->createToken('auth-token', ['*'], now()->addMonths(2))->plainTextToken;

        // حذف OTP بعد الاستخدام
        $otpRecord->delete();

        return response()->json([
            'message' => 'تم إنشاء الحساب بنجاح.',
            'user' => $user,
            'token' => $token
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'بيانات الدخول غير صحيحة'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'sanctum_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }
}