<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailOtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::post('/checkout/guest', [CheckoutController::class, 'guest'])->name('checkout.guest')->middleware('guest');
Route::middleware('auth')->group(function () {
    Route::post('/checkout/start', [CheckoutController::class, 'start'])->name('checkout.start');
    Route::get('/checkout/{order}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::post('/checkout/{order}/verify', [CheckoutController::class, 'verify'])->name('checkout.verify');
    Route::get('/checkout/{order}/thank-you', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify-email', [EmailOtpController::class, 'showRegistrationVerification'])->name('verification.notice');
    Route::post('/verify-email', [EmailOtpController::class, 'verifyRegistration'])->middleware('throttle:6,1')->name('verification.verify');
    Route::post('/verify-email/resend', [EmailOtpController::class, 'resendRegistrationOtp'])->middleware('throttle:3,1')->name('verification.resend');
    Route::get('/forgot-password', [EmailOtpController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [EmailOtpController::class, 'sendPasswordResetOtp'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/reset-password', [EmailOtpController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [EmailOtpController::class, 'resetPassword'])->middleware('throttle:6,1')->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}', [AdminController::class, 'updateOrder'])->name('orders.update');

    Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');
});

// Authenticated routes
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/products', [DashboardController::class, 'products'])->name('products');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
    Route::get('/wishlist', [DashboardController::class, 'wishlist'])->name('wishlist');
    Route::get('/addresses', [DashboardController::class, 'addresses'])->name('addresses');
    Route::post('/addresses', [DashboardController::class, 'storeAddress'])->name('addresses.store');
    Route::patch('/addresses/{address}/default', [DashboardController::class, 'makeDefaultAddress'])->name('addresses.default');
    Route::delete('/addresses/{address}', [DashboardController::class, 'destroyAddress'])->name('addresses.destroy');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
});
