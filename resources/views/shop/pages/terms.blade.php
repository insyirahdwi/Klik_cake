<x-shop.layout :title="$title">
    {{-- Hero --}}
    <section class="bg-blush/30 py-12 px-4 text-center border-b border-blush">
        <span class="font-serif font-black text-4xl text-strawberry-deep">Syarat & Ketentuan</span>
        <p class="text-cocoa-muted text-sm mt-2">Terakhir diperbarui: {{ date('d F Y') }}</p>
    </section>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12 space-y-8 text-sm text-cocoa-muted leading-relaxed">

        <p>
            Dengan menggunakan layanan Klik.Cake, Anda menyetujui syarat dan ketentuan berikut. Harap baca dengan seksama sebelum melakukan pemesanan.
        </p>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">1. Sistem Pre-Order</h2>
            <p>
                Semua produk dijual secara <strong>pre-order</strong>. Pelanggan wajib memilih tanggal pengambilan/pengiriman saat memesan. Produk akan dipanggang sesuai jadwal yang dipilih dan tidak dapat diubah setelah pembayaran dikonfirmasi.
            </p>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">2. Pembayaran</h2>
            <ul class="list-disc pl-5 space-y-1">
                <li>Pembayaran harus diselesaikan dalam batas waktu yang ditentukan setelah pesanan dibuat.</li>
                <li>Pesanan yang melewati batas waktu pembayaran akan otomatis dibatalkan.</li>
                <li>Kami menerima transfer bank, e-wallet, dan metode pembayaran digital lainnya yang tersedia.</li>
            </ul>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">3. Pembatalan & Pengembalian Dana</h2>
            <ul class="list-disc pl-5 space-y-1">
                <li>Pembatalan hanya dapat dilakukan <strong>sebelum proses produksi dimulai</strong>.</li>
                <li>Pesanan yang sudah dalam proses produksi tidak dapat dibatalkan.</li>
                <li>Pengembalian dana (refund) diproses dalam 3–7 hari kerja ke metode pembayaran asal.</li>
                <li>Jika ada produk yang cacat atau tidak sesuai, hubungi kami dalam 2 jam setelah penerimaan dengan disertai foto.</li>
            </ul>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">4. Pengiriman</h2>
            <ul class="list-disc pl-5 space-y-1">
                <li>Pengiriman tersedia dalam area Makassar sesuai zona yang ditentukan.</li>
                <li>Biaya pengiriman dihitung berdasarkan zona alamat Anda.</li>
                <li>Keterlambatan akibat kondisi lalu lintas atau force majeure di luar kendali kami tidak dapat menjadi dasar klaim.</li>
            </ul>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">5. Keterbatasan Stok & Slot</h2>
            <p>
                Setiap produk memiliki kapasitas produksi harian yang terbatas. Jika slot penuh, produk tidak dapat dipesan untuk tanggal tersebut. Kami tidak menjamin ketersediaan produk di luar sistem pre-order.
            </p>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">6. Hak Kekayaan Intelektual</h2>
            <p>
                Semua konten di Klik.Cake — nama, logo, foto, desain — adalah milik Pinky Cake & Bakery dan dilindungi hak cipta. Penggunaan tanpa izin tertulis dilarang.
            </p>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">7. Perubahan Ketentuan</h2>
            <p>
                Kami berhak memperbarui syarat dan ketentuan ini sewaktu-waktu. Perubahan akan berlaku efektif setelah dipublikasikan di halaman ini.
            </p>
        </section>

    </div>
</x-shop.layout>
