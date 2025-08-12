<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Floral Arrangements',
            'Design Prints',
            'Artwork Originals',
            'Event Decor',
            'Custom Pieces',
            'Seasonal Collections',
            'Wedding Arrangements',
            'Corporate Designs'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->optional(0.8)->paragraph(),
            'is_active' => $this->faker->boolean(85),
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }
}