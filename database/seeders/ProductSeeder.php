<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        $products = [
            ['name' => 'Wildflower Garden Hoop', 'category' => 'Embroidery Hoop', 'price' => 34.99, 'stock' => 8, 'emoji' => '🌸', 'color' => '#FFE8D6', 'description' => 'A stunning 8-inch embroidery hoop featuring a lush wildflower meadow.', 'tags' => json_encode(['Floral', '8-inch', 'Wall Art']), 'badge' => 'Bestseller', 'featured' => true],
            ['name' => 'Butterfly Dream Pillowcase', 'category' => 'Pillowcase', 'price' => 48.99, 'stock' => 5, 'emoji' => '🦋', 'color' => '#E8F8F5', 'description' => 'Soft cotton pillowcase with hand-embroidered butterflies.', 'tags' => json_encode(['Butterflies', 'Cotton', 'Bedroom']), 'badge' => 'New', 'featured' => true],
            ['name' => 'Vintage Rose Sofa Cover', 'category' => 'Sofa Cover', 'price' => 89.99, 'stock' => 3, 'emoji' => '🛋️', 'color' => '#F5E8FF', 'description' => 'Elegant sofa cover with intricate rose border embroidery.', 'tags' => json_encode(['Roses', 'Linen', 'Living Room']), 'badge' => 'Premium', 'featured' => true],
            ['name' => 'Sunflower Mini Hoop', 'category' => 'Embroidery Hoop', 'price' => 19.99, 'stock' => 15, 'emoji' => '🌻', 'color' => '#FFFDE8', 'description' => 'A cheerful 4-inch mini hoop with a bright sunflower.', 'tags' => json_encode(['Sunflower', '4-inch', 'Gift']), 'badge' => 'Gift Fave', 'featured' => false],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],   
                $product                         
            );
        }
    }
}
