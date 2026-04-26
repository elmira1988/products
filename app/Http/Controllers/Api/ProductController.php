<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // Метод для страницы СОЗДАНИЯ
    public function create()
    {
        return Inertia::render('Admin/Products/Form', [
            'categories' => Category::all()
        ]);
    }

// Метод для страницы РЕДАКТИРОВАНИЯ
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Form', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Товар успешно создан',
            'product' => $product
        ], 201); // 201 — код "Создано"
    }

    // PUT /api/products/{product} — Обновление
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Товар обновлен',
            'product' => $product
        ]);
    }

    // DELETE /api/products/{product} — Удаление
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Товар удален'
        ]);
    }
}
