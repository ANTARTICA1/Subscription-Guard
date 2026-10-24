@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<style>
    [x-cloak] { display: none !important; }

    .auth-container {
        max-width: 1280px !important;
        width: 100% !important;
        padding: 1.5rem !important;
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }

    @media (max-width: 1023px) {
        .auth-container {
            height: auto !important;
            padding: 1rem !important;
        }
    }
</style>

<div class="w-full flex flex-col lg:flex-row gap-8 lg:gap-16 items-center justify-center my-auto">

    <div class="hidden lg:flex flex-col items-center justify-center w-1/2 text-center relative z-10 px-4">

        <div class="mb-4">
            <div class="w-20 h-20 mx-auto flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Tatagih Logo" class="w-18 h-18 object-contain">
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-[var(--text-primary)] mt-1.5">Tatagih</h1>
        </div>

        <div class="relative w-full max-w-[460px] mx-auto flex items-center justify-center">
            <img src="{{ asset('images/icon.png') }}"
                 alt="Tatagih Subscription Illustration"
                 class="w-full max-h-[330px] object-contain select-none pointer-events-none drop-shadow-md">
        </div>

    </div>

    <div class="flex-1 flex items-center justify-center relative z-10 w-full">
        <div class="w-full max-w-[440px] bg-[var(--bg-card)] rounded-3xl p-7 lg:p-8 border border-[var(--border-color)] shadow-xl relative overflow-hidden transition-colors duration-300">
            <div class="mb-5">
                <h2 class="text-2xl font-bold text-[var(--text-primary)] mb-1">Buat Akun Baru</h2>
                <p class="text-xs text-[var(--text-secondary)]">Yuk mulai atur keuangan subscription Anda sekarang!</p>
            </div>

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="mb-3.5">
                    <label class="block text-[10px] font-bold text-[var(--text-primary)] mb-1.5 uppercase tracking-widest">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-[var(--bg-input)] border border-[var(--border-input)] rounded-xl pl-10 pr-4 py-2.5 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-muted)] focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all hover:border-emerald-500/40" placeholder="Masukkan nama lengkap Anda" required autofocus>
                    </div>
                    @error('name')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3.5">
                    <label class="block text-[10px] font-bold text-[var(--text-primary)] mb-1.5 uppercase tracking-widest">Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[var(--bg-input)] border border-[var(--border-input)] rounded-xl pl-10 pr-4 py-2.5 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-muted)] focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all hover:border-emerald-500/40" placeholder="nama@email.com" required>
                    </div>
                    @error('email')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3.5" x-data="{ show: false }">
                    <label class="block text-[10px] font-bold text-[var(--text-primary)] mb-1.5 uppercase tracking-widest">Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" class="w-full bg-[var(--bg-input)] border border-[var(--border-input)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-muted)] focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all hover:border-emerald-500/40" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-colors p-1 bg-transparent border-none cursor-pointer" @click="show = !show">
                            <template x-if="!show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </template>
                            <template x-if="show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </template>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5" x-data="{ show: false }">
                    <label class="block text-[10px] font-bold text-[var(--text-primary)] mb-1.5 uppercase tracking-widest">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" class="w-full bg-[var(--bg-input)] border border-[var(--border-input)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-muted)] focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all hover:border-emerald-500/40" placeholder="Ulangi password Anda" required>
                        <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-colors p-1 bg-transparent border-none cursor-pointer" @click="show = !show">
                            <template x-if="!show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </template>
                            <template x-if="show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </template>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-[0_4px_15px_0_rgba(16,185,129,0.3)] hover:shadow-[0_6px_20px_0_rgba(16,185,129,0.45)] flex items-center justify-center gap-2 mb-4 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Daftar Sekarang
                </button>

                <p class="text-[11px] text-center text-[var(--text-secondary)]">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-500 font-bold hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>
</div>

<div class="w-full text-center text-[10px] text-[var(--text-muted)] mt-2">
    © {{ date('Y') }} Tatagih
</div>

@endsection
