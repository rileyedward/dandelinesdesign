<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'message' => "Michele's attention to detail and creative vision transformed our wedding into a magical experience. Every element was thoughtfully designed and executed perfectly.",
                'name' => 'Sarah & John, Wedding Clients',
            ],
            [
                'message' => 'Working with Dandelines Design for our corporate event was a pleasure. Michele understood our brand and created an atmosphere that impressed all our guests and partners.',
                'name' => 'Mark Davis, CEO of TechCorp',
            ],
            [
                'message' => 'The floral arrangements Michele created for our anniversary celebration were absolutely stunning. Her artistic eye and ability to bring our vision to life exceeded all expectations.',
                'name' => 'Emily Johnson',
            ],
            [
                'message' => 'Michele has a unique talent for creating spaces that feel both elegant and welcoming. Her design work for our home renovation project was exceptional.',
                'name' => 'The Williams Family',
            ],
            [
                'message' => "From concept to execution, Dandelines Design delivered a birthday celebration that my daughter will remember forever. Michele's creativity and professionalism are unmatched.",
                'name' => 'Rebecca Thompson',
            ],
        ];

        Testimonial::query()->insert($data);
    }
}
