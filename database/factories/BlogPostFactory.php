<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6, true),
            'slug' => str()->slug(fake()->sentence(6, true)),
            'content' => fake()->realText(3000, 2),
            'excerpt' => fake()->realText(200),
            'image_url' => fake()->imageUrl(),
            'is_published' => fake()->boolean(),
        ];
    }
}
