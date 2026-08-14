@extends('layouts.app')
@section('title', 'Deteksi Kebocoran')

@section('content')

<div x-data="leaksPage()" x-cloak class="space-y-6 pb-12">

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
        Halo, {{ explode(' ', Auth::user()->name)[0] }}!
    </h2>
    <p class="text-[13px] text-[#94a3b8] mt-1">Kami memindai keuanganmu untuk menemukan potensi kebocoran.</p>
</div>

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Deteksi Kebocoran</h1>
    <div class="text-right">
        <button @click="scan()" class="inline-flex items-center gap-2 px-4 py-2 bg-transparent border border-[rgba(255,255,255,0.1)] hover:border-[rgba(255,255,255,0.3)] text-white text-xs font-semibold rounded-lg transition-colors" :disabled="isScanning">
            <svg x-show="!isScanning" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            <svg x-cloak x-show="isScanning" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <span x-text="isScanning ? 'Memindai...' : 'Pindai Ulang'"></span>
        </button>
        <p class="text-[9px] text-[#4b5e78] mt-1.5 flex items-center justify-end gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full" :class="isScanning ? 'bg-amber-500 animate-pulse' : 'bg-emerald-500'"></span> 
            <span x-text="isScanning ? 'Memindai saat ini...' : scanStatusText"></span>
        </p>
    </div>
