<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $blogPosts = [
            [
                'title' => 'Spring Wedding Floral Trends 2024',
                'content' => "Spring weddings are magical, and this year's floral trends are all about embracing natural beauty and sustainability. From locally sourced blooms to eco-friendly arrangements, couples are choosing flowers that tell a story.\n\nPeonies continue to reign supreme for spring weddings, with their lush, romantic blooms creating stunning focal points. Pair them with delicate ranunculus and garden roses for a classic, elegant look.\n\nWildflower arrangements are gaining popularity, offering a more relaxed, bohemian aesthetic. Think sweet peas, delphiniums, and cornflowers mixed with textural greenery like eucalyptus and dusty miller.\n\nSustainability is key this season - consider locally grown flowers, potted plants as centerpieces that guests can take home, and biodegradable floral foam alternatives.",
                'is_published' => true,
            ],
            [
                'title' => 'How to Care for Your Wedding Bouquet After the Big Day',
                'content' => "Your wedding bouquet holds precious memories, and with proper care, you can preserve its beauty for years to come. Here's our guide to bouquet preservation.\n\nPress and Frame: The traditional method involves pressing individual flowers between heavy books for 2-3 weeks, then arranging them in a shadow box or frame.\n\nFreeze Drying: This modern technique maintains the flowers' shape and color better than traditional pressing. Professional freeze-drying services can preserve your entire bouquet.\n\nResin Preservation: Create stunning keepsakes by embedding petals in resin to make coasters, jewelry, or decorative pieces.\n\nDried Arrangements: Air-dry your bouquet by hanging it upside down in a dark, dry place. Once dried, display it in a vase or shadow box.\n\nRemember to start the preservation process as soon as possible after your wedding for the best results.",
                'is_published' => true,
            ],
            [
                'title' => 'Corporate Event Floral Design: Making a Lasting Impression',
                'content' => "Corporate events require a delicate balance of professionalism and creativity. The right floral arrangements can transform any business gathering into a memorable experience.\n\nColor Psychology in Business: Choose colors that align with your brand and event goals. Blues and greens convey trust and growth, while warm colors like oranges and reds create energy and excitement.\n\nScale and Proportion: Consider the venue size and guest count. Large arrangements work well for spacious venues, while smaller, elegant pieces suit intimate boardroom meetings.\n\nLongevity Matters: Corporate events often last several hours or days. Choose hardy flowers like chrysanthemums, alstroemeria, and carnations that maintain their appearance.\n\nSeasonal Considerations: Work with what's in season for the best quality and value. Spring offers tulips and daffodils, while fall provides rich dahlias and sunflowers.\n\nRemember, corporate floral design should enhance, not distract from, your business objectives.",
                'is_published' => true,
            ],
            [
                'title' => 'The Art of Seasonal Centerpieces',
                'content' => "Creating stunning centerpieces that reflect the changing seasons adds natural beauty and relevance to any event. Each season offers unique opportunities for creative expression.\n\nSpring Centerpieces: Embrace fresh beginnings with tulips, daffodils, and cherry blossoms. Add pussy willows and flowering branches for height and texture.\n\nSummer Abundance: Celebrate with vibrant sunflowers, zinnias, and dahlias. Incorporate fresh herbs like lavender and rosemary for delightful fragrance.\n\nAutumn Elegance: Rich burgundies, golds, and oranges shine in fall arrangements. Use seasonal elements like mini pumpkins, pine cones, and colored leaves.\n\nWinter Wonder: Create magic with white and silver palettes featuring roses, lilies, and evergreen branches. Add sparkle with frosted elements and candles.\n\nPro tip: Always consider the venue's lighting and table size when designing centerpieces. They should enhance conversation, not hinder it.",
                'is_published' => false,
            ],
            [
                'title' => 'Sustainable Floral Design: Eco-Friendly Practices',
                'content' => "As environmental consciousness grows, sustainable floral design has become more important than ever. Here's how we're leading the green revolution in floriculture.\n\nLocal Sourcing: We partner with local farms to reduce transportation emissions and support our community. Local flowers are often fresher and last longer.\n\nSeasonal Selection: Working with nature's timeline ensures the best quality blooms while reducing the need for greenhouse production and long-distance shipping.\n\nEco-Friendly Mechanics: We use biodegradable floral foam alternatives, reusable containers, and minimal packaging. Chicken wire and pin holders replace traditional foam in many designs.\n\nCompost Programs: All organic waste from our studio goes to local composting facilities, creating nutrient-rich soil for future gardens.\n\nEducation and Awareness: We help clients understand the environmental impact of their choices and offer beautiful, sustainable alternatives.\n\nSustainable floristry doesn't mean compromising on beauty – it means creating arrangements that are beautiful for both today and tomorrow.",
                'is_published' => true,
            ],
            [
                'title' => 'Behind the Scenes: A Day in Our Floral Studio',
                'content' => "Ever wondered what happens behind the scenes at Dandeline Designs? Take a peek into our daily routine and creative process.\n\n5:00 AM - Market Run: Our day starts early at the flower market, selecting the freshest blooms. We look for flowers with strong stems, vibrant colors, and tight buds that will open beautifully.\n\n7:00 AM - Conditioning: Back at the studio, every stem gets conditioned – cut at an angle under running water and placed in fresh, clean water with flower food.\n\n8:00 AM - Design Planning: We review the day's orders, checking color palettes, delivery times, and special requests. Each arrangement is sketched before creation begins.\n\n9:00 AM - Creation Time: The magic happens as our team brings designs to life. Music plays, coffee flows, and beautiful arrangements take shape.\n\n2:00 PM - Quality Check: Every arrangement receives a final inspection for balance, color harmony, and overall impact.\n\n3:00 PM - Delivery Prep: Arrangements are carefully packed for safe transport to ensure they arrive in perfect condition.\n\nIt's a labor of love that brings joy to countless celebrations throughout our community.",
                'is_published' => false,
            ],
            [
                'title' => 'Holiday Floral Traditions Around the World',
                'content' => "Flowers play a significant role in holiday celebrations worldwide. Let's explore beautiful floral traditions that inspire our holiday arrangements.\n\nPoinsettias in Mexico: The vibrant red bracts of poinsettias symbolize the Star of Bethlehem and are central to Mexican Christmas celebrations.\n\nCherry Blossoms in Japan: Hanami, the tradition of viewing cherry blossoms, celebrates the fleeting beauty of spring and renewal.\n\nMarigolds in India: During Diwali, marigold garlands and petals create stunning decorations symbolizing prosperity and good fortune.\n\nRoses on Valentine's Day: This Western tradition has spread globally, with red roses expressing deep love and passion.\n\nLilies at Easter: White lilies represent rebirth and new life, making them perfect for Easter celebrations across Christian communities.\n\nOlive Branches in Greece: Symbol of peace and wisdom, olive branches are used in Greek Orthodox celebrations and weddings.\n\nThese traditions inspire our holiday collections, blending cultural significance with contemporary design to create meaningful arrangements for every celebration.",
                'is_published' => true,
            ],
            [
                'title' => 'DIY Floral Arrangements: Tips from the Pros',
                'content' => "Creating beautiful floral arrangements at home can be rewarding and fun. Here are our professional tips to help you succeed.\n\nStart with Fresh Flowers: Visit your local flower market or grocery store and choose flowers with firm stems and vibrant colors. Avoid blooms that look wilted or have brown edges.\n\nPrepare Your Vase: Clean your vase thoroughly and fill it with fresh water. Add flower food if available – it really does extend flower life.\n\nCreate a Foundation: Start with greenery to create structure, then add your largest flowers as focal points. Fill in with smaller blooms and delicate details.\n\nHeight Variation: Cut stems at different lengths to create visual interest. A good rule is to make the tallest flowers 1.5 times the height of your vase.\n\nOdd Numbers Work: Arrange flowers in odd numbers (3, 5, 7) for the most pleasing visual balance.\n\nDaily Maintenance: Change the water every few days, recut stems at an angle, and remove any wilted flowers to extend the life of your arrangement.\n\nWith practice and these professional techniques, you'll be creating stunning arrangements that rival any florist!",
                'is_published' => true,
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'is_published' => $post['is_published'],
            ]);
        }

        BlogPost::factory(12)->create();
    }
}
