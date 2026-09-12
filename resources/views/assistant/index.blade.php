@extends('layouts.app')
@section('title', 'Tata Asisten')

@section('content')
<div x-data="assistantPage()" x-cloak class="max-w-6xl mx-auto space-y-6 pb-16 px-2 sm:px-4">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="text-2xl font-bold text-[var(--text-primary)] tracking-tight">Tata Asisten</h1>
            <p class="text-xs text-[var(--text-muted)] mt-0.5">Analisis kesehatan finansial dan rekomendasi optimasi langganan cerdas</p>
        </div>

        <div class="flex flex-col sm:items-end gap-1.5">
            <div class="flex items-center gap-2">
                <a href="{{ route('assistant.chat') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-lg border border-[var(--border-color)] text-[var(--text-secondary)] hover:text-white hover:border-emerald-500/40 bg-[var(--bg-card)] transition-colors">
                    <svg class="w-4 h-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span>Tanya TATA AI</span>
                </a>

                <button @click="triggerScan()"
                        :disabled="isScanning"
                        class="btn-primary inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg cursor-pointer">
                    <svg x-show="!isScanning" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <svg x-cloak x-show="isScanning" class="animate-spin w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isScanning ? 'Menganalisis...' : 'Pindai Tata Asisten'"></span>
                </button>
            </div>
            <p class="text-[10px] text-[var(--text-muted)] flex items-center justify-start sm:justify-end gap-1.5 font-medium">
                <span class="w-1.5 h-1.5 rounded-full" :class="isScanning ? 'bg-emerald-500 animate-pulse' : (isSynced ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse')"></span>
                <span x-text="isScanning ? 'Menganalisis saat ini...' : (isSynced ? 'Data Terkini' : (hasNeverScanned ? 'Belum Dipindai' : 'Perubahan Terdeteksi'))"></span>
            </p>
        </div>
    </div>

    <div x-cloak x-show="warningMessage" class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1 text-xs">
            <p class="font-bold text-amber-600 dark:text-amber-300">Pemberitahuan Sistem</p>
            <p class="text-amber-700 dark:text-amber-200/90 mt-0.5 leading-relaxed" x-text="warningMessage"></p>
        </div>
        <button @click="warningMessage = ''" class="text-amber-500 hover:text-amber-700 p-1">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-cloak x-show="!isSynced && !hasNeverScanned && !isScanning" class="p-4 rounded-2xl bg-[var(--bg-card)] border border-[var(--border-color)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="text-emerald-500 shrink-0 flex items-center justify-center">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs text-[var(--text-secondary)] leading-relaxed">
                Portofolio langganan Anda telah diperbarui sejak audit terakhir. Klik tombol <strong class="text-[var(--text-primary)]">Pindai Tata Asisten</strong> untuk menyelaraskan evaluasi AI.
            </p>
        </div>
        <button @click="triggerScan()" class="text-xs font-bold text-emerald-500 hover:text-emerald-600 whitespace-nowrap self-end sm:self-auto">
            Pindai Sekarang &rarr;
        </button>
    </div>

    <div class="card p-0 rounded-2xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-[var(--border-color)]">

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Health Score</p>
                <div class="flex items-baseline gap-1.5 mb-1">
                    <span class="text-3xl font-black tracking-tight" :class="healthScoreColor" x-text="analysisData.health_score ?? 0"></span>
                    <span class="text-sm font-normal text-[var(--text-muted)]">/ 100</span>
                </div>
            </div>
            <p class="text-[11px] font-semibold" :class="healthScoreColor" x-text="healthScoreLabel"></p>
        </div>

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Profil Pengguna</p>
                <h3 class="text-base sm:text-lg font-bold text-[var(--text-primary)] leading-snug tracking-tight mb-1" x-text="analysisData.personality || 'Belum Ada Data'"></h3>
            </div>
            <p class="text-[11px] text-[var(--text-muted)]">Karakteristik pola langganan</p>
        </div>

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Pengeluaran Bulanan</p>
                <h3 class="text-2xl sm:text-3xl font-black text-[var(--text-primary)] tracking-tight mb-1" x-text="'Rp' + formatMoney(analysisData.total_monthly || 0)"></h3>
            </div>
            <p class="text-[11px] text-[var(--text-muted)]" x-text="'≈ Rp' + formatMoney(analysisData.total_yearly || 0) + ' / tahun'"></p>
        </div>

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[var(--text-muted)] mb-1">Potensi Hemat</p>
                <h3 class="text-2xl sm:text-3xl font-black text-emerald-500 tracking-tight mb-1">
                    <span x-text="'Rp' + formatMoney(analysisData.potential_savings || 0)"></span>
                    <span class="text-sm font-normal text-[var(--text-muted)]">/ bln</span>
                </h3>
            </div>
            <p class="text-[11px] text-[var(--text-muted)]" x-text="'Hemat Rp' + formatMoney((analysisData.potential_savings || 0) * 12) + ' / tahun'"></p>
        </div>

    </div>

    <div class="card p-5 sm:p-6" x-show="analysisData.summary">
        <div class="flex items-start gap-3 sm:gap-4">
            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1.5">Ringkasan Eksekutif</p>
                <p class="text-xs sm:text-sm text-[var(--text-primary)] leading-relaxed" x-html="analysisData.summary"></p>
            </div>
        </div>
    </div>

    <div class="card p-5 sm:p-6" x-show="healthBreakdown.length > 0">
        <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-4">Penjelasan Skor Kesehatan Finansial</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="(item, idx) in healthBreakdown" :key="idx">
                <div class="bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl p-4 flex flex-col justify-between gap-3">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-[var(--text-primary)]" x-text="item.name"></span>
                            <span class="text-xs font-bold" :class="item.score >= (item.max * 0.75) ? 'text-emerald-500' : (item.score >= (item.max * 0.5) ? 'text-amber-500' : 'text-red-500')" x-text="item.score + '/' + item.max"></span>
                        </div>
                        <div class="w-full bg-[var(--bg-card)] rounded-full h-2 overflow-hidden border border-[var(--border-color)]">
                            <div class="h-2 rounded-full transition-all duration-700"
                                 :class="item.score >= (item.max * 0.75) ? 'bg-emerald-500' : (item.score >= (item.max * 0.5) ? 'bg-amber-500' : 'bg-red-500')"
                                 :style="'width:' + ((item.score / Math.max(1, item.max)) * 100) + '%'"></div>
                        </div>
                    </div>
                    <p class="text-[11px] text-[var(--text-muted)] leading-snug" x-text="item.desc"></p>
                </div>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-[var(--text-primary)] flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Intelligence Insights
            </h3>

            <div class="space-y-3">
                <template x-for="(insight, idx) in analysisData.insights || []" :key="idx">
                    <div class="card p-5 flex gap-3.5 sm:gap-4 items-start transition-colors">
                        <div class="shrink-0 mt-0.5 text-emerald-500">
                            <template x-if="insight.icon === 'trending-up'">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </template>
                            <template x-if="insight.icon === 'pie-chart'">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </template>
                            <template x-if="insight.icon !== 'trending-up' && insight.icon !== 'pie-chart'">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-xs sm:text-sm text-[var(--text-primary)] mb-1" x-text="insight.title"></h4>
                            <p class="text-xs text-[var(--text-muted)] leading-relaxed" x-html="insight.description"></p>
                        </div>
                    </div>
                </template>

                <template x-if="(!analysisData.insights || analysisData.insights.length === 0)">
                    <div class="card p-6 text-center text-xs text-[var(--text-muted)]">
                        Belum ada insight tersedia.
                    </div>
                </template>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-[var(--text-primary)] flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Actionable Recommendations
            </h3>

            <div class="space-y-3">
                <template x-for="(rec, idx) in analysisData.recommendations || []" :key="idx">
                    <div class="card p-5 flex gap-4 sm:gap-5 items-start transition-colors">
                        <span class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5" x-text="idx + 1"></span>
                        <p class="text-xs sm:text-sm text-[var(--text-primary)] leading-relaxed flex-1 min-w-0" x-html="rec"></p>
                    </div>
                </template>

                <template x-if="(!analysisData.recommendations || analysisData.recommendations.length === 0)">
                    <div class="card p-6 text-center text-xs text-[var(--text-muted)]">
                        Tidak ada rekomendasi pemangkasan. Portofolio Anda dalam kondisi prima.
                    </div>
                </template>
            </div>

            <div class="card p-5 mt-4" x-data="{
                selectedSubs: [],
                totalSaving: 0,
                toggleSub() { this.totalSaving = this.selectedSubs.reduce((acc, val) => acc + Number(val), 0); }
            }">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <h4 class="font-bold text-xs text-[var(--text-primary)] flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Simulasi Pemangkasan Mandiri
                    </h4>
                    <span class="text-[10px] text-[var(--text-muted)]">Pilih langganan</span>
                </div>

                <div class="max-h-48 overflow-y-auto space-y-2 mb-4 pr-1 custom-scrollbar">
                    @foreach(auth()->user()->activeSubscriptions as $sub)
                    <label class="flex items-center justify-between p-2.5 rounded-lg bg-[var(--bg-elevated)] hover:border-emerald-500/40 border border-[var(--border-color)] cursor-pointer transition-colors">
                        <div class="flex items-center gap-2.5 min-w-0 pr-2">
                            <input type="checkbox" value="{{ $sub->monthly_amount }}" x-model="selectedSubs" @change="toggleSub()" class="w-4 h-4 rounded shrink-0 text-emerald-500 focus:ring-emerald-500">
                            <span class="text-xs font-semibold text-[var(--text-primary)] truncate">{{ $sub->name }}</span>
                        </div>
                        <span class="text-xs font-bold text-[var(--text-secondary)] shrink-0">Rp{{ number_format($sub->monthly_amount, 0, ',', '.') }}</span>
                    </label>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-[var(--border-color)] flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-[var(--text-primary)]">Uang Terselamatkan</p>
                        <p class="text-[10px] text-[var(--text-muted)]">Akumulasi langganan dipilih</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-black text-emerald-500 tracking-tight">
                            Rp<span x-text="new Intl.NumberFormat('id-ID').format(totalSaving)">0</span>
                            <span class="text-xs font-normal text-[var(--text-muted)]">/ bln</span>
                        </p>
                        <p class="text-[10px] text-[var(--text-muted)]" x-show="totalSaving > 0" x-text="'≈ Rp' + new Intl.NumberFormat('id-ID').format(totalSaving * 12) + ' / tahun'"></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@section('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('assistantPage', () => ({
        analysisData: @json($analysis ?? []),
        isSynced: @json($syncStatus['is_synced'] ?? false),
        hasNeverScanned: @json($syncStatus['has_never_scanned'] ?? true),
        scannedAtText: @json($syncStatus['scanned_at'] ? \Carbon\Carbon::parse($syncStatus['scanned_at'])->translatedFormat('d M Y H:i') : ''),
        isScanning: false,
        warningMessage: '',

        get healthBreakdown() {
            return this.analysisData?.health_data?.breakdown || [];
        },

        get healthScoreColor() {
            const score = this.analysisData?.health_score || 0;
            if (score >= 90) return 'text-emerald-400';
            if (score >= 75) return 'text-blue-400';
            if (score >= 50) return 'text-amber-400';
            return 'text-red-400';
        },

        get healthScoreLabel() {
            if (this.analysisData?.health_data?.label) {
                return 'Kategori ' + this.analysisData.health_data.label;
            }
            const score = this.analysisData?.health_score || 0;
            if (score >= 90) return 'Kategori Sempurna';
            if (score >= 75) return 'Kategori Baik';
            if (score >= 50) return 'Perlu Perhatian';
            return 'Kategori Kritis';
        },

        async triggerScan() {
            this.isScanning = true;
            this.warningMessage = '';

            try {
                const response = await fetch('{{ route('assistant.scan') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success && result.data) {
                    this.analysisData = result.data;
                    this.isSynced = true;
                    this.hasNeverScanned = false;
                    this.scannedAtText = result.scanned_at || 'Baru saja';
                } else {
                    if (result.warning) {
                        this.warningMessage = result.warning;
                    }
                    if (result.data) {
                        this.analysisData = result.data;
                    }
                }
            } catch (error) {
                this.warningMessage = 'Gagal menghubungi server aplikasi. Menampilkan data sebelumnya.';
            } finally {
                this.isScanning = false;
            }
        },

        formatMoney(val) {
            return new Intl.NumberFormat('id-ID').format(Math.round(val || 0));
        }
    }));
});
</script>
@endsection
@endsection
