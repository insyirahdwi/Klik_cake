<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Klik.Cake by Pinky Cake & Bakery — Pre-order Roti & Kue Segar Makassar' }}</title>
    <meta name="description" content="Pesan roti & kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Klik, dipanggang, sampai.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Nunito:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $announcementEnabled = (bool) \App\Models\WebSetting::get('announcement_enabled', '1');
    $announcementText = \App\Models\WebSetting::get('announcement_text', '✨ Fresh Bake Setiap Hari — Pesan Hari Ini untuk Pengiriman Esok Hari di Area Makassar!');
    $waNumber = \App\Models\WebSetting::get('contact_whatsapp', config('shop.wa_number', '6281234567890'));
    $siteName = \App\Models\WebSetting::get('site_name', 'Klik.Cake');
    $waMessage = rawurlencode('Halo ' . $siteName . ', saya ingin bertanya tentang pesanan roti dan kue.');
    $waUrl = "https://wa.me/{$waNumber}?text={$waMessage}";
    $siteTagline = \App\Models\WebSetting::get('site_tagline', 'by Pinky Cake & Bakery Makassar');
    $kitchenAddress = \App\Models\WebSetting::get('kitchen_address', "Jl. Boulevard / Panakkukang\nMakassar, Sulawesi Selatan");
    $operatingHours = \App\Models\WebSetting::get('operating_hours', 'Buka setiap hari: 08.00 – 20.00 WITA');
    $socialNetworks = \App\Models\Networking::social()->get();
    $footerPages = \App\Models\Page::published()->where('show_in_footer', true)->orderBy('sort_order')->get();
@endphp

