<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['primary', 'success', 'danger', 'warning', 'info']),
            'title' => $this->faker->sentence(3),
            'message' => $this->faker->sentence(),
            'action_url' => $this->faker->optional(0.7)->url(),
            'action_text' => $this->faker->optional(0.7)->words(2, true),
            'is_read' => $this->faker->boolean(0.3),
        ];
    }
}
