@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<style>

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
        <div class="w-full max-w-[420px] bg-[var(--bg-card)] rounded-3xl p-7 md:p-9 border border-[var(--border-color)] shadow-xl relative overflow-hidden transition-colors duration-300">
            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-[10px] font-bold text-[var(--text-primary)] mb-1.5 uppercase tracking-widest">Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[var(--bg-input)] border border-[var(--border-input)] rounded-xl pl-10 pr-4 py-3 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-muted)] focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all hover:border-emerald-500/40" placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-[10px] font-bold text-[var(--text-primary)] mb-1.5 uppercase tracking-widest">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" class="w-full bg-[var(--bg-input)] border border-[var(--border-input)] rounded-xl pl-10 pr-10 py-3 text-sm text-[var(--text-primary)] placeholder:text-[var(--text-muted)] focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all hover:border-emerald-500/40" placeholder="••••••••" required>
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] cursor-pointer hover:text-[var(--text-primary)] transition-colors p-1" @click="show = !show">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-[11px] text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer appearance-none w-4 h-4 border border-[var(--border-input)] rounded bg-[var(--bg-input)] checked:bg-emerald-500 checked:border-emerald-500 transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-3 h-3 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="text-xs text-[var(--text-secondary)] group-hover:text-emerald-500 transition-colors">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-emerald-500 hover:text-emerald-600 font-medium transition-colors">Lupa password?</a>
                </div>

                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-[0_4px_14px_0_rgba(16,185,129,0.35)] hover:shadow-[0_6px_20px_0_rgba(16,185,129,0.45)] flex items-center justify-center gap-2 mb-5 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Masuk ke Akun
                </button>

                <p class="text-[11px] text-center text-[var(--text-secondary)]">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-500 font-bold hover:underline">Daftar sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>

<div class="w-full text-center text-[10px] text-[var(--text-muted)] mt-2">
    © {{ date('Y') }} Tatagih
</div>

@endsection
