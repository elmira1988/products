<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductViewController extends Controller
{
    public function index(Request $request)
    {
        // Получаем товары с категорией и пагинацией (10 штук)
        // Добавляем фильтр, если выбрана категория
        $products = Product::with('category')
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString(); // Сохраняем фильтры в ссылках пагинации

        return Inertia::render('Products/Index', [
            'products' => $products,
            'categories' => Category::all(),
            'filters' => $request->only(['category_id']),
        ]);
    }

    public function show(Product $product)
    {
        // Загружаем категорию, чтобы показать её в карточке
        return Inertia::render('Products/Show', [
            'product' => $product->load('category')
        ]);
    }
}
