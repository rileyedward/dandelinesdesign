<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;

class NewsletterSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        // Create a variety of newsletter subscribers with different statuses and attributes

        // Active subscribers (majority)
        NewsletterSubscriber::factory()->count(150)->create([
            'status' => 'active',
            'subscribed_at' => now()->subDays(rand(1, 365)),
        ]);

        // Inactive subscribers
        NewsletterSubscriber::factory()->count(25)->create([
            'status' => 'inactive',
            'subscribed_at' => now()->subDays(rand(30, 180)),
        ]);

        // Unsubscribed subscribers
        NewsletterSubscriber::factory()->count(20)->create([
            'status' => 'unsubscribed',
            'subscribed_at' => now()->subDays(rand(60, 300)),
            'unsubscribed_at' => now()->subDays(rand(1, 30)),
        ]);

        // Create some specific subscribers with known data for testing
        NewsletterSubscriber::create([
            'email' => 'test@example.com',
            'name' => 'Test',
            'status' => 'active',
            'subscribed_at' => now()->subDays(30),
            'source' => 'website',
            'preferences' => ['weekly_digest', 'product_updates'],
            'tags' => ['vip', 'early_adopter'],
        ]);

        NewsletterSubscriber::create([
            'email' => 'demo@dandeline.com',
            'name' => 'Demo',
            'status' => 'active',
            'subscribed_at' => now()->subDays(5),
            'source' => 'popup',
            'preferences' => ['promotions', 'events'],
            'tags' => ['local', 'frequent_buyer'],
        ]);

        NewsletterSubscriber::create([
            'email' => 'unsubscribed@example.com',
            'name' => 'Former',
            'status' => 'unsubscribed',
            'subscribed_at' => now()->subDays(90),
            'unsubscribed_at' => now()->subDays(10),
            'source' => 'referral',
            'preferences' => null,
            'tags' => ['event_planner'],
        ]);
    }
}
