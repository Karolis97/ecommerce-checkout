<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => ucwords(fake()->words(3, true)),
            'description'    => fake()->sentence(10),
            'price'          => fake()->numberBetween(500, 10000),
            'stock_quantity' => fake()->numberBetween(10, 30),
        ];
    }
}
