@extends('layouts.auth')
@section('title', 'Login')

@section('left-content')
    <!-- Logo and Title -->
    <div class="text-center w-full mb-8">
        <div class="relative inline-block mb-4">
            <div class="absolute inset-0 bg-blue-500 blur-[40px] opacity-30 rounded-full"></div>
            <img src="{{ asset('images/logo.png') }}" alt="Tatagih Logo" class="relative z-10 mx-auto w-20 drop-shadow-xl">
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight mb-1">
            <span class="text-cyan-400">Tata</span><span class="text-purple-500">gih</span>
        </h1>
        <p class="text-sm tracking-wide text-gray-400 font-medium">Subscription Manager</p>
    </div>

    <!-- Value Proposition -->
    <div class="text-center mb-10 w-full">
        <h2 class="text-xl font-bold mb-2 leading-snug text-white">Kelola semua subscription<br>lebih mudah & cerdas</h2>
        <p class="text-sm text-gray-400 max-w-[320px] mx-auto leading-relaxed">Pantau pengeluaran, hindari kebocoran, dan hemat lebih banyak.</p>
    </div>

    <!-- Beautiful Dashboard Card (Replaces the ugly 3D) -->
    <div class="w-full max-w-[360px] relative mb-12 group">
        <!-- Intense Glow -->
        <div class="absolute -inset-2 bg-gradient-to-r from-purple-600/40 via-blue-500/30 to-emerald-400/30 blur-[50px] rounded-full opacity-60"></div>
        
        <div class="relative z-10 rounded-2xl p-4 bg-[#0B1121]/80 backdrop-blur-md shadow-2xl transition-transform duration-500 hover:-translate-y-1" style="box-shadow: inset 0 0 0 1px rgba(255,255,255,0.05);">
            <!-- Dashboard UI Simulation -->
            <div class="flex gap-3 mb-3">
                <div class="flex-[3] bg-white/5 rounded-xl p-4">
                    <div class="h-1.5 w-16 bg-white/10 rounded-full mb-6"></div>
                    <svg viewBox="0 0 100 30" class="w-full h-10 overflow-visible drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]">
                        <path d="M0,25 C20,25 30,10 50,15 C70,20 80,5 100,5" fill="none" stroke="#06b6d4" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="flex-[2] flex flex-col gap-3">
                    <div class="flex-1 bg-white/5 rounded-xl p-3 flex justify-between items-center">
                        <div class="w-6 h-6 rounded-md bg-purple-500/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div class="w-5 h-5 rounded-full bg-emerald-500 flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.5)]">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                    <div class="flex-1 bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-3 flex flex-col justify-center">
                        <div class="text-[0.55rem] text-emerald-400/80 font-bold mb-1 uppercase tracking-wider">Hemat Bulan Ini</div>
                        <div class="text-emerald-400 font-bold text-sm">Rp70.700</div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex-[3] bg-white/5 rounded-xl p-3.5 flex items-center justify-between">
                    <div class="flex flex-col gap-2">
                        <div class="h-1.5 w-12 bg-blue-500 rounded-full"></div>
                        <div class="h-1.5 w-20 bg-white/10 rounded-full"></div>
                    </div>
                    <div class="w-6 h-6 rounded-full border-[3px] border-blue-500/30 border-t-blue-500 transform -rotate-45"></div>
                </div>
                <div class="flex-[2]"></div>
            </div>
        </div>
    </div>

    <!-- 3 Features Bottom -->
    <div class="flex justify-between w-full max-w-[360px] gap-2 mx-auto">
        <div class="text-center flex-1">
            <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center mb-3 bg-purple-500/10 text-purple-400" style="box-shadow: inset 0 0 0 1px rgba(168,85,247,0.3);">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="font-bold text-xs mb-1 text-white">Aman & Terpercaya</h3>
            <p class="text-[0.65rem] text-gray-500">Keamanan data terbaik</p>
        </div>
        <div class="text-center flex-1">
            <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center mb-3 bg-blue-500/10 text-blue-400" style="box-shadow: inset 0 0 0 1px rgba(59,130,246,0.3);">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-bold text-xs mb-1 text-white">Insight Cerdas</h3>
            <p class="text-[0.65rem] text-gray-500">Analisis otomatis AI</p>
        </div>
        <div class="text-center flex-1">
            <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center mb-3 bg-emerald-500/10 text-emerald-400" style="box-shadow: inset 0 0 0 1px rgba(16,185,129,0.3);">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h3 class="font-bold text-xs mb-1 text-white">Patungan Mudah</h3>
            <p class="text-[0.65rem] text-gray-500">Kelola bersama teman</p>
        </div>
    </div>
