
<?php

use App\Http\Controllers\PetCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/users', [UserController::class, 'index'])->middleware('auth.api');
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile', [UserController::class, 'getUserProfile'])->middleware('auth:sanctum');
Route::put('/profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'getUserProfile'])->middleware('auth:sanctum');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

//admin routes
Route::get('/admin/users/{id}/purchase', [PurchaseController::class, 'showAdminUserPurchases'])->middleware('auth:sanctum');

// Password Reset
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

//pet categories
Route::get('/petCategories', [PetCategoryController::class, 'getPetCategories']);
Route::post('/petCategories', [PetCategoryController::class, 'addPetCategories']);
Route::put('/petCategories/{id}', [PetCategoryController::class, 'updatePetCategory']);
Route::delete('/petCategories/{id}', [PetCategoryController::class, 'destroy']);

//product types
Route::get('/productTypes', [TypeProductController::class, 'getProductionTypes']);
Route::post('/productTypes', [TypeProductController::class, 'addProductType']);
Route::put('/productTypes/{id}', [TypeProductController::class, 'updateProductType']);
Route::delete('/productTypes/{id}', [TypeProductController::class, 'destroy']);

//products
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/userProduct', [ProductController::class, 'getProductsFromAUser'])->middleware('auth:sanctum');
Route::post('/products', [ProductController::class, 'addProducts'])->middleware('auth:sanctum');
Route::put('/products/{name}', [ProductController::class, 'updateProduct'])->middleware('auth:sanctum');
Route::delete('/products/{name}', [ProductController::class, 'deleteProduct'])->middleware('auth:sanctum');

//purchase
Route::post('/purchase', [PurchaseController::class, 'purchaseProduct'])->middleware('auth:sanctum');
Route::get('/purchase', [PurchaseController::class, 'showUserPurchases'])->middleware('auth:sanctum');