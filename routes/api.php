<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'authUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Admin routes (role-based)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('categories', CategoryController::class)->except(['edit', 'show']);
    Route::apiResource('products', ProductController::class)->except(['edit']);
    // Route::apiResource('orders', OrderController::class);
});

// Customer routes (role-based)
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {
    return 200;
    // Route::apiResource('cart', CartController::class);
    // Route::post('orders', [CustomerOrderController::class, 'placeOrder']);
    // Route::get('orders', [CustomerOrderController::class, 'myOrders']);
});