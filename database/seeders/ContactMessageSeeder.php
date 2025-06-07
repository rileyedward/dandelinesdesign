<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Rachel Green',
                'business_name' => null,
                'email' => 'rachel.green@example.com',
                'phone' => '555-123-4567',
                'subject' => 'Wedding Consultation Inquiry',
                'message' => 'Hello! My fiancé and I are getting married next summer and we\'re looking for a floral designer who can create a romantic, garden-inspired atmosphere for our outdoor ceremony. We love your portfolio and would like to schedule a consultation to discuss our vision. We\'re particularly interested in seasonal blooms and sustainable practices. Looking forward to hearing from you!',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'James Wilson',
                'business_name' => 'Wilson Event Planning',
                'email' => 'james.wilson@example.com',
                'phone' => '555-987-6543',
                'subject' => 'Corporate Event Partnership',
                'message' => 'I run an event planning company specializing in corporate gatherings, and I\'m looking to partner with a reliable floral designer for our upcoming events. We have several client events scheduled for the fall season and would love to discuss a potential collaboration. Your work has caught our attention, and we believe your aesthetic would align well with our high-end corporate clients.',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Olivia Martinez',
                'business_name' => null,
                'email' => 'olivia.martinez@example.com',
                'phone' => '555-234-5678',
                'subject' => 'Birthday Arrangement Question',
                'message' => 'I\'d like to order a special floral arrangement for my mother\'s 60th birthday. Her favorite colors are purple and white, and she loves orchids and lilies. Do you offer delivery services? The celebration is on June 15th, and I\'d like the flowers to arrive that morning. Also, do you have any special birthday add-ons like balloons or chocolates? Thank you for your help!',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'William Taylor',
                'business_name' => 'Taylor & Sons Funeral Home',
                'email' => 'william.taylor@example.com',
                'phone' => '555-345-6789',
                'subject' => 'Funeral Arrangement Services',
                'message' => 'Our funeral home is looking to establish a relationship with a new floral provider for our services. We require a variety of arrangements, from casket sprays to standing displays, and need a provider who can deliver with short notice and handle our volume with care and dignity. Would you be available to meet next week to discuss your services and pricing structure?',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Emma Johnson',
                'business_name' => null,
                'email' => 'emma.johnson@example.com',
                'phone' => '555-456-7890',
                'subject' => 'Workshop Information',
                'message' => 'I saw on your website that you occasionally offer floral arrangement workshops. I\'m interested in organizing a private workshop for a bridal shower I\'m hosting. There would be about 10 participants. Could you provide information about pricing, duration, and what types of arrangements we could create? We\'re looking at dates in early August. Thank you!',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Daniel Brown',
                'business_name' => 'Brown\'s Fine Dining',
                'email' => 'daniel.brown@example.com',
                'phone' => '555-567-8901',
                'subject' => 'Restaurant Weekly Flower Service',
                'message' => 'I own a fine dining establishment in downtown Portland, and we\'re looking to enhance our ambiance with fresh floral arrangements. We\'d need weekly deliveries for about 8 tables plus our reception area. I\'m interested in discussing a standing order with seasonal rotations that complement our restaurant\'s warm, sophisticated interior. Would you be available for a meeting at our location to see the space?',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Sophia Lee',
                'business_name' => null,
                'email' => 'sophia.lee@example.com',
                'phone' => '555-678-9012',
                'subject' => 'Custom Anniversary Gift',
                'message' => 'My husband and I are celebrating our 10th anniversary next month, and I\'d like to surprise him with a special floral arrangement. Our wedding flowers were sunflowers and blue delphinium, and I\'d love to incorporate those if they\'re in season. Do you create custom arrangements for special occasions? I\'d also be interested in adding a personalized note. Please let me know what options you offer.',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Michael Davis',
                'business_name' => 'Davis Photography',
                'email' => 'michael.davis@example.com',
                'phone' => '555-789-0123',
                'subject' => 'Collaboration for Photo Shoot',
                'message' => 'I\'m a local photographer planning a styled bridal shoot for my portfolio in September. I\'m looking for a floral designer to collaborate with who can provide a stunning bridal bouquet, some smaller bridesmaid bouquets, and perhaps a few decorative pieces. This would be great exposure for both of us, as I plan to submit the shoot to several wedding publications. Would you be interested in discussing this creative partnership?',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Isabella Garcia',
                'business_name' => null,
                'email' => 'isabella.garcia@example.com',
                'phone' => '555-890-1234',
                'subject' => 'Sympathy Arrangement Delivery',
                'message' => 'I need to send a sympathy arrangement to a funeral home for a service this Thursday. My friend lost her mother, and I\'d like to send something elegant and comforting. White lilies were her mother\'s favorite flower, so I\'d like those to be included if possible. Could you create something appropriate and ensure delivery to Smith Funeral Home by Thursday morning? Please let me know the options and pricing.',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
            [
                'name' => 'Ethan Miller',
                'business_name' => 'Miller Real Estate',
                'email' => 'ethan.miller@example.com',
                'phone' => '555-901-2345',
                'subject' => 'Property Staging Flowers',
                'message' => 'Our real estate agency is looking for a floral provider to help stage our high-end property listings. We typically need arrangements for entryways, dining tables, and occasionally master bedrooms. We list about 5-10 luxury properties per month and would need fresh arrangements for open houses and photography sessions. I\'d like to discuss a potential ongoing arrangement with flexible scheduling based on our listing calendar.',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 1)),
            ],
        ];

        foreach ($data as $messageData) {
            ContactMessage::create($messageData);
        }
    }
}
