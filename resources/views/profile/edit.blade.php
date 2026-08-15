@extends('layouts.app')
@section('title', 'Profil')

@section('content')



<div class="grid grid-cols-1 xl:grid-cols-12 gap-6 pb-12">

    {{-- Main Content (Left Column) --}}
    <div class="xl:col-span-8 space-y-6">
        
        {{-- Informasi Profil Card --}}
        <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 md:p-8 relative overflow-hidden">
            <h3 class="text-[15px] font-bold text-white mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Informasi Profil
            </h3>
            
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                {{-- Avatar Upload Section --}}
                <div class="flex items-center gap-6 mb-8">
                    <div class="relative group">
                        <div class="w-20 h-20 rounded-full border border-[rgba(255,255,255,0.1)] bg-[#111c2e] overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=192a42&color=fff" alt="Avatar" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-purple-600 rounded-full border-2 border-[#0b121f] flex items-center justify-center text-white cursor-pointer hover:bg-purple-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </div>
                    </div>
                    <div>
                        <label class="px-4 py-2 bg-transparent border border-purple-500/30 hover:border-purple-500 hover:bg-purple-500/10 text-purple-400 text-xs font-semibold rounded-lg cursor-pointer transition-all inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            Upload Avatar
                            <input type="file" name="avatar" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[10px] text-[#4b5e78] mt-2">JPG, PNG, WebP. Maks 2MB.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-[11px] font-bold text-[#f1f5f9] mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-4 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" required>
                        </div>
                    </div>
                    
                    {{-- Email --}}
                    <div>
                        <label class="block text-[11px] font-bold text-[#f1f5f9] mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" required>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Telegram Chat ID --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-[#f1f5f9] mb-2 flex items-center gap-1.5">
                        Telegram Chat ID
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0088cc]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/></svg>
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-white font-mono focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                        @if($user->telegram_chat_id)
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        @endif
                    </div>
                    <p class="text-[10px] mt-2 text-[#4b5e78] leading-relaxed">
                        Chat ID digunakan untuk menerima tagihan patungan (Split Bill) secara otomatis via Telegram. 
                        <br>Cara mengetahui Chat ID: Cari bot <span class="text-purple-400">@userinfobot</span> di Telegram, klik Start, lalu salin angka `Id` yang diberikan.
                    </p>
                </div>
                
                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl transition-colors text-sm flex items-center justify-center gap-2 shadow-[0_0_15px_rgba(147,51,234,0.2)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Profil
                    </button>
            </form>

            @if($user->telegram_chat_id)
                    <form method="POST" action="{{ route('telegram.test-notification') }}" class="sm:flex-1">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-transparent border border-[rgba(255,255,255,0.2)] hover:bg-[#111c2e] hover:border-[#0088cc] text-white hover:text-[#0088cc] font-bold py-2.5 px-6 rounded-xl transition-colors text-sm flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/></svg>
                            Kirim Pesan Uji Coba (Test Bot)
                        </button>
                    </form>
            @endif
                </div>
        </div>

        {{-- Ubah Password Card --}}
        <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 md:p-8 relative overflow-hidden">
            <h3 class="text-[15px] font-bold text-white mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Ubah Password
            </h3>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    {{-- Password Saat Ini --}}
                    <div>
                        <label class="block text-[11px] font-bold text-[#f1f5f9] mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="current_password" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" placeholder="Masukkan password saat ini" required>
                            <div onclick="let inp = this.previousElementSibling; if(inp.type === 'password'){inp.type = 'text'; this.children[0].classList.add('hidden'); this.children[1].classList.remove('hidden');}else{inp.type = 'password'; this.children[0].classList.remove('hidden'); this.children[1].classList.add('hidden');}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4b5e78] cursor-pointer hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </div>
                        </div>
                        @error('current_password')
                            <p class="text-[10px] mt-1 text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Baru --}}
                    <div>
                        <label class="block text-[11px] font-bold text-[#f1f5f9] mb-2">Password Baru</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" placeholder="Minimal 8 karakter" required>
                            <div onclick="let inp = this.previousElementSibling; if(inp.type === 'password'){inp.type = 'text'; this.children[0].classList.add('hidden'); this.children[1].classList.remove('hidden');}else{inp.type = 'password'; this.children[0].classList.remove('hidden'); this.children[1].classList.add('hidden');}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4b5e78] cursor-pointer hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="block text-[11px] font-bold text-[#f1f5f9] mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#4b5e78]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password_confirmation" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-10 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors" placeholder="Ulangi password baru" required>
                            <div onclick="let inp = this.previousElementSibling; if(inp.type === 'password'){inp.type = 'text'; this.children[0].classList.add('hidden'); this.children[1].classList.remove('hidden');}else{inp.type = 'password'; this.children[0].classList.remove('hidden'); this.children[1].classList.add('hidden');}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4b5e78] cursor-pointer hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-2">
                        <h4 class="text-[11px] font-bold text-[#f1f5f9] flex items-center gap-1.5 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Tips Keamanan
                        </h4>
                        <div class="flex items-center gap-2 text-[10px] text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Gunakan minimal 8 karakter
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Kombinasikan huruf, angka & simbol
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Jangan gunakan password yang mudah ditebak
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-[0_0_15px_rgba(147,51,234,0.3)] text-sm flex items-center justify-center gap-2 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Security Sidebar (Right Column) --}}
    <div class="xl:col-span-4 space-y-6">
        
        <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 relative overflow-hidden text-center">
            {{-- Shield Icon --}}
            <div class="relative w-20 h-20 mx-auto mb-4">
                <div class="absolute inset-0 bg-emerald-500/20 rounded-full animate-pulse blur-xl"></div>
                <div class="w-full h-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-full flex items-center justify-center relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400 drop-shadow-[0_0_8px_rgba(52,211,153,0.5)]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            
            <h3 class="text-emerald-400 font-bold text-base mb-1">Status Akun Aktif</h3>
            <p class="text-[10px] text-[#4b5e78] mb-1">Bergabung sejak</p>
            <p class="text-xs font-bold text-white mb-2">{{ $user->created_at->format('d M Y, H:i') }}</p>
        </div>

        <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl overflow-hidden">


            <form method="POST" action="#" class="block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun?');">
                @csrf @method('DELETE')
                <button type="submit" class="w-full flex items-center justify-between p-4 hover:bg-red-500/5 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#111c2e] border border-[rgba(255,255,255,0.06)] flex items-center justify-center text-red-500/70 group-hover:text-red-500 group-hover:border-red-500/30 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <span class="text-[11px] font-bold text-red-500/80 group-hover:text-red-500">Hapus Akun</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500/50 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </form>
        </div>

    </div>

</div>

@endsection

@section('scripts')
<style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }
</style>
@endsection
