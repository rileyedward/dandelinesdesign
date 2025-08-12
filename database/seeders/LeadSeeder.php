<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $leads = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'phone_number' => '(555) 123-4567',
                'company' => 'Elegant Events Co.',
                'notes' => 'Interested in wedding package for June 2024. Looking for rustic/boho style arrangements.',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@techcorp.com',
                'phone_number' => '(555) 234-5678',
                'company' => 'TechCorp Solutions',
                'notes' => 'Corporate event planning - quarterly company dinner for 150 guests. Budget flexible.',
            ],
            [
                'name' => 'Emma Rodriguez',
                'email' => 'emma.r@gmail.com',
                'phone_number' => '(555) 345-6789',
                'company' => '',
                'notes' => 'Anniversary party for parents 50th wedding anniversary. Gold and white theme preferred.',
            ],
            [
                'name' => 'David Thompson',
                'email' => 'dthompson@marriotthotel.com',
                'phone_number' => '(555) 456-7890',
                'company' => 'Marriott Downtown',
                'notes' => 'Hotel lobby arrangements - monthly contract signed. Contemporary style, seasonal rotations.',
            ],
            [
                'name' => 'Lisa Park',
                'email' => 'lisa.park@email.com',
                'phone_number' => '(555) 567-8901',
                'company' => 'Park Family Foundation',
                'notes' => 'Charity gala in November. Need centerpieces for 20 tables, elegant and sophisticated.',
            ],
            [
                'name' => 'Robert Williams',
                'email' => 'rwilliams@lawfirm.com',
                'phone_number' => '(555) 678-9012',
                'company' => 'Williams & Associates',
                'notes' => 'Office grand opening celebration. Professional atmosphere, modern arrangements.',
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'jen.martinez@yahoo.com',
                'phone_number' => '(555) 789-0123',
                'company' => '',
                'notes' => 'Wedding postponed indefinitely due to personal circumstances. Keep on file for future.',
            ],
            [
                'name' => 'Thomas Anderson',
                'email' => 'tanderson@restaurant.com',
                'phone_number' => '(555) 890-1234',
                'company' => 'The Garden Bistro',
                'notes' => 'Restaurant opening - needs fresh arrangements weekly. Farm-to-table concept, rustic style.',
            ],
            [
                'name' => 'Amanda Foster',
                'email' => 'afoster@eventplanning.com',
                'phone_number' => '(555) 901-2345',
                'company' => 'Foster Event Planning',
                'notes' => 'Wedding planner looking for partnership. Handles 30+ weddings per year.',
            ],
            [
                'name' => 'Kevin O\'Brien',
                'email' => 'kevin.obrien@gmail.com',
                'phone_number' => '(555) 012-3456',
                'company' => '',
                'notes' => 'Baby shower arrangements needed. Soft pastels, gender neutral theme.',
            ],
        ];

        foreach ($leads as $lead) {
            Lead::query()->create($lead);
        }

        Lead::factory(15)->create();
    }
}
