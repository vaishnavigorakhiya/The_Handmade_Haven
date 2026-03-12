<?php
// routes/web.php  — REPLACE your entire web.php with this

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

// ══════════════════════════════════════
//  PUBLIC ROUTES
// ══════════════════════════════════════
Route::get('/',        [ProductController::class, 'home'])->name('home');
Route::get('/shop',    [ProductController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

// Cart
Route::get('/cart',                     [OrderController::class, 'cart'])->name('cart');
Route::post('/cart/add/{id}',           [OrderController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}',      [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/checkout',           [OrderController::class, 'checkout'])->name('cart.checkout');

// ══════════════════════════════════════
//  AUTH ROUTES
// ══════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('/login',          [AuthController::class, 'showLogin'])->name('login');
    Route::post('/auth/submit',   [AuthController::class, 'submitIdentifier'])->name('auth.submit');
    Route::post('/auth/password', [AuthController::class, 'verifyPassword'])->name('auth.password');
    Route::post('/auth/otp',      [AuthController::class, 'verifyOtp'])->name('auth.otp');
    Route::post('/auth/resend',   [AuthController::class, 'resendOtp'])->name('auth.resend');
});



Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ══════════════════════════════════════
//  USER DASHBOARD (logged in customers)
// ══════════════════════════════════════
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',             [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/dashboard/profile',    [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
});

// ══════════════════════════════════════
//  ADMIN ROUTES (admin role only)
// ══════════════════════════════════════
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                          [ProductController::class, 'adminDashboard'])->name('dashboard');
    Route::post('/products',                 [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{id}',          [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/restock',    [ProductController::class, 'restock'])->name('products.restock');
});
