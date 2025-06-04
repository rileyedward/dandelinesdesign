<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => fake()->paragraph(3),
            'excerpt' => fake()->paragraph(1),
            'image_url' => fake()->imageUrl(),
            'is_published' => fake()->boolean(),
        ];
    }
}
