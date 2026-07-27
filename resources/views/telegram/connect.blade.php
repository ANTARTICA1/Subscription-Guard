@extends('layouts.app')
@section('title', 'Telegram Bot')
@section('heading', 'Telegram Bot')
@section('subheading', 'Hubungkan akun untuk notifikasi pengingat otomatis')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="card">
        <div class="flex items-center gap-4 mb-6">
            <div class="icon-box text-2xl" style="background: rgba(124, 58, 237, 0.12);">✈️</div>
            <div>
                <h3 class="section-title">Status Koneksi</h3>
                <p class="section-desc">Integrasi notifikasi real-time via Telegram</p>
            </div>
        </div>

        @if($connection && $connection->isVerified())
        <div class="item-row mb-6" style="border-color: rgba(16, 185, 129, 0.3); background: var(--success-bg);">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
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
                <button type="submit" class="btn-primary text-xs">🚀 Uji Coba Notifikasi</button>
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
                <button type="submit" class="btn-secondary text-xs w-full justify-center">🔄 Generate Kode Baru</button>
            </form>
        </div>
        @endif
    </div>

    <div class="card">
        <h3 class="section-title mb-5">📋 History Notifikasi</h3>
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
