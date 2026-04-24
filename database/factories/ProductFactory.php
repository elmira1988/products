<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Массив для примера, если хочется конкретики
        $products = ['Молоко', 'Хлеб', 'Сыр', 'Яблоки', 'Курица', 'Кофе', 'Чай', 'Паста', 'Рис'];

        return [
            'name' => $this->faker->randomElement($products) . ' ' . $this->faker->colorName() ,
            'description' => $this->faker->realText(100), // Текст на русском
            'price' => $this->faker->numberBetween(50, 2000),
            'category_id' => Category::factory(),
        ];
    }
}
