<?php


use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
// Route::get('/profile', [ProfileController::class, 'getProfile']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/products/{name}', [ProductController::class, 'getByProduct']);
Route::get('/categories', [CategoryController::class, 'getCategories']);
Route::get('/products/category/{id}', [CategoryController::class, 'getByCategory']);
Route::get('/images', [ImageController::class, 'DisplayImagesToUser']);

// Route::middleware('auth:sanctum')->get('/user/orders', [OrderController::class, 'getOrders']);
Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->post('/coupons', [CouponController::class, 'applyCoupon']);
Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->put('/profile/update', [ProfileController::class, 'updateProfile']);
Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->get('/profile', [ProfileController::class, 'getProfile']);
Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->get('/user/orders', [OrderController::class, 'getOrders']);

// Route::get('/user/orders', [OrderController::class, 'getOrders']);
// 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');