<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        // Published Blog Posts
        BlogPost::factory()
            ->count(5)
            ->state([
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
            ])
            ->create();

        // Unpublished Blog Posts
        BlogPost::factory()
            ->count(3)
            ->state([
                'is_published' => false,
                'published_at' => null,
            ])
            ->create();
    }
}
