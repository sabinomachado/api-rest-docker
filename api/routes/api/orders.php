<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

Route::get('orders/search', OrderController::class . '@search')->name('orders.search');
Route::apiResource('orders', OrderController::class);
Route::put('orders/{id}/update-status', OrderController::class . '@updateStatus')->name('orders.update-status');
