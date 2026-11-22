<x-shop.layout title="Edit Profil — Klik.Cake Makassar">
    <div class="bg-cream min-h-screen py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs md:text-sm text-cocoa-muted mb-6">
                <a href="{{ route('home') }}" class="hover:text-strawberry-deep transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('account.dashboard') }}" class="hover:text-strawberry-deep transition-colors">Akun Saya</a>
                <span>/</span>
                <span class="text-cocoa font-semibold">Edit Profil</span>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

                {{-- Sidebar Profile Card --}}
                <div class="bg-white rounded-3xl p-6 shadow-card border border-blush space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blush text-strawberry-deep flex items-center justify-center font-serif font-black text-2xl uppercase">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="font-serif font-bold text-lg text-cocoa leading-tight">
                                {{ $user->name }}
                            </h1>
                            <p class="text-xs text-cocoa-muted truncate max-w-[180px]">
                                {{ $user->email }}
                            </p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $user->isAdmin() ? 'bg-butter text-cocoa' : 'bg-blush text-strawberry-deep' }}">
                                {{ $user->isAdmin() ? 'Administrator' : 'Pelanggan' }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-blush pt-4 space-y-2">
                        <a href="{{ route('account.dashboard') }}" class="w-full flex items-center justify-between p-3 rounded-2xl hover:bg-cream/60 text-xs font-bold text-cocoa transition-colors">
                            <span class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-strawberry-deep" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span>Dashboard Akun</span>
                            </span>
                            <span class="text-cocoa-muted">&rarr;</span>
                        </a>

                        <a href="{{ route('catalog.index') }}" class="w-full flex items-center justify-between p-3 rounded-2xl hover:bg-cream/60 text-xs font-bold text-cocoa transition-colors">
                            <span class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-strawberry-deep" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span>Pesan Roti &amp; Kue</span>
                            </span>
                            <span class="text-cocoa-muted">&rarr;</span>
                        </a>

                        <a href="{{ route('track.index') }}" class="w-full flex items-center justify-between p-3 rounded-2xl hover:bg-cream/60 text-xs font-bold text-cocoa transition-colors">
                            <span class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-strawberry-deep" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span>Lacak Pesanan</span>
                            </span>
                            <span class="text-cocoa-muted">&rarr;</span>
                        </a>
                    </div>

                    {{-- Logout Form --}}
                    <div class="border-t border-blush pt-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="w-full py-2.5 px-4 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Keluar dari Akun</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- ====================== --}}
                    {{-- Section: Edit Profil   --}}
                    {{-- ====================== --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-card border border-blush">
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-8 h-8 rounded-xl bg-blush flex items-center justify-center text-strawberry-deep flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="font-serif font-black text-xl text-cocoa">Informasi Profil</h3>
                            </div>
                            <p class="text-xs text-cocoa-muted ml-11">Perbarui nama dan nomor telepon akun Anda.</p>
                        </div>

                        {{-- Validation errors for profile form --}}
                        @if ($errors->hasBag('profile') && $errors->getBag('profile')->any())
                            <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-700">
                                <div class="flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="font-bold">Terjadi kesalahan:</p>
                                        <ul class="list-disc list-inside mt-1 space-y-0.5">
                                            @foreach ($errors->getBag('profile')->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                                    Nama Lengkap <span class="text-strawberry-deep">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        maxlength="100"
                                        placeholder="Nama lengkap Anda"
                                        class="w-full pl-10 pr-4 py-3 rounded-2xl bg-cream/30 border border-blush text-sm text-cocoa placeholder-cocoa-muted/50 focus:outline-none focus:ring-2 focus:ring-strawberry-deep focus:border-transparent transition-all @error('name') border-red-400 ring-1 ring-red-400 @enderror"
                                    >
                                </div>
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email (read-only) --}}
                            <div>
                                <label for="email_display" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                                    Alamat Email
                                    <span class="ml-1.5 px-1.5 py-0.5 rounded text-[9px] bg-cream border border-blush text-cocoa-muted font-bold normal-case tracking-normal">Tidak dapat diubah</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        id="email_display"
                                        value="{{ $user->email }}"
                                        disabled
                                        class="w-full pl-10 pr-4 py-3 rounded-2xl bg-cream/60 border border-blush text-sm text-cocoa-muted cursor-not-allowed select-none"
                                    >
                                </div>
                                <p class="mt-1.5 text-[11px] text-cocoa-muted">Email akun terhubung dengan riwayat pesanan Anda dan tidak dapat diubah.</p>
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                                    Nomor WhatsApp / Telepon
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="tel"
                                        name="phone"
                                        id="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        maxlength="20"
                                        placeholder="Contoh: 0812-3456-7890"
                                        class="w-full pl-10 pr-4 py-3 rounded-2xl bg-cream/30 border border-blush text-sm text-cocoa placeholder-cocoa-muted/50 focus:outline-none focus:ring-2 focus:ring-strawberry-deep focus:border-transparent transition-all @error('phone') border-red-400 ring-1 ring-red-400 @enderror"
                                    >
                                </div>
                                @error('phone')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto px-8 py-3 rounded-full bg-strawberry-deep hover:bg-strawberry text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- ========================= --}}
                    {{-- Section: Ganti Password   --}}
                    {{-- ========================= --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-card border border-blush">
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-8 h-8 rounded-xl bg-blush flex items-center justify-center text-strawberry-deep flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <h3 class="font-serif font-black text-xl text-cocoa">Ganti Password</h3>
                            </div>
                            <p class="text-xs text-cocoa-muted ml-11">Pastikan akun Anda menggunakan password yang kuat dan unik.</p>
                        </div>

                        {{-- Validation errors for password form --}}
                        @if ($errors->hasBag('password'))
                            <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-700">
                                <div class="flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="font-bold">Terjadi kesalahan:</p>
                                        <ul class="list-disc list-inside mt-1 space-y-0.5">
                                            @foreach ($errors->getBag('password')->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('account.password.update') }}" method="POST" class="space-y-5" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                            @csrf
                            @method('PUT')

                            {{-- Current Password --}}
                            <div>
                                <label for="current_password" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                                    Password Saat Ini <span class="text-strawberry-deep">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input
                                        :type="showCurrent ? 'text' : 'password'"
                                        name="current_password"
                                        id="current_password"
                                        required
                                        placeholder="Password Anda saat ini"
                                        class="w-full pl-10 pr-10 py-3 rounded-2xl bg-cream/30 border border-blush text-sm text-cocoa placeholder-cocoa-muted/50 focus:outline-none focus:ring-2 focus:ring-strawberry-deep focus:border-transparent transition-all @error('current_password') border-red-400 ring-1 ring-red-400 @enderror"
                                    >
                                    <button type="button" @click="showCurrent = !showCurrent" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-cocoa-muted hover:text-cocoa focus:outline-none">
                                        <svg x-show="!showCurrent" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showCurrent" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div>
                                <label for="password" class="block text-xs font-bold text-cocoa uppercase tracking-wider mb-2">
                                    Password Baru <span class="text-strawberry-deep">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-cocoa-muted">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                    <input
                                        :type="showNew ? 'text' : 'password'"
                                        name="password"
                                        id="password"
                                        required
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

                            {{-- Confirm New Password --}}
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
                                    class="w-full sm:w-auto px-8 py-3 rounded-full bg-cocoa hover:bg-cocoa/90 text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>Perbarui Password</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-shop.layout>
