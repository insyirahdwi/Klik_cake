<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            [
                'key' => 'site_name',
                'value' => 'Klik.Cake',
                'group' => 'general',
                'label' => 'Nama Website / Brand',
                'type' => 'text',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'by Pinky Cake & Bakery Makassar',
                'group' => 'general',
                'label' => 'Tagline Brand',
                'type' => 'text',
            ],
            [
                'key' => 'meta_description',
                'value' => 'Pesan roti & kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Dibuat fresh setiap hari.',
                'group' => 'general',
                'label' => 'Deskripsi Meta SEO',
                'type' => 'textarea',
            ],

            // Announcement
            [
                'key' => 'announcement_enabled',
                'value' => '1',
                'group' => 'announcement',
                'label' => 'Aktifkan Announcement Bar',
                'type' => 'boolean',
            ],
            [
                'key' => 'announcement_text',
                'value' => '✨ Fresh Bake Setiap Hari — Pesan Hari Ini untuk Pengiriman Esok Hari di Seluruh Area Makassar!',
                'group' => 'announcement',
                'label' => 'Teks Pengumuman',
                'type' => 'text',
            ],

            // Contact & Kitchen
            [
                'key' => 'contact_whatsapp',
                'value' => '6281234567890',
                'group' => 'contact',
                'label' => 'Nomor WhatsApp CS (tanpa tanda +)',
                'type' => 'text',
            ],
            [
                'key' => 'contact_email',
                'value' => 'halo@klikcake.local',
                'group' => 'contact',
                'label' => 'Email Layanan Pelanggan',
                'type' => 'text',
            ],
            [
                'key' => 'kitchen_address',
                'value' => "Jl. Boulevard / Panakkukang\nMakassar, Sulawesi Selatan",
                'group' => 'contact',
                'label' => 'Alamat Dapur / Lokasi Pick-up',
                'type' => 'textarea',
            ],
            [
                'key' => 'operating_hours',
                'value' => 'Buka setiap hari: 08.00 – 20.00 WITA',
                'group' => 'contact',
                'label' => 'Jam Operasional Dapur',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            WebSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
