<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'business_name' => fake()->optional(0.7)->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional(0.8)->phoneNumber(),
            'subject' => fake()->sentence(),
            'message' => fake()->paragraph(3),
        ];
    }
}
