@extends('layouts.app')
@section('title', 'Telegram Bot')
@section('heading', 'Telegram Bot')
@section('subheading', 'Hubungkan akun untuk notifikasi pengingat otomatis')

@section('content')
<div class="max-w-3xl space-y-6" x-data="{
    copyFeedback: {},
    copyText(text, key) {
        if (!text) return;
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text);
        } else {
            const ta = document.createElement('textarea');
            ta.value = text;
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); } catch(e) {}
            document.body.removeChild(ta);
        }
        this.copyFeedback[key] = true;
        setTimeout(() => { this.copyFeedback[key] = false; }, 1800);
    }
}">
    <div class="card shadow-sm">
        <div class="flex items-center gap-3.5 pb-6 border-b border-[var(--border-color)]">
            <div class="text-[#229ED9] flex-shrink-0">
                <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/>
                </svg>
            </div>
            <div>
                <h3 class="section-title text-[var(--text-primary)] mb-0.5">Status Koneksi</h3>
                <p class="text-xs text-[var(--text-muted)]">Integrasi notifikasi real-time via Telegram Bot</p>
            </div>
        </div>

        @if($connection && $connection->isVerified())
        <div class="pt-6">
            <div class="item-row mb-6 border-emerald-500/30 bg-emerald-500/10 p-4 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-500 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    </span>
                    <div>
                        <p class="font-bold text-sm text-emerald-600 dark:text-emerald-400">Terhubung ke Telegram!</p>
                        <p class="text-xs text-[var(--text-muted)]">Chat ID: <span class="font-mono font-semibold">{{ $connection->chat_id }}</span></p>
                        <p class="text-[11px] text-[var(--text-muted)] opacity-80">Terverifikasi: {{ $connection->verified_at->translatedFormat('d M Y H:i') }}</p>
                    </div>
                </div>
                <span class="badge badge-active font-bold">TERKONEKSI</span>
            </div>
            <div class="flex flex-wrap gap-3">
                <form method="POST" action="{{ route('telegram.test-notification') }}">@csrf
                    <button type="submit" class="btn-primary text-xs flex items-center gap-2 cursor-pointer shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Uji Coba Notifikasi
                    </button>
                </form>
                <form method="POST" action="{{ route('telegram.disconnect') }}">@csrf @method('DELETE')
                    <button type="submit" class="btn-danger text-xs hover:bg-red-500 hover:text-white cursor-pointer" onclick="return confirm('Putuskan koneksi bot Telegram?')">Putuskan</button>
                </form>
            </div>
        </div>
        @else
        <div class="pt-6 space-y-6">
            <div>
                <h4 class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-4">Panduan Menghubungkan:</h4>
                <ol class="space-y-4 text-xs text-[var(--text-secondary)]">
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center flex-shrink-0 bg-emerald-500 shadow-xs mt-0.5">1</span>
                        <span class="leading-relaxed">Buka Telegram dan cari Bot: <a href="https://t.me/TataReminderBot" target="_blank" rel="noopener noreferrer" class="font-bold text-emerald-600 dark:text-emerald-400 underline underline-offset-4 decoration-emerald-500/70 hover:decoration-emerald-500 transition-colors inline-flex items-center gap-1">@TataReminderBot <svg class="w-3 h-3 inline opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center flex-shrink-0 bg-emerald-500 shadow-xs mt-0.5">2</span>
                        <span class="leading-relaxed">Ketik pesan <code class="font-mono font-bold text-emerald-600 dark:text-emerald-400 underline underline-offset-4 decoration-emerald-500/70">/start</code> lalu kirimkan (atau tekan tombol Start jika ada)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white w-5 h-5 rounded-full text-[10px] flex items-center justify-center flex-shrink-0 bg-emerald-500 shadow-xs mt-0.5">3</span>
                        <span class="leading-relaxed">Kirimkan kode verifikasi di bawah ini ke bot untuk menghubungkan akun:</span>
                    </li>
                </ol>
            </div>

            <div class="py-6 border-y border-[var(--border-color)] flex flex-col items-center justify-center text-center">
                <p class="text-[11px] mb-3 font-bold text-[var(--text-muted)] uppercase tracking-wider">Kode Verifikasi Anda</p>
                
                <div class="inline-flex items-center gap-3 px-6 py-2.5 rounded-2xl border-2 border-emerald-500/40 hover:border-emerald-500/70 transition-all bg-transparent">
                    <span class="text-2xl sm:text-3xl font-mono font-extrabold tracking-widest text-emerald-600 dark:text-emerald-400 select-all">
                        {{ $connection->verification_code ?? 'TATAGIH-XXXXXX' }}
                    </span>
                    <button type="button" @click="copyText('{{ $connection->verification_code ?? '' }}', 'code')" title="Salin Kode" class="p-1.5 rounded-lg text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 transition-all cursor-pointer flex items-center justify-center" aria-label="Salin Kode">
                        <template x-if="!copyFeedback.code">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        </template>
                        <template x-if="copyFeedback.code">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </template>
                    </button>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                    <span class="text-xs text-[var(--text-muted)]">Perintah siap kirim:</span>
                    <button type="button" @click="copyText('/connect {{ $connection->verification_code ?? '' }}', 'cmd')" title="Klik untuk salin perintah" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl font-mono text-xs font-bold border border-[var(--border-color)] hover:border-emerald-500/40 text-emerald-600 dark:text-emerald-400 bg-transparent transition-all cursor-pointer group" aria-label="Salin Perintah">
                        <code>/connect {{ $connection->verification_code ?? 'KODE' }}</code>
                        <template x-if="!copyFeedback.cmd">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 opacity-60 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        </template>
                        <template x-if="copyFeedback.cmd">
                            <span class="text-[10px] font-sans font-bold text-emerald-500">Disalin!</span>
                        </template>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-center pt-1">
                <form method="POST" action="{{ route('telegram.regenerate') }}" class="m-0">@csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-[var(--text-muted)] hover:text-emerald-600 dark:hover:text-emerald-400 transition-all cursor-pointer group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        <span>Generate Kode Baru</span>
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <h3 class="section-title text-[var(--text-primary)] flex items-center gap-2 mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                History Notifikasi
            </h3>
            <div class="md:hidden flex items-center gap-1 text-[10px] text-[var(--text-muted)] italic">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                <span>Geser tabel</span>
            </div>
        </div>
        <div class="overflow-x-auto w-full rounded-xl border border-[var(--border-color)]">
            <table class="modern-table w-full min-w-[500px] whitespace-nowrap">
                <thead>
                    <tr>
                        <th>Subscription</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notif)
                    <tr class="hover:bg-[var(--bg-elevated)] transition-colors">
                        <td class="font-semibold text-[var(--text-primary)]">{{ $notif->subscription->name ?? 'System' }}</td>
                        <td><span class="badge badge-accent">{{ $notif->type }}</span></td>
                        <td><span class="badge badge-{{ $notif->status === 'sent' ? 'active' : ($notif->status === 'pending' ? 'pending' : 'danger') }}">{{ strtoupper($notif->status) }}</span></td>
                        <td class="text-[var(--text-muted)] text-xs">{{ $notif->created_at->translatedFormat('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-6 text-xs text-[var(--text-muted)]">Belum ada riwayat notifikasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
