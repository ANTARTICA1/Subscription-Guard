@extends('layouts.app')
@section('title', 'Telegram Bot')
@section('heading', 'Telegram Bot')
@section('subheading', 'Hubungkan akun untuk notifikasi pengingat otomatis')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="card">
        <div class="flex items-center gap-4 mb-6">
            <div class="icon-box text-2xl" style="background: rgba(124, 58, 237, 0.12);"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>️</div>
            <div>
                <h3 class="section-title">Status Koneksi</h3>
                <p class="section-desc">Integrasi notifikasi real-time via Telegram</p>
            </div>
        </div>

        @if($connection && $connection->isVerified())
        <div class="item-row mb-6" style="border-color: rgba(16, 185, 129, 0.3); background: var(--success-bg);">
            <div class="flex items-center gap-3">
                <span class="text-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></span>
                <div>
                    <p class="font-bold text-sm" style="color: var(--success);">Terhubung!</p>
                    <p class="text-xs" style="color: var(--text-muted);">Chat ID: {{ $connection->chat_id }}</p>
                    <p class="text-xs" style="color: var(--text-muted);">Verified: {{ $connection->verified_at->translatedFormat('d M Y H:i') }}</p>
                </div>
            </div>
            <span class="badge badge-active">TERKONEKSI</span>
        </div>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('telegram.test-notification') }}">@csrf
                <button type="submit" class="btn-primary text-xs"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Uji Coba Notifikasi</button>
            </form>
            <form method="POST" action="{{ route('telegram.disconnect') }}">@csrf @method('DELETE')
                <button type="submit" class="btn-danger text-xs" onclick="return confirm('Putuskan koneksi?')">Putuskan</button>
            </form>
        </div>
        @else
        <div class="space-y-6">
            <div class="p-5 rounded-xl" style="background: var(--bg-primary);">
                <h4 class="stat-label mb-4">Panduan Menghubungkan:</h4>
                <ol class="space-y-3 text-xs" style="color: var(--text-secondary);">
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white px-2.5 py-0.5 rounded-lg text-xs flex-shrink-0" style="background: var(--accent-primary);">1</span>
                        <span>Buka Telegram dan cari Bot: <strong>@TatagihBot</strong></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white px-2.5 py-0.5 rounded-lg text-xs flex-shrink-0" style="background: var(--accent-primary);">2</span>
                        <span>Tekan <strong>Start</strong> atau kirim <code>/start</code></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white px-2.5 py-0.5 rounded-lg text-xs flex-shrink-0" style="background: var(--accent-primary);">3</span>
                        <span>Kirim perintah verifikasi:</span>
                    </li>
                </ol>
            </div>

            <div class="text-center py-5 rounded-xl" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
                <p class="text-xs mb-2" style="color: var(--text-muted);">Kode Verifikasi:</p>
                <div class="inline-block px-6 py-3 rounded-xl text-xl font-mono font-extrabold tracking-widest" style="background: var(--bg-card); border: 2px solid var(--accent-primary); color: var(--accent-primary);">
                    {{ $connection->verification_code ?? 'TATAGIH-XXXXXX' }}
                </div>
                <p class="text-xs mt-3" style="color: var(--text-muted);">
                    Perintah: <code class="px-2 py-1 rounded font-mono font-bold" style="background: var(--bg-card); color: var(--accent-primary);">/connect {{ $connection->verification_code ?? 'KODE' }}</code>
                </p>
            </div>

            <form method="POST" action="{{ route('telegram.regenerate') }}">@csrf
                <button type="submit" class="btn-secondary text-xs w-full justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> Generate Kode Baru</button>
            </form>
        </div>
        @endif
    </div>

    <div class="card">
        <h3 class="section-title mb-5"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg> History Notifikasi</h3>
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Subscription</th><th>Tipe</th><th>Status</th><th>Waktu</th></tr></thead>
                <tbody>
                    @forelse($notifications as $notif)
                    <tr>
                        <td class="font-semibold" style="color: var(--text-primary);">{{ $notif->subscription->name ?? 'System' }}</td>
                        <td><span class="badge badge-accent">{{ $notif->type }}</span></td>
                        <td><span class="badge badge-{{ $notif->status === 'sent' ? 'active' : ($notif->status === 'pending' ? 'pending' : 'failed') }}">{{ strtoupper($notif->status) }}</span></td>
                        <td style="color: var(--text-muted);">{{ $notif->created_at->translatedFormat('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-6 text-xs" style="color: var(--text-muted);">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
