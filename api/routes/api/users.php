<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('users/search', UserController::class . '@search')->name('users.search');
Route::apiResource('users', UserController::class);
