<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
