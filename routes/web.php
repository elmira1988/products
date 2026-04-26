<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Models\Product;

use \App\Http\Controllers\ProductViewController;
use \App\Http\Controllers\Api\ProductController;

Route::get('/', [ProductViewController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductViewController::class, 'show'])->name('products.show');

Route::get('/admin/products', function () {
    return Inertia::render('Admin/Products/Index', [
        'products' => Product::with('category')->paginate(12)
    ]);
});

Route::get('/admin/products/create', [ProductController::class, 'create']);
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit']);


/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/
require __DIR__.'/auth.php';
