@extends('layouts.app')
@section('title', 'Profil')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-12 min-w-0">

    <div class="lg:col-span-7 xl:col-span-8 space-y-6 min-w-0">

        <div class="card p-6 md:p-8">
            <h3 class="text-sm font-bold text-[var(--text-primary)] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                Informasi Profil
            </h3>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="flex items-center gap-5 mb-8">
                    <div class="relative group">
                        <div class="w-16 h-16 rounded-full border border-[var(--border-color)] bg-[var(--bg-elevated)] overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=192a42&color=fff" alt="Avatar" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-0 w-5 h-5 bg-[var(--bg-elevated)] rounded-full border border-[var(--border-color)] flex items-center justify-center text-[var(--text-secondary)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </div>
                    </div>
                    <div>
                        <label class="px-3.5 py-1.5 bg-[var(--bg-elevated)] border border-[var(--border-color)] hover:border-[var(--text-secondary)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] text-xs font-semibold rounded-lg cursor-pointer transition-all inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            Upload Avatar
                            <input type="file" name="avatar" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[10px] text-[var(--text-muted)] mt-1.5">JPG, PNG, WebP. Maks 2MB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-primary)] mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-9 pr-4 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-primary)] mb-1.5">Email</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-9 pr-9 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" required>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-semibold text-[var(--text-primary)] mb-1.5">
                        Telegram Chat ID
                    </label>
                    <div class="relative">
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-9 pr-9 py-2 text-xs text-[var(--text-primary)] font-mono focus:outline-none focus:border-slate-400 transition-colors">
                        @if($user->telegram_chat_id)
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        @endif
                    </div>
                    <p class="text-[10px] mt-1.5 text-[var(--text-muted)] leading-relaxed">
                        Chat ID digunakan untuk menerima tagihan patungan secara otomatis via Telegram.
                    </p>
                </div>

                <div class="border-t border-[var(--border-color)] pt-5 mb-5">
                    <h4 class="text-xs font-bold text-[var(--text-primary)] mb-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        Rekening / E-Wallet Pembayaran Patungan
                    </h4>
                    <p class="text-[10px] text-[var(--text-muted)] mb-3">Informasi ini akan ditampilkan ke anggota saat mereka melakukan transfer patungan kepada Anda.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Nama Bank / E-Wallet</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}" placeholder="Contoh: BCA / GoPay / Dana" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg px-3 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Nomor Rekening / No. HP</label>
                            <input type="text" name="account_number" value="{{ old('account_number', $user->account_number) }}" placeholder="Contoh: 1234567890" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg px-3 py-2 text-xs text-[var(--text-primary)] font-mono focus:outline-none focus:border-slate-400 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Atas Nama (Pemilik)</label>
                            <input type="text" name="account_holder" value="{{ old('account_holder', $user->account_holder) }}" placeholder="Contoh: {{ $user->name }}" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg px-3 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit" class="btn-primary py-2 px-5 rounded-lg text-xs font-semibold flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Profil
                    </button>
            </form>

            @if($user->telegram_chat_id)
                    <form method="POST" action="{{ route('telegram.test-notification') }}" class="sm:flex-1">
                        @csrf
                        <button type="submit" class="btn-secondary py-2 px-4 rounded-lg text-xs font-semibold flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/></svg>
                            Kirim Pesan Uji Coba (Test Bot)
                        </button>
                    </form>
            @endif
                </div>
        </div>

        <div class="card p-6 md:p-8">
            <h3 class="text-sm font-bold text-[var(--text-primary)] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Ubah Password
            </h3>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-primary)] mb-1.5">Password Saat Ini</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="current_password" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-9 pr-9 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" placeholder="Masukkan password saat ini" required>
                            <div onclick="let inp = this.previousElementSibling; if(inp.type === 'password'){inp.type = 'text'; this.children[0].classList.add('hidden'); this.children[1].classList.remove('hidden');}else{inp.type = 'password'; this.children[0].classList.remove('hidden'); this.children[1].classList.add('hidden');}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] cursor-pointer hover:text-[var(--text-primary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </div>
                        </div>
                        @error('current_password')
                            <p class="text-[10px] mt-1 text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-primary)] mb-1.5">Password Baru</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-9 pr-9 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" placeholder="Minimal 8 karakter" required>
                            <div onclick="let inp = this.previousElementSibling; if(inp.type === 'password'){inp.type = 'text'; this.children[0].classList.add('hidden'); this.children[1].classList.remove('hidden');}else{inp.type = 'password'; this.children[0].classList.remove('hidden'); this.children[1].classList.add('hidden');}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] cursor-pointer hover:text-[var(--text-primary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[var(--text-primary)] mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password_confirmation" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-9 pr-9 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" placeholder="Ulangi password baru" required>
                            <div onclick="let inp = this.previousElementSibling; if(inp.type === 'password'){inp.type = 'text'; this.children[0].classList.add('hidden'); this.children[1].classList.remove('hidden');}else{inp.type = 'password'; this.children[0].classList.remove('hidden'); this.children[1].classList.add('hidden');}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] cursor-pointer hover:text-[var(--text-primary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-1.5">
                        <h4 class="text-[11px] font-bold text-[var(--text-secondary)] flex items-center gap-1.5 mb-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Tips Keamanan
                        </h4>
                        <div class="flex items-center gap-2 text-[10px] text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Gunakan minimal 8 karakter
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Kombinasikan huruf, angka & simbol
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-[var(--text-muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            Jangan gunakan password yang mudah ditebak
                        </div>
                    </div>

                    <button type="submit" class="btn-primary py-2 px-6 rounded-lg text-xs font-semibold flex items-center justify-center gap-2 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>

    </div>

    <div class="lg:col-span-5 xl:col-span-4 space-y-4 min-w-0">

        <div class="card p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] flex items-center justify-center mx-auto mb-3 text-[var(--text-secondary)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>

            <h3 class="text-sm font-bold text-[var(--text-primary)] mb-1">Status Akun Aktif</h3>
            <p class="text-[10px] text-[var(--text-muted)] mb-0.5">Bergabung sejak</p>
            <p class="text-xs font-semibold text-[var(--text-secondary)]">{{ $user->created_at->format('d M Y, H:i') }}</p>
        </div>

        <div class="text-center pt-1">
            <form method="POST" action="#" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun?');">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-1.5 text-xs text-[var(--text-muted)] hover:text-red-500 transition-colors py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    <span>Hapus Akun</span>
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
