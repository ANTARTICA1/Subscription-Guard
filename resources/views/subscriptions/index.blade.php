@extends('layouts.app')
@section('title', 'Subscriptions')

@section('content')
@section('actions')
    <div class="flex items-center gap-1.5 sm:gap-2">
        <a href="{{ route('subscriptions.export') }}" class="btn-secondary px-2.5 sm:px-3.5 py-1.5 sm:py-2 text-[10px] sm:text-xs font-bold rounded-lg sm:rounded-xl flex items-center gap-1 sm:gap-1.5 shadow-sm" title="Export">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            <span class="hidden sm:inline">Export</span>
        </a>

        <a href="{{ route('subscriptions.create') }}" class="btn-primary px-2.5 sm:px-3.5 py-1.5 sm:py-2 text-[10px] sm:text-xs font-bold rounded-lg sm:rounded-xl flex items-center gap-1 sm:gap-1.5 shadow-sm" title="Tambah">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            <span class="hidden sm:inline">Tambah</span>
        </a>
    </div>
@endsection

<div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-[var(--border-color)] overflow-hidden shadow-sm mb-6 min-w-0">

    <div class="p-4 flex flex-col justify-between">
        <div class="mb-1.5">
            <p class="text-[10px] text-[var(--text-muted)] font-semibold uppercase tracking-wider">Total Subscription</p>
        </div>
        <h3 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">{{ $totalActiveCount }}</h3>
        <p class="text-[10px] text-[var(--text-muted)] mt-2">Aktif saat ini</p>
    </div>

    <div class="p-4 flex flex-col justify-between">
        <div class="mb-1.5">
            <p class="text-[10px] text-[var(--text-muted)] font-semibold uppercase tracking-wider">Pengeluaran Bulan Ini</p>
        </div>
        <h3 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">Rp{{ number_format($monthlySpending, 0, ',', '.') }}</h3>
        <p class="text-[10px] text-[var(--text-muted)] mt-2"><span class="text-emerald-500 font-bold">+8%</span> dari bulan lalu</p>
    </div>

    <div class="p-4 flex flex-col justify-between">
        <div class="mb-1.5">
            <p class="text-[10px] text-[var(--text-muted)] font-semibold uppercase tracking-wider">Akan Datang</p>
        </div>
        <h3 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">{{ $upcomingCount }}</h3>
        <p class="text-[10px] text-[var(--text-muted)] mt-2">Dalam 7 hari</p>
    </div>

    <div class="p-4 flex flex-col justify-between">
        <div class="mb-1.5">
            <p class="text-[10px] text-[var(--text-muted)] font-semibold uppercase tracking-wider">Total Hemat</p>
        </div>
        <h3 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">Rp{{ number_format($totalSavings, 0, ',', '.') }}</h3>
        <p class="text-[10px] text-[var(--text-muted)] mt-2">Dari deteksi pemborosan</p>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-2 min-w-0">

    <div class="lg:col-span-7 xl:col-span-8 2xl:col-span-9 space-y-6 min-w-0">

        <div class="card p-6">

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold text-[var(--text-primary)]">Subscription Aktif</h3>
                    <span class="px-2 py-0.5 rounded-lg bg-[var(--bg-elevated)] text-[var(--text-muted)] text-[10px] font-bold">{{ $totalActiveCount }}</span>
                </div>
            </div>

            <div class="flex flex-col">
                @foreach($subscriptions as $sub)
                @php
                    $isActive = $sub->status === 'active';
                    $progressPercent = $isActive ? max(0, min(100, 100 - ($sub->days_until_payment * 3.33))) : 0;
                    $progressColor = $sub->days_until_payment <= 3 ? 'bg-amber-500' : 'bg-emerald-500';
                @endphp
                <div class="flex flex-col sm:flex-row sm:items-center justify-between py-4 border-b border-[var(--border-color)] group">

                    <div class="flex items-center gap-4 sm:w-5/12 mb-3 sm:mb-0">
                        @if($sub->logo)
                        <div class="w-10 h-10 flex-shrink-0 bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-full p-2 flex items-center justify-center">
                            <img src="{{ $sub->logo }}" alt="{{ $sub->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                        </div>
                        @else
                        <div class="w-10 h-10 flex-shrink-0 rounded-full flex items-center justify-center text-lg font-bold" style="background: {{ $sub->category->color ?? '#10b981' }}15; color: {{ $sub->category->color ?? '#10b981' }}">
                            <span class="text-sm font-extrabold uppercase">{{ substr($sub->category->name ?? 'S', 0, 1) }}</span>
                        </div>
                        @endif

                        <div>
                            <h4 class="font-bold text-[var(--text-primary)] text-sm leading-tight">{{ $sub->name }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-[var(--text-muted)]">{{ $sub->category->name ?? 'Lainnya' }}</span>
                                @if($isActive)
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-500 font-bold tracking-wide uppercase">ACTIVE</span>
                                @else
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-[var(--bg-elevated)] text-[var(--text-muted)] font-bold tracking-wide uppercase">INACTIVE</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sm:w-4/12 mb-3 sm:mb-0">
                        <p class="text-xs font-bold text-[var(--text-primary)] mb-1">
                            Rp{{ number_format($sub->amount, 0, ',', '.') }} <span class="text-[10px] text-[var(--text-muted)] font-normal">/ {{ ucfirst($sub->billing_cycle) }}</span>
                        </p>
                        @if($isActive)
                            <p class="text-[10px] text-[var(--text-muted)] mb-1.5">Renews in {{ $sub->days_until_payment }} hari lagi</p>
                            <div class="w-48 h-0.5 bg-[var(--bg-elevated)] rounded-full overflow-hidden">
                                <div class="h-full {{ $progressColor }} rounded-full" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        @else
                            <p class="text-[10px] text-red-500 mb-1.5">Expired {{ abs($sub->days_until_payment) }} hari yang lalu</p>
                            <div class="w-48 h-0.5 bg-[var(--bg-elevated)] rounded-full overflow-hidden"></div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 justify-end sm:w-3/12">
                        @if($isActive)
                            <a href="{{ route('subscriptions.show', $sub) }}" class="px-4 py-1.5 bg-[var(--bg-elevated)] border border-[var(--border-color)] hover:border-emerald-500/40 text-[var(--text-primary)] text-xs font-semibold rounded-lg transition-colors">
                                Kelola
                            </a>
                        @else
                            <form method="POST" action="{{ route('subscriptions.toggle-status', $sub) }}">
                                @csrf
                                <button type="submit" class="px-4 py-1.5 bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-primary)] text-xs font-semibold rounded-lg transition-colors whitespace-nowrap">
                                    Aktifkan Kembali
                                </button>
                            </form>
                        @endif

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="p-1.5 bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-lg text-[var(--text-muted)] hover:text-[var(--text-primary)] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                            </button>
                            <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-36 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl shadow-xl z-50 overflow-hidden py-1">
                                <a href="{{ route('subscriptions.edit', $sub) }}" class="flex items-center gap-2 px-4 py-2 text-xs text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] transition-colors">Edit</a>
                                @if($isActive)
                                <form method="POST" action="{{ route('subscriptions.toggle-status', $sub) }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-2 text-xs text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] transition-colors">Pause</button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('subscriptions.destroy', $sub) }}" onsubmit="return confirm('Hapus subscription ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-2 text-xs text-red-500 hover:bg-red-500/10 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="lg:col-span-5 xl:col-span-4 2xl:col-span-3 space-y-6 min-w-0">

        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[13px] font-bold text-[var(--text-primary)]">Pembayaran Mendatang</h3>
                <a href="{{ route('dashboard') }}" class="text-[10px] text-emerald-500 hover:text-emerald-600">Lihat Kalender</a>
            </div>

            <div class="space-y-4 mb-5">
                @forelse($upcomingPayments as $payment)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($payment->logo)
                        <div class="w-6 h-6 flex-shrink-0 bg-[var(--bg-elevated)] rounded-full p-1 flex items-center justify-center">
                            <img src="{{ $payment->logo }}" class="w-full h-full object-contain">
                        </div>
                        @else
                        <div class="w-6 h-6 flex-shrink-0 rounded-full flex items-center justify-center text-[10px] font-bold" style="background: {{ $payment->category->color ?? '#10b981' }}15; color: {{ $payment->category->color ?? '#10b981' }}">
                            {!! $payment->category->icon ?? 'S' !!}
                        </div>
                        @endif
                        <p class="text-[11px] font-semibold text-[var(--text-primary)]">{{ $payment->name }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-right">
                        <p class="text-[10px] text-[var(--text-muted)]">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-bold {{ $payment->days_until_payment <= 3 ? 'text-amber-500' : 'text-emerald-500' }} w-14">{{ $payment->days_until_payment }} hari lagi</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-[var(--text-muted)] text-center py-2">Tidak ada tagihan dalam waktu dekat.</p>
                @endforelse
            </div>

            <a href="{{ route('dashboard') }}" class="btn-emerald-soft group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Lihat Kalender Lengkap</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 flex-shrink-0 opacity-60 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="card p-6 relative">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[13px] font-bold text-[var(--text-primary)]">Pengeluaran Bulanan</h3>
            </div>

            <div class="mb-4">
                <h4 class="text-xl font-bold text-[var(--text-primary)] mb-1">Rp{{ number_format($monthlySpending, 0, ',', '.') }}</h4>
            </div>

            <div class="h-36 w-full mt-6 relative">
                <canvas id="monthlySpendingChart"></canvas>
            </div>
        </div>

        <div class="card p-6 relative overflow-hidden">
            <div class="text-amber-500 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
            </div>

            <h3 class="text-sm font-bold text-[var(--text-primary)] mb-2">Tips Hemat</h3>

            <p class="text-xs text-[var(--text-muted)] mb-4 leading-relaxed">
                Periksa kebocoran subscription untuk menghemat pengeluaran bulanan Anda.
            </p>

            <a href="{{ route('leaks.index') }}" class="btn-primary inline-block px-4 py-2 text-[10px] font-bold rounded-lg text-center">
                Lihat Rekomendasi
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlySpendingChart');
    if (ctx) {
        const context = ctx.getContext('2d');
        const gradient = context.createLinearGradient(0, 0, 0, 128);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(context, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    borderColor: '#10b981',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        displayColors: false,
                        callbacks: {
                            label: (context) => 'Rp' + new Intl.NumberFormat('id-ID').format(context.raw)
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#64748b', font: { size: 9, family: 'Inter' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(15,23,42,0.06)', drawBorder: false },
                        ticks: {
                            color: '#64748b',
                            font: { size: 9, family: 'Inter' },
                            maxTicksLimit: 4,
                            callback: function(v) {
                                if (v >= 1000000) return (v / 1000000).toFixed(1) + 'M';
                                if (v >= 1000) return (v / 1000) + 'K';
                                return v;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
