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
        $product->load('category'); // Подгружаем связь, чтобы ресурс её увидел

        return response()->json([
            'message' => 'Создано',
            'product' => new ProductResource($product) // Обязательно Resource
        ], 201);
    }

    // PUT /api/products/{product} — Обновление
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        // 1. Обновляем данные в базе
        $product->update($request->validated());

        $product->load('category');

        return response()->json([
            'message' => 'Товар успешно обновлен',
            'product' => new ProductResource($product)
        ]);
    }

    // DELETE /api/products/{product} — Удаление
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
