<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/checkout/{slug}',   [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/{slug}',  [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/orders/{order_code}/{public_token}', [OrderController::class, 'show'])->name('orders.show');
// routes/web.php
Route::get('/orders/{order_code}/{public_token}/status', [OrderController::class, 'status'])->name('orders.status');