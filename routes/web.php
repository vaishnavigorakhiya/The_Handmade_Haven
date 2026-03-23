<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\WishlistController;


// ══ PUBLIC ══
Route::get('/',             [ProductController::class, 'home'])->name('home');
Route::get('/shop',         [ProductController::class, 'shop'])->name('shop');
Route::get('/search',       [ProductController::class, 'search'])->name('search');
Route::get('/about',        [ProductController::class, 'about'])->name('about');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');


// Cart (public — guests can add to cart)
Route::get('/cart',                [OrderController::class, 'cart'])->name('cart');
Route::post('/cart/add/{id}',      [OrderController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [OrderController::class, 'removeFromCart'])->name('cart.remove');

// Checkout — requires login
Route::get('/checkout',  [OrderController::class, 'checkoutPage'])->name('checkout.page');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

// ══ AUTH (guests only) ══
Route::middleware('guest')->group(function () {
    Route::get('/login',           [AuthController::class, 'showLogin'])->name('login');
    Route::post('/auth/submit',    [AuthController::class, 'submitIdentifier'])->name('auth.submit');
    Route::post('/auth/password',  [AuthController::class, 'verifyPassword'])->name('auth.password');
    Route::post('/auth/otp',       [AuthController::class, 'verifyOtp'])->name('auth.otp');
    Route::post('/auth/resend',    [AuthController::class, 'resendOtp'])->name('auth.resend');
    Route::post('/auth/register',  [AuthController::class, 'register'])->name('auth.register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ══ USER DASHBOARD ══
Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('user.')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::post('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    });

    Route::get('/orders/{order}', [UserDashboardController::class, 'orderDetail'])->name('user.order.detail');

    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist');
        Route::post('/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::delete('/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    });
});

// Blog index page
Route::get('/blog', function () {
    return view('blog'); 
});
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// USER-FACING CONTACT ROUTE 
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ══ ADMIN ══
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                       [ProductController::class,  'adminDashboard'])->name('dashboard');
    Route::post('/products',              [ProductController::class,  'store'])->name('products.store');
    Route::patch('/products/{id}',        [ProductController::class,  'update'])->name('products.update');
    Route::delete('/products/{id}',       [ProductController::class,  'destroy'])->name('products.destroy');
    Route::post('/products/{id}/restock', [ProductController::class,  'restock'])->name('products.restock');
    Route::post('/categories',            [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}',     [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.status');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/blog',                    [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create',             [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog',                   [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{blog}/edit',        [BlogController::class, 'edit'])->name('blog.edit');
    Route::patch('/blog/{blog}',           [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{blog}',          [BlogController::class, 'destroy'])->name('blog.destroy');
    Route::patch('/blog/{blog}/toggle',    [BlogController::class, 'togglePublish'])->name('blog.toggle');


});


