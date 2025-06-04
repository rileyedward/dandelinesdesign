<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // System Admin
        User::factory()->create([
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
    }
}
