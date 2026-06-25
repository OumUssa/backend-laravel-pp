
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PetCategoryController;
use App\Http\Controllers\ProductCommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TypeProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/profile', [UserController::class, 'getUserProfile'])->middleware('auth:sanctum');
Route::put('/profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'getUserProfile'])->middleware('auth:sanctum');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

//admin routes
Route::get('/admin/users/{id}/purchase', [PurchaseController::class, 'showAdminUserPurchases'])->middleware('auth:sanctum');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth:sanctum');
Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->middleware('auth:sanctum');

// Password Reset
Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('/direct-reset-password', [ResetPasswordController::class, 'directResetPassword']);

//pet categories
Route::get('/petCategories', [PetCategoryController::class, 'getPetCategories']);
Route::post('/petCategories', [PetCategoryController::class, 'addPetCategories']);
Route::put('/petCategories/{id}', [PetCategoryController::class, 'updatePetCategory']);
Route::post('/petCategories/update/{id}', [PetCategoryController::class, 'updatePetCategory']);
Route::delete('/petCategories/{id}', [PetCategoryController::class, 'destroy']);
Route::post('/petCategories/delete/{id}', [PetCategoryController::class, 'destroy']);

//product types
Route::get('/productTypes', [TypeProductController::class, 'getProductionTypes']);
Route::post('/productTypes', [TypeProductController::class, 'addProductType']);
Route::put('/productTypes/{id}', [TypeProductController::class, 'updateProductType']);
Route::post('/productTypes/update/{id}', [TypeProductController::class, 'updateProductType']);
Route::delete('/productTypes/{id}', [TypeProductController::class, 'destroy']);
Route::post('/productTypes/delete/{id}', [TypeProductController::class, 'destroy']);

//products
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProduct']);
Route::get('/userProduct', [ProductController::class, 'getProductsFromAUser'])->middleware('auth:sanctum');
Route::post('/products', [ProductController::class, 'addProducts'])->middleware('auth:sanctum');
Route::put('/products/{name}', [ProductController::class, 'updateProduct'])->middleware('auth:sanctum');
Route::delete('/products/{name}', [ProductController::class, 'deleteProduct'])->middleware('auth:sanctum');

//product comments
Route::post('/products/{id}/comments', [ProductCommentController::class, 'store'])->middleware('auth:sanctum');
Route::get('/products/{id}/comments', [ProductCommentController::class, 'index']);
Route::delete('/comments/{id}', [ProductCommentController::class, 'destroy'])->middleware('auth:sanctum');

//purchase
Route::post('/purchase', [PurchaseController::class, 'purchaseProduct'])->middleware('auth:sanctum');
Route::get('/purchase', [PurchaseController::class, 'showUserPurchases'])->middleware('auth:sanctum');
Route::put('/purchase/{id}/status', [PurchaseController::class, 'updateStatus'])->middleware('auth:sanctum');

//contacts
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts', [ContactController::class, 'index'])->middleware('auth:sanctum');
Route::get('/contacts/{id}', [ContactController::class, 'show'])->middleware('auth:sanctum');
Route::put('/contacts/{id}/reply', [ContactController::class, 'reply'])->middleware('auth:sanctum');