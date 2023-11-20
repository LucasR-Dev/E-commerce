<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/search/{id}', [ProductsController::class, 'searchId']);
Route::get('/search', [ProductsController::class, 'search']);
Route::apiResource('/products', ProductsController::class);




// Route::get('/products', [ProductsController::class, 'index']);
// Route::post('/products', [ProductsController::class, 'store']);
// Route::patch('/products/{id}', [ProductsController::class, 'update']);
// Route::delete('/products/{id}', [ProductsController::class, 'destroy']);

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});