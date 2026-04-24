<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Молочные продукты', 'Выпечка', 'Мясо и рыба', 'Овощи и фрукты', 'Напитки', 'Бакалея'];

        return [
            'name' => $this->faker->randomElement($categories),
            'description' => $this->faker->realText(50),
        ];
    }
}
