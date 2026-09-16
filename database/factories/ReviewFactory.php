<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->optional()->sentence(),
            'created_at_review' => fake()->dateTimeBetween('-6 months'),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
