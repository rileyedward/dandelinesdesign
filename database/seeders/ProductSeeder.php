<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $imagesPath = public_path('images');
        $images = array_filter(scandir($imagesPath), function ($item) use ($imagesPath) {
            return ! is_dir($imagesPath.'/'.$item) && $item !== '.' && $item !== '..' && $item !== '.DS_Store';
        });

        $availableProducts = [
            [
                'name' => 'Elegant Rose Bouquet',
                'description' => 'A stunning arrangement of premium roses in various shades, perfect for special occasions or as a heartfelt gift. Each bouquet is carefully crafted with fresh, high-quality roses and complementary greenery.',
                'price' => 65.99,
                'is_available' => true,
            ],
            [
                'name' => 'Rustic Wildflower Centerpiece',
                'description' => 'Bring the beauty of a meadow to your table with this charming wildflower centerpiece. Features a seasonal mix of wildflowers arranged in a rustic wooden box, perfect for farmhouse-style decor.',
                'price' => 49.95,
                'is_available' => true,
            ],
            [
                'name' => 'Tropical Paradise Arrangement',
                'description' => 'Transport yourself to a tropical oasis with this vibrant arrangement featuring exotic blooms like bird of paradise, orchids, and tropical greenery. A bold statement piece for any space.',
                'price' => 79.99,
                'is_available' => true,
            ],
            [
                'name' => 'Succulent Garden Bowl',
                'description' => 'A low-maintenance living arrangement featuring an assortment of premium succulents planted in a decorative ceramic bowl. Perfect for home or office, these hardy plants bring long-lasting beauty.',
                'price' => 45.50,
                'is_available' => true,
            ],
            [
                'name' => 'Seasonal Wreath',
                'description' => 'Welcome guests with our handcrafted seasonal wreath. Made with preserved and dried flowers, this wreath offers lasting beauty and can be displayed year after year. Available in various seasonal designs.',
                'price' => 89.95,
                'is_available' => true,
            ],
            [
                'name' => 'Lavender Herb Pot',
                'description' => 'Enjoy the calming scent and beauty of fresh lavender with this potted herb arrangement. Comes in a decorative terracotta pot and includes care instructions for long-lasting enjoyment.',
                'price' => 29.99,
                'is_available' => true,
            ],
            [
                'name' => 'Wedding Floral Package',
                'description' => 'Our comprehensive wedding floral package includes bridal bouquet, bridesmaids bouquets, boutonnieres, corsages, and ceremony arrangements. Customizable to match your wedding colors and style.',
                'price' => 899.00,
                'is_available' => true,
            ],
            [
                'name' => 'Sympathy Peace Lily',
                'description' => 'Express your condolences with this elegant peace lily plant. Known for its air-purifying qualities and symbolic meaning, this long-lasting plant comes in a tasteful decorative pot with a sympathy card.',
                'price' => 59.95,
                'is_available' => true,
            ],
        ];

        $unavailableProducts = [
            [
                'name' => 'Holiday Poinsettia Arrangement',
                'description' => 'Celebrate the holiday season with our festive poinsettia arrangement. Features premium red poinsettias accented with holly berries, pine cones, and seasonal greenery in a decorative holiday container.',
                'price' => 55.00,
                'is_available' => false,
            ],
            [
                'name' => 'Spring Tulip Collection',
                'description' => 'Welcome spring with our vibrant tulip collection. This arrangement features a colorful assortment of fresh tulips arranged in a glass vase. A perfect way to brighten any space after winter.',
                'price' => 39.99,
                'is_available' => false,
            ],
            [
                'name' => 'Custom Event Centerpiece',
                'description' => 'Designed specifically for corporate events and galas, these custom centerpieces are created to match your event theme and color scheme. Minimum order of 10 centerpieces required.',
                'price' => 75.00,
                'is_available' => false,
            ],
        ];

        foreach ($availableProducts as $product) {
            Product::query()->create([
                'name' => $product['name'],
                'description' => $product['description'],
                'image_url' => '/images/'.($images ? $images[array_rand($images)] : ''),
                'price' => $product['price'],
                'is_available' => $product['is_available'],
            ]);
        }

        foreach ($unavailableProducts as $product) {
            Product::query()->create([
                'name' => $product['name'],
                'description' => $product['description'],
                'image_url' => '/images/'.($images ? $images[array_rand($images)] : ''),
                'price' => $product['price'],
                'is_available' => $product['is_available'],
            ]);
        }
    }
}
