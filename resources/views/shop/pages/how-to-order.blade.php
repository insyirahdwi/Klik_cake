<x-shop.layout :title="$title">
    {{-- Hero --}}
    <section class="bg-blush/30 py-12 px-4 text-center border-b border-blush">
        <span class="font-serif font-black text-4xl text-strawberry-deep">Cara Pesan</span>
        <p class="text-cocoa-muted text-sm mt-2">Mudah, cepat, dan kuenya selalu segar</p>
    </section>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12">

        {{-- Steps --}}
        <ol class="space-y-8">
            <li class="flex gap-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-strawberry-deep text-white font-black flex items-center justify-center text-lg">1</div>
                <div>
                    <h3 class="font-bold text-cocoa text-base">Pilih Produk</h3>
                    <p class="text-cocoa-muted text-sm mt-1 leading-relaxed">Jelajahi <a href="{{ route('catalog.index') }}" class="text-strawberry-deep font-bold hover:underline">menu koleksi</a> kami — cake, roti, pastry, hingga snackbox. Klik produk untuk melihat detail, bahan, dan ketersediaan slot.</p>
                </div>
            </li>

            <li class="flex gap-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-strawberry-deep text-white font-black flex items-center justify-center text-lg">2</div>
                <div>
                    <h3 class="font-bold text-cocoa text-base">Pilih Tanggal & Jam</h3>
                    <p class="text-cocoa-muted text-sm mt-1 leading-relaxed">Tentukan kapan kamu ingin produk selesai dipanggang. Sistem kami menampilkan slot yang masih tersedia secara real-time agar kamu bisa memilih waktu yang paling sesuai.</p>
                </div>
            </li>

            <li class="flex gap-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-strawberry-deep text-white font-black flex items-center justify-center text-lg">3</div>
                <div>
                    <h3 class="font-bold text-cocoa text-base">Masukkan ke Keranjang</h3>
                    <p class="text-cocoa-muted text-sm mt-1 leading-relaxed">Tambahkan produk ke keranjang, sesuaikan jumlah, dan tambahkan catatan khusus jika ada (misal: "tuliskan Happy Birthday Sarah" atau permintaan alergi).</p>
                </div>
            </li>

            <li class="flex gap-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-strawberry-deep text-white font-black flex items-center justify-center text-lg">4</div>
                <div>
                    <h3 class="font-bold text-cocoa text-base">Checkout & Isi Alamat</h3>
                    <p class="text-cocoa-muted text-sm mt-1 leading-relaxed">Isi nama, nomor WhatsApp, dan alamat pengiriman. Sistem akan menghitung biaya ongkos kirim berdasarkan zona wilayahmu di Makassar.</p>
                </div>
            </li>

            <li class="flex gap-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-strawberry-deep text-white font-black flex items-center justify-center text-lg">5</div>
                <div>
                    <h3 class="font-bold text-cocoa text-base">Bayar & Konfirmasi</h3>
                    <p class="text-cocoa-muted text-sm mt-1 leading-relaxed">Selesaikan pembayaran melalui transfer bank atau e-wallet. Setelah pembayaran terkonfirmasi, pesananmu resmi masuk antrian produksi dapur kami.</p>
                </div>
            </li>

            <li class="flex gap-5">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-strawberry-deep text-white font-black flex items-center justify-center text-lg">6</div>
                <div>
                    <h3 class="font-bold text-cocoa text-base">Pantau Progres & Nikmati!</h3>
                    <p class="text-cocoa-muted text-sm mt-1 leading-relaxed">Gunakan fitur <a href="{{ route('track.index') }}" class="text-strawberry-deep font-bold hover:underline">Lacak Pesanan</a> untuk melihat status terkini — dari antrian, sedang dipanggang, hingga siap dikirim. Kue segar tiba di pintu rumahmu! 🎂</p>
                </div>
            </li>
        </ol>

        {{-- Tips --}}
        <div class="mt-12 bg-blush/40 border border-blush rounded-2xl p-5">
            <h3 class="font-serif font-bold text-cocoa text-lg mb-3">💡 Tips Pre-Order</h3>
            <ul class="text-sm text-cocoa-muted space-y-2">
                <li>✅ Pesan <strong>minimal H-1</strong> untuk memastikan slot tersedia</li>
                <li>✅ Untuk pesanan acara besar (50+ pcs), hubungi kami via WhatsApp untuk koordinasi khusus</li>
                <li>✅ Slot weekend biasanya penuh lebih cepat — pesan lebih awal!</li>
                <li>✅ Simpan nomor pesananmu untuk melacak status kapan saja</li>
            </ul>
        </div>

        {{-- CTA --}}
        <div class="text-center mt-10">
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-strawberry-deep text-white font-bold text-sm px-6 py-3 rounded-full hover:bg-strawberry-deep/90 transition-colors">
                Mulai Pesan Sekarang →
            </a>
        </div>

    </div>
</x-shop.layout>
