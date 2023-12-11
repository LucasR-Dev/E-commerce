<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/api/categories', [CategoryController::class, 'index']);
Route::post('/api/category', [CategoryController::class, 'store']);
Route::put('/api/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/api/categories/{id}', [CategoryController::class, 'destroy']);

Route::put('/api/update-prices', [CategoryController::class, 'updateValueByCategory']);

Route::get('/api/products', [ProductsController::class, 'index']);
Route::post('/api/products', [ProductsController::class, 'store']);
Route::put('/api/products/{id}', [ProductsController::class, 'update']);
Route::delete('/api/products/{id}', [ProductsController::class, 'destroy']);
Route::get('/api/search/{id}', [ProductsController::class, 'searchId']);
// Route::get('/api/search', [ProductsController::class, 'search']);
// Route::get('/api/products/with-images', [ProductsController::class, 'getProductsWithImages']);
// Route::get('/api/products/without-images', [ProductsController::class, 'getProductsWithoutImages']);

Route::get('/api/users', [UserController::class, 'index']);
Route::post('/api/users/create', [UserController::class, 'store']);
Route::get('/api/search/{id}', [UserController::class, 'show']);
Route::put('/api/users/{id}', [UserController::class, 'update']);
Route::delete('/api/users/{id}', [UserController::class, 'destroy']);




Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});