<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@dandelinesdesign.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            LeadSeeder::class,
            BlogPostSeeder::class,
            ContactMessageSeeder::class,
            TestimonialSeeder::class,
            QuoteRequestSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            NotificationSeeder::class,
            NewsletterSubscriberSeeder::class,
        ]);
    }
}
