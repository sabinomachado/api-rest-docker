<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

Route::get('orders/search', OrderController::class . '@search')->name('orders.search');
Route::apiResource('orders', OrderController::class);
