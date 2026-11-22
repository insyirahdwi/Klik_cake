<x-shop.layout :title="$title">
    {{-- Hero --}}
    <section class="bg-blush/30 py-12 px-4 text-center border-b border-blush">
        <span class="font-serif font-black text-4xl text-strawberry-deep">Kebijakan Privasi</span>
        <p class="text-cocoa-muted text-sm mt-2">Terakhir diperbarui: {{ date('d F Y') }}</p>
    </section>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12 space-y-8 text-sm text-cocoa-muted leading-relaxed">

        <p>
            Klik.Cake by Pinky Cake & Bakery ("kami", "Klik.Cake") berkomitmen untuk melindungi privasi setiap pengguna yang mengakses layanan kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.
        </p>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">1. Data yang Kami Kumpulkan</h2>
            <ul class="list-disc pl-5 space-y-1">
                <li>Nama lengkap dan informasi kontak (nomor WhatsApp / email)</li>
                <li>Alamat pengiriman dan koordinat lokasi</li>
                <li>Riwayat pesanan dan preferensi produk</li>
                <li>Data pembayaran (diproses aman melalui gateway pihak ketiga — kami <strong>tidak</strong> menyimpan nomor kartu)</li>
                <li>Data teknis: IP address, jenis perangkat, log akses</li>
            </ul>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">2. Penggunaan Data</h2>
            <ul class="list-disc pl-5 space-y-1">
                <li>Memproses dan menyelesaikan pesanan Anda</li>
                <li>Mengirim konfirmasi, pembaruan status, dan notifikasi pesanan</li>
                <li>Meningkatkan kualitas layanan dan pengalaman pengguna</li>
                <li>Mematuhi kewajiban hukum dan peraturan yang berlaku</li>
            </ul>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">3. Berbagi Data dengan Pihak Ketiga</h2>
            <p>
                Kami tidak menjual atau menyewakan data pribadi Anda. Data hanya dibagikan kepada mitra terpercaya yang membantu operasional kami, seperti penyedia layanan pembayaran dan pengiriman, sesuai keperluan transaksi.
            </p>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">4. Keamanan Data</h2>
            <p>
                Kami menggunakan enkripsi SSL/TLS, pembatasan akses internal, dan praktik keamanan industri untuk melindungi data Anda. Namun, tidak ada sistem yang sepenuhnya bebas risiko — harap hubungi kami segera jika Anda mencurigai adanya penyalahgunaan.
            </p>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">5. Hak Anda</h2>
            <p>Anda berhak untuk:</p>
            <ul class="list-disc pl-5 space-y-1 mt-1">
                <li>Mengakses dan memperbarui data pribadi melalui halaman profil akun</li>
                <li>Meminta penghapusan data (kecuali data yang diperlukan secara hukum)</li>
                <li>Berhenti menerima komunikasi promosi kapan saja</li>
            </ul>
        </section>

        <section>
            <h2 class="font-serif font-bold text-xl text-cocoa mb-2">6. Kontak</h2>
            <p>
                Pertanyaan tentang kebijakan privasi kami? Hubungi kami melalui WhatsApp atau email yang tertera di footer halaman ini.
            </p>
        </section>

    </div>
</x-shop.layout>
