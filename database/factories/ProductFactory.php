<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $name = fake()->unique()->words(3, true); // e.g., "Modern Wireless Mouse"
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 1000), // price between 10.00 and 1000.00
            'image' => fake()->imageUrl(640, 480, 'tech'), // Placeholder image
            'stock' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
