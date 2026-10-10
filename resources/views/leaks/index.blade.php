@extends('layouts.app')
@section('title', 'Deteksi Kebocoran')

@section('content')

<style>
    .leak-badge-high {
        background-color: rgba(239, 68, 68, 0.18) !important;
        color: #fca5a5 !important;
        border: 1px solid rgba(239, 68, 68, 0.4) !important;
    }
    .leak-badge-medium {
        background-color: rgba(245, 158, 11, 0.18) !important;
        color: #fde047 !important;
        border: 1px solid rgba(245, 158, 11, 0.4) !important;
    }
    .leak-badge-low {
        background-color: rgba(148, 163, 184, 0.18) !important;
        color: #e2e8f0 !important;
        border: 1px solid rgba(148, 163, 184, 0.35) !important;
    }

    [data-theme="light"] .leak-badge-high {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
        border: 1px solid #fca5a5 !important;
    }
    [data-theme="light"] .leak-badge-medium {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border: 1px solid #fcd34d !important;
    }
    [data-theme="light"] .leak-badge-low {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
    }

    .leak-icon-high {
        background-color: rgba(239, 68, 68, 0.16) !important;
        color: #f87171 !important;
    }
    .leak-icon-medium {
        background-color: rgba(245, 158, 11, 0.16) !important;
        color: #fbbf24 !important;
    }
    .leak-icon-low {
        background-color: rgba(148, 163, 184, 0.16) !important;
        color: #cbd5e1 !important;
    }

    [data-theme="light"] .leak-icon-high {
        background-color: #fee2e2 !important;
        color: #dc2626 !important;
    }
    [data-theme="light"] .leak-icon-medium {
        background-color: #fef3c7 !important;
        color: #d97706 !important;
    }
    [data-theme="light"] .leak-icon-low {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
    }
