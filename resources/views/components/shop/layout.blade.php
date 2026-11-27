<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Klik.Cake by Pinky Cake & Bakery — Pre-order Roti & Kue Segar Makassar' }}</title>
    <meta name="description" content="Pesan roti & kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Klik, dipanggang, sampai.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Nunito:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..700&family=Nunito:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet"></noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
@php
    // Batch load all settings in ONE query instead of 7 individual queries
    $settings = \App\Models\WebSetting::getMany([
        'announcement_enabled',
        'announcement_text',
        'contact_whatsapp',
        'site_name',
        'site_tagline',
        'kitchen_address',
        'operating_hours',
    ], [
        'announcement_enabled' => '1',
        'announcement_text' => '✨ Fresh Bake Setiap Hari — Pesan Hari Ini untuk Pengiriman Esok Hari di Area Makassar!',
        'contact_whatsapp' => config('shop.wa_number', '6281234567890'),
        'site_name' => 'Klik.Cake',
        'site_tagline' => 'by Pinky Cake & Bakery Makassar',
        'kitchen_address' => "Jl. Boulevard / Panakkukang\nMakassar, Sulawesi Selatan",
        'operating_hours' => 'Buka setiap hari: 08.00 – 20.00 WITA',
    ]);

    $announcementEnabled = (bool) $settings['announcement_enabled'];
    $announcementText = $settings['announcement_text'];
    $waNumber = $settings['contact_whatsapp'];
    $siteName = $settings['site_name'];
    $siteTagline = $settings['site_tagline'];
    $kitchenAddress = $settings['kitchen_address'];
    $operatingHours = $settings['operating_hours'];
    $waMessage = rawurlencode('Halo ' . $siteName . ', saya ingin bertanya tentang pesanan roti dan kue.');
    $waUrl = "https://wa.me/{$waNumber}?text={$waMessage}";
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

    {{-- Top Desktop & Mobile Header --}}
    <header class="sticky top-0 z-30 bg-cream/95 backdrop-blur-md border-b border-blush/60 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2.5 group shrink-0">
                <img src="{{ asset('images/logo-pinky-cake.png') }}" alt="Pinky Cake & Bakery" class="h-9 sm:h-10 w-auto object-contain transform group-hover:scale-105 transition-transform duration-200" />
                <div class="flex flex-col">
                    <span class="font-serif font-black text-lg sm:text-xl text-strawberry-deep tracking-tight leading-none">
                        {{ $siteName }}
                    </span>
                    <span class="hidden sm:inline-block text-[8px] font-extrabold text-cocoa-muted tracking-widest uppercase leading-none mt-0.5">
                        {{ $siteTagline }}
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation Links --}}
            <nav class="hidden lg:flex items-center gap-0.5 font-semibold text-[13px] text-cocoa bg-white/70 px-3 py-1.5 rounded-full border border-blush/50 shadow-sm">
                <a href="{{ route('catalog.index') }}" wire:navigate class="px-3 py-1 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all {{ request()->routeIs('catalog.*') ? 'text-strawberry-deep bg-blush font-bold' : '' }}">
                    Menu
                </a>
                <a href="{{ route('home') }}#fresh-bake" class="px-3 py-1 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all flex items-center gap-1.5">
                    <span>Fresh Bake</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-butter animate-pulse"></span>
                </a>
                <a href="{{ route('article.index') }}" wire:navigate class="px-3 py-1 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all {{ request()->routeIs('article.*') ? 'text-strawberry-deep bg-blush font-bold' : '' }}">
                    Artikel
                </a>
                <a href="{{ route('networking.index') }}" wire:navigate class="px-3 py-1 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all {{ request()->routeIs('networking.*') ? 'text-strawberry-deep bg-blush font-bold' : '' }}">
                    Jaringan
                </a>
                <a href="{{ route('home') }}#lacak" class="px-3 py-1 rounded-full hover:text-strawberry-deep hover:bg-blush/40 transition-all">
                    Lacak
                </a>
            </nav>

            {{-- Header Actions --}}
            @php
                $cartCount = session('cart_count', 0);
            @endphp
            <div class="flex items-center gap-1.5 sm:gap-2">
                {{-- User Login / Account --}}
                @guest
                    <a href="{{ route('login') }}" wire:navigate
                       class="inline-flex items-center gap-1.5 text-[11px] font-bold text-cocoa hover:text-strawberry-deep px-3 py-1.5 rounded-full border border-blush/60 hover:border-strawberry-deep/30 bg-white shadow-sm transition-all">
                        <svg class="w-3.5 h-3.5 text-cocoa-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Masuk</span>
                    </a>
                @else
                    <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
                        <button type="button" @click="userMenuOpen = !userMenuOpen"
                                class="inline-flex items-center gap-1.5 text-[11px] font-bold text-cocoa hover:text-strawberry-deep pl-1 pr-2.5 py-1 rounded-full border border-blush/60 bg-white shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-strawberry-deep/30 cursor-pointer">
                            <span class="w-5 h-5 rounded-full bg-gradient-to-br from-strawberry-deep to-strawberry text-white font-black text-[10px] flex items-center justify-center uppercase">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </span>
                            <span class="max-w-[80px] truncate hidden sm:inline">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->isAdmin())
                                <span class="px-1 py-px rounded bg-butter text-[8px] font-black text-cocoa leading-none">Admin</span>
                            @endif
                            <svg class="w-3 h-3 text-cocoa-muted transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="userMenuOpen" x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-52 rounded-xl bg-white shadow-xl border border-blush/60 py-1.5 z-50 text-left">
                            <div class="px-3.5 py-2 border-b border-blush/40">
                                <p class="text-[11px] font-bold text-cocoa truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-cocoa-muted truncate">{{ auth()->user()->email }}</p>
                            </div>

                            @if(auth()->user()->isAdmin())
                                <a href="{{ url('/admin') }}" class="flex items-center gap-2 px-3.5 py-2 text-[11px] font-bold text-strawberry-deep hover:bg-blush/30 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Panel Admin</span>
                                </a>
                                <div class="border-t border-blush/40 my-0.5"></div>
                            @endif

                            <a href="{{ route('account.dashboard') }}" wire:navigate class="flex items-center gap-2 px-3.5 py-2 text-[11px] font-semibold text-cocoa hover:bg-cream transition-colors">
                                <svg class="w-3.5 h-3.5 text-cocoa-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span>Akun Saya &amp; Pesanan</span>
                            </a>

                            <div class="border-t border-blush/40 my-0.5"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-3.5 py-2 text-[11px] font-semibold text-red-500 hover:bg-red-50 transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                {{-- Cart Button --}}
                <a href="#keranjang" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-white border border-blush/60 hover:border-strawberry-deep/30 text-cocoa hover:text-strawberry-deep text-[11px] font-bold shadow-sm transition-all">
                    <div class="relative">
                        <svg class="w-3.5 h-3.5 text-strawberry-deep" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-2 bg-strawberry-deep text-white text-[8px] font-black w-3.5 h-3.5 rounded-full flex items-center justify-center ring-2 ring-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </div>
                    <span class="hidden sm:inline">Keranjang</span>
                </a>

                {{-- Primary CTA --}}
                <a href="{{ route('catalog.index') }}" wire:navigate class="hidden sm:inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-strawberry-deep text-white text-[11px] font-extrabold shadow-pill hover:bg-strawberry-hover transition-all hover:-translate-y-px">
                    <span>Pesan Sekarang</span>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
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

    {{-- Mobile Bottom Bar Navigation --}}
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 bg-white/95 backdrop-blur-md border-t border-blush/50 shadow-[0_-2px_12px_rgba(0,0,0,0.06)] px-2 pb-[env(safe-area-inset-bottom)] flex items-center justify-around">
        {{-- Beranda --}}
        <a href="{{ route('home') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-2 px-3 transition-colors {{ request()->routeIs('home') ? 'text-strawberry-deep' : 'text-cocoa-muted hover:text-cocoa' }}">
            @if(request()->routeIs('home'))
                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"/><path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z"/></svg>
            @else
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            @endif
            <span class="text-[9px] font-bold leading-none">Beranda</span>
        </a>

        {{-- Menu --}}
        <a href="{{ route('catalog.index') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-2 px-3 transition-colors {{ request()->routeIs('catalog.*') ? 'text-strawberry-deep' : 'text-cocoa-muted hover:text-cocoa' }}">
            @if(request()->routeIs('catalog.*'))
                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75z" clip-rule="evenodd"/></svg>
            @else
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h7.5"/></svg>
            @endif
            <span class="text-[9px] font-bold leading-none">Menu</span>
        </a>

        {{-- Artikel --}}
        <a href="{{ route('article.index') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-2 px-3 transition-colors {{ request()->routeIs('article.*') ? 'text-strawberry-deep' : 'text-cocoa-muted hover:text-cocoa' }}">
            @if(request()->routeIs('article.*'))
                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a2.25 2.25 0 00-2.25 2.25v1.5a2.25 2.25 0 002.25 2.25h3a2.25 2.25 0 002.25-2.25V9A2.25 2.25 0 009 6.75H6z" clip-rule="evenodd"/><path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z"/></svg>
            @else
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            @endif
            <span class="text-[9px] font-bold leading-none">Artikel</span>
        </a>

        {{-- Lacak --}}
        <a href="{{ route('home') }}#lacak" class="flex flex-col items-center gap-0.5 py-2 px-3 text-cocoa-muted hover:text-cocoa transition-colors">
            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
            <span class="text-[9px] font-bold leading-none">Lacak</span>
        </a>

        {{-- Keranjang --}}
        <a href="#keranjang" class="flex flex-col items-center gap-0.5 py-2 px-3 text-cocoa-muted hover:text-cocoa transition-colors relative">
            <div class="relative">
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/></svg>
                @if($cartCount > 0)
                    <span class="absolute -top-1 -right-1.5 bg-strawberry-deep text-white text-[7px] font-black w-3.5 h-3.5 rounded-full flex items-center justify-center ring-1.5 ring-white">{{ $cartCount }}</span>
                @endif
            </div>
            <span class="text-[9px] font-bold leading-none">Keranjang</span>
        </a>

        {{-- Akun / Masuk --}}
        @guest
            <a href="{{ route('login') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-2 px-3 transition-colors {{ request()->routeIs('login') ? 'text-strawberry-deep' : 'text-cocoa-muted hover:text-cocoa' }}">
                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <span class="text-[9px] font-bold leading-none">Masuk</span>
            </a>
        @else
            <a href="{{ route('account.dashboard') }}" wire:navigate class="flex flex-col items-center gap-0.5 py-2 px-3 transition-colors {{ request()->routeIs('account.*') ? 'text-strawberry-deep' : 'text-cocoa-muted hover:text-cocoa' }}">
                @if(request()->routeIs('account.*'))
                    <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"/></svg>
                @else
                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                @endif
                <span class="text-[9px] font-bold leading-none">Akun</span>
            </a>
        @endguest
    </nav>

    {{-- Footer & Kontak (Screen 01 Footer) --}}
    <footer class="bg-blush/40 border-t border-blush text-cocoa py-12 px-4 sm:px-6 lg:px-8 mt-12">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-1 space-y-3">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo-pinky-cake.png') }}" alt="Pinky Cake & Bakery" class="h-10 w-auto object-contain" />
                    <div>
                        <span class="font-serif font-black text-xl text-strawberry-deep tracking-tight block">
                            {{ $siteName }}
                        </span>
                        <span class="text-[9px] font-bold text-cocoa-muted tracking-wider uppercase block">
                            {{ $siteTagline }}
                        </span>
                    </div>
                </div>
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
                    <li><a href="{{ route('catalog.category', 'cake') }}" wire:navigate class="hover:text-strawberry-deep transition-colors">Cake &amp; Tart Ulang Tahun</a></li>
                    <li><a href="{{ route('catalog.category', 'roti') }}" wire:navigate class="hover:text-strawberry-deep transition-colors">Roti Manis &amp; Gurih</a></li>
                    <li><a href="{{ route('catalog.category', 'pastry') }}" wire:navigate class="hover:text-strawberry-deep transition-colors">Croissant &amp; Pastry</a></li>
                    <li><a href="{{ route('catalog.category', 'snackbox') }}" wire:navigate class="hover:text-strawberry-deep transition-colors">Snackbox Acara &amp; Kantor</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-serif font-bold text-base text-cocoa mb-3">Informasi &amp; Jejaring</h4>
                <ul class="space-y-2 text-sm text-cocoa-muted font-medium">
                    <li><a href="{{ route('article.index') }}" wire:navigate class="hover:text-strawberry-deep transition-colors">Artikel &amp; Resep Dapur</a></li>
                    <li><a href="{{ route('networking.index') }}" wire:navigate class="hover:text-strawberry-deep transition-colors">Cabang Dapur &amp; Mitra Reseller</a></li>
                    @foreach($footerPages as $fPage)
                        <li>
                            <a href="{{ url('/' . $fPage->slug) }}" wire:navigate class="hover:text-strawberry-deep transition-colors">
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

    @livewireScriptConfig
    @stack('scripts')

    {{-- Livewire Navigate Loading Indicator --}}
    <style>
        [x-cloak] { display: none !important; }
        .navigate-loading-bar {
            position: fixed; top: 0; left: 0; right: 0; height: 3px; z-index: 9999;
            background: linear-gradient(90deg, #E91E72, #FF6B9D, #E91E72);
            background-size: 200% 100%;
            animation: loading-shimmer 1s linear infinite;
            transition: opacity 0.2s;
        }
        @keyframes loading-shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
    <div x-data="{ loading: false }"
         x-on:livewire:navigate-start.window="loading = true"
         x-on:livewire:navigate-end.window="loading = false">
        <div x-show="loading" x-cloak class="navigate-loading-bar"></div>
    </div>
</body>
</html>
