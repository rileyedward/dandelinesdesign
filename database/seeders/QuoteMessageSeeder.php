<?php

namespace Database\Seeders;

use App\Models\QuoteMessage;
use Illuminate\Database\Seeder;

class QuoteMessageSeeder extends Seeder
{
    public function run(): void
    {
        QuoteMessage::factory()
            ->count(10)
            ->create();
    }
}
