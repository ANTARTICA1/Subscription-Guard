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
    <!-- Status Koneksi -->
    <div class="card shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[var(--border-color)]">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-sky-500/10 text-sky-500 flex items-center justify-center flex-shrink-0">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="section-title text-[var(--text-primary)] mb-0">Telegram Bot</h3>
                    <p class="text-xs text-[var(--text-muted)] mt-1">Integrasi notifikasi pengingat otomatis via Telegram</p>
                </div>
            </div>

            @if($connection && $connection->isVerified())
            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                <form method="POST" action="{{ route('telegram.test-notification') }}">@csrf
                    <button type="submit" class="btn-primary text-xs cursor-pointer shadow-sm">
                        Uji Coba Notifikasi
                    </button>
                </form>
                <form method="POST" action="{{ route('telegram.disconnect') }}">@csrf @method('DELETE')
                    <button type="submit" class="btn-danger text-xs hover:bg-red-500 hover:text-white cursor-pointer" onclick="return confirm('Putuskan koneksi bot Telegram?')">Putuskan</button>
                </form>
            </div>
            @endif
        </div>

        @if($connection && $connection->isVerified())
        <div class="pt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="text-xs font-medium text-[var(--text-muted)] block">Telegram Chat ID</span>
                    <span class="text-sm font-bold font-mono text-[var(--text-primary)] mt-1 block">{{ $connection->chat_id }}</span>
                </div>
                <div>
                    <span class="text-xs font-medium text-[var(--text-muted)] block">Terverifikasi Sejak</span>
                    <span class="text-sm font-semibold text-[var(--text-primary)] mt-1 block">{{ $connection->verified_at->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
            </div>
        </div>
        @else
        <div class="pt-6 space-y-6">
            <div>
                <h4 class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-4">Panduan Menghubungkan:</h4>
                <ol class="space-y-4 text-xs text-[var(--text-secondary)]">
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] text-[10px] font-semibold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                        <span class="leading-relaxed">Buka Telegram dan cari Bot: <a href="https://t.me/TataReminderBot" target="_blank" rel="noopener noreferrer" class="font-bold text-[var(--text-primary)] hover:underline inline-flex items-center gap-1">@TataReminderBot <svg class="w-3 h-3 inline opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] text-[10px] font-semibold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                        <span class="leading-relaxed">Ketik pesan <code class="font-mono font-semibold px-1.5 py-0.5 rounded bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-primary)]">/start</code> lalu kirimkan (atau tekan tombol Start jika ada)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] text-[10px] font-semibold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                        <span class="leading-relaxed">Kirimkan kode verifikasi di bawah ini ke bot untuk menghubungkan akun:</span>
                    </li>
                </ol>
            </div>

            <div class="py-6 border-y border-[var(--border-color)] flex flex-col items-center justify-center text-center">
                <p class="text-[11px] mb-3 font-bold text-[var(--text-muted)] uppercase tracking-wider">Kode Verifikasi Anda</p>
                
                <div class="inline-flex items-center gap-3 px-6 py-2.5 rounded-2xl border border-[var(--border-color)] bg-[var(--bg-elevated)] transition-all">
                    <span class="text-2xl sm:text-3xl font-mono font-extrabold tracking-widest text-[var(--text-primary)] select-all">
                        {{ $connection->verification_code ?? 'TATAGIH-XXXXXX' }}
                    </span>
                    <button type="button" @click="copyText('{{ $connection->verification_code ?? '' }}', 'code')" title="Salin Kode" class="p-1.5 rounded-lg text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-all cursor-pointer flex items-center justify-center" aria-label="Salin Kode">
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
                    <button type="button" @click="copyText('/connect {{ $connection->verification_code ?? '' }}', 'cmd')" title="Klik untuk salin perintah" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl font-mono text-xs font-semibold border border-[var(--border-color)] hover:border-[var(--text-muted)] text-[var(--text-secondary)] bg-[var(--bg-elevated)] transition-all cursor-pointer group" aria-label="Salin Perintah">
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

            <div class="pt-6 border-t border-[var(--border-color)]">
                <h4 class="text-xs font-bold text-[var(--text-primary)] mb-1">Hubungkan Langsung dengan Chat ID</h4>
                <p class="text-[11px] text-[var(--text-muted)] mb-3 leading-relaxed">
                    Anda bisa langsung memasukkan <strong>Telegram Chat ID</strong> Anda:
                </p>
                <form method="POST" action="{{ route('telegram.manual-connect') }}" class="flex flex-col sm:flex-row gap-2.5">
                    @csrf
                    <div class="relative flex-1">
                        <input type="text" name="chat_id" placeholder="Contoh: 123456789" value="{{ old('chat_id', Auth::user()->telegram_chat_id) }}" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl px-3.5 py-2 text-xs text-[var(--text-primary)] font-mono focus:outline-none focus:border-sky-500 transition-colors" required>
                    </div>
                    <button type="submit" class="btn-primary text-xs flex items-center justify-center gap-1.5 whitespace-nowrap cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Hubungkan Sekarang
                    </button>
                </form>
                <div class="mt-2.5 flex items-center gap-1.5 text-[10px] text-[var(--text-muted)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 opacity-70 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Belum tahu Chat ID Anda? Cari bot <a href="https://t.me/userinfobot" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-500 hover:underline">@userinfobot</a> di Telegram lalu ketik <code>/start</code>.</span>
                </div>
            </div>

            <div class="flex items-center justify-center pt-1">
                <form method="POST" action="{{ route('telegram.regenerate') }}" class="m-0">@csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-all cursor-pointer group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        <span>Generate Kode Baru</span>
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <!-- History Notifikasi -->
    <div class="card shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-[var(--border-color)]">
            <h3 class="section-title text-[var(--text-primary)] flex items-center gap-2 mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                History Notifikasi
            </h3>
            <div class="md:hidden flex items-center gap-1 text-[10px] text-[var(--text-muted)] italic">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                <span>Geser tabel</span>
            </div>
        </div>
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[500px] whitespace-nowrap text-left border-collapse">
                <thead>
                    <tr class="border-b border-[var(--border-color)]">
                        <th class="py-3 px-2 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider">Subscription</th>
                        <th class="py-3 px-2 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider">Tipe</th>
                        <th class="py-3 px-2 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider">Status</th>
                        <th class="py-3 px-2 text-[10px] font-extrabold text-[var(--text-muted)] uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]">
                    @forelse($notifications as $notif)
                    <tr class="hover:bg-[var(--bg-elevated)]/50 transition-colors">
                        <td class="py-3.5 px-2 font-semibold text-xs text-[var(--text-primary)]">{{ $notif->subscription->name ?? 'System' }}</td>
                        <td class="py-3.5 px-2 text-xs text-[var(--text-secondary)] font-medium">{{ $notif->type }}</td>
                        <td class="py-3.5 px-2 text-xs font-medium {{ $notif->status === 'sent' ? 'text-emerald-500' : ($notif->status === 'pending' ? 'text-amber-500' : 'text-red-500') }}">{{ strtoupper($notif->status) }}</td>
                        <td class="py-3.5 px-2 text-[var(--text-muted)] text-xs">{{ $notif->created_at->translatedFormat('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-8 text-xs text-[var(--text-muted)]">Belum ada riwayat notifikasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
