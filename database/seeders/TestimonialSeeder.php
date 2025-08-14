<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Emily Johnson',
                'title' => 'Bride',
                'quote' => 'The floral arrangements for our wedding were absolutely stunning! Dandelines Design captured our vision perfectly and created the most beautiful atmosphere for our special day.',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Michael Roberts',
                'title' => 'Event Coordinator',
                'quote' => 'We\'ve worked with Dandelines Design for multiple corporate events, and they consistently deliver exceptional quality and professionalism. Their attention to detail is unmatched.',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Thompson',
                'title' => 'Mother of the Bride',
                'quote' => 'The centerpieces created for my daughter\'s wedding reception were breathtaking. So many guests commented on how beautiful the flowers were!',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'David Chen',
                'title' => 'Restaurant Owner',
                'quote' => 'Our weekly flower arrangements from Dandelines Design add the perfect touch to our dining room. Fresh, creative, and always on time.',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Jennifer Martinez',
                'title' => 'Anniversary Celebration',
                'quote' => 'The anniversary arrangement was exactly what I wanted to surprise my husband. The attention to detail and quality of flowers exceeded my expectations.',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Robert Wilson',
                'title' => 'Corporate Client',
                'quote' => 'Dandelines Design transformed our office lobby with their stunning arrangements. Professional service from start to finish.',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Amanda Parker',
                'title' => 'Wedding Planner',
                'quote' => 'As a wedding planner, I\'ve worked with many florists, but Dandelines Design stands out for their creativity, reliability, and ability to work within any budget.',
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::query()->create($testimonial);
        }

        Testimonial::factory(10)->create();
    }
}
