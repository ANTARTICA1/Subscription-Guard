@extends('layouts.app')
@section('title', 'Deteksi Kebocoran')

@section('content')

<div x-data="leaksPage()" x-cloak class="space-y-6 pb-12">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-[var(--text-primary)] tracking-tight">Deteksi Kebocoran Langganan</h1>
            <p class="text-xs text-[var(--text-muted)] mt-0.5">Identifikasi langganan pasif, duplikasi, dan kenaikan harga secara cerdas</p>
        </div>
        <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-2">
            <button @click="scan()" class="btn-primary inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg" :disabled="isScanning">
                <svg x-show="!isScanning" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                <svg x-cloak x-show="isScanning" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="isScanning ? 'Memindai...' : 'Pindai Ulang'"></span>
            </button>
            <p class="text-[9px] text-[var(--text-muted)] mt-0.5 flex items-center justify-end gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full" :class="isScanning ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500'"></span>
                <span x-text="isScanning ? 'Memindai saat ini...' : scanStatusText"></span>
            </p>
        </div>
    </div>

    <div class="card p-0 flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-[var(--border-color)] overflow-hidden">

        <div class="flex-1 p-6 md:p-8 flex items-center gap-6">
            <div class="relative w-20 h-20 flex items-center justify-center flex-shrink-0">
                <div class="absolute inset-0 rounded-full border" :class="threatColorClass.border20"></div>
                <div class="absolute inset-2 rounded-full border" :class="threatColorClass.border40"></div>
                <div class="absolute inset-0 rounded-full animate-pulse" :class="threatColorClass.bg10"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 relative z-10" :class="threatColorClass.text" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>

            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Risiko Kebocoran</p>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-2xl font-black" :class="threatColorClass.text" x-text="threatLevel"></h3>
                </div>
                <p class="text-xs text-[var(--text-muted)]" x-text="`Terdeteksi ${leaks.length} potensi kebocoran langganan.`"></p>
            </div>
        </div>

        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center">
            <p class="text-xs text-[var(--text-muted)] mb-1">Estimasi Kebocoran / Bulan</p>
            <h3 class="text-3xl font-black text-red-500 tracking-tight mb-1" x-text="'Rp' + formatMoney(totalSavings)"></h3>
            <p class="text-[11px] text-[var(--text-muted)]" x-text="'≈ Rp' + formatMoney(totalSavings * 12) + ' / tahun'"></p>
        </div>

        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center">
            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Uang yang Bisa Diselamatkan</p>
                <h3 class="text-2xl font-black text-emerald-500 tracking-tight mb-1">
                    <span x-text="'Rp' + formatMoney(totalSavings)"></span> <span class="text-sm font-normal text-[var(--text-muted)]">/ bln</span>
                </h3>
                <p class="text-[11px] text-[var(--text-muted)]" x-text="'Rp' + formatMoney(totalSavings * 12) + ' / tahun'"></p>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2 overflow-x-auto pb-2 custom-scrollbar">
        <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/30' : 'text-[var(--text-muted)] border-[var(--border-color)] hover:bg-[var(--bg-elevated)]'" class="px-3.5 py-1.5 text-xs font-semibold rounded-full border transition-colors">
            Semua
        </button>
        <button @click="filter = 'high'" :class="filter === 'high' ? 'bg-red-500/10 text-red-500 border-red-500/30' : 'text-[var(--text-muted)] border-[var(--border-color)] hover:bg-[var(--bg-elevated)]'" class="px-3.5 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
            Risiko Tinggi <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.2 rounded-full" x-text="highLeaksCount"></span>
        </button>
        <button @click="filter = 'medium'" :class="filter === 'medium' ? 'bg-amber-500/10 text-amber-500 border-amber-500/30' : 'text-[var(--text-muted)] border-[var(--border-color)] hover:bg-[var(--bg-elevated)]'" class="px-3.5 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
            Risiko Sedang <span class="bg-amber-500 text-white text-[9px] px-1.5 py-0.2 rounded-full" x-text="medLeaksCount"></span>
        </button>
        <button @click="filter = 'low'" :class="filter === 'low' ? 'bg-blue-500/10 text-blue-500 border-blue-500/30' : 'text-[var(--text-muted)] border-[var(--border-color)] hover:bg-[var(--bg-elevated)]'" class="px-3.5 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
            Risiko Rendah <span class="bg-blue-500 text-white text-[9px] px-1.5 py-0.2 rounded-full" x-text="lowLeaksCount"></span>
        </button>
    </div>

    <div class="space-y-4">
        <template x-for="leak in sortedAndFilteredLeaks" :key="leak.id">
            <div class="card p-5 relative overflow-hidden group hover:border-emerald-500/40 transition-colors">

                <div class="flex flex-col lg:flex-row gap-6 relative z-10">

                    <div class="flex items-start gap-3.5 lg:w-1/3">
                        <div class="flex items-center justify-center flex-shrink-0 mt-0.5" :class="leak.severity === 'high' ? 'text-red-500' : (leak.severity === 'medium' ? 'text-amber-500' : 'text-blue-500')">
                            <template x-if="leak.severity === 'high'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </template>
                            <template x-if="leak.severity !== 'high'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-[var(--text-primary)] text-base truncate" x-text="leak.title"></h4>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded border border-current/25 uppercase tracking-wider whitespace-nowrap bg-transparent" :class="leak.severity === 'high' ? 'text-red-500' : (leak.severity === 'medium' ? 'text-amber-500' : 'text-blue-500')" x-text="leak.severity === 'high' ? 'TINGGI' : (leak.severity === 'medium' ? 'SEDANG' : 'RENDAH')"></span>
                            </div>
                            <p class="text-xs text-[var(--text-muted)]">Rp<span x-text="formatMoney(leak.potential_savings)"></span> / Bulan</p>
                        </div>
                    </div>

                    <div class="lg:w-2/3 flex flex-col justify-between">
                        <div class="mb-3">
                            <h5 class="text-sm font-bold text-[var(--text-primary)] mb-1" x-text="leak.title"></h5>
                            <p class="text-xs text-[var(--text-secondary)] leading-relaxed" x-html="leak.description"></p>
                        </div>

                        <div class="bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl p-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                                <p class="text-xs text-[var(--text-secondary)]" x-html="leak.recommendation"></p>
                            </div>
                            <template x-if="leak.potential_savings > 0">
                                <span class="text-xs font-bold tracking-wide whitespace-nowrap text-emerald-500">Hemat Rp<span x-text="formatMoney(leak.potential_savings)"></span>/bln</span>
                            </template>
                        </div>
                    </div>

                </div>
            </div>
        </template>

        <template x-if="sortedAndFilteredLeaks.length === 0">
            <div class="card p-10 text-center">
                <p class="text-[var(--text-muted)] text-xs">Tidak terdeteksi ada pemborosan di kategori ini.</p>
            </div>
        </template>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

        <div class="card p-6 flex flex-col justify-between items-start gap-2">
            <div>
                <h4 class="text-sm font-bold text-[var(--text-primary)] mb-1">Cara Kerja Deteksi Kebocoran</h4>
                <p class="text-xs text-[var(--text-muted)] leading-relaxed">Kami menganalisis pola pembayaran, auto-renewal, dan aktivitas untuk menemukan potensi kebocoran.</p>
            </div>
        </div>

        <div class="card p-6 flex flex-col justify-between items-start gap-2">
            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Total Pengeluaran Bulan Ini</p>
                <h4 class="text-2xl font-black text-[var(--text-primary)] mb-1">Rp{{ number_format(Auth::user()->monthlyExpense(), 0, ',', '.') }}</h4>
                <p class="text-xs text-[var(--text-muted)]">{{ Auth::user()->activeSubscriptions()->count() }} Layanan Aktif</p>
            </div>
        </div>

        <div class="card p-6 flex flex-col justify-between items-start gap-2">
            <div class="w-full">
                <p class="text-xs text-[var(--text-muted)] mb-1">Rata-rata Kebocoran / Bulan</p>
                <h4 class="text-2xl font-black text-[var(--text-primary)] mb-1" x-text="'Rp' + formatMoney(totalSavings)"></h4>
                <p class="text-xs text-[var(--text-muted)]"><span x-text="totalSavings > 0 ? (totalSavings / {{ max(1, Auth::user()->monthlyExpense()) }} * 100).toFixed(1) : 0"></span>% dari total pengeluaran</p>
            </div>
        </div>
    </div>

