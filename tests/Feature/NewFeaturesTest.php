<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\HeroSection;
use App\Models\Networking;
use App\Models\Page;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewFeaturesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure default admin exists
        User::firstOrCreate(
            ['email' => 'adminpinky@klikcake.local'],
            [
                'name' => 'Admin Pinky',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }

    public function test_article_index_and_detail_page(): void
    {
        $cat = ArticleCategory::firstOrCreate(
            ['slug' => 'test-kategori'],
            ['name' => 'Test Kategori', 'is_active' => true]
        );

        $article = Article::firstOrCreate(
            ['slug' => 'test-artikel-makassar'],
            [
                'category_id' => $cat->id,
                'title' => 'Test Artikel Makassar',
                'excerpt' => 'Cuplikan artikel pengujian.',
                'content' => '<p>Konten artikel pengujian kue Makassar.</p>',
                'author_name' => 'Redaksi Test',
                'is_published' => true,
                'published_at' => now(),
            ]
        );

        // 1. Index page
        $resIndex = $this->get('/artikel');
        $resIndex->assertStatus(200);
        $resIndex->assertSee('Artikel, Tips & Inspirasi Pesta');

        // 2. Filter by category
        $resFilter = $this->get('/artikel?kategori=' . $cat->slug);
        $resFilter->assertStatus(200);
        $resFilter->assertSee('Test Artikel Makassar');

        // 3. Detail page
        $resShow = $this->get('/artikel/' . $article->slug);
        $resShow->assertStatus(200);
        $resShow->assertSee('Test Artikel Makassar');
        $resShow->assertSee('Konten artikel pengujian kue Makassar.');
    }

    public function test_dynamic_and_static_pages(): void
    {
        $page = Page::firstOrCreate(
            ['slug' => 'panduan-kemitraan'],
            [
                'title' => 'Panduan Kemitraan Reseller',
                'content' => '<p>Informasi resmi kemitraan reseller Pinky Cake Makassar.</p>',
                'is_published' => true,
                'show_in_footer' => true,
            ]
        );

        $response = $this->get('/halaman/' . $page->slug);
        $response->assertStatus(200);
        $response->assertSee('Panduan Kemitraan Reseller');
        $response->assertSee('Informasi resmi kemitraan reseller');

        // Static fallback routes still work
        $this->get('/tentang-kami')->assertStatus(200);
        $this->get('/cara-pesan')->assertStatus(200);
        $this->get('/faq')->assertStatus(200);
    }

    public function test_hero_section_rendered_on_homepage(): void
    {
        HeroSection::firstOrCreate(
            ['title' => 'Bolu Spesial Makassar'],
            [
                'badge_text' => 'Bake Harian',
                'subtitle' => 'Dibuat fresh setiap hari.',
                'button_text' => 'Beli Sekarang',
                'button_link' => '/katalog',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Bolu Spesial Makassar');
    }

    public function test_web_settings_helper_and_announcement_bar(): void
    {
        WebSetting::set('announcement_enabled', '1', 'announcement');
        WebSetting::set('announcement_text', 'Promo Spesial Diskon 20% Dapur Panakkukang!', 'announcement');
        WebSetting::set('site_name', 'Klik.Cake', 'general');

        $this->assertEquals('Klik.Cake', WebSetting::get('site_name'));
        $this->assertEquals('1', WebSetting::get('announcement_enabled'));

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Promo Spesial Diskon 20% Dapur Panakkukang!');
    }

    public function test_networking_page_lists_outlets_and_socials(): void
    {
        Networking::firstOrCreate(
            ['name' => 'Outlet Uji Panakkukang'],
            [
                'type' => 'outlet',
                'platform' => 'gmaps',
                'address' => 'Jl. Pengayoman Ruko Panakkukang',
                'phone' => '081122334455',
                'is_active' => true,
            ]
        );

        $response = $this->get('/jaringan');
        $response->assertStatus(200);
        $response->assertSee('Jejaring Dapur, Outlet & Mitra Makassar');
        $response->assertSee('Outlet Uji Panakkukang');
    }

    public function test_admin_can_access_new_filament_resources(): void
    {
        $admin = User::where('email', 'adminpinky@klikcake.local')->first();

        $this->actingAs($admin)
            ->get('/admin/article-categories')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/articles')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/pages')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/hero-sections')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/web-settings')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/networkings')
            ->assertStatus(200);
    }
}
