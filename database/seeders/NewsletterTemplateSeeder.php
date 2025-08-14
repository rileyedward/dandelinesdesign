<?php

namespace Database\Seeders;

use App\Models\NewsletterTemplate;
use Illuminate\Database\Seeder;

class NewsletterTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Create a variety of newsletter templates with different statuses

        // Draft templates (new/in-progress)
        NewsletterTemplate::factory()->count(8)->create([
            'status' => 'draft',
        ]);

        // Scheduled templates (ready to send)
        NewsletterTemplate::factory()->count(3)->create([
            'status' => 'scheduled',
            'scheduled_at' => now()->addDays(rand(1, 14)),
        ]);

        // Sent templates with realistic analytics
        NewsletterTemplate::factory()->count(12)->create([
            'status' => 'sent',
            'sent_at' => now()->subDays(rand(1, 180)),
            'recipients_count' => rand(50, 500),
            'opens_count' => function (array $attributes) {
                return rand(10, $attributes['recipients_count'] * 0.8);
            },
            'clicks_count' => function (array $attributes) {
                return rand(0, $attributes['opens_count'] * 0.3);
            },
        ]);

        // Create specific templates with known content for testing
        NewsletterTemplate::create([
            'name' => 'Welcome to Dandeline Designs',
            'subject' => 'Welcome to our floral design community! 🌸',
            'content' => '<h1>Welcome to Dandeline Designs!</h1>
<p>Thank you for subscribing to our newsletter. We\'re excited to share our passion for beautiful floral arrangements and event planning with you.</p>
<h2>What to Expect</h2>
<ul>
<li>Weekly design inspiration</li>
<li>Seasonal arrangement tips</li>
<li>Exclusive offers and promotions</li>
<li>Behind-the-scenes content</li>
</ul>
<p>Follow us on social media for daily inspiration, and don\'t hesitate to reach out if you have any questions!</p>
<p>Best regards,<br>The Dandeline Designs Team</p>',
            'preview_text' => 'Welcome to our community of floral design enthusiasts! Get ready for weekly inspiration and exclusive offers.',
            'status' => 'sent',
            'sent_at' => now()->subDays(30),
            'recipients_count' => 245,
            'opens_count' => 198,
            'clicks_count' => 45,
            'tags' => ['welcome', 'onboarding'],
            'metadata' => ['campaign_type' => 'welcome_series', 'automation' => true],
        ]);

        NewsletterTemplate::create([
            'name' => 'Spring Collection 2024',
            'subject' => 'Fresh Spring Arrangements - Now Available! 🌷',
            'content' => '<h1>Spring Has Arrived!</h1>
<p>Discover our stunning new spring collection featuring vibrant tulips, fresh daffodils, and elegant cherry blossoms.</p>
<h2>Featured Arrangements</h2>
<p><strong>Sunshine Bouquet</strong> - Bright yellow and orange blooms to brighten any space</p>
<p><strong>Garden Party Centerpiece</strong> - Perfect for spring celebrations and gatherings</p>
<p><strong>Pastel Dreams</strong> - Soft pink and lavender arrangements for a delicate touch</p>
<h2>Limited Time Offer</h2>
<p>Use code SPRING2024 for 15% off your first spring arrangement order!</p>
<p>Order now for delivery this week.</p>',
            'preview_text' => 'Discover our stunning spring collection with 15% off your first order!',
            'status' => 'sent',
            'sent_at' => now()->subDays(15),
            'recipients_count' => 287,
            'opens_count' => 234,
            'clicks_count' => 67,
            'tags' => ['seasonal', 'promotion', 'spring'],
            'metadata' => ['campaign_type' => 'product_launch', 'discount_code' => 'SPRING2024'],
        ]);

        NewsletterTemplate::create([
            'name' => 'Wedding Planning Tips - Draft',
            'subject' => '5 Essential Wedding Floral Design Tips',
            'content' => '<h1>Planning Your Dream Wedding Flowers</h1>
<p>Creating the perfect floral atmosphere for your special day requires careful planning and attention to detail.</p>
<h2>Our Top 5 Tips</h2>
<ol>
<li><strong>Choose seasonal flowers</strong> - They\'re fresher and more budget-friendly</li>
<li><strong>Consider your venue</strong> - Indoor vs outdoor settings require different approaches</li>
<li><strong>Think about color harmony</strong> - Coordinate with your wedding theme and colors</li>
<li><strong>Don\'t forget the details</strong> - Boutonnieres, corsages, and ceremony decorations</li>
<li><strong>Plan for preservation</strong> - Consider how to preserve your bouquet as a keepsake</li>
</ol>
<p>Ready to start planning? Contact us for a consultation!</p>',
            'preview_text' => 'Essential tips for planning your perfect wedding flowers, from seasonal selection to preservation.',
            'status' => 'draft',
            'tags' => ['wedding', 'tips', 'planning'],
            'metadata' => ['target_audience' => 'engaged_couples', 'content_type' => 'educational'],
        ]);

        NewsletterTemplate::create([
            'name' => 'Monthly Newsletter - April 2024',
            'subject' => 'April Updates: New Workshops & Easter Specials',
            'content' => '<h1>April Newsletter</h1>
<h2>What\'s New This Month</h2>
<p>Spring is in full swing, and we\'re excited to share what\'s happening at Dandeline Designs!</p>
<h3>Upcoming Workshops</h3>
<p><strong>Flower Crown Workshop</strong> - April 20th, 2:00 PM<br>
Learn to create beautiful flower crowns perfect for spring photoshoots and festivals.</p>
<p><strong>Easter Centerpiece Class</strong> - April 25th, 10:00 AM<br>
Design elegant Easter table arrangements using seasonal blooms.</p>
<h3>Easter Specials</h3>
<p>Order your Easter arrangements by April 15th and receive free delivery!</p>
<h3>Featured This Month</h3>
<p>Our designer spotlight features Maria\'s stunning work on the Johnson wedding last weekend.</p>',
            'preview_text' => 'April updates including new workshops, Easter specials, and designer spotlight.',
            'status' => 'scheduled',
            'scheduled_at' => now()->addDays(3),
            'tags' => ['monthly', 'workshops', 'easter'],
            'metadata' => ['newsletter_type' => 'monthly_update', 'featured_designer' => 'Maria'],
        ]);
    }
}
