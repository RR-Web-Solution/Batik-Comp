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
        return [
            'category_id' => null,
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(10, 200) * 1000,
            'image' => null,
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }

    public function inCategory(?Category $category = null): static
    {
        return $this->state(fn () => [
            'category_id' => $category?->id ?? Category::factory()->create()->id,
        ]);
    }
}
