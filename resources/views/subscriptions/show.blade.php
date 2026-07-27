@extends('layouts.app')
@section('title', $subscription->name)
@section('heading', $subscription->name)
@section('subheading', ($subscription->category->icon ?? '📦') . ' ' . ($subscription->category->name ?? 'Kategori'))

@section('actions')
<div class="flex items-center gap-2">
    <form method="POST" action="{{ route('subscriptions.mark-paid', $subscription) }}">
        @csrf
        <button type="submit" class="btn-primary text-xs">⚡ Bayar</button>
    </form>
    <a href="{{ route('subscriptions.edit', $subscription) }}" class="btn-secondary text-xs">✏️ Edit</a>
    <form method="POST" action="{{ route('subscriptions.destroy', $subscription) }}" onsubmit="return confirm('Hapus subscription ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-danger text-xs">🗑️ Hapus</button>
    </form>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Detail Card --}}
        <div class="card">
            <h3 class="section-title mb-5">Detail Subscription</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                <div>
                    <p class="stat-label mb-1">Biaya Tagihan</p>
                    <p class="text-2xl font-extrabold" style="color: var(--text-primary);">{{ $subscription->formatted_amount }}</p>
                </div>
                <div>
                    <p class="stat-label mb-1">Siklus</p>
                    <p class="text-base font-bold" style="color: var(--text-primary);">{{ ucfirst($subscription->billing_cycle) }}</p>
                </div>
                <div>
                    <p class="stat-label mb-1">Jatuh Tempo</p>
                    <p class="font-bold text-sm" style="color: var(--text-primary);">{{ $subscription->next_payment_date->translatedFormat('d F Y') }}</p>
                    <p class="text-xs font-semibold" style="color: {{ $subscription->days_until_payment <= 3 ? 'var(--warning)' : 'var(--success)' }};">
                        {{ $subscription->days_until_payment }} hari lagi
                    </p>
                </div>
                <div>
                    <p class="stat-label mb-1">Status</p>
                    <span class="badge badge-{{ $subscription->status }}">{{ strtoupper($subscription->status) }}</span>
                </div>
                <div>
                    <p class="stat-label mb-1">Tanggal Mulai</p>
                    <p class="text-sm font-semibold" style="color: var(--text-secondary);">{{ $subscription->start_date->translatedFormat('d F Y') }}</p>
                </div>
                <div>
                    <p class="stat-label mb-1">Auto Renewal</p>
                    <p class="text-sm font-semibold" style="color: {{ $subscription->auto_renew ? 'var(--warning)' : 'var(--success)' }};">
                        {{ $subscription->auto_renew ? '⚠️ Aktif' : '✅ Manual' }}
                    </p>
                </div>
            </div>
            @if($subscription->description)
            <div class="mt-5 pt-5" style="border-top: 1px solid var(--border-color);">
                <p class="stat-label">Catatan</p>
                <p class="text-xs mt-1" style="color: var(--text-secondary);">{{ $subscription->description }}</p>
            </div>
            @endif
        </div>

        {{-- Payment History --}}
        <div class="card">
            <h3 class="section-title mb-2">📊 Riwayat Pembayaran</h3>
            <p class="section-desc mb-5">Histori transaksi untuk {{ $subscription->name }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div class="item-row justify-center text-center flex-col" style="min-height: 70px;">
                    <p class="stat-label">Total Terbayar</p>
                    <p class="text-lg font-extrabold" style="color: var(--text-primary);">
                        Rp{{ number_format($subscription->paymentHistories->where('status', 'paid')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="item-row justify-center text-center flex-col" style="min-height: 70px;">
                    <p class="stat-label">Frekuensi</p>
                    <p class="text-lg font-extrabold" style="color: var(--text-primary);">{{ $subscription->paymentHistories->count() }} Kali</p>
                </div>
                <div class="item-row justify-center text-center flex-col" style="min-height: 70px;">
                    <p class="stat-label">Rata-rata</p>
                    <p class="text-lg font-extrabold" style="color: var(--accent-primary);">Rp{{ number_format($subscription->amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscription->paymentHistories as $payment)
                        <tr>
                            <td class="font-semibold" style="color: var(--text-primary);">{{ $payment->payment_date->translatedFormat('d F Y') }}</td>
                            <td class="font-extrabold" style="color: var(--text-primary);">{{ $payment->formatted_amount }}</td>
                            <td><span class="badge badge-{{ $payment->status }}">{{ strtoupper($payment->status) }}</span></td>
                            <td style="color: var(--text-muted);">{{ $payment->note ?? 'Pembayaran rutin' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-xs" style="color: var(--text-muted);">Belum ada riwayat pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        @if($subscription->auto_renew)
        <div class="card" style="border-left: 3px solid var(--warning);">
            <div class="flex items-start gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <h4 class="font-bold text-xs uppercase" style="color: var(--warning);">Peringatan Auto-Renew</h4>
                    <p class="text-xs mt-1" style="color: var(--text-secondary);">
                        Layanan ini memperpanjang otomatis. Evaluasi berkala untuk mencegah kebocoran saldo.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="card">
            <h4 class="section-title mb-4">💰 Proyeksi Beban</h4>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between pb-2" style="border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-muted);">Per Bulan:</span>
                    <span class="font-bold text-sm" style="color: var(--text-primary);">Rp{{ number_format($subscription->monthly_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between pb-2" style="border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-muted);">12 Bulan:</span>
                    <span class="font-bold text-sm" style="color: var(--accent-primary);">Rp{{ number_format($subscription->monthly_amount * 12, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--text-muted);">3 Tahun:</span>
                    <span class="font-bold text-sm" style="color: var(--text-primary);">Rp{{ number_format($subscription->monthly_amount * 36, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h4 class="section-title">🤝 Patungan</h4>
                <a href="{{ route('shares.index') }}" class="btn-ghost text-xs">Kelola →</a>
            </div>
            <div class="space-y-2">
                @forelse($subscription->shares as $share)
                <div class="item-row text-xs">
                    <span class="font-semibold" style="color: var(--text-primary);">{{ $share->friend_name }}</span>
                    <span class="badge badge-{{ $share->payment_status === 'paid' ? 'active' : 'pending' }}">{{ strtoupper($share->payment_status) }}</span>
                </div>
                @empty
                <p class="text-xs text-center py-3" style="color: var(--text-muted);">Belum ada patungan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
