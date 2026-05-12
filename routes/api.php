
<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index'])->middleware('auth.api');
Route::post('/createUser', [UserController::class, 'createUser']);