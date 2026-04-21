<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductAccountController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::prefix('v1')->group(function () {

    Route::get('products',          [ProductController::class, 'index']);
    Route::get('products/{slug}',   [ProductController::class, 'show']);

    Route::post('orders',                          [OrderController::class, 'store']);
    Route::get('orders/{order_code}/{public_token}', [OrderController::class, 'show']);

    Route::post('webhook/midtrans', [WebhookController::class, 'handle']);
});

Route::prefix('v1/admin')->group(function () {

    Route::post('login',  [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])
         ->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum', 'admin.guard'])->group(function () {

        Route::apiResource('products', AdminProductController::class);
        Route::patch('products/{product}/toggle-status', 
                     [AdminProductController::class, 'toggleStatus']);

        Route::get ('products/{product}/accounts',        [ProductAccountController::class, 'index']);
        Route::post('products/{product}/accounts',        [ProductAccountController::class, 'store']);
        Route::post('products/{product}/accounts/bulk',   [ProductAccountController::class, 'bulkStore']);
        Route::put ('accounts/{account}',                 [ProductAccountController::class, 'update']);
        Route::delete('accounts/{account}',               [ProductAccountController::class, 'destroy']);

        Route::get('orders',          [AdminOrderController::class, 'index']);
        Route::get('orders/{order}',  [AdminOrderController::class, 'show']);
    });
});