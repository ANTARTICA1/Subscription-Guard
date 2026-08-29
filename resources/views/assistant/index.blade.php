@extends('layouts.app')
@section('title', 'Tata Asisten')

@section('content')
<div x-data="assistantPage()" x-cloak class="max-w-5xl mx-auto space-y-6 pb-12">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-2xl font-extrabold text-[var(--text-primary)]">Tata Asisten</h2>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                    <svg class="w-3 h-3 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    AI Engine
                </span>
            </div>
            <p class="text-[var(--text-secondary)] text-sm mt-1">Audit finansial cerdas, analisis tumpang tindih, dan rekomendasi efisiensi pengeluaran.</p>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-[var(--bg-card)] border border-[var(--border-color)] text-xs">
                <template x-if="isSynced">
                    <div class="flex items-center gap-1.5 text-emerald-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-semibold">Data Terkini</span>
                    </div>
                </template>
                <template x-if="!isSynced && !hasNeverScanned">
                    <div class="flex items-center gap-1.5 text-amber-400">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="font-semibold">Perubahan Terdeteksi</span>
                    </div>
                </template>
                <template x-if="hasNeverScanned">
                    <div class="flex items-center gap-1.5 text-[var(--text-muted)]">
                        <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                        <span class="font-semibold">Belum Dipindai</span>
                    </div>
                </template>
                <span class="text-[var(--text-muted)]" x-show="scannedAtText" x-text="'• ' + scannedAtText"></span>
            </div>

            <button @click="triggerScan()" 
                    :disabled="isScanning"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs text-white transition-all shadow-lg"
                    :class="!isSynced ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 shadow-indigo-500/25 ring-2 ring-indigo-400/30 animate-pulse' : 'bg-[var(--bg-elevated)] hover:bg-[var(--border-color)] border border-[var(--border-color)] text-[var(--text-primary)]'">
                <svg x-show="!isScanning" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <svg x-cloak x-show="isScanning" class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-text="isScanning ? 'Menganalisis...' : 'Pindai Tata Asisten'"></span>
            </button>
        </div>
    </div>

    <div x-cloak x-show="warningMessage" class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-start gap-3">
        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1 text-xs">
            <p class="font-bold text-amber-300">Pemberitahuan Sistem</p>
            <p class="text-amber-200/90 mt-0.5" x-text="warningMessage"></p>
        </div>
        <button @click="warningMessage = ''" class="text-amber-400 hover:text-amber-200">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-cloak x-show="!isSynced && !hasNeverScanned && !isScanning" class="p-4 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs text-[var(--text-secondary)] leading-relaxed">
                Daftar langganan Anda mengalami perubahan sejak audit terakhir. Klik <strong class="text-[var(--text-primary)]">Pindai Tata Asisten</strong> untuk menyelaraskan rekomendasi AI.
            </p>
        </div>
        <button @click="triggerScan()" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 whitespace-nowrap">
            Pindai Sekarang &rarr;
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-2">Health Score</p>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black" :class="healthScoreColor" x-text="analysisData.health_score ?? 0"></span>
                <span class="text-sm font-semibold text-[var(--text-secondary)]">/ 100</span>
            </div>
            <p class="text-[10px] text-[var(--text-muted)] mt-1" x-text="healthScoreLabel"></p>
        </div>
        
        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm">
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-2">Profil Pengguna</p>
            <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 font-bold px-3 py-1.5 rounded-lg text-sm truncate" :title="analysisData.personality" x-text="analysisData.personality || 'Belum Ada Data'">
            </div>
            <p class="text-[10px] text-[var(--text-muted)] mt-1 truncate" x-text="analysisData.summary ? 'Karakteristik pola langganan' : ''"></p>
        </div>

        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm sm:col-span-2 flex flex-col justify-center">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Pengeluaran Bulanan</p>
                    <p class="text-2xl font-black text-[var(--text-primary)]" x-text="'Rp' + formatMoney(analysisData.total_monthly || 0)"></p>
                    <p class="text-[10px] text-[var(--text-muted)] mt-0.5" x-text="'≈ Rp' + formatMoney(analysisData.total_yearly || 0) + ' / tahun'"></p>
                </div>
                <div class="text-right border-l border-[var(--border-color)] pl-4">
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Potensi Hemat</p>
                    <p class="text-xl font-bold text-emerald-400">
                        <span x-text="'Rp' + formatMoney(analysisData.potential_savings || 0)"></span>
                        <span class="text-xs font-normal text-[var(--text-muted)]">/bln</span>
                    </p>
                    <p class="text-[10px] text-emerald-400/80 mt-0.5" x-text="'Hemat Rp' + formatMoney((analysisData.potential_savings || 0) * 12) + ' / thn'"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm" x-show="analysisData.summary">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Ringkasan Eksekutif</p>
                <p class="text-sm text-[var(--text-primary)] leading-relaxed" x-html="analysisData.summary"></p>
            </div>
        </div>
    </div>

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm" x-show="healthBreakdown.length > 0">
        <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-4">Penjelasan Skor Kesehatan Finansial</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="(item, idx) in healthBreakdown" :key="idx">
                <div class="bg-[var(--bg-primary)] p-3.5 rounded-xl border border-[var(--border-color)] flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-xs font-bold text-[var(--text-primary)]" x-text="item.name"></span>
                            <span class="text-xs font-bold" :class="item.score >= (item.max * 0.8) ? 'text-emerald-400' : 'text-indigo-400'" x-text="item.score + '/' + item.max"></span>
                        </div>
                        <div class="w-full bg-[var(--bg-elevated)] rounded-full h-1.5 mb-2 overflow-hidden">
                            <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-500" :style="'width:' + ((item.score / Math.max(1, item.max)) * 100) + '%'"></div>
                        </div>
                    </div>
                    <p class="text-[10px] text-[var(--text-muted)] leading-tight" x-text="item.desc"></p>
                </div>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-4">
            <h3 class="text-base font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Intelligence Insights
            </h3>
            
            <div class="space-y-3">
                <template x-for="(insight, idx) in analysisData.insights || []" :key="idx">
                    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl p-4 flex gap-3.5 items-start shadow-sm hover:border-indigo-500/30 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                            <template x-if="insight.icon === 'trending-up'">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </template>
                            <template x-if="insight.icon === 'pie-chart'">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </template>
                            <template x-if="insight.icon !== 'trending-up' && insight.icon !== 'pie-chart'">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </template>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-xs text-[var(--text-primary)] mb-1" x-text="insight.title"></h4>
                            <p class="text-xs text-[var(--text-secondary)] leading-relaxed" x-html="insight.description"></p>
                        </div>
                    </div>
                </template>

                <template x-if="(!analysisData.insights || analysisData.insights.length === 0)">
                    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl p-6 text-center text-xs text-[var(--text-muted)]">
                        Belum ada insight tersedia.
                    </div>
                </template>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-base font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Actionable Recommendations
            </h3>
            
            <div class="space-y-3">
                <template x-for="(rec, idx) in analysisData.recommendations || []" :key="idx">
                    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl p-4 flex gap-3 shadow-sm hover:border-emerald-500/30 transition-colors">
                        <span class="w-6 h-6 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5" x-text="idx + 1"></span>
                        <p class="text-xs text-[var(--text-primary)] leading-relaxed" x-html="rec"></p>
                    </div>
                </template>

                <template x-if="(!analysisData.recommendations || analysisData.recommendations.length === 0)">
                    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl p-6 text-center text-xs text-[var(--text-muted)]">
                        Tidak ada rekomendasi pemangkasan. Portofolio Anda dalam kondisi prima.
                    </div>
                </template>
            </div>

            <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl p-5 shadow-sm mt-4" x-data="{
                selectedSubs: [],
                totalSaving: 0,
                toggleSub() { this.totalSaving = this.selectedSubs.reduce((acc, val) => acc + Number(val), 0); }
            }">
                <h4 class="font-bold text-xs text-[var(--text-primary)] mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[var(--text-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg> 
                    Simulasi Pemangkasan Mandiri
                </h4>
                
                <div class="max-h-40 overflow-y-auto space-y-2 mb-4 pr-1">
                    @foreach(auth()->user()->activeSubscriptions as $sub)
                    <label class="flex items-center justify-between p-2 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-color)] cursor-pointer hover:border-indigo-500/40 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <input type="checkbox" value="{{ $sub->monthly_amount }}" x-model="selectedSubs" @change="toggleSub()" class="w-3.5 h-3.5 rounded" style="accent-color: var(--accent-primary);">
                            <span class="text-xs font-semibold text-[var(--text-primary)]">{{ $sub->name }}</span>
                        </div>
                        <span class="text-xs font-bold text-[var(--text-secondary)]">Rp{{ number_format($sub->monthly_amount, 0, ',', '.') }}</span>
                    </label>
                    @endforeach
                </div>
                
                <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-lg p-3 flex justify-between items-center">
                    <span class="text-[11px] font-bold uppercase text-emerald-400 tracking-wide">Uang Terselamatkan</span>
                    <span class="text-base font-black text-emerald-400">
                        Rp<span x-text="new Intl.NumberFormat('id-ID').format(totalSaving)">0</span><span class="text-[10px] font-normal">/bln</span>
                    </span>
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
            if (score >= 80) return 'text-emerald-400';
            if (score >= 50) return 'text-amber-400';
            return 'text-red-400';
        },

        get healthScoreLabel() {
            const score = this.analysisData?.health_score || 0;
            if (score >= 80) return 'Kategori Sangat Baik';
            if (score >= 60) return 'Kategori Baik';
            if (score >= 40) return 'Perlu Perhatian';
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
