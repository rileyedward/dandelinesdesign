<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        // Create a set of contact messages
        ContactMessage::factory()
            ->count(10)
            ->create();
    }
}
