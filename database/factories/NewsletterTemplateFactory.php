<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterTemplateFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'scheduled', 'sent']);
        $createdAt = $this->faker->dateTimeBetween('-6 months', 'now');

        return [
            'name' => $this->faker->words(3, true).' Newsletter',
            'subject' => $this->faker->sentence(6, true),
            'content' => $this->faker->randomHtml(3, 6),
            'status' => $status,
            'sent_at' => $status === 'sent' ? $this->faker->dateTimeBetween($createdAt, 'now') : null,
            'recipients_count' => $status === 'sent' ? $this->faker->numberBetween(50, 1000) : 0,
        ];
    }
}
