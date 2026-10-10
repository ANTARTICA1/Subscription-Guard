@extends('layouts.app')
@section('title', 'Daftar Teman')

@section('content')

<div class="space-y-6 pb-12">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-[var(--text-primary)] tracking-tight">Daftar Teman & Hubungan</h1>
            <p class="text-xs text-[var(--text-muted)] mt-0.5">Temukan teman dan bagikan tagihan subscription bersama</p>
        </div>

        <div x-data="{ copied: false }" class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-xl bg-[var(--bg-card)] border border-[var(--border-color)] shadow-sm self-start sm:self-auto">
            <span class="text-xs text-[var(--text-muted)] font-medium">Tag Anda:</span>
            <code class="font-mono text-xs font-bold text-[var(--text-primary)] px-2 py-0.5 rounded-lg bg-[var(--bg-elevated)] border border-[var(--border-color)] tracking-wide">{{ $user->user_tag }}</code>
            <button type="button" 
                    @click="navigator.clipboard.writeText('{{ $user->user_tag }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                    class="p-1 rounded-md text-[var(--text-muted)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] transition-colors cursor-pointer inline-flex items-center gap-1" 
                    :title="copied ? 'Tersalin!' : 'Salin Tag'">
                <template x-if="!copied">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                </template>
                <template x-if="copied">
                    <span class="text-[10px] font-bold text-emerald-500">Tersalin!</span>
                </template>
            </button>
        </div>
    </div>

    @if(isset($pendingRequests) && $pendingRequests->isNotEmpty())
    <div class="rounded-xl border border-amber-500/20 bg-amber-500/5 p-4 flex flex-col gap-3">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            <h4 class="text-xs font-bold text-[var(--text-primary)]">Permintaan Pertemanan Masuk ({{ $pendingRequests->count() }})</h4>
        </div>
        <div class="divide-y divide-[var(--border-color)]/40">
            @foreach($pendingRequests as $req)
            <div class="flex items-center justify-between py-2.5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] font-semibold text-xs flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($req->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-[var(--text-primary)]">{{ $req->user->name }}</p>
                        <p class="text-[11px] text-[var(--text-muted)] font-mono">{{ $req->user->user_tag }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('social.accept', $req->id) }}">
                    @csrf
                    <button type="submit" class="btn-primary px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm cursor-pointer">
                        Terima
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl shadow-sm overflow-hidden">
        <div class="p-3.5 sm:p-4 border-b border-[var(--border-color)] bg-[var(--bg-card)]">
            <form method="POST" action="{{ route('social.add') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                @csrf
                <div class="relative flex-1">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)] font-mono text-xs">@</span>
                    <input type="text" 
                           name="user_tag" 
                           class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg pl-8 pr-4 py-2 text-xs text-[var(--text-primary)] placeholder-[var(--text-muted)] focus:outline-none focus:border-slate-400 dark:focus:border-slate-500 transition-colors font-medium" 
                           placeholder="Masukkan User Tag teman (contoh: TAG-A1B2C3)" 
                           required>
                </div>
                <button type="submit" class="btn-primary py-2 px-4 rounded-lg text-xs font-semibold flex items-center justify-center gap-1.5 shrink-0 cursor-pointer shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    <span>Tambah Teman</span>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-[var(--border-color)]">
            <div class="lg:col-span-7 flex flex-col min-w-0">
                <div class="p-3.5 px-5 border-b border-[var(--border-color)] flex items-center justify-between bg-[var(--bg-card)]">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-xs sm:text-sm text-[var(--text-primary)]">Teman Terhubung</h3>
                        <span class="px-2 py-0.5 rounded-full bg-[var(--bg-elevated)] text-[var(--text-muted)] text-[10px] font-semibold">{{ $friends->count() }}</span>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto max-h-[460px] divide-y divide-[var(--border-color)]/50">
                    @forelse($friends as $friend)
                    <div class="flex items-center justify-between py-3 px-5 hover:bg-[var(--bg-elevated)]/40 transition-colors">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-8 h-8 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] font-semibold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($friend->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-[var(--text-primary)] truncate">{{ $friend->name }}</p>
                                <p class="text-[11px] text-[var(--text-muted)] font-mono mt-0.5">{{ $friend->user_tag }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('social.remove', $friend->id) }}" onsubmit="return confirm('Hapus {{ $friend->name }} dari daftar teman?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-[var(--text-muted)] hover:text-red-500 hover:bg-red-500/10 transition-colors cursor-pointer" title="Hapus Teman">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                        <div class="w-10 h-10 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] flex items-center justify-center text-[var(--text-muted)] mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <p class="text-xs font-semibold text-[var(--text-primary)]">Belum ada teman terhubung</p>
                        <p class="text-[11px] text-[var(--text-muted)] mt-1 max-w-xs">Tambahkan teman menggunakan User Tag di atas atau pilih dari daftar saran.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col min-w-0 bg-[var(--bg-elevated)]/20">
                <div class="p-3.5 px-5 border-b border-[var(--border-color)] flex items-center justify-between bg-[var(--bg-card)]">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-xs sm:text-sm text-[var(--text-primary)]">Saran Teman</h3>
                        <span class="px-2 py-0.5 rounded-full bg-[var(--bg-elevated)] text-[var(--text-muted)] text-[10px] font-semibold">{{ $suggestedFriends->count() }}</span>
                    </div>
                    <span class="text-[11px] text-[var(--text-muted)]">Rekomendasi</span>
                </div>

                <div class="flex-1 overflow-y-auto max-h-[460px] divide-y divide-[var(--border-color)]/50">
                    @forelse($suggestedFriends as $suggested)
                    <div class="flex items-center justify-between py-3 px-5 hover:bg-[var(--bg-card)]/60 transition-colors">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="w-8 h-8 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] font-semibold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($suggested->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-[var(--text-primary)] truncate">{{ $suggested->name }}</p>
                                <p class="text-[11px] text-[var(--text-muted)] font-mono mt-0.5">{{ $suggested->user_tag }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('social.add') }}">
                            @csrf
                            <input type="hidden" name="user_tag" value="{{ $suggested->user_tag }}">
                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-[var(--text-secondary)] hover:text-[var(--text-primary)] bg-[var(--bg-card)] hover:bg-[var(--bg-elevated)] border border-[var(--border-color)] transition-colors cursor-pointer" title="Tambah Teman">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                                <span>Tambah</span>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                        <p class="text-xs text-[var(--text-muted)]">Tidak ada saran teman saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
