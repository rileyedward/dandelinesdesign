<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $contactMessages = [
            [
                'name' => 'John Davis',
                'business_name' => 'Davis Events',
                'email' => 'john.davis@example.com',
                'phone_number' => '(555) 123-7890',
                'subject' => 'Partnership Opportunity',
                'message' => 'I run an event planning business and would love to discuss a potential partnership. We have several upcoming events that could benefit from your floral expertise.',
                'is_read' => true,
            ],
            [
                'name' => 'Maria Garcia',
                'business_name' => null,
                'email' => 'maria.garcia@example.com',
                'phone_number' => '(555) 234-8901',
                'subject' => 'Custom Arrangement Inquiry',
                'message' => 'I\'m looking for a custom floral arrangement for my mother\'s 70th birthday. She loves orchids and the color purple. Could you create something special?',
                'is_read' => true,
            ],
            [
                'name' => 'Thomas Wilson',
                'business_name' => 'Wilson & Sons Funeral Home',
                'email' => 'thomas@wilsonfuneral.com',
                'phone_number' => '(555) 345-9012',
                'subject' => 'Funeral Service Arrangements',
                'message' => 'We\'re looking to establish a regular supplier for our funeral service floral arrangements. Would like to discuss your options and pricing for sympathy arrangements.',
                'is_read' => false,
            ],
            [
                'name' => 'Rebecca Taylor',
                'business_name' => null,
                'email' => 'rebecca.taylor@example.com',
                'phone_number' => '(555) 456-0123',
                'subject' => 'Website Feedback',
                'message' => 'I just wanted to let you know how much I love your new website! The photos of your arrangements are beautiful and it was very easy to navigate.',
                'is_read' => true,
            ],
            [
                'name' => 'Michael Brown',
                'business_name' => 'Downtown Bistro',
                'email' => 'michael@downtownbistro.com',
                'phone_number' => '(555) 567-1234',
                'subject' => 'Weekly Restaurant Flowers',
                'message' => 'We\'re opening a new restaurant and would like to discuss options for weekly flower arrangements for our dining room tables and reception area.',
                'is_read' => false,
            ],
            [
                'name' => 'Laura Martinez',
                'business_name' => null,
                'email' => 'laura.m@example.com',
                'phone_number' => null,
                'subject' => 'Delivery Question',
                'message' => 'Do you deliver to the Oakwood neighborhood? I\'d like to order flowers for my anniversary but need to confirm you can deliver to this area.',
                'is_read' => false,
            ],
        ];

        foreach ($contactMessages as $contactMessage) {
            ContactMessage::query()->create($contactMessage);
        }

        ContactMessage::factory(20)->create();
    }
}
