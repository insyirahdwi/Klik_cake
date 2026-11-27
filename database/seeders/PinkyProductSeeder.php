<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class PinkyProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure root collections exist
        $snack = Collection::firstOrCreate(
            ['slug' => 'snack'],
            ['name' => 'Snack', 'sort_order' => 4]
        );
        $cake = Collection::firstOrCreate(
            ['slug' => 'cake'],
            ['name' => 'Cake', 'sort_order' => 2]
        );
        $roti = Collection::firstOrCreate(
            ['slug' => 'roti'],
            ['name' => 'Roti', 'sort_order' => 1]
        );

        // Delete existing products to avoid duplicates
        Product::whereIn('slug', [
            'kacang-kribo', 'cheese-cake', 'floshroll',
            'roti-sosis', 'donat-kukus', 'brownies',
        ])->each(function ($p) {
            $p->variants()->delete();
            $p->delete();
        });

        $products = [
            [
                'collection' => $snack,
                'name' => 'Kacang Kribo',
                'slug' => 'kacang-kribo',
                'image_url' => 'products/kacang-kribo.jpg',
                'description' => 'Snack kacang kribo gurih dan renyah, cocok untuk cemilan sehari-hari. Dikemas rapi dan higienis.',
                'portion_info' => '1 pack ± 200g',
                'is_fresh_bake' => true,
                'is_featured' => true,
                'rating' => 4.8,
                'lead_time_days' => 1,
                'availability_type' => 'preorder',
                'variants' => [
                    ['name' => 'Pack Reguler', 'sku' => 'KK-REG', 'price' => 25000, 'stock' => 50],
                    ['name' => 'Pack Jumbo', 'sku' => 'KK-JMB', 'price' => 45000, 'stock' => 30],
                ],
            ],
            [
                'collection' => $cake,
                'name' => 'Cheese Cake',
                'slug' => 'cheese-cake',
                'image_url' => 'products/cheese-cake.jpg',
                'description' => 'Cheese cake lembut dengan topping keju premium. Menu kamis untuk yang termanis.',
                'portion_info' => 'Porsi 4-6 orang',
                'is_fresh_bake' => true,
                'is_featured' => true,
                'rating' => 4.9,
                'lead_time_days' => 1,
                'availability_type' => 'preorder',
                'variants' => [
                    ['name' => 'Slice', 'sku' => 'CC-SLC', 'price' => 35000, 'stock' => 20],
                    ['name' => 'Whole Cake', 'sku' => 'CC-WHL', 'price' => 185000, 'stock' => 10],
                ],
            ],
            [
                'collection' => $roti,
                'name' => 'Floshroll',
                'slug' => 'floshroll',
                'image_url' => 'products/floshroll.jpg',
                'description' => 'Roti gulung floss dengan isian yang melimpah. Gurihnya melimpah, lembutnya bikin nagih.',
                'portion_info' => '1 pack isi 4 pcs',
                'is_fresh_bake' => true,
                'is_featured' => true,
                'rating' => 4.7,
                'lead_time_days' => 1,
                'availability_type' => 'preorder',
                'variants' => [
                    ['name' => 'Pack 4 pcs', 'sku' => 'FR-4PC', 'price' => 30000, 'stock' => 40],
                    ['name' => 'Pack 8 pcs', 'sku' => 'FR-8PC', 'price' => 55000, 'stock' => 20],
                ],
            ],
            [
                'collection' => $roti,
                'name' => 'Roti Sosis',
                'slug' => 'roti-sosis',
                'image_url' => 'products/roti-sosis.jpg',
                'description' => 'Roti sosis dengan keju mozarella yang melimpah. Gurih kejunya, juicy sosisnya.',
                'portion_info' => '1 pack isi 4 pcs',
                'is_fresh_bake' => true,
                'is_featured' => true,
                'rating' => 4.8,
                'lead_time_days' => 1,
                'availability_type' => 'preorder',
                'variants' => [
                    ['name' => 'Pack 4 pcs', 'sku' => 'RS-4PC', 'price' => 28000, 'stock' => 35],
                    ['name' => 'Pack 8 pcs', 'sku' => 'RS-8PC', 'price' => 50000, 'stock' => 20],
                ],
            ],
            [
                'collection' => $roti,
                'name' => 'Donat Kukus',
                'slug' => 'donat-kukus',
                'image_url' => 'products/donat-kukus.jpg',
                'description' => 'Donat kukus lembut dan fluffy. Sekali gigit langsung lumer di mulut.',
                'portion_info' => '1 box isi 6 pcs',
                'is_fresh_bake' => true,
                'is_featured' => true,
                'rating' => 4.9,
                'lead_time_days' => 1,
                'availability_type' => 'preorder',
                'variants' => [
                    ['name' => 'Box 6 pcs', 'sku' => 'DK-6PC', 'price' => 25000, 'stock' => 40],
                    ['name' => 'Box 12 pcs', 'sku' => 'DK-12PC', 'price' => 45000, 'stock' => 25],
                ],
            ],
            [
                'collection' => $cake,
                'name' => 'Brownies',
                'slug' => 'brownies',
                'image_url' => 'products/brownies.jpg',
                'description' => 'Brownies red velvet premium. Manis, gurih, dan moist — perpaduan sempurna.',
                'portion_info' => 'Porsi 6-8 orang',
                'is_fresh_bake' => true,
                'is_featured' => true,
                'rating' => 4.8,
                'lead_time_days' => 1,
                'availability_type' => 'preorder',
                'variants' => [
                    ['name' => 'Reguler', 'sku' => 'BR-REG', 'price' => 65000, 'stock' => 15],
                    ['name' => 'Premium Box', 'sku' => 'BR-PRM', 'price' => 95000, 'stock' => 10],
                ],
            ],
        ];

        foreach ($products as $data) {
            $collection = $data['collection'];
            $variants = $data['variants'];
            unset($data['collection'], $data['variants']);

            $product = Product::create(array_merge($data, [
                'collection_id' => $collection->id,
            ]));

            foreach ($variants as $variant) {
                $product->variants()->create($variant);
            }

            $this->command->info("✓ Created: {$product->name}");
        }

        $this->command->info("\n🎉 6 produk Pinky Cake berhasil di-seed!");
    }
}
