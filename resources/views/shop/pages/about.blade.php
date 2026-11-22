<x-shop.layout :title="$title">
    {{-- Hero --}}
    <section class="bg-blush/30 py-12 px-4 text-center border-b border-blush">
        <span class="font-serif font-black text-4xl text-strawberry-deep">Tentang Kami</span>
        <p class="text-cocoa-muted text-sm mt-2">Mengenal Pinky Cake & Bakery lebih dekat</p>
    </section>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12 space-y-10">

        {{-- Story --}}
        <section>
            <h2 class="font-serif font-bold text-2xl text-cocoa mb-3">Cerita Kami</h2>
            <p class="text-cocoa-muted leading-relaxed text-sm">
                Klik.Cake adalah platform pre-order roti & kue segar milik <strong>Pinky Cake & Bakery</strong>, sebuah dapur rumahan yang berdiri di jantung kota Makassar sejak 2019.
                Kami percaya bahwa kue yang lezat dimulai dari bahan-bahan berkualitas — mentega pilihan, telur segar, dan tepung premium — dipadukan dengan teknik memanggang yang penuh kasih.
            </p>
            <p class="text-cocoa-muted leading-relaxed text-sm mt-3">
                Dengan sistem pre-order ini, setiap produk yang kamu terima dijamin baru keluar dari oven — bukan dari rak display yang sudah bermalam. Klik, dipanggang, sampai ke tanganmu dalam kondisi terbaik.
            </p>
        </section>

        {{-- Values --}}
        <section>
            <h2 class="font-serif font-bold text-2xl text-cocoa mb-4">Nilai Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-blush p-5 text-center">
                    <div class="text-3xl mb-2">🧈</div>
                    <h3 class="font-bold text-cocoa text-sm">Bahan Berkualitas</h3>
                    <p class="text-cocoa-muted text-xs mt-1 leading-relaxed">Hanya bahan pilihan tanpa pengawet buatan untuk setiap produk kami.</p>
                </div>
                <div class="bg-white rounded-2xl border border-blush p-5 text-center">
                    <div class="text-3xl mb-2">🔥</div>
                    <h3 class="font-bold text-cocoa text-sm">Selalu Segar</h3>
                    <p class="text-cocoa-muted text-xs mt-1 leading-relaxed">Dipanggang sesuai jadwal pesanan, bukan stok sisa kemarin.</p>
                </div>
                <div class="bg-white rounded-2xl border border-blush p-5 text-center">
                    <div class="text-3xl mb-2">❤️</div>
                    <h3 class="font-bold text-cocoa text-sm">Dibuat dengan Cinta</h3>
                    <p class="text-cocoa-muted text-xs mt-1 leading-relaxed">Setiap loyang diproses dengan perhatian dan standar dapur rumahan kami.</p>
                </div>
            </div>
        </section>

        {{-- Location --}}
        <section>
            <h2 class="font-serif font-bold text-2xl text-cocoa mb-3">Lokasi Dapur</h2>
            <div class="bg-white rounded-2xl border border-blush p-5 text-sm text-cocoa-muted leading-relaxed">
                <p><strong class="text-cocoa">Pinky Cake & Bakery</strong></p>
                <p>Jl. Boulevard / Panakkukang</p>
                <p>Makassar, Sulawesi Selatan</p>
                <p class="mt-2">🕐 Buka setiap hari: <strong class="text-cocoa">08.00 – 20.00 WITA</strong></p>
            </div>
        </section>

        {{-- CTA --}}
        <div class="text-center pt-4">
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-strawberry-deep text-white font-bold text-sm px-6 py-3 rounded-full hover:bg-strawberry-deep/90 transition-colors">
                Lihat Menu Kami →
            </a>
        </div>

    </div>
</x-shop.layout>
