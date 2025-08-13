<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            [
                'type' => 'success',
                'title' => 'New Quote Request Received',
                'message' => 'A new quote request has been submitted by Emily Johnson for a wedding in June.',
                'action_url' => route('admin.quotes.index'),
                'action_text' => 'View Quote Requests',
                'is_read' => false,
            ],
            [
                'type' => 'info',
                'title' => 'New Contact Message',
                'message' => 'Michael Smith has sent a new contact message regarding corporate event planning.',
                'action_url' => route('admin.messages.index'),
                'action_text' => 'View Messages',
                'is_read' => false,
            ],
            [
                'type' => 'primary',
                'title' => 'Lead Status Updated',
                'message' => 'Lead "Sarah Johnson" status updated to "Proposal Sent"',
                'action_url' => route('admin.leads.index'),
                'action_text' => 'View Leads',
                'is_read' => true,
            ],
            [
                'type' => 'warning',
                'title' => 'Inventory Alert',
                'message' => 'Product "Rustic Centerpiece" is low in stock (2 remaining).',
                'action_url' => route('admin.products.index'),
                'action_text' => 'Manage Inventory',
                'is_read' => false,
            ],
            [
                'type' => 'danger',
                'title' => 'Payment Failed',
                'message' => 'Payment for order #1042 has failed. Customer has been notified.',
                'action_url' => '#',
                'action_text' => 'View Order',
                'is_read' => false,
            ],
            [
                'type' => 'success',
                'title' => 'New Testimonial Submitted',
                'message' => 'A new 5-star testimonial has been submitted by David Thompson.',
                'action_url' => route('admin.testimonials.index'),
                'action_text' => 'View Testimonials',
                'is_read' => true,
            ],
            [
                'type' => 'info',
                'title' => 'Blog Post Published',
                'message' => 'Your blog post "Spring Wedding Trends" has been published successfully.',
                'action_url' => route('admin.blog.index'),
                'action_text' => 'View Blog Posts',
                'is_read' => true,
            ],
            [
                'type' => 'primary',
                'title' => 'Calendar Reminder',
                'message' => 'You have a consultation with Amanda Foster tomorrow at 2:00 PM.',
                'action_url' => '#',
                'action_text' => 'View Calendar',
                'is_read' => false,
            ],
            [
                'type' => 'warning',
                'title' => 'Website Maintenance',
                'message' => 'Scheduled maintenance will occur tonight from 2:00 AM to 4:00 AM.',
                'action_url' => null,
                'action_text' => null,
                'is_read' => false,
            ],
            [
                'type' => 'danger',
                'title' => 'Security Alert',
                'message' => 'Multiple failed login attempts detected from IP 192.168.1.1.',
                'action_url' => '#',
                'action_text' => 'Review Security',
                'is_read' => true,
                'created_at' => now()->subDays(5),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::query()->create($notification);
        }
    }
}
