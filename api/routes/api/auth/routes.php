<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('login', AuthController::class . '@login')->name('auth.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', AuthController::class . '@logout')->name('auth.logout');
    Route::post('refresh', AuthController::class . '@refresh')->name('auth.refresh');
    Route::get('me', AuthController::class . '@me')->name('auth.me');
});
