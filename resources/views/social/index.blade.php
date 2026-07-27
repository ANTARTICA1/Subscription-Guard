@extends('layouts.app')
@section('title', 'Teman & User Tag')
@section('heading', 'Teman & User Tag')
@section('subheading', 'Tambahkan teman menggunakan User Tag untuk berbagi tagihan')

@section('content')
<div class="max-w-4xl space-y-6">
    
    <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] border-l-4 border-l-[var(--accent-primary)] shadow-sm rounded-xl p-5" x-data="{ copied: false, showQrModal: false }">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-1">User Tag Unik Anda:</p>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-2xl font-mono font-extrabold text-[var(--text-primary)] bg-[var(--bg-elevated)] border border-[var(--border-color)] px-3 py-1 rounded-lg">{{ $user->user_tag }}</span>
                    <button type="button" @click="navigator.clipboard.writeText('{{ $user->user_tag }}'); copied = true; setTimeout(() => copied = false, 2000)" class="bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-colors text-xs py-2 px-4 rounded-lg font-bold flex items-center gap-2">
                        <template x-if="copied">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </template>
                        <template x-if="!copied">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                        </template>
                        <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                    </button>
                </div>
                <p class="text-xs mt-3 text-[var(--text-muted)]">Berikan Tag ini ke teman Anda agar mereka bisa menambahkan Anda.</p>
            </div>
            <div class="flex flex-col items-center gap-2">
                <button @click="showQrModal = true" class="w-12 h-12 rounded-lg bg-[var(--accent-primary)]/10 text-[var(--accent-primary)] hover:bg-[var(--accent-primary)]/20 transition-colors flex items-center justify-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                </button>
                <span class="text-[10px] font-bold text-[var(--accent-primary)]">Tampilkan QR</span>
            </div>
        </div>

        
        <div x-show="showQrModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" @click.away="showQrModal = false">
            <div class="bg-[var(--bg-secondary)] p-8 rounded-2xl max-w-sm w-full border border-[var(--border-color)] text-center shadow-xl">
                <h4 class="text-xl font-bold text-[var(--text-primary)] mb-2">QR Code Saya</h4>
                <p class="text-sm text-[var(--text-muted)] mb-6">Suruh temanmu scan QR ini untuk menambahkanmu sebagai teman.</p>
                <div class="p-4 bg-white rounded-xl inline-block mb-6 shadow-sm border border-slate-200">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('social.add-by-tag', $user->user_tag)) }}" alt="QR Code Profile" class="w-48 h-48 mx-auto rounded-lg">
                </div>
                <button @click="showQrModal = false" class="w-full bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] font-bold py-3 rounded-xl hover:bg-[var(--bg-primary)] transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] shadow-sm rounded-xl p-5">
            <h3 class="text-sm font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-3 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Teman
            </h3>
            <form method="POST" action="{{ route('social.add') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">User Tag Teman</label>
                        <input type="text" name="user_tag" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-lg px-3 py-2 text-[var(--text-primary)] font-mono font-bold focus:ring-2 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)]" placeholder="TAG-A1B2C3" required>
                    </div>
                    <button type="submit" class="w-full bg-[var(--accent-primary)] hover:bg-[var(--accent-secondary)] text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari & Tambahkan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] shadow-sm rounded-xl p-5">
            <h3 class="text-sm font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-3 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Permintaan Pertemanan
            </h3>
            <div class="space-y-3">
                @forelse($pendingRequests as $req)
                <div class="flex items-center justify-between p-3 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-color)]">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-light)] flex items-center justify-center text-[var(--text-primary)] font-bold text-xs">
                            {{ strtoupper(substr($req->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-[var(--text-primary)]">{{ $req->user->name }}</p>
                            <p class="text-[10px] font-mono text-[var(--text-muted)]">{{ $req->user->user_tag }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('social.accept', $req->id) }}">
                        @csrf
                        <button type="submit" class="bg-[var(--accent-primary)] hover:bg-[var(--accent-secondary)] text-white text-xs font-bold py-1.5 px-3 rounded-md transition-colors">Terima</button>
                    </form>
                </div>
                @empty
                <p class="text-xs text-center py-6 text-[var(--text-muted)]">Belum ada permintaan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] shadow-sm rounded-xl p-5">
        <h3 class="text-sm font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-3 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            Teman Terhubung ({{ $friends->count() }})
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @forelse($friends as $friend)
            <div class="flex items-center justify-between p-3 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-color)]">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-light)] flex items-center justify-center text-[var(--text-primary)] font-bold text-xs">
                        {{ strtoupper(substr($friend->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[var(--text-primary)]">{{ $friend->name }}</p>
                        <p class="text-[10px] font-mono text-[var(--accent-primary)]">{{ $friend->user_tag }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('social.remove', $friend->id) }}" onsubmit="return confirm('Hapus teman?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 text-[var(--text-muted)] hover:text-red-400 hover:bg-red-400/10 rounded-md transition-colors" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="col-span-full border border-dashed border-[var(--border-color)] rounded-xl py-8 text-center bg-[var(--bg-primary)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-[var(--text-muted)] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <p class="text-[var(--text-muted)] text-sm">Belum ada teman. Bagikan Tag <strong>{{ $user->user_tag }}</strong>!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
