@extends('layouts.app')
@section('title', $subscription->name)
@section('heading', $subscription->name)
@section('subheading', ($subscription->category->icon ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>') . ' ' . ($subscription->category->name ?? 'Kategori'))

@section('actions')
<div class="flex items-center gap-2">
    <form method="POST" action="{{ route('subscriptions.mark-paid', $subscription) }}">
        @csrf
        <button type="submit" class="btn-primary text-xs"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Bayar</button>
    </form>
    <a href="{{ route('subscriptions.edit', $subscription) }}" class="btn-secondary text-xs"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>️ Edit</a>
    <form method="POST" action="{{ route('subscriptions.destroy', $subscription) }}" onsubmit="return confirm('Hapus subscription ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-danger text-xs"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>️ Hapus</button>
    </form>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        
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
                    <p class="text-sm font-semibold" style="color: {{ $subscription->status !== 'active' ? 'var(--text-muted)' : ($subscription->auto_renew ? 'var(--success)' : 'var(--text-muted)') }};">
                        {!! $subscription->status !== 'active' ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Di-Pause' : ($subscription->auto_renew ? 'Aktif' : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Manual') !!}
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

        
        <div class="card">
            <h3 class="section-title mb-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Riwayat Pembayaran</h3>
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

    
    <div class="space-y-6">
        @if($subscription->auto_renew && $subscription->status === 'active')
        <div class="card" style="border-left: 3px solid var(--warning);">
            <div class="flex items-start gap-3">
                <span class="text-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></span>
                <div>
                    <h4 class="font-bold text-xs uppercase" style="color: var(--warning);">Info Auto-Renew</h4>
                    <p class="text-xs mt-1" style="color: var(--text-secondary);">
                        Layanan ini memperpanjang otomatis. Pastikan saldo Anda mencukupi untuk tagihan berikutnya.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="card">
            <h4 class="section-title mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Proyeksi Beban</h4>
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
                <h4 class="section-title"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg> Patungan</h4>
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
