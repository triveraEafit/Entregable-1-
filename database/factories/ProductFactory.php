<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 2000),
            'stock' => fake()->numberBetween(0, 100),
            'image' => null,
            'active' => true,
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
