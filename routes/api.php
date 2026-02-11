<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;





Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from Laravel API']);
});

Route::apiResource('posts', PostController::class);

Route::get('/products', [ProductController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::get('/products/{product:slug}', [ProductController::class, 'show']);

Route::put('/profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');


// Protect admin actions
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});
