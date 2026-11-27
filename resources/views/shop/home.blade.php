<x-shop.layout>
    {{-- ═══════════════════════════════════════════════════════════════════
         1. HERO SECTION — Full-bleed Asymmetric Split Screen
         Inspired by reference design: bold left headline + right product panel
    ═══════════════════════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden bg-cream" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
        {{-- Subtle grain texture overlay --}}
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E');"></div>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[85vh] lg:min-h-[640px]">

                {{-- LEFT — Editorial Typography & CTAs --}}
                <div class="lg:col-span-7 flex flex-col justify-center px-6 sm:px-10 lg:px-16 py-12 lg:py-20 relative z-10">
                    {{-- Decorative floating dots --}}
                    <div class="absolute top-12 left-8 w-3 h-3 rounded-full bg-butter/60 animate-float hidden lg:block"></div>
                    <div class="absolute bottom-24 left-20 w-2 h-2 rounded-full bg-strawberry-light animate-float delay-300 hidden lg:block"></div>

                    <div class="space-y-6" x-show="loaded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0">
                        {{-- Badge --}}
                        <div>
                            <span class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white border border-blush-dark/40 shadow-sm text-xs font-extrabold uppercase tracking-[0.15em] text-cocoa">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-strawberry-deep opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-strawberry-deep"></span>
                                </span>
                                {{ $heroSection->badge_text ?? 'Fresh Bake Hari Ini · Makassar' }}
                            </span>
                        </div>

                        {{-- Display Headline --}}
                        <h1 class="font-serif font-black text-[2.75rem] sm:text-6xl lg:text-[4.25rem] text-cocoa leading-[1.05] tracking-tight">
                            Klik,
                            <span class="relative inline-block">
                                <span class="text-strawberry-deep italic">dipanggang</span>
                                <svg class="absolute -bottom-1 left-0 w-full h-3 text-butter/70" viewBox="0 0 200 12" preserveAspectRatio="none"><path d="M0 8 Q50 0 100 6 Q150 12 200 4" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
                            </span>,<br class="hidden sm:inline">
                            sampai.
                        </h1>

                        {{-- Subtitle --}}
                        <p class="text-base sm:text-lg text-cocoa-muted max-w-lg leading-relaxed font-medium">
                            {{ $heroSection->subtitle ?? 'Pesan roti & kue segar dari Makassar. Pilih jadwal panggang harian, bayar praktis, pantau sampai tiba di tangan.' }}
                        </p>

                        {{-- Dual CTAs --}}
                        <div class="flex flex-wrap items-center gap-4 pt-1">
                            <a href="{{ $heroSection->button_link ?? route('catalog.index') }}"
                               class="group inline-flex items-center gap-3 px-8 py-4 rounded-full bg-strawberry-deep text-white font-extrabold text-sm sm:text-base shadow-pill hover:bg-strawberry-hover hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                                <span>{{ $heroSection->button_text ?? 'Pesan Sekarang' }}</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                            <a href="{{ $heroSection->secondary_button_link ?? '#menu-favorit' }}"
                               class="inline-flex items-center gap-2 px-6 py-4 rounded-full bg-white border-2 border-blush-dark/50 hover:border-strawberry-deep text-cocoa hover:text-strawberry-deep font-bold text-sm transition-all">
                                {{ $heroSection->secondary_button_text ?? 'Lihat Menu' }}
                            </a>
                        </div>

                        {{-- Trust Indicators --}}
                        <div class="pt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs font-bold text-cocoa-muted">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center"><span class="text-emerald-600 text-sm">🌿</span></div>
                                <span>Bahan Alami 100%</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-butter-light flex items-center justify-center"><span class="text-sm">⏰</span></div>
                                <span>3 Slot Harian</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-blush flex items-center justify-center"><span class="text-sm">🚚</span></div>
                                <span>Kirim Makassar</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT — Raspberry/Maroon Product Showcase Panel --}}
                <div class="lg:col-span-5 relative bg-gradient-to-br from-[#C72D5A] via-[#A91D45] to-[#6D1130] overflow-hidden flex flex-col justify-center items-center p-8 sm:p-10 lg:p-12"
                     x-show="loaded" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                    {{-- Giant Watermark --}}
                    <div class="absolute -right-6 top-1/2 -translate-y-1/2 select-none pointer-events-none opacity-[0.06] font-serif font-black text-[8rem] sm:text-[10rem] tracking-widest rotate-90 origin-center whitespace-nowrap text-white">CAKE</div>

                    {{-- Decorative ring --}}
                    <div class="absolute top-8 left-8 w-24 h-24 rounded-full border border-white/10 hidden lg:block"></div>
                    <div class="absolute bottom-12 right-10 w-16 h-16 rounded-full border border-white/10 hidden lg:block"></div>

                    {{-- Featured Tag --}}
                    <div class="absolute top-6 left-6 right-6 flex items-center justify-between z-20">
                        <span class="px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-md text-[10px] uppercase tracking-[0.2em] font-extrabold text-white/90 border border-white/20">
                            ★ Unggulan
                        </span>
                        <span class="text-[10px] font-mono font-bold text-butter tracking-wider">Fresh Baked</span>
                    </div>

                    {{-- Price Badge Sticker --}}
                    <div class="absolute top-16 right-8 z-30 animate-gentle-rotate">
                        <div class="w-[4.5rem] h-[4.5rem] sm:w-20 sm:h-20 rounded-full bg-butter text-cocoa flex flex-col items-center justify-center shadow-xl border-[3px] border-white transform rotate-12">
                            <span class="text-[8px] font-extrabold uppercase tracking-tight leading-none opacity-80">Mulai</span>
                            <span class="font-serif font-black text-[11px] sm:text-xs leading-tight">{{ $heroProduct->formattedPrice() ?? 'Rp185rb' }}</span>
                        </div>
                    </div>

                    {{-- Floating Cake Image --}}
                    <div class="relative w-56 h-56 sm:w-64 sm:h-64 lg:w-72 lg:h-72 my-6 animate-float">
                        {{-- Soft glow behind --}}
                        <div class="absolute inset-4 rounded-full bg-white/10 blur-2xl"></div>
                        {{-- Outer ring --}}
                        <div class="absolute inset-0 rounded-full border-2 border-white/15"></div>
                        {{-- Image --}}
                        <div class="relative z-10 w-full h-full rounded-full overflow-hidden border-4 border-white shadow-2xl bg-white">
                            <img
                                src="{{ asset($heroSection?->image_url ?? 'products/hero-makassar.jpg') }}"
                                alt="{{ $heroProduct->name ?? 'Strawberry Cream Cake' }}"
                                class="w-full h-full object-cover"
                                loading="eager"
                                fetchpriority="high"
                            />
                        </div>
                    </div>

                    {{-- Product Info Card --}}
                    <div class="relative z-10 w-full max-w-xs bg-white/[0.12] backdrop-blur-xl rounded-2xl p-5 border border-white/20 text-white mt-2">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-serif font-black text-lg sm:text-xl leading-tight">{{ $heroProduct->name ?? 'Strawberry Cream Cake' }}</h3>
                                <p class="text-[11px] text-white/70 mt-1">{{ $heroProduct->portion_info ?? 'Porsi 6–8 orang · Minimal H-1' }}</p>
                            </div>
                            <span class="font-serif font-black text-lg text-butter shrink-0">{{ $heroProduct->formattedPrice() ?? 'Rp185.000' }}</span>
                        </div>
                        <div class="mt-3 pt-3 border-t border-white/15 flex items-center justify-between">
                            <span class="text-[10px] text-white/60 font-medium">Tanpa Pengawet · Bahan Alami</span>
                            <a href="{{ route('product.show', $heroProduct->slug) }}"
                               class="group inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white text-strawberry-deep font-extrabold text-xs shadow-md hover:bg-butter hover:text-cocoa transition-all">
                                <span>Pesan</span>
                                <svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════
         2. MARQUEE TRUST BAR — Infinite scrolling social proof
    ═══════════════════════════════════════════════════════════════════ --}}
    <div class="bg-cocoa text-white py-3 overflow-hidden relative">
        <div class="flex animate-marquee whitespace-nowrap">
            @for($i = 0; $i < 3; $i++)
            <span class="mx-8 text-xs font-bold tracking-wider uppercase flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-butter"></span> Dipanggang Segar Setiap Hari
            </span>
            <span class="mx-8 text-xs font-bold tracking-wider uppercase flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-strawberry"></span> 100% Bahan Alami
            </span>
            <span class="mx-8 text-xs font-bold tracking-wider uppercase flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-butter"></span> Pengiriman Makassar
            </span>
            <span class="mx-8 text-xs font-bold tracking-wider uppercase flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-strawberry"></span> 3 Slot Pemanggangan
            </span>
            <span class="mx-8 text-xs font-bold tracking-wider uppercase flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-butter"></span> Pembayaran Instan
            </span>
            @endfor
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 space-y-20 sm:space-y-28">

        {{-- ═══════════════════════════════════════════════════════════════
             3. CATEGORY NAVIGATION — Pill-shaped category quick links
        ═══════════════════════════════════════════════════════════════ --}}
        <section id="kategori" class="pt-16 sm:pt-20" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-[0.2em] text-strawberry-deep">Eksplorasi Rasa</span>
                    <h2 class="font-serif font-black text-3xl sm:text-4xl text-cocoa mt-1 tracking-tight">Kategori Menu</h2>
                </div>
                <a href="{{ route('catalog.index') }}" class="group hidden sm:flex items-center gap-2 text-sm font-bold text-strawberry-deep hover:underline underline-offset-4">
                    <span>Semua Menu</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($categories as $i => $cat)
                    <a href="{{ route('catalog.category', $cat->slug) }}"
                       class="group relative flex flex-col items-center justify-center gap-3 p-6 sm:p-8 rounded-3xl bg-white border-2 border-transparent hover:border-strawberry-deep/30 text-cocoa hover:text-strawberry-deep font-bold text-sm sm:text-base transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl overflow-hidden"
                       style="animation-delay: {{ $i * 100 }}ms">
                        {{-- Soft bg glow on hover --}}
                        <div class="absolute inset-0 bg-gradient-to-b from-blush-light to-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl"></div>

                        <span class="relative z-10 w-14 h-14 rounded-2xl bg-blush group-hover:bg-strawberry-deep group-hover:text-white text-2xl flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-pill group-hover:scale-110">
                            @if(str_contains(strtolower($cat->slug), 'cake')) 🎂
                            @elseif(str_contains(strtolower($cat->slug), 'roti')) 🍞
                            @elseif(str_contains(strtolower($cat->slug), 'pastry')) 🥐
                            @else 📦
                            @endif
                        </span>
                        <span class="relative z-10 font-bold">{{ $cat->name }}</span>
                        <span class="relative z-10 text-[10px] font-semibold text-cocoa-muted group-hover:text-strawberry-deep/70 uppercase tracking-wider">Lihat Koleksi →</span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             4. PRODUCT SHOWCASE — Staggered editorial card grid
        ═══════════════════════════════════════════════════════════════ --}}
        <section id="menu-favorit" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blush text-strawberry-deep text-xs font-extrabold uppercase tracking-[0.15em]">
                    <span>✦</span> Pilihan Terlaris
                </span>
                <h2 class="font-serif font-black text-3xl sm:text-[2.75rem] text-cocoa tracking-tight mt-3 leading-tight">
                    Menu Favorit Pelanggan
                </h2>
                <p class="text-sm text-cocoa-muted mt-3 leading-relaxed max-w-lg mx-auto">
                    Pilihan kue dan roti paling dicintai pelanggan setia Pinky Cake di Makassar. Dipanggang segar dengan bahan premium.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($bestSellers->take(8) as $product)
                    <x-product-card
                        :product="$product"
                        :href="route('product.show', $product->slug)"
                        variant="showcase"
                    />
                @endforeach
            </div>

            <div class="text-center pt-10">
                <a href="{{ route('catalog.index', ['sort' => 'terpopuler']) }}"
                   class="group inline-flex items-center gap-3 px-8 py-4 rounded-full bg-cocoa text-white hover:bg-strawberry-deep font-bold text-sm shadow-soft hover:shadow-pill transition-all duration-300">
                    <span>Lihat Seluruh Menu</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             5. PROMO / CUSTOM CAKE CTA — Wide gradient banner
        ═══════════════════════════════════════════════════════════════ --}}
        <section class="relative rounded-[2rem] overflow-hidden" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            {{-- Background gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#C72D5A] via-[#A01D40] to-[#3B2320]"></div>
            {{-- Pattern overlay --}}
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 sm:p-12 lg:p-16 items-center">
                <div class="space-y-5 text-center lg:text-left">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-butter text-cocoa font-extrabold text-xs uppercase tracking-wider shadow-sm">
                        🎂 Custom Cake & Event
                    </span>

                    <h2 class="font-serif font-black text-3xl sm:text-4xl lg:text-5xl text-white leading-tight">
                        Make Every Moment <span class="text-butter italic">Sweeter</span>
                    </h2>

                    <p class="text-sm sm:text-base text-white/85 max-w-lg leading-relaxed">
                        Pesan kue spesial untuk ulang tahun, anniversary, wisuda, dan momen bahagia Anda. Bebas desain, ucapan, dan ukuran kue.
                    </p>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('catalog.category', 'cake') }}"
                           class="group inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-butter text-cocoa font-extrabold text-sm hover:bg-white shadow-md transition-all">
                            <span>Pesan Custom Cake</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        @php
                            $customCakeWa = "https://wa.me/" . config('shop.wa_number', '6281234567890') . "?text=" . rawurlencode('Halo Pinky Cake, saya ingin konsultasi pemesanan Custom Cake untuk acara.');
                        @endphp
                        <a href="{{ $customCakeWa }}" target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-white/15 backdrop-blur-md border border-white/25 text-white font-bold text-sm hover:bg-white/25 transition-all">
                            <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                </div>

                {{-- Perks list --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach([
                        ['icon' => '🎁', 'text' => 'Gratis Pisau Kue & Lilin Ulang Tahun'],
                        ['icon' => '💌', 'text' => 'Bebas Tulis Pesan Kartu Ucapan'],
                        ['icon' => '🚗', 'text' => 'Pengiriman Mobil Ber-AC Aman'],
                        ['icon' => '🎨', 'text' => 'Pilihan Krim Lembut / Fondant 3D'],
                    ] as $perk)
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/15">
                            <span class="text-lg shrink-0">{{ $perk['icon'] }}</span>
                            <span class="text-xs text-white/90 font-semibold">{{ $perk['text'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             6. BRAND STORY — Editorial split with image
        ═══════════════════════════════════════════════════════════════ --}}
        <section class="relative" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">
                {{-- Left Text --}}
                <div class="lg:col-span-7 space-y-6">
                    <div>
                        <span class="font-serif italic text-strawberry-deep text-sm font-semibold">Tradisi Dapur Sejak 1998</span>
                        <h2 class="font-serif font-black text-3xl sm:text-4xl text-cocoa leading-tight tracking-tight mt-2">
                            Rasa Otentik dari Dapur<br class="hidden sm:inline"> <span class="text-strawberry-deep">Pinky Cake</span> & Bakery
                        </h2>
                    </div>

                    <div class="space-y-4 text-sm sm:text-base text-cocoa-muted leading-relaxed">
                        <p>Berawal dari kecintaan memanggang kue rumahan di Makassar, Pinky Cake & Bakery mendedikasikan setiap adonan untuk menghadirkan kelezatan sejati.</p>
                        <p>Kami memilih mentega berkualitas tinggi, susu murni, dan buah stroberi segar tanpa pemanis buatan maupun pengawet sintetis.</p>
                    </div>

                    {{-- Value Points --}}
                    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-blush-dark/40">
                        @foreach([
                            ['emoji' => '🌾', 'title' => '100% Bahan Alami', 'desc' => 'Tanpa pengawet sintetis'],
                            ['emoji' => '⏰', 'title' => 'Fresh Bake 3×/Hari', 'desc' => '10.00, 13.00, 16.00'],
                            ['emoji' => '🚚', 'title' => 'Kirim Makassar', 'desc' => 'Jaminan kue utuh'],
                        ] as $val)
                            <div class="space-y-1.5">
                                <span class="text-2xl">{{ $val['emoji'] }}</span>
                                <h4 class="font-serif font-bold text-sm text-cocoa">{{ $val['title'] }}</h4>
                                <p class="text-[11px] text-cocoa-muted">{{ $val['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-2 flex items-center gap-3">
                        <span class="font-serif italic text-base text-strawberry-deep font-bold">Pinky Cake Bakery Team</span>
                        <span class="text-xs text-cocoa-muted">· Panakkukang, Makassar</span>
                    </div>
                </div>

                {{-- Right Image --}}
                <div class="lg:col-span-5">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl group">
                        <div class="relative w-full aspect-[4/5] bg-blush">
                            <img src="{{ asset('products/hero-makassar.jpg') }}" alt="Dapur Pinky Cake" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
                        </div>
                        {{-- Overlay badge --}}
                        <div class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-md rounded-2xl p-4 flex items-center justify-between shadow-soft">
                            <div>
                                <span class="text-[10px] font-bold text-cocoa-muted block">Dapur Utama</span>
                                <span class="font-serif font-black text-sm text-cocoa">Panakkukang, Makassar</span>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase">Buka</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             7. JADWAL FRESH BAKE — Gradient CTA strip
        ═══════════════════════════════════════════════════════════════ --}}
        <section id="fresh-bake" class="bg-gradient-to-r from-blush via-blush-light to-cream rounded-[2rem] p-8 sm:p-10 flex flex-col sm:flex-row items-center justify-between gap-6 border border-blush-dark/50" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <div class="space-y-3 text-center sm:text-left">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-butter text-cocoa text-xs font-extrabold">
                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-strawberry-deep opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-strawberry-deep"></span></span>
                    Jadwal Fresh Bake
                </span>
                <h3 class="font-serif font-black text-2xl sm:text-3xl text-cocoa">Dipanggang Pas Jadwal, Tiba Masih Wangi</h3>
                <p class="text-sm text-cocoa-muted max-w-xl">
                    Tiga slot pemanggangan setiap hari: <strong>10.00</strong>, <strong>13.00</strong>, dan <strong>16.00 WITA</strong>. Kuota 5 cake per slot.
                </p>
            </div>
            <a href="{{ route('catalog.index') }}"
               class="group inline-flex items-center gap-2 px-7 py-4 rounded-full bg-strawberry-deep text-white font-extrabold text-sm shadow-pill hover:bg-strawberry-hover transition-all shrink-0">
                <span>Pilih Jadwal</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             8. CARA PESAN — 3 Steps with connector line
        ═══════════════════════════════════════════════════════════════ --}}
        <section id="lacak" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blush text-strawberry-deep text-xs font-extrabold uppercase tracking-[0.15em]">Mudah & Transparan</span>
                <h2 class="font-serif font-black text-3xl sm:text-4xl text-cocoa tracking-tight mt-3">Cara Pesan di Klik.Cake</h2>
                <p class="text-sm text-cocoa-muted mt-2">Hanya butuh 3 menit dari memilih kue sampai pesanan masuk antrean dapur</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
                {{-- Connecting line (desktop only) --}}
                <div class="hidden md:block absolute top-14 left-[20%] right-[20%] h-[2px] bg-gradient-to-r from-strawberry-deep via-butter to-strawberry-deep opacity-20"></div>

                @foreach([
                    ['num' => '1', 'title' => 'Pilih Menu & Jadwal', 'desc' => 'Tentukan varian ukuran, tulis ucapan kartu, lalu pilih tanggal dan jam slot di Makassar.', 'color' => 'from-strawberry-deep to-[#C72D5A]'],
                    ['num' => '2', 'title' => 'Bayar Instan', 'desc' => 'Pembayaran otomatis via QRIS, GoPay, ShopeePay, atau Virtual Account. Verifikasi hitungan detik.', 'color' => 'from-butter-dark to-butter'],
                    ['num' => '3', 'title' => 'Pantau Sampai Matang', 'desc' => 'Status transparan: Diterima → Dipanggang → Siap → Selesai. Notifikasi otomatis ke WhatsApp.', 'color' => 'from-strawberry-deep to-[#C72D5A]'],
                ] as $step)
                    <div class="relative bg-white rounded-3xl p-7 sm:p-8 border border-blush shadow-soft text-center space-y-4 hover:-translate-y-1.5 hover:shadow-xl transition-all duration-300">
                        <div class="w-14 h-14 mx-auto rounded-2xl bg-gradient-to-br {{ $step['color'] }} text-white font-serif font-black text-2xl flex items-center justify-center shadow-pill relative z-10">
                            {{ $step['num'] }}
                        </div>
                        <h3 class="font-serif font-black text-lg text-cocoa">{{ $step['title'] }}</h3>
                        <p class="text-xs sm:text-sm text-cocoa-muted leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ═══════════════════════════════════════════════════════════════
             9. TESTIMONI — Card grid with quotes
        ═══════════════════════════════════════════════════════════════ --}}
        <section x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <div class="text-center max-w-xl mx-auto mb-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-butter-light text-cocoa text-xs font-extrabold uppercase tracking-[0.15em]">Cerita Pembeli</span>
                <h2 class="font-serif font-black text-3xl sm:text-4xl text-cocoa tracking-tight mt-3">Kata Mereka Tentang Pinky Cake</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach([
                    ['quote' => 'Strawberry Cream Cake-nya juara! Bolunya lembut dan krimnya ringan tidak bikin enek. Stroberinya fresh manis asem segar.', 'name' => 'Andi Nurul', 'area' => 'Panakkukang'],
                    ['quote' => 'Sangat terbantu ada pilihan slot jam. Pesan H-1 sore, besok jam 1 siang diambil di toko kuenya baru saja selesai dikemas.', 'name' => 'Reza Pratama', 'area' => 'Tamalanrea'],
                    ['quote' => 'Snackbox kantor untuk rapat 40 orang rapi dan kuenya enak semua. Pesan lewat web praktis langsung dapat rincian lengkap.', 'name' => 'Ibu Fatimah', 'area' => 'Biringkanaya'],
                ] as $i => $t)
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-blush shadow-soft flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="space-y-3">
                            {{-- Giant quote mark --}}
                            <span class="font-serif text-5xl text-blush-dark leading-none select-none">&ldquo;</span>
                            <div class="flex text-butter text-sm -mt-4">★★★★★</div>
                            <p class="text-sm text-cocoa leading-relaxed">"{{ $t['quote'] }}"</p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-blush flex items-center justify-between">
                            <div>
                                <p class="font-bold text-xs text-cocoa">{{ $t['name'] }}</p>
                                <p class="text-[10px] text-cocoa-muted">{{ $t['area'] }}, Makassar</p>
                            </div>
                            <span class="text-[9px] font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-wider">Verified</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</x-shop.layout>
