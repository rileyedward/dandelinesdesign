<?php

namespace Database\Seeders;

use App\Models\QuoteRequest;
use Illuminate\Database\Seeder;

class QuoteRequestSeeder extends Seeder
{
    public function run(): void
    {
        $quoteRequests = [
            [
                'name' => 'Jessica Williams',
                'email' => 'jessica.williams@example.com',
                'phone_number' => '(555) 123-4567',
                'service_type' => 'floral_design',
                'event_date' => '2025-10-15',
                'event_location' => 'Grand Ballroom, Hilton Hotel',
                'guest_count' => 150,
                'budget' => 3500.00,
                'description' => 'Looking for elegant floral arrangements for my wedding. Interested in roses, peonies, and eucalyptus with a romantic theme.',
                'status' => 'contacted',
            ],
            [
                'name' => 'Daniel Smith',
                'email' => 'daniel.smith@company.com',
                'phone_number' => '(555) 234-5678',
                'service_type' => 'both',
                'event_date' => '2025-12-10',
                'event_location' => 'Corporate Headquarters',
                'guest_count' => 200,
                'budget' => 5000.00,
                'description' => 'Annual corporate holiday party. Need both floral arrangements and event planning assistance. Modern and festive theme.',
                'status' => 'quoted',
            ],
            [
                'name' => 'Sophia Rodriguez',
                'email' => 'sophia.r@example.com',
                'phone_number' => '(555) 345-6789',
                'service_type' => 'event_planning',
                'event_date' => '2026-02-14',
                'event_location' => 'The Garden Venue',
                'guest_count' => 75,
                'budget' => 2000.00,
                'description' => 'Planning a Valentine\'s Day themed engagement party. Need help with overall event coordination and design.',
                'status' => 'pending',
            ],
            [
                'name' => 'James Johnson',
                'email' => 'james.johnson@example.com',
                'phone_number' => '(555) 456-7890',
                'service_type' => 'floral_design',
                'event_date' => '2025-09-22',
                'event_location' => 'Riverside Gardens',
                'guest_count' => 100,
                'budget' => 1500.00,
                'description' => 'Outdoor wedding ceremony and reception. Looking for wildflower arrangements with a rustic, bohemian feel.',
                'status' => 'completed',
            ],
            [
                'name' => 'Emma Thompson',
                'email' => 'emma.t@example.com',
                'phone_number' => '(555) 567-8901',
                'service_type' => 'both',
                'event_date' => '2026-04-10',
                'event_location' => 'Lakeside Manor',
                'guest_count' => 120,
                'budget' => 4000.00,
                'description' => 'Spring wedding with pastel color scheme. Need full service planning and floral design.',
                'status' => 'quoted',
            ],
        ];

        foreach ($quoteRequests as $quoteRequest) {
            QuoteRequest::query()->create($quoteRequest);
        }

        QuoteRequest::factory(15)->create();
    }
}
