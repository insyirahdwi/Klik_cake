<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::firstOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'title' => 'Tentang Kami',
                'meta_description' => 'Mengenal Pinky Cake & Bakery Makassar dan sistem pemesanan online Klik.Cake.',
                'content' => '<h2>Hangat Dari Dapur Makassar</h2><p><strong>Klik.Cake</strong> adalah platform pemesanan online resmi dari <strong>Pinky Cake & Bakery</strong> di Makassar. Kami hadir untuk menghadirkan pengalaman menikmati roti, cake, dan pastry segar tanpa khawatir kehabisan kuota atau kue mengendap lama di etalase toko.</p><h3>Filosofi Fresh Bake Kami</h3><p>Kami percaya kue terbaik adalah kue yang baru selesai dipanggang. Dengan sistem kuota slot harian, kami menjamin setiap kue dipanggang khusus menjelang jam pengiriman atau pengambilan yang Anda tentukan.</p>',
                'is_published' => true,
                'show_in_header' => false,
                'show_in_footer' => true,
                'sort_order' => 1,
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'cara-pesan'],
            [
                'title' => 'Cara Pesan',
                'meta_description' => 'Panduan mudah memesan roti dan kue di Klik.Cake Makassar.',
                'content' => '<h2>3 Langkah Mudah Pesan di Klik.Cake</h2><ol><li><strong>Pilih Menu & Varian:</strong> Tentukan kue favorit Anda, tentukan ukuran/rasa, dan tambahkan ucapan kartu jika untuk kado.</li><li><strong>Tentukan Tanggal & Slot:</strong> Pilih tanggal pengiriman (minimal H-1) dan slot waktu yang tersedia (10.00, 13.00, atau 16.00 WITA).</li><li><strong>Bayar & Lacak:</strong> Selesaikan pembayaran via QRIS/Transfer, dan pantau status pemanggangan kue Anda secara real-time.</li></ol>',
                'is_published' => true,
                'show_in_header' => true,
                'show_in_footer' => true,
                'sort_order' => 2,
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'kebijakan-privasi'],
            [
                'title' => 'Kebijakan Privasi',
                'meta_description' => 'Kebijakan privasi dan perlindungan data pelanggan Klik.Cake.',
                'content' => '<h2>Perlindungan Data Anda</h2><p>Klik.Cake menghormati dan menjaga kerahasiaan data pribadi seluruh pelanggan. Data seperti nama, nomor WhatsApp, dan alamat pengiriman hanya digunakan untuk keperluan pemrosesan dan pengantaran pesanan Anda di area Makassar.</p>',
                'is_published' => true,
                'show_in_header' => false,
                'show_in_footer' => true,
                'sort_order' => 3,
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'syarat-ketentuan'],
            [
                'title' => 'Syarat & Ketentuan',
                'meta_description' => 'Syarat dan ketentuan pemesanan dan pengiriman di Klik.Cake.',
                'content' => '<h2>Ketentuan Pemesanan</h2><p>1. Pemesanan cake standar dilakukan minimal H-1 sebelum pukul 18.00 WITA.<br>2. Pembayaran terverifikasi otomatis dalam batas waktu 1 jam setelah checkout.<br>3. Pengantaran dilakukan oleh kurir khusus bakery area Makassar.</p>',
                'is_published' => true,
                'show_in_header' => false,
                'show_in_footer' => true,
                'sort_order' => 4,
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'faq'],
            [
                'title' => 'Pertanyaan Umum (FAQ)',
                'meta_description' => 'Jawaban atas pertanyaan seputar pemesanan roti dan cake di Klik.Cake.',
                'content' => '<h2>Pertanyaan yang Sering Diajukan</h2><p><strong>Q: Apakah bisa pesan untuk hari yang sama?</strong><br>A: Untuk menjaga kesegaran Fresh Bake, pemesanan minimal dilakukan H-1 sebelum cut-off jam 18.00 WITA.</p><p><strong>Q: Di mana lokasi pengambilan langsung?</strong><br>A: Dapur pusat kami berlokasi di area Panakkukang / Boulevard, Makassar.</p>',
                'is_published' => true,
                'show_in_header' => false,
                'show_in_footer' => true,
                'sort_order' => 5,
            ]
        );
    }
}
