<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use \App\Models\Product;

use \App\Http\Controllers\ProductViewController;
use \App\Http\Controllers\Api\ProductController;
use \App\Http\Resources\ProductResource;

Route::get('/', [ProductViewController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductViewController::class, 'show'])->name('products.show');

Route::get('/admin/products', function () {
    $products = Product::with('category')->paginate(12);

    return Inertia::render('Admin/Products/Index', [
        'products' => ProductResource::collection($products)
    ]);
});

Route::get('/admin/products/create', [ProductController::class, 'create']);
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit']);

require __DIR__.'/auth.php';
