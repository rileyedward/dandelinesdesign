<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        $imagesPath = public_path('images');
        $images = array_filter(scandir($imagesPath), function ($item) use ($imagesPath) {
            return ! is_dir($imagesPath.'/'.$item) && $item !== '.' && $item !== '..' && $item !== '.DS_Store';
        });

        return [
            'title' => fake()->sentence(6, true),
            'slug' => str()->slug(fake()->sentence(6, true)),
            'content' => fake()->realText(3000, 2),
            'excerpt' => fake()->realText(200),
            'image_url' => '/images/'.($images ? $images[array_rand($images)] : ''),
            'is_published' => fake()->boolean(),
        ];
    }
}
