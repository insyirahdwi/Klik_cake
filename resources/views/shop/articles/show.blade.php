<x-shop.layout :title="$article->title . ' — Klik.Cake by Pinky Cake Makassar'">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-cocoa-muted flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-strawberry-deep transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('article.index') }}" class="hover:text-strawberry-deep transition-colors">Artikel</a>
            @if($article->category)
                <span>/</span>
                <a href="{{ route('article.index', ['kategori' => $article->category->slug]) }}" class="hover:text-strawberry-deep transition-colors">
                    {{ $article->category->name }}
                </a>
            @endif
            <span>/</span>
            <span class="text-cocoa font-bold truncate max-w-[200px] sm:max-w-none">{{ $article->title }}</span>
        </nav>

        {{-- Main Article Card --}}
        <article class="bg-white rounded-3xl p-6 sm:p-12 border border-blush shadow-soft space-y-8">
            
            {{-- Header --}}
            <header class="space-y-4 border-b border-blush pb-8">
                <div class="flex items-center gap-3 flex-wrap">
                    @if($article->category)
                        <span class="px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-blush text-strawberry-deep">
                            {{ $article->category->name }}
                        </span>
                    @endif
                    <span class="text-xs font-bold text-cocoa-muted">
                        {{ $article->readingTimeMinutes() }} menit membaca
                    </span>
                    <span class="text-xs text-cocoa-muted">&bull;</span>
                    <span class="text-xs font-bold text-cocoa-muted">
                        {{ $article->view_count }} kali dibaca
                    </span>
                </div>

                <h1 class="font-serif font-black text-3xl sm:text-4xl lg:text-5xl text-cocoa leading-[1.2]">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center justify-between gap-4 pt-2 flex-wrap">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blush text-strawberry-deep font-black flex items-center justify-center text-sm">
                            🎂
                        </div>
                        <div>
                            <p class="text-xs font-black text-cocoa">{{ $article->author_name }}</p>
                            <p class="text-[11px] text-cocoa-muted font-semibold">{{ $article->formattedPublishedDate() }} &bull; Dapur Makassar</p>
                        </div>
                    </div>

                    {{-- WhatsApp Share Button --}}
                    @php
                        $shareUrl = rawurlencode(url()->current());
                        $shareText = rawurlencode("Baca artikel menarik dari Klik.Cake: {$article->title}\n" . url()->current());
                    @endphp
                    <a
                        href="https://wa.me/?text={{ $shareText }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all border border-[#25D366]/30"
                    >
                        <span>Bagikan ke WhatsApp</span>
                    </a>
                </div>
            </header>

            {{-- Excerpt Highlight --}}
            @if($article->excerpt)
                <div class="p-5 rounded-2xl bg-cream border-l-4 border-strawberry-deep text-cocoa font-medium text-sm sm:text-base leading-relaxed italic">
                    {{ $article->excerpt }}
                </div>
            @endif

            {{-- Rich Content Body --}}
            <div class="font-sans text-cocoa text-base leading-relaxed space-y-5 prose prose-pink max-w-none">
                {!! $article->content !!}
            </div>

            {{-- Call to Action Card in Article --}}
            <div class="p-6 sm:p-8 rounded-3xl bg-blush/60 border border-blush-dark/40 flex flex-col sm:flex-row items-center justify-between gap-6 mt-10">
                <div class="space-y-1 text-center sm:text-left">
                    <h3 class="font-serif font-black text-xl text-cocoa">Mau Pesan Cake Fresh Bake Sekarang?</h3>
                    <p class="text-xs sm:text-sm text-cocoa-muted">Pilih jadwal panggangan favorit Anda dan rasakan kesegarannya langsung dari oven.</p>
                </div>
                <x-button as="a" href="{{ route('catalog.index') }}" variant="primary" size="md" class="flex-shrink-0">
                    Buka Katalog Menu &rarr;
                </x-button>
            </div>

            {{-- Article Footer --}}
            <footer class="pt-6 border-t border-blush flex items-center justify-between text-xs text-cocoa-muted flex-wrap gap-4">
                <a href="{{ route('article.index') }}" class="font-bold text-strawberry-deep hover:underline">
                    &larr; Lihat Artikel Lainnya
                </a>
                <span class="font-semibold">&copy; Klik.Cake by Pinky Cake and Bakery</span>
            </footer>

        </article>

        {{-- Related Articles Section --}}
        @if($relatedArticles->isNotEmpty())
            <div class="space-y-6 pt-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-serif font-black text-2xl text-cocoa">Artikel Terkait Lainnya</h2>
                    <a href="{{ route('article.index') }}" class="text-xs font-bold text-strawberry-deep hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <div class="bg-white rounded-2xl p-5 border border-blush shadow-soft space-y-3 flex flex-col justify-between group">
                            <div class="space-y-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-blush text-strawberry-deep">
                                    {{ $rel->category->name ?? 'Dapur Pinky' }}
                                </span>
                                <h4 class="font-serif font-black text-base text-cocoa group-hover:text-strawberry-deep transition-colors">
                                    <a href="{{ route('article.show', $rel->slug) }}">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-cocoa-muted line-clamp-2">
                                    {{ $rel->excerpt }}
                                </p>
                            </div>
                            <a href="{{ route('article.show', $rel->slug) }}" class="text-xs font-bold text-strawberry-deep group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                <span>Baca selengkapnya</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-shop.layout>
