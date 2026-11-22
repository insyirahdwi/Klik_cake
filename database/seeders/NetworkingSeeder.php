<?php

namespace Database\Seeders;

use App\Models\Networking;
use Illuminate\Database\Seeder;

class NetworkingSeeder extends Seeder
{
    public function run(): void
    {
        $networks = [
            // Social Media
            [
                'name' => 'Instagram @pinkycakemks',
                'type' => 'social_media',
                'platform' => 'instagram',
                'url' => 'https://instagram.com/pinkycakemks',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'TikTok @klik.cake',
                'type' => 'social_media',
                'platform' => 'tiktok',
                'url' => 'https://tiktok.com/@klik.cake',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'WhatsApp Channel Pinky Cake',
                'type' => 'social_media',
                'platform' => 'whatsapp',
                'url' => 'https://wa.me/6281234567890',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Outlets & Kitchens in Makassar
            [
                'name' => 'Dapur Pusat Panakkukang',
                'type' => 'kitchen',
                'platform' => 'gmaps',
                'url' => 'https://maps.google.com/?q=Panakkukang+Makassar',
                'address' => 'Jl. Boulevard Ruko Ruby, Panakkukang, Makassar',
                'phone' => '0812-3456-7890',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Outlet Pick-up Pengayoman',
                'type' => 'outlet',
                'platform' => 'gmaps',
                'url' => 'https://maps.google.com/?q=Pengayoman+Makassar',
                'address' => 'Jl. Pengayoman No. 45, Makassar',
                'phone' => '0812-9876-5432',
                'is_active' => true,
                'sort_order' => 5,
            ],

            // Reseller / Mitra
            [
                'name' => 'Mitra Reseller Antang & Tamalanrea',
                'type' => 'reseller',
                'platform' => 'whatsapp',
                'url' => 'https://wa.me/6281234567890',
                'address' => 'Titik Distribusi Antang / Perintis, Makassar',
                'phone' => '0821-1122-3344',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($networks as $item) {
            Networking::firstOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
