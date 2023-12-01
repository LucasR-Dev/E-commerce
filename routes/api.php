<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/products', [ProductsController::class, 'index']);
Route::post('/api/products', [ProductsController::class, 'store']);
Route::put('/api/products/{id}', [ProductsController::class, 'update']);
Route::delete('/api/products/{id}', [ProductsController::class, 'destroy']);
Route::get('/api/search/{id}', [ProductsController::class, 'searchId']);
Route::get('/api/search', [ProductsController::class, 'search']);
Route::get('/api/products/with-images', [ProductsController::class, 'getProductsWithImages']);
Route::get('/api/products/without-images', [ProductsController::class, 'getProductsWithoutImages']);

Route::post('/api/register', [UserController::class, 'store']);

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});