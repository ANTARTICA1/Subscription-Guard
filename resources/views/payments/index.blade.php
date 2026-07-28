@extends('layouts.app')
@section('title', 'Pusat Pembayaran & Validasi')
@section('heading', 'Pusat Pembayaran')
@section('subheading', 'Validasi bukti transfer dari teman dan catat pengeluaran pribadi Anda.')

@section('content')
<div x-data="{ activeTab: 'validasi' }">
    <!-- Tabs Header -->
    <div class="flex gap-4 mb-8 border-b border-[var(--border-color)]">
        <button @click="activeTab = 'validasi'" 
                :class="activeTab === 'validasi' ? 'border-b-2 border-[var(--accent-primary)] text-[var(--text-primary)] font-bold' : 'text-[var(--text-muted)] hover:text-[var(--text-primary)]'"
                class="px-4 py-3 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Validasi Patungan
            @if($pendingVerifications->count() > 0)
                <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $pendingVerifications->count() }}</span>
            @endif
        </button>
        <button @click="activeTab = 'pengeluaran'" 
                :class="activeTab === 'pengeluaran' ? 'border-b-2 border-[var(--accent-primary)] text-[var(--text-primary)] font-bold' : 'text-[var(--text-muted)] hover:text-[var(--text-primary)]'"
                class="px-4 py-3 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pengeluaran Pribadi
        </button>
    </div>

    <!-- TAB: Validasi Patungan -->
    <div x-show="activeTab === 'validasi'" x-cloak>
        <div class="mb-8">
            <h3 class="text-xl font-bold text-[var(--text-primary)] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Menunggu Validasi
            </h3>
            
            @if($pendingVerifications->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pendingVerifications as $share)
                    <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-2xl overflow-hidden shadow-sm flex flex-col" x-data="{ showBukti: false }">
                        <div class="p-5 border-b border-[var(--border-color)] bg-[var(--bg-elevated)] flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-[var(--text-primary)]">{{ $share->friend_name }}</h4>
                                <p class="text-xs text-[var(--text-muted)]">{{ $share->subscription->name }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-[var(--bg-primary)] border border-[var(--border-light)] flex items-center justify-center font-bold text-[var(--text-secondary)]">
                                {{ substr($share->friend_name, 0, 1) }}
                            </div>
                        </div>
                        <div class="p-5 flex-1">
                            <p class="text-xs text-[var(--text-muted)] mb-1">Nominal Tagihan</p>
                            <p class="text-2xl font-black text-[var(--accent-primary)] mb-4">{{ $share->formatted_split_amount }}</p>
                            
                            <button @click="showBukti = true" class="w-full bg-[var(--bg-elevated)] hover:bg-[var(--bg-primary)] border border-[var(--border-color)] text-[var(--text-primary)] font-bold py-2 rounded-xl text-sm mb-3 flex justify-center items-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Lihat Bukti Transfer
                            </button>

                            <form method="POST" action="{{ route('shares.mark-paid', $share->id) }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl shadow-[0_0_15px_rgba(16,185,129,0.3)] transition-all">
                                    Terima & Validasi (Lunas)
                                </button>
                            </form>
                        </div>
                        
                        <!-- Modal Bukti -->
                        <div x-show="showBukti" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" @click.away="showBukti = false">
                            <div class="bg-[var(--bg-secondary)] p-6 rounded-2xl max-w-sm w-full border border-[var(--border-color)] text-center relative shadow-xl">
                                <h4 class="text-lg font-bold text-[var(--text-primary)] mb-4">Bukti Transfer</h4>
                                <div class="bg-[var(--bg-primary)] p-2 rounded-xl mb-6 shadow-sm border border-[var(--border-color)]">
                                    <img src="{{ Storage::url($share->payment_proof_path) }}" alt="Bukti Transfer" class="w-full rounded-lg object-contain max-h-[60vh]">
                                </div>
                                <button @click="showBukti = false" class="w-full bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] font-bold py-3 rounded-xl hover:bg-[var(--bg-primary)] transition-colors">Tutup</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-[var(--bg-secondary)] border border-dashed border-[var(--border-color)] rounded-2xl p-10 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-[var(--bg-elevated)] border border-[var(--border-light)] rounded-full flex items-center justify-center text-[var(--text-muted)] mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h4 class="font-bold text-[var(--text-primary)] mb-1">Tidak Ada Antrean Validasi</h4>
                    <p class="text-sm text-[var(--text-muted)]">Semua bukti transfer dari teman Anda sudah divalidasi atau belum ada yang membayar.</p>
                </div>
            @endif
        </div>

        <div>
            <h3 class="text-lg font-bold text-[var(--text-primary)] mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Riwayat Validasi Terakhir
            </h3>
            
            <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-xl overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[var(--bg-elevated)] border-b border-[var(--border-color)] text-[var(--text-secondary)] text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Teman</th>
                            <th class="px-6 py-4">Layanan</th>
                            <th class="px-6 py-4">Nominal</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-color)] text-sm">
                        @forelse($historyValidations as $share)
                        <tr class="hover:bg-[var(--bg-elevated)] transition-colors">
                            <td class="px-6 py-4 font-bold text-[var(--text-primary)]">{{ $share->friend_name }}</td>
                            <td class="px-6 py-4 text-[var(--text-secondary)]">{{ $share->subscription->name }}</td>
                            <td class="px-6 py-4 font-bold text-[var(--accent-primary)]">{{ $share->formatted_split_amount }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 px-2 py-1 rounded text-xs font-bold">LUNAS</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-[var(--text-muted)]">Belum ada riwayat validasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: Pengeluaran Pribadi -->
    <div x-show="activeTab === 'pengeluaran'" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] p-5 rounded-2xl shadow-sm">
                <span class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider">Total Realisasi</span>
                <p class="mt-2 text-2xl font-black text-[var(--text-primary)]">Rp{{ number_format($totalPaid, 0, ',', '.') }}</p>
                <p class="text-xs text-[var(--text-muted)] mt-1">Total pengeluaran terverifikasi</p>
            </div>
            <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] p-5 rounded-2xl shadow-sm">
                <span class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider">Transaksi Bulan Ini</span>
                <p class="mt-2 text-2xl font-black text-[var(--accent-primary)]">{{ $payments->where('payment_date', '>=', now()->startOfMonth())->count() }}</p>
                <p class="text-xs text-[var(--text-muted)] mt-1">{{ now()->translatedFormat('F Y') }}</p>
            </div>
            <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] p-5 rounded-2xl shadow-sm">
                <span class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider">Subscription Aktif</span>
                <p class="mt-2 text-2xl font-black text-[var(--text-primary)]">{{ $subscriptions->count() }}</p>
                <p class="text-xs text-[var(--text-muted)] mt-1">Layanan terhubung</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm lg:col-span-2">
                <h3 class="text-lg font-bold text-[var(--text-primary)] mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> 
                    Grafik Pengeluaran (6 Bulan)
                </h3>
                <div style="position: relative; height: 230px;">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>

            <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-[var(--text-primary)] mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> 
                    Catat Pengeluaran
                </h3>
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Subscription</label>
                            <select name="subscription_id" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl px-3 py-2 text-sm text-[var(--text-primary)] focus:ring-1 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-all" required>
                                <option value="">Pilih...</option>
                                @foreach($subscriptions as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }} ({{ $sub->formatted_amount }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Nominal (IDR)</label>
                            <input type="number" name="amount" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl px-3 py-2 text-sm text-[var(--text-primary)] focus:ring-1 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-all" placeholder="186000" min="0" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Tanggal</label>
                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl px-3 py-2 text-sm text-[var(--text-primary)] focus:ring-1 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-all" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-1">Catatan</label>
                            <input type="text" name="note" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl px-3 py-2 text-sm text-[var(--text-primary)] focus:ring-1 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-all" placeholder="Opsional">
                        </div>
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" class="w-full bg-[var(--accent-primary)] hover:bg-[var(--accent-secondary)] text-white font-bold py-2.5 rounded-xl shadow-lg transition-all text-sm mt-2">
                            Simpan Catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5">
                <h3 class="text-lg font-bold text-[var(--text-primary)] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg> 
                    Riwayat Anda ({{ $payments->total() }})
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[var(--bg-elevated)] border-b border-[var(--border-color)] text-[var(--text-secondary)] text-xs font-bold uppercase tracking-wider">
                            <th class="px-4 py-3">Layanan</th>
                            <th class="px-4 py-3">Nominal</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Catatan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-color)] text-sm">
                        @forelse($payments as $payment)
                        <tr class="hover:bg-[var(--bg-elevated)] transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-[var(--bg-primary)] border border-[var(--border-light)] rounded flex items-center justify-center text-xs">
                                        {{ $payment->subscription->category->icon ?? '💳' }}
                                    </div>
                                    <span class="font-bold text-[var(--text-primary)]">{{ $payment->subscription->name ?? 'Dihapus' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-extrabold text-[var(--text-primary)]">{{ $payment->formatted_amount }}</td>
                            <td class="px-4 py-3 text-[var(--text-secondary)]">{{ $payment->payment_date->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 text-[var(--text-muted)]">{{ $payment->note ?? '-' }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('payments.destroy', $payment->id) }}" onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-500/10 text-red-500 rounded text-xs font-bold hover:bg-red-500 hover:text-white transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-8 text-xs text-[var(--text-muted)]">Belum ada catatan pengeluaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $payments->withQueryString()->links() }}</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
    const ctx = document.getElementById('paymentChart');
    if(ctx) {
        new Chart(ctx.getContext('2d'), {
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
    }
});
</script>
@endsection
