<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'customer_title' => fake()->optional()->words(3, true),
            'content' => fake()->sentence(),
            'rating' => fake()->numberBetween(3, 5),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
