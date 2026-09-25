<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/preview', [OrderController::class, 'preview'])->name('orders.preview');
// both show one customer's order, and order numbers run in sequence: only signed links open them
// (see Order::successUrl and Order::invoiceUrl)
Route::get('/orders/{trackingCode}/success', [OrderController::class, 'success'])->name('orders.success')->middleware('signed');
Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice')->middleware('signed');