</style>

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

        <div class="flex-1 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                 :class="threatLevel === 'TINGGI' ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400' : (threatLevel === 'SEDANG' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <div>
                <p class="text-xs text-[var(--text-muted)] mb-0.5">Tingkat Risiko</p>
                <h3 class="text-xl font-bold tracking-tight"
                    :class="threatLevel === 'TINGGI' ? 'text-rose-600 dark:text-rose-400' : (threatLevel === 'SEDANG' ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400')"
                    x-text="threatLevel"></h3>
                <p class="text-[11px] text-[var(--text-muted)] mt-0.5" x-text="`${leaks.length} potensi kebocoran terdeteksi`"></p>
            </div>
        </div>

        <div class="flex-1 p-6 flex flex-col justify-center">
            <p class="text-xs text-[var(--text-muted)] mb-0.5">Estimasi Kebocoran / Bulan</p>
            <h3 class="text-2xl font-bold text-[var(--text-primary)] tracking-tight" x-text="'Rp' + formatMoney(totalSavings)"></h3>
            <p class="text-[11px] text-[var(--text-muted)] mt-0.5" x-text="'≈ Rp' + formatMoney(totalSavings * 12) + ' / tahun'"></p>
        </div>

        <div class="flex-1 p-6 flex flex-col justify-center">
            <p class="text-xs text-[var(--text-muted)] mb-0.5">Potensi Efisiensi</p>
            <h3 class="text-2xl font-bold text-[var(--text-primary)] tracking-tight">
                <span x-text="totalSavings > 0 ? (totalSavings / {{ max(1, Auth::user()->monthlyExpense()) }} * 100).toFixed(0) + '%' : '0%'"></span>
                <span class="text-xs font-normal text-[var(--text-muted)]">dari tagihan</span>
            </h3>
            <p class="text-[11px] text-[var(--text-muted)] mt-0.5">Dapat dihemat jika ditindaklanjuti</p>
        </div>
    </div>

    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <button @click="filter = 'all'"
                :class="filter === 'all' ? 'bg-[var(--text-primary)] text-[var(--bg-card)] font-bold' : 'bg-[var(--bg-card)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] border border-[var(--border-color)]'"
                class="px-3.5 py-1.5 text-xs rounded-lg transition-colors flex items-center gap-1.5 cursor-pointer">
            <span>Semua</span>
            <span class="text-[10px] px-1.5 py-0.2 rounded-full font-semibold"
                  :class="filter === 'all' ? 'bg-[var(--bg-card)]/20 text-inherit' : 'bg-[var(--bg-elevated)] text-[var(--text-muted)]'"
                  x-text="leaks.length"></span>
        </button>
        <button @click="filter = 'high'"
                :class="filter === 'high' ? 'bg-[var(--text-primary)] text-[var(--bg-card)] font-bold' : 'bg-[var(--bg-card)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] border border-[var(--border-color)]'"
                class="px-3.5 py-1.5 text-xs rounded-lg transition-colors flex items-center gap-1.5 cursor-pointer">
            <span>Risiko Tinggi</span>
            <span class="text-[10px] px-1.5 py-0.2 rounded-full font-semibold"
                  :class="filter === 'high' ? 'bg-[var(--bg-card)]/20 text-inherit' : 'bg-[var(--bg-elevated)] text-[var(--text-muted)]'"
                  x-text="highLeaksCount"></span>
        </button>
        <button @click="filter = 'medium'"
                :class="filter === 'medium' ? 'bg-[var(--text-primary)] text-[var(--bg-card)] font-bold' : 'bg-[var(--bg-card)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] border border-[var(--border-color)]'"
                class="px-3.5 py-1.5 text-xs rounded-lg transition-colors flex items-center gap-1.5 cursor-pointer">
            <span>Risiko Sedang</span>
            <span class="text-[10px] px-1.5 py-0.2 rounded-full font-semibold"
                  :class="filter === 'medium' ? 'bg-[var(--bg-card)]/20 text-inherit' : 'bg-[var(--bg-elevated)] text-[var(--text-muted)]'"
                  x-text="medLeaksCount"></span>
        </button>
        <button @click="filter = 'low'"
                :class="filter === 'low' ? 'bg-[var(--text-primary)] text-[var(--bg-card)] font-bold' : 'bg-[var(--bg-card)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] border border-[var(--border-color)]'"
                class="px-3.5 py-1.5 text-xs rounded-lg transition-colors flex items-center gap-1.5 cursor-pointer">
            <span>Risiko Rendah</span>
            <span class="text-[10px] px-1.5 py-0.2 rounded-full font-semibold"
                  :class="filter === 'low' ? 'bg-[var(--bg-card)]/20 text-inherit' : 'bg-[var(--bg-elevated)] text-[var(--text-muted)]'"
                  x-text="lowLeaksCount"></span>
        </button>
    </div>

    <div class="space-y-3.5">
        <template x-for="leak in sortedAndFilteredLeaks" :key="leak.id">
            <div class="card p-5 transition-all">

                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">

                    <div class="flex items-start gap-3.5 flex-1 min-w-0">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                             :class="leak.severity === 'high' ? 'leak-icon-high' : (leak.severity === 'medium' ? 'leak-icon-medium' : 'leak-icon-low')">
                            <template x-if="leak.severity === 'high'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </template>
                            <template x-if="leak.severity !== 'high'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </template>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <h3 class="font-bold text-[var(--text-primary)] text-sm sm:text-base leading-snug" x-text="leak.title"></h3>
                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-md tracking-wider uppercase"
                                      :class="leak.severity === 'high' ? 'leak-badge-high' : (leak.severity === 'medium' ? 'leak-badge-medium' : 'leak-badge-low')"
                                      x-text="leak.severity === 'high' ? 'TINGGI' : (leak.severity === 'medium' ? 'SEDANG' : 'RENDAH')"></span>
                            </div>

                            <p class="text-xs text-[var(--text-secondary)] leading-relaxed mt-1" x-html="leak.description"></p>
                        </div>
                    </div>

                    <div class="sm:text-right shrink-0 pl-12 sm:pl-0">
                        <p class="text-[10px] text-[var(--text-muted)] font-medium">Potensi Hemat</p>
                        <p class="text-sm sm:text-base font-bold text-[var(--text-primary)] mt-0.5">
                            Rp<span x-text="formatMoney(leak.potential_savings)"></span>
                            <span class="text-[10px] text-[var(--text-muted)] font-normal">/bln</span>
                        </p>
                    </div>
                </div>

                <div class="mt-3.5 pt-3 border-t border-[var(--border-color)] flex items-start gap-2 text-xs">
                    <span class="text-[var(--text-muted)] font-semibold shrink-0">Saran:</span>
                    <p class="text-[var(--text-secondary)] leading-relaxed flex-1" x-html="leak.recommendation"></p>
                </div>

            </div>
        </template>

        <template x-if="sortedAndFilteredLeaks.length === 0">
            <div class="card p-10 text-center">
                <p class="text-[var(--text-muted)] text-xs">Tidak terdeteksi ada pemborosan di kategori ini.</p>
            </div>
        </template>
    </div>

    <p class="text-center text-xs text-[var(--text-muted)] pt-4 pb-2">
        Analisis kebocoran otomatis didasarkan pada perbandingan fitur antar-layanan, siklus penagihan, dan konsistensi penggunaan.
    </p>

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
