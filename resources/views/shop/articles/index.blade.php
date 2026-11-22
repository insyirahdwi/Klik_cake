<x-shop.layout title="Artikel, Tips & Resep Kue — Klik.Cake by Pinky Cake Makassar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-cocoa-muted">
            <a href="{{ route('home') }}" class="hover:text-strawberry-deep transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-cocoa font-bold">Artikel &amp; Cerita Dapur</span>
        </nav>

        {{-- Header Section --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <x-badge variant="butter" size="sm">Dapur Pinky Cake</x-badge>
                <span class="text-xs text-cocoa-muted font-bold">&bull; Makassar</span>
            </div>
            <h1 class="font-serif font-black text-3xl sm:text-5xl text-cocoa tracking-tight">
                Artikel, Tips &amp; Inspirasi Pesta
            </h1>
            <p class="font-sans text-base sm:text-lg text-cocoa-muted max-w-2xl leading-relaxed">
                Temukan tips memilih cake ulang tahun, rahasia panggangan fresh bake, hingga inspirasi snackbox acara dan kumpul keluarga di Makassar.
            </p>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 pt-2 border-b border-blush pb-6">
            {{-- Category Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2">
                <a
                    href="{{ route('article.index') }}"
                    class="px-4 py-2 rounded-full text-xs font-bold transition-all {{ empty(request('kategori')) ? 'bg-strawberry-deep text-white shadow-pill' : 'bg-white text-cocoa border border-blush hover:border-strawberry-deep/40' }}"
                >
                    Semua Artikel
                </a>
                @foreach($categories as $cat)
                    <a
                        href="{{ route('article.index', ['kategori' => $cat->slug]) }}"
                        class="px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 {{ request('kategori') === $cat->slug ? 'bg-strawberry-deep text-white shadow-pill' : 'bg-white text-cocoa border border-blush hover:border-strawberry-deep/40' }}"
                    >
                        <span>{{ $cat->name }}</span>
                        <span class="text-[10px] opacity-80">({{ $cat->published_articles_count }})</span>
                    </a>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <form action="{{ route('article.index') }}" method="GET" class="relative max-w-xs w-full">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari artikel..."
                    class="w-full bg-white text-xs font-semibold text-cocoa placeholder:text-cocoa-muted/70 pl-9 pr-4 py-2.5 rounded-full border border-blush focus:border-strawberry-deep focus:ring-1 focus:ring-strawberry-deep outline-none shadow-sm"
                >
                <svg class="w-4 h-4 text-cocoa-muted absolute left-3 top-3 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
        </div>

        {{-- Active Filter Notification --}}
        @if(request('kategori') || request('q'))
            <div class="flex items-center gap-2 text-xs font-bold text-cocoa-muted">
                <span>Filter aktif:</span>
                @if($activeCategory)
                    <span class="px-2.5 py-1 rounded-full bg-blush text-strawberry-deep flex items-center gap-1">
                        {{ $activeCategory->name }}
                        <a href="{{ route('article.index', ['q' => request('q')]) }}" class="hover:text-cocoa">&times;</a>
                    </span>
                @endif
                @if(request('q'))
                    <span class="px-2.5 py-1 rounded-full bg-blush text-strawberry-deep flex items-center gap-1">
                        Pencarian: "{{ request('q') }}"
                        <a href="{{ route('article.index', ['kategori' => request('kategori')]) }}" class="hover:text-cocoa">&times;</a>
                    </span>
                @endif
                <a href="{{ route('article.index') }}" class="text-strawberry-deep underline hover:text-cocoa ml-2">Reset</a>
            </div>
        @endif

        {{-- Articles Grid --}}
        @if($articles->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-blush max-w-lg mx-auto space-y-4">
                <div class="w-16 h-16 rounded-full bg-blush text-strawberry-deep flex items-center justify-center mx-auto text-2xl font-bold">
                    ✍️
                </div>
                <h3 class="font-serif font-black text-xl text-cocoa">Belum ada artikel ditemukan</h3>
                <p class="text-sm text-cocoa-muted">Silakan coba kata kunci lain atau pilih kategori artikel yang berbeda.</p>
                <div class="pt-2">
                    <x-button as="a" href="{{ route('article.index') }}" variant="secondary" size="sm">
                        Lihat Semua Artikel
                    </x-button>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($articles as $art)
                    <article class="bg-white rounded-3xl border border-blush/80 hover:border-strawberry-deep/30 shadow-soft hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">
                        
                        {{-- Top Header / Category Pill --}}
                        <div class="p-6 pb-0 flex items-center justify-between gap-2">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-blush text-strawberry-deep">
                                {{ $art->category->name ?? 'Dapur Pinky' }}
                            </span>
                            <span class="text-[11px] font-semibold text-cocoa-muted">
                                {{ $art->readingTimeMinutes() }} mnt baca
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h2 class="font-serif font-black text-xl text-cocoa group-hover:text-strawberry-deep transition-colors leading-snug">
                                    <a href="{{ route('article.show', $art->slug) }}">
                                        {{ $art->title }}
                                    </a>
                                </h2>
                                <p class="font-sans text-xs sm:text-sm text-cocoa-muted mt-2 line-clamp-3 leading-relaxed">
                                    {{ $art->excerpt }}
                                </p>
                            </div>

                            {{-- Footer Meta --}}
                            <div class="pt-4 border-t border-blush flex items-center justify-between text-xs text-cocoa-muted">
                                <div class="flex items-center gap-1.5 font-bold">
                                    <span>{{ $art->author_name }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $art->formattedPublishedDate() }}</span>
                                </div>
                                <a
                                    href="{{ route('article.show', $art->slug) }}"
                                    class="font-black text-strawberry-deep group-hover:translate-x-0.5 transition-transform inline-flex items-center gap-1"
                                >
                                    <span>Baca</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pt-8">
                {{ $articles->links() }}
            </div>
        @endif

    </div>
</x-shop.layout>
