<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use \App\Http\Controllers\Api\CategoryController;

Route::post('/login', [AuthController::class, 'login']);


Route::get('/categories', [CategoryController::class, 'index']);

// Защищенные маршруты
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
