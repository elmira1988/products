<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

// Защищенные маршруты
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/products', function () {
        return response()->json(['message' => 'Welcome to Dashboard']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
