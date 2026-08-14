@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<style>
    /* Override layouts.auth container to allow wide split layout */
    .auth-container {
        max-width: 1400px !important;
        width: 100% !important;
        padding: 2rem !important;
    }
    
    /* Hide the old background styles of the layout to ensure a clean slate */
    body {
        background-color: #03060D !important;
    }
    
    /* Hide scrollbar visually */
    .auth-container::-webkit-scrollbar {
        display: none;
    }
    .auth-container {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

</style>

<div class="w-full flex flex-col lg:flex-row gap-10 lg:gap-24 items-center justify-center">
    
    {{-- Left Column: Branding & Features --}}
    <div class="hidden lg:flex flex-col items-center justify-center w-1/2 text-center relative z-10 px-8">
        
        {{-- Logo Section --}}
        <div class="mb-4 relative">
            <div class="absolute inset-0 bg-blue-500/20 blur-[50px] rounded-full"></div>
            <div class="relative w-28 h-28 mx-auto flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Tatagih" class="w-24 h-24 object-contain drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]">
            </div>
            <h1 class="text-4xl font-extrabold mt-2 tracking-tight">
                <span class="text-emerald-400">Tata</span><span class="text-purple-400">gih</span>
            </h1>
            <p class="text-sm text-[#94a3b8] mt-1 tracking-wider uppercase font-medium">Subscription Manager</p>
        </div>

        <h2 class="text-2xl font-bold text-white mb-2">Kelola semua subscription<br>lebih mudah & cerdas</h2>
        <p class="text-[13px] text-[#94a3b8] mb-6 max-w-sm">Pantau pengeluaran, hindari kebocoran, dan hemat lebih banyak.</p>

        {{-- Floating Mockup Illustration --}}
        <div class="relative w-full max-w-sm mx-auto mb-8 perspective-[1000px]">
            {{-- Glow --}}
            <div class="absolute inset-0 bg-emerald-500/10 blur-[80px] rounded-full"></div>
            
            {{-- Main Glass Card --}}
            <div class="relative bg-[#080d19]/80 backdrop-blur-md border border-[rgba(255,255,255,0.06)] rounded-2xl p-4 shadow-2xl transform rotate-x-[15deg] rotate-y-[-10deg] rotate-z-[2deg] hover:rotate-0 transition-transform duration-500">
                <div class="flex gap-4">
                    {{-- Chart Box --}}
                    <div class="flex-1 bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-xl p-3 h-24 flex flex-col justify-end">
                        <svg viewBox="0 0 100 30" class="w-full h-8 overflow-visible">
                            <path d="M0 20 Q 20 5, 40 15 T 70 10 T 100 0" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>
                    {{-- Side Boxes --}}
                    <div class="w-24 space-y-3">
                        <div class="bg-purple-500/10 border border-purple-500/20 rounded-xl p-3 h-10 flex items-center justify-between text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-2 h-11 text-right">
                            <p class="text-[7px] text-emerald-400/70 mb-0.5">Hemat Bulan Ini</p>
                            <p class="text-xs font-bold text-emerald-400">Rp70.700</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-3">
                    <div class="flex-1 bg-[#111c2e] rounded-lg h-8 flex flex-col justify-center px-3 gap-1.5">
                        <div class="w-full h-1.5 bg-blue-500 rounded-full"></div>
                        <div class="w-1/2 h-1.5 bg-blue-500/30 rounded-full"></div>
                    </div>
                    <div class="w-8 h-8 rounded-full border-[3px] border-blue-500 border-r-transparent border-t-transparent transform rotate-45"></div>
                </div>
            </div>
        </div>

        {{-- Features Row --}}
        <div class="flex items-start justify-center gap-10 text-center w-full max-w-md">
            <div>
                <div class="w-8 h-8 mx-auto bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-400 mb-2 border border-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <p class="text-[11px] font-bold text-white mb-0.5">Aman & Terpercaya</p>
                <p class="text-[10px] text-[#4b5e78]">Keamanan data terbaik</p>
            </div>
            <div>
                <div class="w-8 h-8 mx-auto bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-400 mb-2 border border-purple-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <p class="text-[11px] font-bold text-white mb-0.5">Insight Cerdas</p>
                <p class="text-[10px] text-[#4b5e78]">Analisis otomatis TATA Asisten</p>
            </div>
            <div>
                <div class="w-8 h-8 mx-auto bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-400 mb-2 border border-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <p class="text-[11px] font-bold text-white mb-0.5">Patungan Mudah</p>
                <p class="text-[10px] text-[#4b5e78]">Kelola bersama teman</p>
            </div>
        </div>

    </div>

    {{-- Right Column: Login Form --}}
    <div class="flex-1 flex items-center justify-center relative z-10">
        <div class="w-full max-w-md bg-[#0b121f] rounded-3xl p-8 md:p-10 border border-[rgba(255,255,255,0.04)] shadow-2xl relative overflow-hidden">
            
            {{-- Gradient Border Top --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 via-blue-500 to-purple-600 opacity-50"></div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Selamat datang kembali</h2>
                <p class="text-xs text-[#94a3b8]">Masuk untuk melanjutkan ke akun Anda</p>
            </div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-[#f1f5f9] mb-2 uppercase tracking-widest">Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-11 pr-4 py-3.5 text-sm text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all hover:border-[rgba(255,255,255,0.1)]" placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-[11px] text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-[#f1f5f9] mb-2 uppercase tracking-widest">Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-11 pr-11 py-3.5 text-sm text-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all hover:border-[rgba(255,255,255,0.1)]" placeholder="••••••••" required>
                        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78] cursor-pointer hover:text-white transition-colors" @click="show = !show">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-[11px] text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer appearance-none w-4 h-4 border border-[rgba(255,255,255,0.2)] rounded bg-[#111c2e] checked:bg-emerald-500 checked:border-emerald-500 transition-colors cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute w-3 h-3 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span class="text-xs text-white group-hover:text-emerald-400 transition-colors">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-xs text-emerald-400 hover:text-emerald-300 font-medium transition-colors">Lupa password?</a>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-400 to-blue-500 hover:from-emerald-500 hover:to-blue-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-[0_4px_14px_0_rgba(16,185,129,0.39)] flex items-center justify-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Masuk ke Akun
                </button>

                <p class="text-[11px] text-center text-[#94a3b8]">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-400 font-bold hover:underline">Daftar sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>

{{-- Footer --}}
<div class="fixed bottom-6 left-0 right-0 w-full flex items-center justify-center text-[10px] text-[#4b5e78] z-0 pointer-events-none">
    <div>© {{ date('Y') }} Tatagih. All rights reserved.</div>
</div>

@endsection
