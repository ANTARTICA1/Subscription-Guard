@extends('layouts.app')
@section('title', 'Profil')
@section('heading', 'Profil')
@section('subheading', 'Kelola informasi akun Anda')

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="card">
        <h3 class="section-title mb-5 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            Informasi Profil
        </h3>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="flex items-center gap-4 mb-6">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="object-cover" style="width: 64px; height: 64px; border-radius: 20px; border: 2px solid var(--accent-primary);">
                @else
                    <div class="sidebar-user-avatar" style="width: 64px; height: 64px; font-size: 1.5rem; border-radius: 20px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <label class="btn-secondary cursor-pointer text-sm inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Upload Avatar
                        <input type="file" name="avatar" class="hidden" accept="image/*">
                    </label>
                    <p class="text-xs mt-1" style="color: var(--text-muted);">JPG, PNG, WebP. Maks 2MB.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                </div>
            </div>
            <div class="mt-4">
                <label class="form-label flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0088cc]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/></svg>
                    Telegram Chat ID
                </label>
                <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id', $user->telegram_chat_id) }}" class="form-input" placeholder="Contoh: 123456789">
                <p class="text-xs mt-2" style="color: var(--text-muted);">
                    Chat ID digunakan untuk menerima tagihan patungan (Split Bill) secara otomatis via Telegram. 
                    <br><strong>Cara mengetahui Chat ID:</strong> Cari bot <a href="https://t.me/userinfobot" target="_blank" class="text-blue-500 hover:underline">@userinfobot</a> di Telegram, klik Start, lalu salin angka `Id` yang diberikan.
                </p>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Profil</button>
            </div>
        </form>

        @if($user->telegram_chat_id)
        <div class="mt-4 pt-4 border-t border-[var(--border-color)]">
            <form method="POST" action="{{ route('telegram.test-notification') }}">
                @csrf
                <button type="submit" class="w-full bg-[#0088cc] hover:bg-[#0077b3] text-white font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/></svg>
                    Kirim Pesan Uji Coba (Test Bot)
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="card">
        <h3 class="section-title mb-5 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            Ubah Password
        </h3>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-input" required>
                    @error('current_password')
                    <p class="text-xs mt-1" style="color: var(--danger);">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>
            <button type="submit" class="btn-primary mt-6">Ubah Password</button>
        </form>
    </div>
</div>
@endsection
