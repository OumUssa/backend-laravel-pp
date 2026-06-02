
<?php

use App\Http\Controllers\PetCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index'])->middleware('auth.api');
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/users/{id}', [UserController::class, 'show'])->middleware('auth.api');

//pet categories
Route::get('/petCategories', [PetCategoryController::class, 'getPetCategories']);
Route::post('/petCategories', [PetCategoryController::class, 'addPetCategories']);

//product types
Route::get('/productTypes', [TypeProductController::class, 'getProductionTypes']);
Route::post('/productTypes', [TypeProductController::class, 'addProductType']);

//products
Route::get('/products', [ProductController::class, 'getProducts'])->middleware('auth:sanctum');
Route::post('/products', [ProductController::class, 'addProducts'])->middleware('auth:sanctum');
