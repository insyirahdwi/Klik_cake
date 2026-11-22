<x-shop.layout :title="$title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-cocoa-muted mb-6">
            <a href="{{ route('home') }}" class="hover:text-strawberry-deep transition-colors">Beranda</a>
            <span>/</span>
            <span class="text-cocoa font-bold">{{ $page->title }}</span>
        </nav>

        {{-- Page Card --}}
        <article class="bg-white rounded-3xl p-6 sm:p-10 border border-blush shadow-soft space-y-6">
            <header class="border-b border-blush pb-6">
                <h1 class="font-serif font-black text-3xl sm:text-4xl text-cocoa">
                    {{ $page->title }}
                </h1>
                @if($page->meta_description)
                    <p class="font-sans text-sm sm:text-base text-cocoa-muted mt-2 leading-relaxed">
                        {{ $page->meta_description }}
                    </p>
                @endif
            </header>

            {{-- Rich Content --}}
            <div class="prose prose-pink max-w-none font-sans text-cocoa leading-relaxed space-y-4">
                {!! $page->content !!}
            </div>

            <footer class="pt-6 border-t border-blush flex items-center justify-between text-xs text-cocoa-muted">
                <span>Diperbarui pada: {{ $page->updated_at->translatedFormat('d F Y') }}</span>
                <a href="{{ route('home') }}" class="font-bold text-strawberry-deep hover:underline">
                    &larr; Kembali ke Beranda
                </a>
            </footer>
        </article>
    </div>
</x-shop.layout>
