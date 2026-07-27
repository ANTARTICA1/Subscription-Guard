@extends('layouts.app')
@section('title', 'Riwayat Pembayaran')
@section('heading', 'Riwayat Pembayaran')
@section('subheading', 'Catatan realisasi transaksi pembayaran subscription Anda')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="stat-card">
        <span class="stat-label">Total Realisasi</span>
        <p class="stat-value" style="font-size: 1.5rem;">Rp{{ number_format($totalPaid, 0, ',', '.') }}</p>
        <p class="stat-sub">Total pengeluaran terverifikasi</p>
    </div>
    <div class="stat-card">
        <span class="stat-label">Transaksi Bulan Ini</span>
        <p class="stat-value" style="font-size: 1.5rem; color: var(--accent-primary);">{{ $payments->where('payment_date', '>=', now()->startOfMonth())->count() }}</p>
        <p class="stat-sub">{{ now()->translatedFormat('F Y') }}</p>
    </div>
    <div class="stat-card">
        <span class="stat-label">Subscription Terhubung</span>
        <p class="stat-value" style="font-size: 1.5rem;">{{ $subscriptions->count() }}</p>
        <p class="stat-sub">Layanan aktif</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card lg:col-span-2">
        <h3 class="section-title mb-5"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Grafik Pengeluaran (6 Bulan)</h3>
        <div style="position: relative; height: 230px;">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title mb-5"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Catat Pembayaran</h3>
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="form-label">Subscription</label>
                    <select name="subscription_id" class="form-select" required>
                        <option value="">Pilih...</option>
                        @foreach($subscriptions as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }} ({{ $sub->formatted_amount }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Nominal (IDR)</label>
                    <input type="number" name="amount" class="form-input" placeholder="186000" min="0" required>
                </div>
                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Catatan</label>
                    <input type="text" name="note" class="form-input" placeholder="Opsional">
                </div>
                <button type="submit" class="btn-primary w-full justify-center text-xs">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5">
        <h3 class="section-title"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg> Riwayat ({{ $payments->total() }})</h3>
        <form method="GET" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <select name="subscription_id" class="form-select text-xs py-1.5 min-w-[160px]">
                <option value="">Semua Subscription</option>
                @foreach($subscriptions as $s)
                <option value="{{ $s->id }}" {{ request('subscription_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select text-xs py-1.5 min-w-[120px]">
                <option value="">Semua Status</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <button type="submit" class="btn-secondary text-xs py-1.5 px-3">Filter</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead><tr><th>Subscription</th><th>Nominal</th><th>Tanggal</th><th>Status</th><th>Catatan</th><th class="text-right">Aksi</th></tr></thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td><div class="flex items-center gap-2.5"><span class="text-base">{{ $payment->subscription->category->icon ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>' }}</span><span class="font-bold" style="color: var(--text-primary);">{{ $payment->subscription->name ?? 'Dihapus' }}</span></div></td>
                    <td class="font-extrabold" style="color: var(--text-primary);">{{ $payment->formatted_amount }}</td>
                    <td style="color: var(--text-secondary);">{{ $payment->payment_date->translatedFormat('d M Y') }}</td>
                    <td><span class="badge badge-{{ $payment->status }}">{{ strtoupper($payment->status) }}</span></td>
                    <td style="color: var(--text-muted);">{{ $payment->note ?? 'Pembayaran rutin' }}</td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('payments.destroy', $payment->id) }}" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-ghost text-xs" style="color: var(--danger);">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-8 text-xs" style="color: var(--text-muted);">Belum ada catatan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payments->withQueryString()->links() }}</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
    new Chart(document.getElementById('paymentChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pengeluaran',
                data: @json($chartData),
                backgroundColor: 'rgba(124, 58, 237, 0.6)',
                borderColor: '#7c3aed',
                borderWidth: 1.5,
                borderRadius: 10,
                hoverBackgroundColor: 'rgba(124, 58, 237, 0.8)',
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutQuart' },
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx) => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw) } } },
            scales: {
                x: { grid: { display: false }, ticks: { color: isDark ? '#586882' : '#7c7399', font: { size: 11, family: 'Inter' } } },
                y: { beginAtZero: true, grid: { color: isDark ? 'rgba(148,163,184,0.06)' : 'rgba(124,58,237,0.06)' }, ticks: { color: isDark ? '#586882' : '#7c7399', font: { size: 11, family: 'Inter' }, callback: function(v) { if (v >= 1000000) return 'Rp' + (v/1000000).toFixed(1) + 'Jt'; if (v >= 1000) return 'Rp' + (v/1000) + 'Rb'; return 'Rp' + v; } } }
            }
        }
    });
});
</script>
@endsection
