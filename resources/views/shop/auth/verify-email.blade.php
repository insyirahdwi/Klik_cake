<x-shop.layout title="Verifikasi Email — Klik.Cake Makassar">
    <div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cream">
        <div class="max-w-md w-full">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-blush text-strawberry-deep flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blush text-strawberry-deep text-xs font-bold tracking-wide uppercase shadow-sm">
                    Verifikasi Diperlukan
                </span>
                <h1 class="font-serif font-black text-3xl sm:text-4xl text-cocoa mt-3 tracking-tight">
                    Cek Email Anda
                </h1>
                <p class="font-sans text-sm text-cocoa-muted mt-2 leading-relaxed">
                    Kami telah mengirim link verifikasi ke
                    <strong class="text-cocoa">{{ $user->email }}</strong>.
                    Buka Gmail dan klik link tersebut untuk mengaktifkan akun.
                </p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 shadow-card border border-blush space-y-5">

                {{-- Flash success --}}
                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-700 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Info box --}}
                <div class="p-4 rounded-2xl bg-cream border border-blush text-xs text-cocoa-muted leading-relaxed space-y-2">
                    <div class="flex items-start gap-2">
                        <span class="text-strawberry-deep text-base">📬</span>
                        <p>Buka <strong class="text-cocoa">Gmail</strong> Anda dan cari email dari <strong class="text-cocoa">Klik.Cake by Pinky Cake</strong>.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-strawberry-deep text-base">⏱️</span>
                        <p>Link verifikasi berlaku selama <strong class="text-cocoa">60 menit</strong>. Jika belum masuk, cek folder Spam.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="text-strawberry-deep text-base">🔒</span>
                        <p>Setelah terverifikasi, Anda bisa mulai memesan kue &amp; roti segar.</p>
                    </div>
                </div>

                {{-- Resend form --}}
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full py-3.5 px-6 rounded-full bg-strawberry-deep hover:bg-strawberry text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Kirim Ulang Email Verifikasi</span>
                    </button>
                </form>

                {{-- Logout link --}}
                <div class="text-center">
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs text-cocoa-muted hover:text-red-600 font-semibold transition-colors cursor-pointer">
                            Keluar dari akun ini &rarr;
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-shop.layout>
