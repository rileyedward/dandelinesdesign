<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'title' => $this->faker->optional(0.7)->jobTitle(),
            'quote' => $this->faker->paragraph(2),
            'is_featured' => $this->faker->boolean(20),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
