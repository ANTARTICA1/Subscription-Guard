@extends('layouts.app')
@section('title', 'Tata Asisten')

@section('content')
<div x-data="assistantPage()" x-cloak class="max-w-6xl mx-auto space-y-6 pb-16 px-2 sm:px-4">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Tata Asisten</h1>
        </div>

        <div class="text-left sm:text-right">
            <button @click="triggerScan()" 
                    :disabled="isScanning"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#111c2e] hover:bg-[#16263d] text-white text-xs font-semibold rounded-lg transition-colors cursor-pointer"
                    :class="!isSynced ? 'text-indigo-300 bg-indigo-500/10' : ''">
                <svg x-show="!isScanning" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <svg x-cloak x-show="isScanning" class="animate-spin w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-text="isScanning ? 'Menganalisis...' : 'Pindai Tata Asisten'"></span>
            </button>
            <p class="text-[10px] text-[#4b5e78] mt-1.5 flex items-center justify-start sm:justify-end gap-1.5 font-medium">
                <span class="w-1.5 h-1.5 rounded-full" :class="isScanning ? 'bg-indigo-400 animate-pulse' : (isSynced ? 'bg-emerald-500' : 'bg-amber-500 animate-pulse')"></span> 
                <span x-text="isScanning ? 'Menganalisis saat ini...' : (isSynced ? 'Data Terkini' : (hasNeverScanned ? 'Belum Dipindai' : 'Perubahan Terdeteksi'))"></span>
            </p>
        </div>
    </div>

    <div x-cloak x-show="warningMessage" class="p-4 rounded-2xl bg-amber-500/10 flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1 text-xs">
            <p class="font-bold text-amber-300">Pemberitahuan Sistem</p>
            <p class="text-amber-200/90 mt-0.5 leading-relaxed" x-text="warningMessage"></p>
        </div>
        <button @click="warningMessage = ''" class="text-amber-400 hover:text-amber-200 p-1">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-cloak x-show="!isSynced && !hasNeverScanned && !isScanning" class="p-4 rounded-2xl bg-indigo-500/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs text-[#94a3b8] leading-relaxed">
                Portofolio langganan Anda telah diperbarui sejak audit terakhir. Klik tombol <strong class="text-white">Pindai Tata Asisten</strong> untuk menyelaraskan evaluasi AI.
            </p>
        </div>
        <button @click="triggerScan()" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 whitespace-nowrap self-end sm:self-auto">
            Pindai Sekarang &rarr;
        </button>
    </div>

    <div class="bg-[#0b121f] rounded-2xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        
        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[#94a3b8] mb-1">Health Score</p>
                <div class="flex items-baseline gap-1.5 mb-1">
                    <span class="text-3xl font-black tracking-tight" :class="healthScoreColor" x-text="analysisData.health_score ?? 0"></span>
                    <span class="text-sm font-normal text-[#94a3b8]">/ 100</span>
                </div>
            </div>
            <p class="text-[11px] font-semibold" :class="healthScoreColor" x-text="healthScoreLabel"></p>
        </div>

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[#94a3b8] mb-1">Profil Pengguna</p>
                <h3 class="text-base sm:text-lg font-bold text-white leading-snug tracking-tight mb-1" x-text="analysisData.personality || 'Belum Ada Data'"></h3>
            </div>
            <p class="text-[11px] text-[#4b5e78]">Karakteristik pola langganan</p>
        </div>

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[#94a3b8] mb-1">Pengeluaran Bulanan</p>
                <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight mb-1" x-text="'Rp' + formatMoney(analysisData.total_monthly || 0)"></h3>
            </div>
            <p class="text-[11px] text-[#4b5e78]" x-text="'≈ Rp' + formatMoney(analysisData.total_yearly || 0) + ' / tahun'"></p>
        </div>

        <div class="p-5 flex flex-col justify-between">
            <div>
                <p class="text-xs text-[#94a3b8] mb-1">Potensi Hemat</p>
                <h3 class="text-2xl sm:text-3xl font-black text-emerald-400 tracking-tight mb-1">
                    <span x-text="'Rp' + formatMoney(analysisData.potential_savings || 0)"></span>
                    <span class="text-sm font-normal text-[#94a3b8]">/ bln</span>
                </h3>
            </div>
            <p class="text-[11px] text-[#4b5e78]" x-text="'Hemat Rp' + formatMoney((analysisData.potential_savings || 0) * 12) + ' / tahun'"></p>
        </div>

    </div>

    <div class="bg-[#0b121f] rounded-2xl p-5 sm:p-6 shadow-sm" x-show="analysisData.summary">
        <div class="flex items-start gap-4 sm:gap-5">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[11px] font-bold text-[#64748b] uppercase tracking-wider mb-1.5">Ringkasan Eksekutif</p>
                <p class="text-xs sm:text-sm text-white leading-relaxed" x-html="analysisData.summary"></p>
            </div>
        </div>
    </div>

    <div class="bg-[#0b121f] rounded-2xl p-5 sm:p-6" x-show="healthBreakdown.length > 0">
        <p class="text-xs font-bold text-[#94a3b8] uppercase tracking-wider mb-4">Penjelasan Skor Kesehatan Finansial</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="(item, idx) in healthBreakdown" :key="idx">
                <div class="bg-[#111c2e] p-4 flex flex-col justify-between gap-3">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-white" x-text="item.name"></span>
                            <span class="text-xs font-bold" :class="item.score >= (item.max * 0.75) ? 'text-emerald-400' : (item.score >= (item.max * 0.5) ? 'text-amber-400' : 'text-red-400')" x-text="item.score + '/' + item.max"></span>
                        </div>
                        <div class="w-full bg-[#08101a] h-2 overflow-hidden">
                            <div class="h-2 transition-all duration-700" 
                                 :class="item.score >= (item.max * 0.75) ? 'bg-emerald-500' : (item.score >= (item.max * 0.5) ? 'bg-amber-500' : 'bg-red-500')"
                                 :style="'width:' + ((item.score / Math.max(1, item.max)) * 100) + '%'"></div>
                        </div>
                    </div>
                    <p class="text-[11px] text-[#64748b] leading-snug" x-text="item.desc"></p>
                </div>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-white flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-indigo-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Intelligence Insights
            </h3>
            
            <div class="space-y-3">
                <template x-for="(insight, idx) in analysisData.insights || []" :key="idx">
                    <div class="bg-[#0b121f] rounded-2xl p-5 flex gap-4 sm:gap-5 items-start shadow-sm transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 shrink-0 mt-0.5">
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
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-xs sm:text-sm text-white mb-1" x-text="insight.title"></h4>
                            <p class="text-xs text-[#94a3b8] leading-relaxed" x-html="insight.description"></p>
                        </div>
                    </div>
                </template>

                <template x-if="(!analysisData.insights || analysisData.insights.length === 0)">
                    <div class="bg-[#0b121f] rounded-2xl p-6 text-center text-xs text-[#64748b]">
                        Belum ada insight tersedia.
                    </div>
                </template>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-sm sm:text-base font-bold text-white flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Actionable Recommendations
            </h3>
            
            <div class="space-y-3">
                <template x-for="(rec, idx) in analysisData.recommendations || []" :key="idx">
                    <div class="bg-[#0b121f] rounded-2xl p-5 flex gap-4 sm:gap-5 items-start shadow-sm transition-colors">
                        <span class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5" x-text="idx + 1"></span>
                        <p class="text-xs sm:text-sm text-white leading-relaxed flex-1 min-w-0" x-html="rec"></p>
                    </div>
                </template>

                <template x-if="(!analysisData.recommendations || analysisData.recommendations.length === 0)">
                    <div class="bg-[#0b121f] rounded-2xl p-6 text-center text-xs text-[#64748b]">
                        Tidak ada rekomendasi pemangkasan. Portofolio Anda dalam kondisi prima.
                    </div>
                </template>
            </div>

            <div class="bg-[#0b121f] rounded-2xl p-5 shadow-sm mt-4" x-data="{
                selectedSubs: [],
                totalSaving: 0,
                toggleSub() { this.totalSaving = this.selectedSubs.reduce((acc, val) => acc + Number(val), 0); }
            }">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <h4 class="font-bold text-xs text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#64748b] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg> 
                        Simulasi Pemangkasan Mandiri
                    </h4>
                    <span class="text-[10px] text-[#64748b]">Pilih langganan</span>
                </div>
                
                <div class="max-h-48 overflow-y-auto space-y-2 mb-4 pr-1">
                    @foreach(auth()->user()->activeSubscriptions as $sub)
                    <label class="flex items-center justify-between p-2.5 rounded-lg bg-[#111c2e] hover:bg-[#16263d] cursor-pointer transition-colors">
                        <div class="flex items-center gap-2.5 min-w-0 pr-2">
                            <input type="checkbox" value="{{ $sub->monthly_amount }}" x-model="selectedSubs" @change="toggleSub()" class="w-4 h-4 rounded shrink-0" style="accent-color: var(--accent-primary);">
                            <span class="text-xs font-semibold text-white truncate">{{ $sub->name }}</span>
                        </div>
                        <span class="text-xs font-bold text-[#94a3b8] shrink-0">Rp{{ number_format($sub->monthly_amount, 0, ',', '.') }}</span>
                    </label>
                    @endforeach
                </div>
                
                <div class="pt-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-white">Uang Terselamatkan</p>
                        <p class="text-[10px] text-[#64748b]">Akumulasi langganan dipilih</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-black text-emerald-400 tracking-tight">
                            Rp<span x-text="new Intl.NumberFormat('id-ID').format(totalSaving)">0</span>
                            <span class="text-xs font-normal text-[#94a3b8]">/ bln</span>
                        </p>
                        <p class="text-[10px] text-[#4b5e78]" x-show="totalSaving > 0" x-text="'≈ Rp' + new Intl.NumberFormat('id-ID').format(totalSaving * 12) + ' / tahun'"></p>
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
