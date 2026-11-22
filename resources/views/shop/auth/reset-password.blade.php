<x-shop.layout title="Reset Password — Klik.Cake Makassar">
    <div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cream">
        <div class="max-w-md w-full">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-blush text-strawberry-deep flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-blush text-strawberry-deep text-xs font-bold tracking-wide uppercase shadow-sm">
                    Buat Password Baru
                </span>
                <h1 class="font-serif font-black text-3xl sm:text-4xl text-cocoa mt-3 tracking-tight">
                    Reset Password
                </h1>
                <p class="font-sans text-sm text-cocoa-muted mt-2">
                    Masukkan password baru untuk akun <strong class="text-cocoa">{{ $email }}</strong>.
                </p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-3xl p-7 sm:p-8 shadow-card border border-blush">

                {{-- Error --}}
                @if ($errors->any())
                    <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-700">
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

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5"
                      x-data="{ showNew: false, showConfirm: false }">
                    @csrf

                    {{-- Hidden fields --}}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                            Password Baru <span class="text-strawberry-deep">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input
                                :type="showNew ? 'text' : 'password'"
                                name="password"
                                id="password"
                                required
                                autofocus
                                minlength="6"
                                placeholder="Minimal 6 karakter"
                                class="w-full pl-10 pr-10 py-3 rounded-2xl bg-cream/30 border border-blush text-sm text-cocoa placeholder-cocoa-muted/50 focus:outline-none focus:ring-2 focus:ring-strawberry-deep focus:border-transparent transition-all @error('password') border-red-400 ring-1 ring-red-400 @enderror"
                            >
                            <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-cocoa-muted hover:text-cocoa focus:outline-none">
                                <svg x-show="!showNew" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showNew" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                            Konfirmasi Password Baru <span class="text-strawberry-deep">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input
                                :type="showConfirm ? 'text' : 'password'"
                                name="password_confirmation"
                                id="password_confirmation"
                                required
                                placeholder="Ulangi password baru"
                                class="w-full pl-10 pr-10 py-3 rounded-2xl bg-cream/30 border border-blush text-sm text-cocoa placeholder-cocoa-muted/50 focus:outline-none focus:ring-2 focus:ring-strawberry-deep focus:border-transparent transition-all"
                            >
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-cocoa-muted hover:text-cocoa focus:outline-none">
                                <svg x-show="!showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirm" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full py-3.5 px-6 rounded-full bg-strawberry-deep hover:bg-strawberry text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group cursor-pointer"
                        >
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Password Baru</span>
                        </button>
                    </div>
                </form>

                <div class="text-center border-t border-blush mt-5 pt-5">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-strawberry-deep hover:underline">
                        &larr; Kembali ke halaman Login
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-shop.layout>