@endsection

@section('content')
<!-- Right Side Form Card with beautiful gradient border -->
<div class="relative w-full rounded-[1.5rem] bg-gradient-to-bl from-purple-500/80 via-white/5 to-emerald-400/80 p-[1px] shadow-[0_0_50px_-10px_rgba(168,85,247,0.15)]">
    <div class="bg-[#0b1121] rounded-[1.5rem] p-8 lg:p-10 w-full h-full relative overflow-hidden">
        
        <!-- Header Form -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-2 text-white flex items-center gap-2">
                Selamat datang kembali <span class="text-xl">👋</span>
            </h2>
            <p class="text-sm text-gray-400">Masuk untuk melanjutkan ke akun Anda</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('status'))
        <div class="mb-6 p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            
            <!-- Email Field -->
            <div class="mb-5">
                <label class="block text-xs font-bold tracking-widest text-gray-300 mb-2 uppercase">Email</label>
                <div class="relative group">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 group-focus-within:text-emerald-400 transition-colors pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-transparent border border-gray-700 rounded-xl py-3 pl-12 pr-4 text-white text-sm placeholder-gray-600 focus:outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400 transition-all" placeholder="nama@email.com" required autofocus>
                </div>
            </div>
            
            <!-- Password Field -->
            <div class="mb-6">
                <label class="block text-xs font-bold tracking-widest text-gray-300 mb-2 uppercase">Password</label>
                <div class="relative group">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 group-focus-within:text-emerald-400 transition-colors pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <input type="password" name="password" id="password" class="w-full bg-transparent border border-gray-700 rounded-xl py-3 pl-12 pr-10 text-white text-sm placeholder-gray-600 focus:outline-none focus:border-emerald-400 focus:ring-1 focus:ring-emerald-400 transition-all" placeholder="••••••••••••" required>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500 hover:text-white transition-colors cursor-pointer" onclick="togglePassword()" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
            </div>
            
            <!-- Remember & Forgot Password -->
            <div class="flex items-center justify-between mb-8">
                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-400 hover:text-white transition-colors">
                    <div class="relative flex items-center">
                        <input type="checkbox" name="remember" class="peer appearance-none w-4 h-4 border border-gray-600 rounded bg-transparent checked:bg-emerald-500 checked:border-emerald-500 transition-all cursor-pointer">
                        <svg class="absolute w-3 h-3 text-white pointer-events-none opacity-0 peer-checked:opacity-100 left-0.5 top-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Ingat saya
                </label>
                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-emerald-400 hover:text-emerald-300 transition-colors">Lupa password?</a>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full justify-center py-3.5 rounded-xl text-sm font-bold flex items-center gap-2 text-white bg-gradient-to-r from-emerald-400 via-blue-500 to-purple-500 hover:opacity-90 transition-opacity shadow-[0_10px_20px_-10px_rgba(59,130,246,0.5)]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                Masuk ke Akun
            </button>
        </form>

        <!-- Footer Text -->
        <div class="text-center text-sm text-gray-500 mt-8">
            Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-emerald-400 hover:text-emerald-300 transition-colors">Daftar sekarang</a>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>
@endsection
