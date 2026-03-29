<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrderController::class, 'index'])->name('dashboard');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