<body class="bg-cream text-cocoa font-sans min-h-full flex flex-col selection:bg-blush selection:text-strawberry-deep overflow-x-hidden">

    {{-- Top Announcement Bar (from Web Settings) --}}
    @if($announcementEnabled && filled($announcementText))
        <aside class="bg-strawberry-deep text-white text-[11px] sm:text-xs font-bold py-2 px-4 text-center tracking-wide shadow-sm flex items-center justify-center gap-2">
            <span>{{ $announcementText }}</span>
        </aside>
    @endif

    {{-- Top Desktop & Mobile Header (Screen 01–07) --}}
    <header class="sticky top-0 z-30 bg-cream/95 backdrop-blur-md border-b border-blush transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-strawberry-deep to-strawberry text-white flex items-center justify-center font-serif font-black text-lg shadow-sm transform group-hover:rotate-6 transition-transform">
                    K
                </span>
                <div class="flex flex-col">
                    <span class="font-serif font-black text-2xl md:text-3xl text-strawberry-deep tracking-tight group-hover:opacity-90 transition-opacity leading-none">
                        {{ $siteName }}
                    </span>
                    <span class="hidden sm:inline-block text-[10px] font-extrabold text-cocoa-muted tracking-wider uppercase mt-1">
                        {{ $siteTagline }}
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation Links --}}
            <nav class="hidden lg:flex items-center gap-1.5 font-bold text-sm text-cocoa bg-white/80 px-4 py-2 rounded-full border border-blush shadow-sm">
                <a href="{{ route('catalog.index') }}" class="px-3.5 py-1.5 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all {{ request()->routeIs('catalog.*') ? 'text-strawberry-deep bg-blush font-black' : '' }}">
                    Menu
                </a>
                <a href="{{ route('home') }}#fresh-bake" class="px-3.5 py-1.5 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all flex items-center gap-1.5">
                    <span>Fresh Bake</span>
                    <span class="w-2 h-2 rounded-full bg-butter animate-pulse"></span>
                </a>
                <a href="{{ route('article.index') }}" class="px-3.5 py-1.5 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all {{ request()->routeIs('article.*') ? 'text-strawberry-deep bg-blush font-black' : '' }}">
                    Artikel
                </a>
                <a href="{{ route('networking.index') }}" class="px-3.5 py-1.5 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all {{ request()->routeIs('networking.*') ? 'text-strawberry-deep bg-blush font-black' : '' }}">
                    Jaringan &amp; Cabang
                </a>
                <a href="{{ route('home') }}#lacak" class="px-3.5 py-1.5 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all">
                    Lacak
                </a>
            </nav>

            {{-- Header Actions: Contact + User Menu & Cart Button --}}
            @php
                $cartCount = session('cart_count', 0);
            @endphp
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Contact WhatsApp (as seen in reference header) --}}
                <a href="{{ $waUrl }}" target="_blank" class="hidden xl:inline-flex items-center gap-2 text-xs font-bold text-cocoa hover:text-strawberry-deep transition-colors px-3 py-1.5 rounded-full hover:bg-blush/30">
                    <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                        </svg>
                    </span>
                    <span>{{ $waNumber }}</span>
                </a>

                {{-- User Login / Account Dropdown --}}
                @guest
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-cocoa hover:text-strawberry-deep px-3.5 py-2 rounded-full border border-blush hover:border-strawberry-deep/30 bg-white shadow-sm transition-all"
                    >
                        <svg class="w-4 h-4 text-cocoa-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Masuk</span>
                    </a>
                @else
                    <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                        <button
                            type="button"
                            @click="userMenuOpen = !userMenuOpen"
                            class="inline-flex items-center gap-2 text-xs font-bold text-cocoa hover:text-strawberry-deep pl-1.5 pr-3 py-1.5 rounded-full border border-blush bg-white shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-strawberry-deep cursor-pointer"
                        >
                            <span class="w-6 h-6 rounded-full bg-blush text-strawberry-deep font-black text-xs flex items-center justify-center uppercase">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                            <span class="max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <span class="px-1.5 py-0.5 rounded-full bg-butter text-[9px] font-black text-cocoa">Admin</span>
                            @endif
                            <svg class="w-3.5 h-3.5 text-cocoa-muted transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div
                            x-show="userMenuOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 rounded-2xl bg-white shadow-xl border border-blush py-2 z-50 text-left"
                        >
                            <div class="px-4 py-2 border-b border-blush/60">
                                <p class="text-xs font-bold text-cocoa truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-cocoa-muted truncate">{{ auth()->user()->email }}</p>
                            </div>

                            @if(auth()->user()->isAdmin())
                                <a
                                    href="{{ url('/admin') }}"
                                    class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-bold text-strawberry-deep hover:bg-blush/40 transition-colors"
                                >
                                    <svg class="w-4 h-4 text-strawberry-deep" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Panel Admin</span>
                                </a>
                                <div class="border-t border-blush/60 my-1"></div>
                            @endif

                            <a
                                href="{{ route('account.dashboard') }}"
                                class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-cocoa hover:bg-cream transition-colors"
                            >
                                <svg class="w-4 h-4 text-cocoa-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Akun Saya &amp; Pesanan</span>
                            </a>

                            <div class="border-t border-blush/60 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors cursor-pointer"
                                >
                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                {{-- Cart Button --}}
                <a href="#keranjang" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-white border border-blush hover:border-strawberry-deep text-cocoa hover:text-strawberry-deep text-xs font-bold shadow-sm transition-all">
                    <div class="relative">
                        <svg class="w-4 h-4 text-strawberry-deep" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-2 bg-strawberry-deep text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>
                    <span class="hidden sm:inline">Keranjang</span>
                </a>

                {{-- Quick Primary CTA "Pesan Sekarang" --}}
                <a href="{{ route('catalog.index') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 sm:px-5 py-2 rounded-full bg-strawberry-deep text-white text-xs font-extrabold shadow-pill hover:bg-strawberry transition-all transform hover:-translate-y-0.5">
                    <span>Pesan Sekarang</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>
    {{-- Flash Notifications --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-blush border-b border-blush-dark px-4 py-3 text-center text-sm font-bold text-strawberry-deep transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-strawberry-deep flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 text-cocoa-muted hover:text-cocoa">&times;</button>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1 pb-24 md:pb-12">
        {{ $slot }}
    </main>

    {{-- Floating WhatsApp Customer Support Button --}}
    @php
        $waMessage = rawurlencode('Halo ' . $siteName . ', saya ingin bertanya tentang pesanan roti dan kue.');
        $waUrl = "https://wa.me/{$waNumber}?text={$waMessage}";
    @endphp
    <aside class="fixed bottom-20 md:bottom-8 right-5 z-40">
        <a
            href="{{ $waUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center justify-center w-13 h-13 md:w-14 md:h-14 rounded-full bg-[#25D366] text-white shadow-lg hover:scale-110 active:scale-95 transition-all duration-200 group focus:outline-none focus:ring-4 focus:ring-[#25D366]/40"
            aria-label="Chat WhatsApp CS"
            title="Chat WhatsApp {{ $siteName }}"
        >
            <span class="font-extrabold text-sm md:text-base tracking-tighter">WA</span>
        </a>
    </aside>

    {{-- Mobile Bottom Bar Navigation (Screen 01–07) --}}
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 bg-white/95 backdrop-blur-md border-t border-blush shadow-lg px-4 py-2 flex items-center justify-around">
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1 {{ request()->routeIs('home') ? 'text-strawberry-deep font-black' : '' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>

        <a href="{{ route('catalog.index') }}" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1 {{ request()->routeIs('catalog.*') ? 'text-strawberry-deep font-black' : '' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
            </svg>
            <span class="text-[10px] font-bold">Menu</span>
        </a>

        <a href="{{ route('article.index') }}" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1 {{ request()->routeIs('article.*') ? 'text-strawberry-deep font-black' : '' }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <span class="text-[10px] font-bold">Artikel</span>
        </a>

        <a href="{{ route('home') }}#lacak" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span class="text-[10px] font-bold">Lacak</span>
        </a>

        <a href="#keranjang" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1 relative">
            <div class="relative">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span class="absolute -top-1 -right-2 bg-strawberry-deep text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center">
                    {{ $cartCount }}
                </span>
            </div>
            <span class="text-[10px] font-bold">Keranjang</span>
        </a>

        @guest
            <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1 {{ request()->routeIs('login') ? 'text-strawberry-deep font-black' : '' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-[10px] font-bold">Masuk</span>
            </a>
        @else
            <a href="{{ route('account.dashboard') }}" class="flex flex-col items-center gap-1 text-cocoa hover:text-strawberry-deep transition-colors py-1 {{ request()->routeIs('account.*') ? 'text-strawberry-deep font-black' : '' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-[10px] font-bold">Akun</span>
            </a>
        @endguest
    </nav>

    {{-- Footer & Kontak (Screen 01 Footer) --}}
    <footer class="bg-blush/40 border-t border-blush text-cocoa py-12 px-4 sm:px-6 lg:px-8 mt-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-1 space-y-3">
                <span class="font-serif font-black text-2xl text-strawberry-deep tracking-tight">
                    {{ $siteName }}
                </span>
                <span class="text-xs font-bold text-cocoa-muted tracking-wider uppercase block">
                    {{ $siteTagline }}
                </span>
                <p class="font-sans text-xs text-cocoa-muted leading-relaxed">
                    Pesan roti &amp; kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Dibuat langsung di dapur kami dengan mentega berkualitas dan bahan pilihan.
                </p>
                <div class="pt-2">
                    <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-[#25D366] bg-white px-3 py-1.5 rounded-full border border-blush shadow-sm hover:scale-105 transition-transform">
                        <span>WhatsApp CS: +{{ $waNumber }}</span>
                    </a>
                </div>

                {{-- Social Media Icons / Links --}}
                @if($socialNetworks->isNotEmpty())
                    <div class="pt-2 flex items-center gap-2 flex-wrap">
                        @foreach($socialNetworks as $sn)
                            <a
                                href="{{ $sn->url ?? '#' }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                title="{{ $sn->name }}"
                                class="w-8 h-8 rounded-full bg-white border border-blush hover:border-strawberry-deep text-strawberry-deep text-xs font-black flex items-center justify-center hover:scale-110 transition-transform shadow-sm"
                            >
                                {{ strtoupper(substr($sn->platform ?? $sn->name, 0, 2)) }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <h4 class="font-serif font-bold text-base text-cocoa mb-3">Menu Koleksi</h4>
                <ul class="space-y-2 text-sm text-cocoa-muted font-medium">
                    <li><a href="{{ route('catalog.category', 'cake') }}" class="hover:text-strawberry-deep transition-colors">Cake &amp; Tart Ulang Tahun</a></li>
                    <li><a href="{{ route('catalog.category', 'roti') }}" class="hover:text-strawberry-deep transition-colors">Roti Manis &amp; Gurih</a></li>
                    <li><a href="{{ route('catalog.category', 'pastry') }}" class="hover:text-strawberry-deep transition-colors">Croissant &amp; Pastry</a></li>
                    <li><a href="{{ route('catalog.category', 'snackbox') }}" class="hover:text-strawberry-deep transition-colors">Snackbox Acara &amp; Kantor</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-serif font-bold text-base text-cocoa mb-3">Informasi &amp; Jejaring</h4>
                <ul class="space-y-2 text-sm text-cocoa-muted font-medium">
                    <li><a href="{{ route('article.index') }}" class="hover:text-strawberry-deep transition-colors">Artikel &amp; Resep Dapur</a></li>
                    <li><a href="{{ route('networking.index') }}" class="hover:text-strawberry-deep transition-colors">Cabang Dapur &amp; Mitra Reseller</a></li>
                    @foreach($footerPages as $fPage)
                        <li>
                            <a href="{{ url('/' . $fPage->slug) }}" class="hover:text-strawberry-deep transition-colors">
                                {{ $fPage->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="font-serif font-bold text-base text-cocoa mb-3">Dapur Makassar</h4>
                <p class="text-sm text-cocoa-muted leading-relaxed whitespace-pre-line">
                    {{ $kitchenAddress }}
                </p>
                <p class="text-xs text-cocoa-muted mt-2 font-bold">
                    {{ $operatingHours }}
                </p>
                <p class="text-xs text-cocoa-muted/80 mt-4">
                    &copy; {{ date('Y') }} {{ $siteName }} by Pinky Cake. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
