@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<style>
    [x-cloak] { display: none !important; }

    body.auth-bg {
        background-color: #03060D !important;
        min-height: 100vh;
        height: 100vh;
        overflow: hidden;
    }

    .auth-container {
        max-width: 1400px !important;
        width: 100% !important;
        padding: 0 2.5rem !important;
        max-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
    }
</style>

<div class="w-full flex flex-col lg:flex-row gap-8 lg:gap-20 items-center justify-center flex-1">
    
    {{-- Left Column: Branding & Social Proof --}}
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

        <h2 class="text-xl font-bold text-white mb-2 leading-tight">
            <span class="text-emerald-400">Kelola semua subscription</span><br>
            <span class="text-purple-400">lebih mudah & cerdas</span>
        </h2>
        <p class="text-[12px] text-[#94a3b8] mb-8 max-w-[280px] mx-auto leading-relaxed">Pantau pengeluaran, hindari kebocoran, dan hemat lebih banyak.</p>

        {{-- Features List --}}
        <div class="space-y-5 w-full max-w-sm mx-auto text-left mb-8 relative">
            <div class="absolute left-6 top-6 bottom-6 w-px bg-gradient-to-b from-[rgba(255,255,255,0.02)] via-purple-500/20 to-[rgba(255,255,255,0.02)]"></div>
            <div class="absolute left-6 top-1/2 w-64 h-64 border border-blue-500/10 rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 bg-[#0b121f] rounded-xl flex items-center justify-center border border-[rgba(255,255,255,0.06)] shrink-0 shadow-[0_0_15px_rgba(139,92,246,0.1)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <div>
                    <h4 class="text-[13px] font-bold text-white mb-0.5">Aman & Terpercaya</h4>
                    <p class="text-[11px] text-[#4b5e78]">Keamanan data terbaik dengan enkripsi end-to-end.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 bg-[#0b121f] rounded-xl flex items-center justify-center border border-[rgba(255,255,255,0.06)] shrink-0 shadow-[0_0_15px_rgba(59,130,246,0.1)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <div>
                    <h4 class="text-[13px] font-bold text-white mb-0.5">Insight Cerdas</h4>
                    <p class="text-[11px] text-[#4b5e78]">Analisis otomatis dengan TATA Asisten untuk keputusan lebih baik.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 bg-[#0b121f] rounded-xl flex items-center justify-center border border-[rgba(255,255,255,0.06)] shrink-0 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <h4 class="text-[13px] font-bold text-white mb-0.5">Patungan Mudah</h4>
                    <p class="text-[11px] text-[#4b5e78]">Kelola dan split pembayaran bersama teman.</p>
                </div>
            </div>
        </div>

        {{-- Social Proof Card --}}
        <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-4 flex items-center gap-4 w-full max-w-sm mx-auto">
            <div class="flex -space-x-2">
                <img class="w-8 h-8 rounded-full border border-[#0b121f]" src="https://ui-avatars.com/api/?name=User+A&background=2d3748&color=fff" alt="">
                <img class="w-8 h-8 rounded-full border border-[#0b121f]" src="https://ui-avatars.com/api/?name=User+B&background=10b981&color=fff" alt="">
                <img class="w-8 h-8 rounded-full border border-[#0b121f]" src="https://ui-avatars.com/api/?name=User+C&background=8b5cf6&color=fff" alt="">
            </div>
            <div class="text-left">
                <div class="flex gap-0.5 text-amber-400 mb-0.5">
                    @for($i = 0; $i < 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    @endfor
                </div>
                <p class="text-[9px] text-[#94a3b8] leading-tight mt-1">Dipercaya oleh ribuan pengguna<br>untuk kelola subscription mereka</p>
            </div>
        </div>
    </div>

    {{-- Right Column: Register Form --}}
    <div class="flex-1 flex items-center justify-center relative z-10">
        <div class="w-full max-w-[460px] bg-[#0b121f] rounded-3xl p-8 lg:p-10 border border-[rgba(255,255,255,0.04)] shadow-2xl relative overflow-hidden">
            
            {{-- Gradient Border Top --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 via-blue-500 to-purple-600 opacity-50"></div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-2">Buat Akun Baru</h2>
                <p class="text-[13px] text-[#94a3b8]">Yuk mulai atur keuangan subscription Anda sekarang!</p>
            </div>

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-[#f1f5f9] mb-2 uppercase tracking-widest">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all hover:border-[rgba(255,255,255,0.1)]" placeholder="Masukkan nama lengkap Anda" required autofocus>
                    </div>
                    @error('name')
                        <p class="text-[11px] text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-5">
                    <label class="block text-[10px] font-bold text-[#f1f5f9] mb-2 uppercase tracking-widest">Email</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all hover:border-[rgba(255,255,255,0.1)]" placeholder="nama@email.com" required>
                    </div>
                    @error('email')
                        <p class="text-[11px] text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-5" x-data="{ show: false }">
                    <label class="block text-[10px] font-bold text-[#f1f5f9] mb-2 uppercase tracking-widest">Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-12 py-3 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all hover:border-[rgba(255,255,255,0.1)]" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78] hover:text-white transition-colors p-0 bg-transparent border-none cursor-pointer" @click="show = !show">
                            <template x-if="!show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </template>
                            <template x-if="show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </template>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[11px] text-red-400 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-8" x-data="{ show: false }">
                    <label class="block text-[10px] font-bold text-[#f1f5f9] mb-2 uppercase tracking-widest">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-12 py-3 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all hover:border-[rgba(255,255,255,0.1)]" placeholder="Ulangi password Anda" required>
                        <button type="button" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#4b5e78] hover:text-white transition-colors p-0 bg-transparent border-none cursor-pointer" @click="show = !show">
                            <template x-if="!show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </template>
                            <template x-if="show">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </template>
                        </button>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-400 to-purple-500 hover:from-emerald-500 hover:to-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-[0_4px_15px_0_rgba(139,92,246,0.3)] flex items-center justify-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Daftar Sekarang
                </button>

                <p class="text-[11px] text-center text-[#94a3b8]">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 font-bold hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>
</div>

{{-- Footer --}}
<div class="fixed bottom-4 left-0 right-0 w-full flex items-center justify-center text-[10px] text-[#4b5e78] z-0 pointer-events-none">
    <div>© {{ date('Y') }} Tatagih. All rights reserved.</div>
</div>

@endsection
