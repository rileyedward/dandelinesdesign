<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'business_name' => fake()->company(),
            'message' => fake()->paragraph(3),
        ];
    }
}