</div>

    {{-- Top Threat Card --}}
    <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl relative overflow-hidden flex flex-col md:flex-row">
        
        {{-- Left Accent --}}
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b to-transparent" :class="threatColorClass.gradient"></div>
        {{-- Inner Glow --}}
        <div class="absolute -left-32 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full blur-[100px] opacity-[0.08] pointer-events-none" :class="threatColorClass.bg"></div>

        <div class="flex-1 p-6 md:p-8 flex flex-col md:flex-row items-center gap-8 border-b md:border-b-0 md:border-r border-[rgba(255,255,255,0.04)] relative z-10">
            {{-- Radar --}}
            <div class="relative w-28 h-28 flex items-center justify-center flex-shrink-0">
                <div class="absolute inset-0 rounded-full border" :class="threatColorClass.border20"></div>
                <div class="absolute inset-2 rounded-full border" :class="threatColorClass.border40"></div>
                <div class="absolute inset-4 rounded-full border" :class="threatColorClass.border60 + ' ' + threatColorClass.shadow"></div>
                <div class="absolute inset-0 rounded-full animate-pulse" :class="threatColorClass.bg10"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 relative z-10" :class="threatColorClass.text" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            
            <div>
                <p class="text-xs text-[#94a3b8] mb-1">Risiko Kebocoran</p>
                <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-2xl font-black" :class="threatColorClass.text" x-text="threatLevel"></h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="threatColorClass.text" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                </div>
                <p class="text-xs text-[#4b5e78]" x-text="`Terdeteksi ${leaks.length} potensi kebocoran yang bisa menguras uangmu.`">
                </p>
            </div>
        </div>
        
        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center relative z-10 border-b md:border-b-0 md:border-r border-[rgba(255,255,255,0.04)]">
            <p class="text-xs text-[#94a3b8] mb-1">Estimasi Kebocoran / Bulan</p>
            <h3 class="text-3xl font-black text-[#ef4444] tracking-tight mb-1" x-text="'Rp' + formatMoney(totalSavings)">
            </h3>
            <p class="text-[11px] text-[#4b5e78]" x-text="'≈ Rp' + formatMoney(totalSavings * 12) + ' / tahun'"></p>
        </div>

        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center relative z-10">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-[#94a3b8] mb-1">Uang yang Bisa Diselamatkan</p>
                    <h3 class="text-2xl font-black text-emerald-400 tracking-tight mb-1">
                        <span x-text="'Rp' + formatMoney(totalSavings)"></span> <span class="text-sm font-normal text-[#94a3b8]">/ bln</span>
                    </h3>
                    <p class="text-[11px] text-[#4b5e78]" x-text="'Rp' + formatMoney(totalSavings * 12) + ' / tahun'"></p>
                </div>
                <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="flex items-center justify-between gap-4 py-2 border-b border-[rgba(255,255,255,0.04)] overflow-x-auto pb-4">
        <div class="flex gap-2 min-w-max">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-transparent text-[#94a3b8] hover:bg-[#111c2e] border-transparent'" class="px-4 py-1.5 text-xs font-semibold rounded-full border transition-colors">
                Semua
            </button>
            <button @click="filter = 'high'" :class="filter === 'high' ? 'bg-red-500/10 text-red-400 border-red-500/20' : 'bg-transparent text-[#94a3b8] hover:bg-[#111c2e] border-transparent'" class="px-4 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
                Risiko Tinggi <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full" x-text="highLeaksCount"></span>
            </button>
            <button @click="filter = 'medium'" :class="filter === 'medium' ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-transparent text-[#94a3b8] hover:bg-[#111c2e] border-transparent'" class="px-4 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
                Risiko Sedang <span class="bg-amber-500 text-white text-[9px] px-1.5 py-0.5 rounded-full" x-text="medLeaksCount"></span>
            </button>
            <button @click="filter = 'low'" :class="filter === 'low' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-transparent text-[#94a3b8] hover:bg-[#111c2e] border-transparent'" class="px-4 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
                Risiko Rendah <span class="bg-blue-500 text-white text-[9px] px-1.5 py-0.5 rounded-full" x-text="lowLeaksCount"></span>
            </button>
            <button @click="filter = 'safe'" :class="filter === 'safe' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-transparent text-[#94a3b8] hover:bg-[#111c2e] border-transparent'" class="px-4 py-1.5 text-xs font-semibold rounded-full border transition-colors flex items-center gap-1.5">
                Aman <span class="bg-emerald-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">0</span>
            </button>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="relative">
                <select x-model="sortMethod" class="appearance-none bg-[#111c2e] border border-[rgba(255,255,255,0.06)] text-white text-xs font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none cursor-pointer hover:border-indigo-500 transition-colors">
                    <option value="newest">Terbaru</option>
                    <option value="highest_risk">Risiko Tertinggi</option>
                    <option value="largest_saving">Hemat Terbesar</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#94a3b8] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </div>
        </div>
    </div>

    {{-- Leak Cards List --}}
    <div class="space-y-4">
        <template x-for="leak in sortedAndFilteredLeaks" :key="leak.id">
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.03)] rounded-2xl p-6 relative overflow-hidden group transition-colors" :class="leak.severity === 'high' ? 'hover:border-[#ef4444]/30' : (leak.severity === 'medium' ? 'hover:border-[#f59e0b]/30' : 'hover:border-blue-500/30')">
                
                {{-- Left Glowing Line --}}
                <div x-show="leak.severity !== 'low'" class="absolute left-0 top-6 bottom-6 w-[3px] rounded-r-full" :class="leak.severity === 'high' ? 'bg-[#ef4444] shadow-[0_0_10px_rgba(239,68,68,0.8)]' : 'bg-[#f59e0b] shadow-[0_0_10px_rgba(245,158,11,0.8)]'"></div>
                
                <div class="flex flex-col lg:flex-row gap-6 pl-2 relative z-10">
                    
                    {{-- Identity --}}
                    <div class="flex items-start gap-4 lg:w-1/3">
                        <div class="w-12 h-12 rounded-xl border flex items-center justify-center flex-shrink-0" :class="leak.severity === 'high' ? 'border-[#ef4444]/20 bg-[#ef4444]/5 text-[#ef4444]' : (leak.severity === 'medium' ? 'border-[#f59e0b]/20 bg-[#f59e0b]/5 text-[#f59e0b]' : 'border-blue-500/20 bg-blue-500/5 text-blue-500')">
                            <template x-if="leak.severity === 'high'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </template>
                            <template x-if="leak.severity !== 'high'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </template>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-white text-base truncate max-w-[200px]" x-text="leak.title"></h4>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider" :class="leak.severity === 'high' ? 'bg-[#ef4444]/10 text-[#ef4444]' : (leak.severity === 'medium' ? 'bg-[#f59e0b]/10 text-[#f59e0b]' : 'bg-blue-500/10 text-blue-500')" x-text="leak.severity === 'high' ? 'TINGGI' : (leak.severity === 'medium' ? 'SEDANG' : 'RENDAH')"></span>
                            </div>
                            <p class="text-[11px] text-[#4b5e78]">Rp<span x-text="formatMoney(leak.potential_savings)"></span> / Monthly</p>
                        </div>
                    </div>
                    
                    {{-- Details & Recommendation --}}
                    <div class="lg:w-2/3 flex flex-col justify-between">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <h5 class="text-sm font-bold text-white mb-1" x-text="leak.title"></h5>
                                <p class="text-xs text-[#94a3b8] leading-relaxed" x-html="leak.description"></p>
                            </div>
                        </div>
                        
                        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.03)] rounded-lg p-3 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                                <p class="text-[11px] text-[#94a3b8]" x-html="leak.recommendation"></p>
                            </div>
                            <template x-if="leak.potential_savings > 0">
                                <span class="text-[10px] font-bold tracking-wide whitespace-nowrap" :class="leak.severity === 'high' ? 'text-[#ef4444]' : (leak.severity === 'medium' ? 'text-[#f59e0b]' : 'text-blue-500')">Hemat Rp<span x-text="formatMoney(leak.potential_savings)"></span>/bln</span>
                            </template>
                        </div>
                    </div>
                    
                </div>
            </div>
        </template>
        
        <template x-if="sortedAndFilteredLeaks.length === 0">
            <div class="bg-[#0b121f] rounded-2xl p-10 text-center border border-[rgba(255,255,255,0.04)]">
                <p class="text-[#94a3b8]">Tidak terdeteksi ada pemborosan di kategori ini.</p>
            </div>
        </template>
    </div>

    {{-- Bottom Mini Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        {{-- Stat 1 --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 flex flex-col justify-center items-start gap-4 hover:border-emerald-500/20 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center flex-shrink-0 border border-emerald-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white mb-1.5">Cara Kerja Deteksi Kebocoran</h4>
                <p class="text-xs text-[#94a3b8] mb-3 leading-relaxed">Kami menganalisis pola pembayaran, auto-renewal, dan aktivitas untuk menemukan potensi kebocoran.</p>
                <a href="#" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition-colors">Pelajari Selengkapnya →</a>
            </div>
        </div>

        {{-- Stat 2 --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 flex flex-col justify-center items-start gap-4 hover:border-indigo-500/20 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center flex-shrink-0 border border-indigo-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-[#94a3b8] mb-1.5">Total Pengeluaran Bulan Ini</p>
                <h4 class="text-2xl font-black text-white mb-1.5">Rp{{ number_format(Auth::user()->monthlyExpense(), 0, ',', '.') }}</h4>
                <p class="text-xs text-[#4b5e78]">{{ Auth::user()->activeSubscriptions()->count() }} Layanan Aktif</p>
            </div>
        </div>

        {{-- Stat 3 --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 flex flex-col justify-center items-start gap-4 hover:border-blue-500/20 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0 border border-blue-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <div class="w-full">
                <p class="text-xs font-medium text-[#94a3b8] mb-1.5">Rata-rata Kebocoran / Bulan</p>
                <h4 class="text-2xl font-black text-white mb-1.5" x-text="'Rp' + formatMoney(totalSavings)"></h4>
                <p class="text-xs text-[#4b5e78]"><span x-text="totalSavings > 0 ? (totalSavings / {{ max(1, Auth::user()->monthlyExpense()) }} * 100).toFixed(1) : 0"></span>% dari total pengeluaran</p>
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
