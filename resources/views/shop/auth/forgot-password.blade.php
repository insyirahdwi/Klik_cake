<x-shop.layout title="Lupa Password — Klik.Cake Makassar">
    <div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cream">
        <div class="max-w-md w-full">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-blush text-strawberry-deep flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blush text-strawberry-deep text-xs font-bold tracking-wide uppercase shadow-sm">
                    Pemulihan Akun
                </span>
                <h1 class="font-serif font-black text-3xl sm:text-4xl text-cocoa mt-3 tracking-tight">
                    Lupa Password?
                </h1>
                <p class="font-sans text-sm text-cocoa-muted mt-2 leading-relaxed">
                    Masukkan alamat email akun Anda. Kami akan mengirim link untuk mereset password ke Gmail Anda.
                </p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 shadow-card border border-blush space-y-5">

                {{-- Success flash --}}
                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-700 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Error --}}
                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-700">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                            Alamat Email <span class="text-strawberry-deep">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="email-anda@gmail.com"
                                class="w-full pl-10 pr-4 py-3 rounded-2xl bg-cream/30 border border-blush text-sm text-cocoa placeholder-cocoa-muted/50 focus:outline-none focus:ring-2 focus:ring-strawberry-deep focus:border-transparent transition-all @error('email') border-red-400 ring-1 ring-red-400 @enderror"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3.5 px-6 rounded-full bg-strawberry-deep hover:bg-strawberry text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Kirim Link Reset Password</span>
                    </button>
                </form>

                <div class="text-center border-t border-blush pt-5">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-strawberry-deep hover:underline">
                        &larr; Kembali ke halaman Login
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-shop.layout>
