<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = Page::published()->where('slug', 'tentang-kami')->first();
        return view('shop.pages.about', [
            'title' => 'Tentang Kami — Klik.Cake by Pinky Cake & Bakery',
            'page' => $page,
        ]);
    }

    public function privacy(): View
    {
        $page = Page::published()->where('slug', 'kebijakan-privasi')->first();
        return view('shop.pages.privacy', [
            'title' => 'Kebijakan Privasi — Klik.Cake',
            'page' => $page,
        ]);
    }

    public function terms(): View
    {
        $page = Page::published()->where('slug', 'syarat-ketentuan')->first();
        return view('shop.pages.terms', [
            'title' => 'Syarat & Ketentuan — Klik.Cake',
            'page' => $page,
        ]);
    }

    public function howToOrder(): View
    {
        $page = Page::published()->where('slug', 'cara-pesan')->first();
        return view('shop.pages.how-to-order', [
            'title' => 'Cara Pesan — Klik.Cake',
            'page' => $page,
        ]);
    }

    public function faq(): View
    {
        $page = Page::published()->where('slug', 'faq')->first();
        return view('shop.pages.faq', [
            'title' => 'FAQ — Klik.Cake',
            'page' => $page,
        ]);
    }

    /**
     * Show custom dynamic page created in Filament Admin
     */
    public function show(string $slug): View
    {
        // Special routes fallback
        if ($slug === 'tentang-kami') return $this->about();
        if ($slug === 'cara-pesan') return $this->howToOrder();
        if ($slug === 'faq') return $this->faq();
        if ($slug === 'syarat-ketentuan') return $this->terms();
        if ($slug === 'kebijakan-privasi') return $this->privacy();

        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('shop.pages.dynamic', [
            'title' => $page->title . ' — Klik.Cake',
            'page' => $page,
        ]);
    }
}
