@props([
    'product',
    'href' => '#',
    'variant' => 'default',
])

@php
$name = is_object($product) ? $product->name : ($product['name'] ?? 'Nama Produk');
$description = is_object($product) ? ($product->description ?? '') : ($product['description'] ?? '');
$formattedPrice = is_object($product)
    ? (method_exists($product, 'formattedPrice') ? $product->formattedPrice() : 'Rp' . number_format($product->minPrice(), 0, ',', '.'))
    : ($product['formatted_price'] ?? 'Rp' . number_format($product['price'] ?? 0, 0, ',', '.'));
$isFreshBake = is_object($product) ? ($product->is_fresh_bake ?? true) : ($product['is_fresh_bake'] ?? true);
$imageUrl = is_object($product) ? ($product->image_url ?? null) : ($product['image_url'] ?? null);
$rating = is_object($product) ? ($product->rating ?? 4.9) : ($product['rating'] ?? 4.9);
$categoryName = is_object($product) && $product->collection ? $product->collection->name : 'Bakery';
@endphp

@if($variant === 'showcase')
    {{-- Premium Showcase Card — Poster-style product images --}}
    <article {{ $attributes->merge(['class' => 'group relative flex flex-col bg-white rounded-2xl overflow-hidden border border-blush/60 hover:border-strawberry-deep/30 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2']) }}>
        {{-- Image Container — full-bleed poster style --}}
        <a href="{{ $href }}" wire:navigate class="relative block overflow-hidden">
            <div class="relative w-full aspect-[4/5] bg-blush overflow-hidden">
                <x-product-image :src="$imageUrl" :alt="$name" aspect="4/5" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
            </div>

            @if($isFreshBake)
                <div class="absolute top-3 left-3 z-20">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-butter text-cocoa text-[9px] font-extrabold uppercase tracking-wider shadow-md backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-strawberry-deep animate-pulse"></span>
                        Fresh Bake
                    </span>
                </div>
            @endif

            {{-- Gradient overlay at bottom --}}
            <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/30 to-transparent"></div>
        </a>

        {{-- Product Info --}}
        <div class="flex-1 flex flex-col px-4 sm:px-5 pb-4 sm:pb-5 pt-3">
            <a href="{{ $href }}" wire:navigate class="group-hover:text-strawberry-deep transition-colors">
                <h3 class="font-serif font-black text-sm sm:text-base text-cocoa leading-snug line-clamp-1">{{ $name }}</h3>
            </a>

            <div class="flex items-center gap-1.5 mt-1.5 text-[10px] text-cocoa-muted font-semibold">
                <span class="text-butter text-xs tracking-tighter">★★★★★</span>
                <span class="text-cocoa font-extrabold">{{ number_format($rating, 1) }}</span>
                <span class="text-cocoa-muted/30">·</span>
                <span class="uppercase tracking-wider">{{ $categoryName }}</span>
            </div>

            @if($description)
                <p class="text-[11px] text-cocoa-muted line-clamp-2 mt-1.5 leading-relaxed">{{ $description }}</p>
            @endif

            {{-- Price & CTA --}}
            <div class="mt-auto pt-3 border-t border-blush/50 flex items-center justify-between gap-2">
                <span class="px-3 py-1 rounded-full bg-blush/80 text-strawberry-deep font-black text-xs tracking-tight">{{ $formattedPrice }}</span>
                <a href="{{ $href }}" wire:navigate class="group/btn inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-strawberry-deep text-white text-[10px] sm:text-xs font-bold shadow-sm hover:bg-strawberry-hover transition-colors">
                    <span>Pesan</span>
                    <svg class="w-3 h-3 transition-transform group-hover/btn:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </article>
@else
    {{-- Standard Card --}}
    <article {{ $attributes->merge(['class' => 'group flex flex-col bg-white rounded-2xl overflow-hidden p-3 transition-all duration-200 hover:-translate-y-1 hover:shadow-soft border border-blush/60']) }}>
        <a href="{{ $href }}" wire:navigate class="block relative w-full overflow-hidden rounded-xl">
            <x-product-image :src="$imageUrl" :alt="$name" aspect="4/5" />
            @if($isFreshBake)
                <div class="absolute top-2.5 left-2.5 z-10">
                    <x-badge variant="butter" size="xs">Fresh Bake</x-badge>
                </div>
            @endif
        </a>

        <div class="mt-3 flex flex-col flex-1 justify-between">
            <a href="{{ $href }}" wire:navigate class="group-hover:text-strawberry-deep transition-colors">
                <h3 class="font-serif font-bold text-sm md:text-base text-cocoa leading-snug line-clamp-2">{{ $name }}</h3>
            </a>
            <div class="mt-2 flex items-center justify-between pt-1">
                <p class="font-sans font-extrabold text-sm md:text-base text-cocoa">{{ $formattedPrice }}</p>
                <span class="text-xs font-semibold text-strawberry-deep opacity-0 group-hover:opacity-100 transition-opacity">Pesan &rarr;</span>
            </div>
        </div>
    </article>
@endif
