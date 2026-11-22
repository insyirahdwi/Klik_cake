<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use App\Models\Product;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        $featured = Product::where('slug', 'strawberry-cream-cake')->first()
            ?? Product::first();

        HeroSection::firstOrCreate(
            ['title' => 'Klik, dipanggang, sampai.'],
            [
                'badge_text' => 'Fresh Bake hari ini',
                'subtitle' => 'Pesan roti & kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Dibuat fresh setiap hari langsung dari dapur kami.',
                'button_text' => 'Pesan Sekarang',
                'button_link' => '/katalog',
                'secondary_button_text' => 'Lihat Menu',
                'secondary_button_link' => '#kategori',
                'image_url' => 'products/hero-makassar.jpg',
                'featured_product_id' => $featured?->id,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
