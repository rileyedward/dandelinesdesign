<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Console\Command;

class SeedProductionCommand extends Command
{
    protected $signature = 'db:seed-production';

    protected $description = 'Seed the database with production-safe data';

    public function handle(): void
    {
        $this->info('Starting production database seeding...');

        $this->seedBlogPosts();
        $this->seedProducts();

        $this->info('Production database seeding completed successfully!');
    }

    private function seedBlogPosts(): void
    {
        $this->info('Seeding blog posts...');

        BlogPost::factory()->count(10)->create();

        $this->info('Blog posts seeded successfully.');
    }

    private function seedProducts(): void
    {
        $this->info('Seeding products...');

        Product::factory()->count(15)->create();

        $this->info('Products seeded successfully.');
    }
}
