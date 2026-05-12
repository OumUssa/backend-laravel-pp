<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->middleware('auth.api');

Route::post('/createUser', [UserController::class, 'createUser'])
    ->withoutMiddleware([ValidateCsrfToken::class]);