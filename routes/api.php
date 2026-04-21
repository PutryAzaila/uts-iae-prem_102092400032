// routes/api.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductAccountController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| PUBLIC API — Guest/Buyer
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    // Products (public)
    Route::get('products',          [ProductController::class, 'index']);
    Route::get('products/{slug}',   [ProductController::class, 'show']);

    // Checkout & Order
    Route::post('orders',                          [OrderController::class, 'store']);
    Route::get('orders/{order_code}/{public_token}', [OrderController::class, 'show']);

    // Midtrans Webhook — TIDAK pakai auth
    Route::post('webhook/midtrans', [WebhookController::class, 'handle']);
});

/*
|--------------------------------------------------------------------------
| ADMIN API
|--------------------------------------------------------------------------
*/
Route::prefix('v1/admin')->group(function () {

    // Auth
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])
         ->middleware('auth:sanctum');

    // Protected Admin Routes
    Route::middleware(['auth:sanctum', 'admin.guard'])->group(function () {

        // Products
        Route::apiResource('products', AdminProductController::class);
        Route::patch('products/{product}/toggle-status', 
                     [AdminProductController::class, 'toggleStatus']);

        // Product Accounts (Stok)
        Route::get ('products/{product}/accounts',        [ProductAccountController::class, 'index']);
        Route::post('products/{product}/accounts',        [ProductAccountController::class, 'store']);
        Route::post('products/{product}/accounts/bulk',   [ProductAccountController::class, 'bulkStore']);
        Route::put ('accounts/{account}',                 [ProductAccountController::class, 'update']);
        Route::delete('accounts/{account}',               [ProductAccountController::class, 'destroy']);

        // Orders
        Route::get('orders',          [AdminOrderController::class, 'index']);
        Route::get('orders/{order}',  [AdminOrderController::class, 'show']);
    });
});