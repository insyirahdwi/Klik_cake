<x-shop.layout title="Jejaring, Cabang Dapur & Mitra — Klik.Cake Makassar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-cocoa-muted">
            <a href="{{ route('home') }}" class="hover:text-strawberry-deep transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-cocoa font-bold">Jejaring &amp; Mitra</span>
        </nav>

        {{-- Header Section --}}
        <div class="space-y-4">
            <div>
                <x-badge variant="butter" size="sm">Jaringan Resmi</x-badge>
            </div>
            <h1 class="font-serif font-black text-3xl sm:text-5xl text-cocoa tracking-tight">
                Jejaring Dapur, Outlet &amp; Mitra Makassar
            </h1>
            <p class="font-sans text-base sm:text-lg text-cocoa-muted max-w-2xl leading-relaxed">
                Temukan lokasi dapur produksi pusat, outlet pengambilan pesanan mandiri (pick-up), mitra reseller resmi, serta kanal media sosial Pinky Cake &amp; Bakery.
            </p>
        </div>

        {{-- 1. Dapur & Outlet Pick-up --}}
        <section class="space-y-6">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-strawberry-light text-strawberry-deep flex items-center justify-center font-black text-sm">
                    📍
                </span>
                <div>
                    <h2 class="font-serif font-black text-2xl text-cocoa">Dapur Produksi &amp; Titik Pick-up</h2>
                    <p class="text-xs text-cocoa-muted">Lokasi pengambilan mandiri pesanan Anda di Makassar</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($outlets as $outlet)
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-blush shadow-soft space-y-4 hover:border-strawberry-deep/30 transition-all">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-blush text-strawberry-deep">
                                    {{ $outlet->typeLabel() }}
                                </span>
                                <h3 class="font-serif font-black text-xl text-cocoa mt-2">{{ $outlet->name }}</h3>
                            </div>
                            <span class="text-2xl">🧁</span>
                        </div>

                        @if($outlet->address)
                            <div class="flex items-start gap-2.5 text-xs text-cocoa-muted leading-relaxed">
                                <svg class="w-4 h-4 text-strawberry-deep flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $outlet->address }}</span>
                            </div>
                        @endif

                        @if($outlet->phone)
                            <div class="flex items-center gap-2.5 text-xs font-bold text-cocoa">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>Kontak: {{ $outlet->phone }}</span>
                            </div>
                        @endif

                        @if($outlet->url)
                            <div class="pt-2 border-t border-blush flex items-center justify-end">
                                <a
                                    href="{{ $outlet->url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 text-xs font-bold text-strawberry-deep hover:underline"
                                >
                                    <span>Buka di Peta (Google Maps)</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-cocoa-muted italic">Daftar outlet akan segera diperbarui.</p>
                @endforelse
            </div>
        </section>

        {{-- 2. Mitra Reseller & Kerjasama --}}
        <section class="space-y-6 pt-4 border-t border-blush">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-butter-light text-butter-dark flex items-center justify-center font-black text-sm">
                    🤝
                </span>
                <div>
                    <h2 class="font-serif font-black text-2xl text-cocoa">Mitra Reseller &amp; Kerjasama</h2>
                    <p class="text-xs text-cocoa-muted">Distributor dan partner resmi Klik.Cake</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($partners as $partner)
                    <div class="bg-white rounded-2xl p-6 border border-blush shadow-soft space-y-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-butter/20 text-butter-dark">
                            {{ $partner->typeLabel() }}
                        </span>
                        <h4 class="font-serif font-bold text-lg text-cocoa">{{ $partner->name }}</h4>
                        @if($partner->address)
                            <p class="text-xs text-cocoa-muted">{{ $partner->address }}</p>
                        @endif
                        @if($partner->phone)
                            <p class="text-xs font-bold text-emerald-700">WA: {{ $partner->phone }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-cocoa-muted italic">Ingin menjadi mitra reseller? Hubungi Customer Service kami via WhatsApp.</p>
                @endforelse
            </div>
        </section>

        {{-- 3. Media Sosial & Kanal Resmi --}}
        <section class="space-y-6 pt-4 border-t border-blush">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-blush text-strawberry-deep flex items-center justify-center font-black text-sm">
                    📱
                </span>
                <div>
                    <h2 class="font-serif font-black text-2xl text-cocoa">Kanal &amp; Media Sosial Resmi</h2>
                    <p class="text-xs text-cocoa-muted">Ikuti update roti fresh, promo mingguan, dan live baking dapur kami</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($socials as $soc)
                    <a
                        href="{{ $soc->url ?? '#' }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-between p-4 rounded-2xl bg-white border border-blush hover:border-strawberry-deep/50 shadow-soft hover:shadow-md transition-all group"
                    >
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-full bg-blush text-strawberry-deep font-black flex items-center justify-center text-sm uppercase">
                                {{ substr($soc->platform ?? $soc->name, 0, 2) }}
                            </span>
                            <div>
                                <h4 class="font-serif font-bold text-sm text-cocoa group-hover:text-strawberry-deep transition-colors">{{ $soc->name }}</h4>
                                <span class="text-[11px] text-cocoa-muted capitalize">{{ $soc->platform ?? 'Channel' }}</span>
                            </div>
                        </div>
                        <span class="text-strawberry-deep font-bold text-sm group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </a>
                @empty
                    <p class="text-sm text-cocoa-muted italic">Kanal resmi segera ditambahkan.</p>
                @endforelse
            </div>
        </section>

    </div>
</x-shop.layout>
