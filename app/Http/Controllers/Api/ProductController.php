<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $products = Product::with('category')->paginate(10);
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request) {
        $product = Product::create($request->validated());
        return new ProductResource($product);
    }

    public function show(Product $product) {
        return new ProductResource($product->load('category'));
    }

    public function update(StoreProductRequest $request, Product $product) {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->noContent();
    }
}
