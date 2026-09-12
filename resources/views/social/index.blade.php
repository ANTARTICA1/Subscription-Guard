@extends('layouts.app')
@section('title', 'Daftar Teman')

@section('content')

<div class="space-y-6 pb-12">

    <div class="card p-6 flex items-center justify-between">
        <div class="flex items-center gap-3.5">
            <div class="text-emerald-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[var(--text-primary)] tracking-tight">Daftar Teman & Hubungan</h2>
                <p class="text-xs text-[var(--text-muted)] mt-0.5">Temukan teman dan bagikan tagihan subscription bersama</p>
            </div>
        </div>

        <div class="hidden sm:flex items-center gap-2 p-2.5 px-4 rounded-xl bg-[var(--bg-elevated)] border border-[var(--border-color)]">
            <span class="text-xs text-[var(--text-muted)]">User Tag Anda:</span>
            <span class="font-mono text-xs font-bold text-emerald-500">{{ $user->user_tag }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 min-w-0">

        <div class="lg:col-span-12 xl:col-span-4 space-y-6 min-w-0">
            <div class="card p-6">
                <h3 class="font-bold text-[var(--text-primary)] mb-1 text-base">Cari Teman dengan User Tag</h3>
                <p class="text-xs text-[var(--text-muted)] mb-5">Minta tag unik dari temanmu untuk menambahkannya.</p>

                <form method="POST" action="{{ route('social.add') }}">
                    @csrf
                    <div class="relative flex items-center mb-4">
                        <div class="absolute left-3.5 text-[var(--text-muted)] font-mono text-sm">@</div>
                        <input type="text" name="user_tag" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl pl-9 pr-4 py-2.5 text-[var(--text-primary)] text-xs focus:outline-none focus:border-emerald-500 transition-colors placeholder-[var(--text-muted)]" placeholder="Masukkan User Tag (contoh: TAG-A1B2C3)" required>
                    </div>
                    <button type="submit" class="btn-primary w-full py-2.5 px-4 rounded-xl text-xs font-bold flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari & Tambahkan
                    </button>
                </form>
            </div>

            <div class="card p-5 space-y-3">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h4 class="font-bold text-xs text-[var(--text-primary)]">Informasi User Tag</h4>
                </div>
                <p class="text-xs text-[var(--text-muted)] leading-relaxed">
                    Setiap akun memiliki User Tag unik. Bagikan tag Anda kepada teman agar mereka dapat menambahkan Anda ke dalam grup patungan.
                </p>
                <div class="pt-2 border-t border-[var(--border-color)] flex items-center justify-between">
                    <span class="text-xs font-semibold text-[var(--text-secondary)]">Tag Anda:</span>
                    <span class="text-xs font-mono font-bold text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded-lg">{{ $user->user_tag }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-6 xl:col-span-4 card p-0 flex flex-col overflow-hidden min-w-0">
            <div class="p-4 px-5 border-b border-[var(--border-color)] flex items-center justify-between">
                <h3 class="font-bold text-sm text-[var(--text-primary)]">Teman Tersedia</h3>
                <span class="text-xs text-[var(--text-muted)]">{{ $suggestedFriends->count() }} disarankan</span>
            </div>

            <div class="flex-1 overflow-y-auto max-h-[420px] divide-y divide-[var(--border-color)]/60">
                @forelse($suggestedFriends as $suggested)
                <div class="flex items-center justify-between py-3 px-5 hover:bg-[var(--bg-elevated)]/50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <div class="w-9 h-9 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($suggested->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-[var(--text-primary)] truncate">{{ $suggested->name }}</p>
                            <p class="text-[10px] text-emerald-500 font-mono tracking-wide">{{ $suggested->user_tag }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('social.add') }}">
                        @csrf
                        <input type="hidden" name="user_tag" value="{{ $suggested->user_tag }}">
                        <button type="submit" class="w-8 h-8 rounded-lg text-[var(--text-muted)] hover:text-emerald-500 hover:bg-emerald-500/10 flex items-center justify-center transition-colors cursor-pointer" title="Tambah">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-[var(--text-muted)] py-8 px-4">
                    <p class="text-xs">Tidak ada sugesti teman saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-6 xl:col-span-4 card p-0 flex flex-col overflow-hidden min-w-0">
            <div class="p-4 px-5 border-b border-[var(--border-color)] flex items-center justify-between">
                <h3 class="font-bold text-sm text-[var(--text-primary)] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Teman Terhubung ({{ $friends->count() }})
                </h3>
            </div>

            <div class="flex-1 overflow-y-auto max-h-[420px] divide-y divide-[var(--border-color)]/60">
                @forelse($friends as $friend)
                <div class="flex items-center justify-between py-3 px-5 hover:bg-[var(--bg-elevated)]/50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0 flex-1">
                        <div class="w-9 h-9 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($friend->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold text-[var(--text-primary)] truncate">{{ $friend->name }}</p>
                            <p class="text-[10px] text-emerald-500 font-mono tracking-wide">{{ $friend->user_tag }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('social.remove', $friend->id) }}" onsubmit="return confirm('Hapus teman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg text-[var(--text-muted)] hover:text-red-500 hover:bg-red-500/10 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Teman">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="p-8 text-center text-[var(--text-muted)]">
                    <p class="text-xs font-bold text-[var(--text-primary)] mb-1">Belum ada teman terhubung</p>
                    <p class="text-[11px]">Tambahkan teman menggunakan User Tag untuk mulai berbagi tagihan.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection
