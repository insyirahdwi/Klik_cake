<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $catTips = ArticleCategory::firstOrCreate(
            ['slug' => 'tips-dan-resep'],
            [
                'name' => 'Tips & Panduan Kue',
                'description' => 'Tips menyimpan kue, memilih ukuran tart, dan panduan memilih hidangan pesta.',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $catCerita = ArticleCategory::firstOrCreate(
            ['slug' => 'cerita-dapur-pinky'],
            [
                'name' => 'Cerita Dapur Pinky',
                'description' => 'Kisah di balik layar pembuatan roti dan kue segar di dapur Makassar kami.',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $catAcara = ArticleCategory::firstOrCreate(
            ['slug' => 'acara-dan-hampers'],
            [
                'name' => 'Acara & Hampers Makassar',
                'description' => 'Inspirasi snackbox kantor, aqiqah, arisan, hingga hampers hari raya khas Makassar.',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'rahasia-kelembutan-strawberry-cream-cake-khas-pinky-cake'],
            [
                'category_id' => $catCerita->id,
                'title' => 'Rahasia Kelembutan Strawberry Cream Cake Khas Pinky Cake',
                'excerpt' => 'Mengapa bolu chiffon kami begitu lembut dan krim segarnya tidak bikin enek? Simak proses pemanggangan hari-H langsung dari dapur Panakkukang.',
                'content' => '<p>Setiap pagi sebelum fajar menyingsing di kota Makassar, oven dapur <strong>Pinky Cake & Bakery</strong> sudah mulai memancarkan aroma wangi mentega premium dan vanila murni. Salah satu menu paling digemari pelanggan kami sejak hari pertama adalah <em>Strawberry Cream Cake</em>.</p><h3>1. Dipanggang Sesuai Jadwal (Bake to Order)</h3><p>Kami tidak pernah membekukan atau menyimpan bolu berminggu-minggu. Setiap pesanan yang masuk melalui <strong>Klik.Cake</strong> dipanggang khusus H-1 sesuai slot waktu pengambilan atau pengiriman yang Anda pilih (pukul 10.00, 13.00, atau 16.00 WITA).</p><h3>2. Buah Strawberry Segar & Whipped Cream Lembut</h3><p>Kombinasi asam manis strawberry segar berpadu sempurna dengan krim kocok dingin yang ringan. Kue ini sangat cocok disajikan pada suhu dingin untuk menemani momen spesial ulang tahun keluarga tercinta.</p>',
                'author_name' => 'Chef Pastry Pinky Cake',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'view_count' => 124,
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'panduan-memilih-ukuran-cake-sesuai-jumlah-tamu'],
            [
                'category_id' => $catTips->id,
                'title' => 'Panduan Memilih Ukuran Cake Sesuai Jumlah Tamu Acara Anda',
                'excerpt' => 'Bingung memilih ukuran kue 16cm, 20cm, atau 24cm? Simak perkiraan jumlah porsi agar acara Anda berjalan sempurna tanpa kekurangan kue.',
                'content' => '<p>Memilih ukuran kue tart ulang tahun atau perayaan sering kali membingungkan. Apakah diameter 16 cm sudah cukup untuk arisan keluarga, ataukah butuh ukuran 24 cm?</p><ul><li><strong>Diameter 16 cm:</strong> Cocok untuk 4–6 porsi keluarga inti atau perayaan santai berdua.</li><li><strong>Diameter 20 cm:</strong> Pilihan paling populer untuk 8–12 porsi perayaan ulang tahun anak atau kumpul kerabat.</li><li><strong>Diameter 24 cm:</strong> Ideal untuk 16–20 porsi acara kantor, perayaan wisuda, atau syukuran keluarga besar.</li></ul><p>Semua cake kami dilengkapi dengan lilin angka/batang, pisau pemotong higienis, dan kartu ucapan gratis yang dapat Anda isi langsung di website Klik.Cake.</p>',
                'author_name' => 'Tim Klik.Cake',
                'is_published' => true,
                'published_at' => now()->subDays(1),
                'view_count' => 88,
            ]
        );
    }
}