</div>
</div>

@section('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('leaksPage', () => ({
        leaks: @json($result['leaks'] ?? []),
        filter: 'all',
        sortMethod: 'newest',
        isScanning: false,
        scanStatusText: 'Terakhir dipindai: 1 jam lalu',

        init() {
            this.leaks = this.leaks.map((l, i) => ({ ...l, id: i }));
        },

        get totalSavings() {
            return this.leaks.reduce((sum, l) => sum + parseInt(l.potential_savings), 0);
        },

        get threatLevel() {
            if (this.totalSavings >= 100000) return 'TINGGI';
            if (this.totalSavings > 0) return 'SEDANG';
            return 'AMAN';
        },

        get threatColorClass() {
            if (this.threatLevel === 'TINGGI') return { bg: 'bg-[#ef4444]', text: 'text-[#ef4444]', border: 'border-[#ef4444]', border20: 'border-[#ef4444]/20', border40: 'border-[#ef4444]/40', border60: 'border-[#ef4444]/60', shadow: 'shadow-[0_0_20px_rgba(239,68,68,0.3)]', bg10: 'bg-[#ef4444]/10', gradient: 'from-[#ef4444]' };
            if (this.threatLevel === 'SEDANG') return { bg: 'bg-[#f59e0b]', text: 'text-[#f59e0b]', border: 'border-[#f59e0b]', border20: 'border-[#f59e0b]/20', border40: 'border-[#f59e0b]/40', border60: 'border-[#f59e0b]/60', shadow: 'shadow-[0_0_20px_rgba(245,158,11,0.3)]', bg10: 'bg-[#f59e0b]/10', gradient: 'from-[#f59e0b]' };
            return { bg: 'bg-[#10b981]', text: 'text-[#10b981]', border: 'border-[#10b981]', border20: 'border-[#10b981]/20', border40: 'border-[#10b981]/40', border60: 'border-[#10b981]/60', shadow: 'shadow-[0_0_20px_rgba(16,185,129,0.3)]', bg10: 'bg-[#10b981]/10', gradient: 'from-[#10b981]' };
        },

        get highLeaksCount() {
            return this.leaks.filter(l => l.severity === 'high').length;
        },

        get medLeaksCount() {
            return this.leaks.filter(l => l.severity === 'medium').length;
        },

        get lowLeaksCount() {
            return this.leaks.filter(l => l.severity === 'low').length;
        },

        get sortedAndFilteredLeaks() {
            let filtered = [...this.leaks];
            if (this.filter !== 'all' && this.filter !== 'safe') {
                filtered = filtered.filter(l => l.severity === this.filter);
            } else if (this.filter === 'safe') {
                filtered = [];
            }

            return filtered.sort((a, b) => {
                if (this.sortMethod === 'highest_risk') {
                    const weightA = a.severity === 'high' ? 2 : (a.severity === 'medium' ? 1 : 0);
                    const weightB = b.severity === 'high' ? 2 : (b.severity === 'medium' ? 1 : 0);
                    return weightB - weightA;
                }
                if (this.sortMethod === 'largest_saving') {
                    return b.potential_savings - a.potential_savings;
                }
                return 0;
            });
        },

        async scan() {
            this.isScanning = true;
            try {
                const response = await fetch('/leaks/scan');
                if (response.ok) {
                    const data = await response.json();
                    this.leaks = data.leaks.map((l, i) => ({ ...l, id: i }));
                    this.scanStatusText = 'Terakhir dipindai: baru saja';
                } else {
                    console.error('Scan failed');
                }
            } catch (error) {
                console.error(error);
            } finally {
                this.isScanning = false;
            }
        },

        formatMoney(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }
    }));
});
</script>
@endsection
@endsection
