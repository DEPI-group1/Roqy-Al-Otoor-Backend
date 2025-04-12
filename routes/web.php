<?php

use App\Http\Controllers\AdminControl;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AdminController;
// -----------------------------
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthController;



Route::get('test', [AuthController::class,'register']);


Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');
// });



// Route::middleware('auth')->group(function () {
Route::get('verify-email', EmailVerificationPromptController::class)
    ->name('verification.notice');

Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->name('password.confirm');

Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

Route::put('password', [PasswordController::class, 'update'])->name('password.update');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('product.update');

// ---------------- Admin Routes ----------------
Route::prefix('admin')->group(function () {
    // Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products', [ProductController::class, 'index'])->name('products');  // عرض جميع المنتجات
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');  // عرض جميع المنتجات
    Route::get('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/show/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    // Route::put('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/image/{id}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('admin/products/import', [ProductController::class, 'showImportForm'])->name('products.import');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/notification/{notification}', [OrderController::class, 'showId'])->name('orders.show.notification');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::delete('/categories/images/{id}', [CategoryController::class, 'deleteImage'])->name('categories.deleteImage');
    Route::get('/category/products/{category_id}', [CategoryController::class, 'showProducts'])->name('categories.products');
    Route::get('/category/import/{categoryName}', [CategoryController::class, 'showImportFormForCategory'])->name('categories.import');
    Route::post('/category/import', [CategoryController::class, 'importproducts'])->name('categories.import.store');
    Route::resource('coupons', CouponController::class);
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::resource('packages', PackageController::class)->except(['index']);
    Route::get('/control', [AdminControl::class, 'index'])->name('control');
    Route::post('/control/store', [AdminControl::class, 'store'])->name('control.store');
    Route::delete('/control/{id}', [AdminControl::class, 'destroy'])->name('control.destroy');
    Route::delete('/images/{id}', [ImageController::class, 'deleteImage'])->name('carousel.image.delete');
    Route::get('/add-image', [ImageController::class, 'index'])->name('add-image');
    Route::post('/images/store', [ImageController::class, 'store'])->name('images.store');

    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    // -------------------------------
    Route::get('/earnings-report', [AdminController::class, 'earningsReport'])->name('earningsReport');
})->middleware('sauth:anctum');


// ---------------- Offer Management ----------------
Route::prefix('offers')->group(function () {
    // Route::get('/', [OfferController::class, 'index'])->name('offers.index'); // عرض جميع العروض
    Route::get('/', [OfferController::class, 'indexToUser'])->name('offers'); // عرض جميع العروض
    Route::get('/create', [OfferController::class, 'create'])->name('offers.create'); // صفحة إضافة عرض جديد
    Route::post('/store', [OfferController::class, 'store'])->name('offers.store'); // حفظ العرض الجديد
    Route::get('/{id}/edit', [OfferController::class, 'edit'])->name('offers.edit'); // صفحة تعديل العرض
    Route::put('/{id}', [OfferController::class, 'update'])->name('offers.update'); // تحديث العرض
    Route::delete('/{id}', [OfferController::class, 'destroy'])->name('offers.destroy'); // حذف العرض
});



// ---------------- Order Management ----------------
Route::put('/order/{id}/update-status', [OrderController::class, 'updateOrderStatus']);
Route::post('/orders/{id}', [OrderController::class, 'showId'])->name('order.order');
Route::get('accepted_orders', function () {
    return view('admin.orders.accepted_orders');
})->name('accepted_orders');
Route::get('orders', function () {
    return view('admin.orders.orders_summary');
})->name('orders');

// ---------------- Order Return ----------------
Route::post('/order/{id}/return', [OrderController::class, 'checkReturnEligibility'])->name('order.return');
Route::get('/order/{id}/return-form', [OrderController::class, 'ReturnForm'])->name('return.form');



// ---------------- Profile Routes ----------------
// Route::middleware('auth')->group(function () {
// Route::prefix('profile')->group(function () {
//     Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
// });



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
});

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// ---------------- Dashboard Route ----------------
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'admin'])->name('dashboard');


// ---------------- Team Work ----------------
Route::get('/team-work', function () {
    return view('team-work');
})->name('team-work');


require __DIR__ . '/auth.php';