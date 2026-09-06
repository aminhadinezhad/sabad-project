<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('products.index');
})->name('products.index');
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/preview', [OrderController::class, 'preview'])->name('orders.preview');
Route::get('/orders/{trackingCode}/success', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
