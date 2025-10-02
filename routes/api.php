<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\PaymentController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'authUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('categories', CategoryController::class)->except(['show']);
    Route::apiResource('products', ProductController::class);
    Route::get('orders', [AdminOrderController::class, 'allOrders']);
    Route::put('orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
});

// Customer routes 
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {
    Route::apiResource('cart', CartController::class)->except(['show']);
    Route::post('orders', [OrderController::class, 'placeOrder']);
    Route::get('orders', [OrderController::class, 'myOrders']);
    Route::post('/orders/{id}/payment', [PaymentController::class, 'payOrder']);
    Route::get('payments/{id}', [PaymentController::class, 'getPayment']);
});