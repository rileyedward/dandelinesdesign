<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsletterTemplate>
 */
class NewsletterTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'scheduled', 'sent']);
        $createdAt = $this->faker->dateTimeBetween('-6 months', 'now');
        
        return [
            'name' => $this->faker->words(3, true) . ' Newsletter',
            'subject' => $this->faker->sentence(6, true),
            'content' => $this->faker->randomHtml(3, 6),
            'preview_text' => $this->faker->optional(0.7)->sentence(12),
            'status' => $status,
            'scheduled_at' => $status === 'scheduled' ? $this->faker->dateTimeBetween('now', '+1 month') : null,
            'sent_at' => $status === 'sent' ? $this->faker->dateTimeBetween($createdAt, 'now') : null,
            'recipients_count' => $status === 'sent' ? $this->faker->numberBetween(50, 1000) : 0,
            'opens_count' => $status === 'sent' ? $this->faker->numberBetween(0, 500) : 0,
            'clicks_count' => $status === 'sent' ? $this->faker->numberBetween(0, 100) : 0,
            'tags' => $this->faker->optional(0.5)->randomElements(['promotion', 'weekly', 'product_update', 'event', 'seasonal'], $this->faker->numberBetween(1, 2)),
            'metadata' => $this->faker->optional(0.3)->randomElements(['template_id' => $this->faker->uuid(), 'campaign_id' => $this->faker->randomNumber(6)]),
        ];
    }
}
