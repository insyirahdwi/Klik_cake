<x-shop.layout :title="$title">
    {{-- Hero --}}
    <section class="bg-blush/30 py-12 px-4 text-center border-b border-blush">
        <span class="font-serif font-black text-4xl text-strawberry-deep">FAQ</span>
        <p class="text-cocoa-muted text-sm mt-2">Pertanyaan yang sering ditanyakan</p>
    </section>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-12 space-y-4" x-data="{ open: null }">

        @php
        $faqs = [
            [
                'q' => 'Berapa lama sebelumnya saya harus memesan?',
                'a' => 'Umumnya minimal H-1 (1 hari sebelum tanggal yang diinginkan). Untuk produk custom seperti kue ulang tahun berlapis, disarankan minimal H-3. Cek ketersediaan slot langsung di halaman produk.'
            ],
            [
                'q' => 'Apakah bisa memesan tanpa akun?',
                'a' => 'Ya, kamu bisa memesan sebagai tamu (tanpa mendaftar). Namun dengan akun, kamu bisa melihat riwayat pesanan dan proses checkout lebih cepat.'
            ],
            [
                'q' => 'Metode pembayaran apa saja yang tersedia?',
                'a' => 'Kami menerima transfer bank (BCA, Mandiri, BNI, BRI), GoPay, OVO, ShopeePay, Dana, dan QRIS. Semua transaksi diproses aman melalui payment gateway.'
            ],
            [
                'q' => 'Apakah produk bisa dikirim ke luar Makassar?',
                'a' => 'Saat ini kami melayani pengiriman dalam kota Makassar dan sekitarnya. Untuk pengiriman luar kota, silakan hubungi kami via WhatsApp untuk diskusi lebih lanjut.'
            ],
            [
                'q' => 'Bagaimana jika saya ingin membatalkan pesanan?',
                'a' => 'Pembatalan dapat dilakukan sebelum proses produksi dimulai. Hubungi kami via WhatsApp sesegera mungkin. Refund diproses 3–7 hari kerja.'
            ],
            [
                'q' => 'Bisakah menambahkan tulisan atau request custom di kue?',
                'a' => 'Tentu! Tambahkan catatan spesial di kolom "Catatan Pesanan" saat checkout. Contoh: "Happy Birthday Sarah, topping strawberry".'
            ],
            [
                'q' => 'Apa itu Fresh Bake?',
                'a' => 'Fresh Bake adalah jadwal panggang harian kami yang tersedia terbatas. Produk Fresh Bake dipanggang pagi hari dan siap diambil/dikirim pada jam yang ditentukan — dijamin paling segar!'
            ],
            [
                'q' => 'Produk mengandung alergen apa saja?',
                'a' => 'Sebagian besar produk kami mengandung gluten (tepung terigu), produk susu (mentega, susu, keju), dan telur. Untuk informasi alergen spesifik per produk, hubungi kami sebelum memesan.'
            ],
        ];
        @endphp

        @foreach($faqs as $i => $faq)
        <div class="border border-blush rounded-2xl overflow-hidden bg-white">
            <button
                class="w-full text-left px-5 py-4 font-bold text-cocoa text-sm flex justify-between items-center gap-3 hover:bg-blush/20 transition-colors"
                @click="open = open === {{ $i }} ? null : {{ $i }}"
            >
                <span>{{ $faq['q'] }}</span>
                <svg class="w-4 h-4 flex-shrink-0 transition-transform" :class="open === {{ $i }} ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open === {{ $i }}" x-collapse class="px-5 pb-4 text-sm text-cocoa-muted leading-relaxed">
                {{ $faq['a'] }}
            </div>
        </div>
        @endforeach

        {{-- Contact CTA --}}
        <div class="mt-8 text-center text-sm text-cocoa-muted">
            Masih ada pertanyaan?
            @php
                $waNumber = config('shop.wa_number', '6281234567890');
                $waMessage = rawurlencode('Halo Pinky Cake & Bakery, saya ingin bertanya tentang pesanan.');
                $waUrl = "https://wa.me/{$waNumber}?text={$waMessage}";
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="font-bold text-[#25D366] hover:underline">Chat via WhatsApp →</a>
        </div>

    </div>
</x-shop.layout>
