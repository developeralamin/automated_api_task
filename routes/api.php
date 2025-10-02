<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'authUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Admin routes (role-based)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('categories', CategoryController::class)->except(['show']);
    Route::apiResource('products', ProductController::class);
    // Route::apiResource('orders', OrderController::class);
});

// Customer routes (role-based)
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {

    Route::apiResource('cart', CartController::class)->except(['show']);
    // Route::post('orders', [CustomerOrderController::class, 'placeOrder']);
    // Route::get('orders', [CustomerOrderController::class, 'myOrders']);
});