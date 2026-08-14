@extends('layouts.app')
@section('title', 'Deteksi Kebocoran')

@section('content')

{{-- Header --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
            Halo, {{ explode(' ', Auth::user()->name)[0] }}!
        </h2>
        <p class="text-[13px] text-[#94a3b8] mt-1">Kami memindai keuanganmu untuk menemukan potensi kebocoran.</p>
    </div>
    
    <div class="flex items-center gap-4">
        {{-- Search Bar --}}
        <div class="relative hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" placeholder="Cari subscription, kategori, atau teman..." class="w-72 bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-12 py-2.5 text-xs text-[#f1f5f9] focus:outline-none focus:border-emerald-500 transition-colors">
        </div>
        
        {{-- Bell Icon --}}
        <button class="relative p-2.5 bg-[#111c2e] border border-[rgba(255,255,255,0.06)] hover:bg-[#192a42] rounded-xl text-[#94a3b8] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-[#111c2e]"></span>
        </button>
        
        {{-- Profile Avatar --}}
        <div class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.1)] overflow-hidden">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2d3748&color=fff" alt="Profile" class="w-full h-full object-cover">
        </div>
    </div>
</div>

<div class="flex items-center justify-between mb-8">
    <h1 class="text-2xl font-bold text-white tracking-tight">Deteksi Kebocoran</h1>
    <div class="text-right">
        <a href="{{ route('leaks.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-transparent border border-[rgba(255,255,255,0.1)] hover:border-[rgba(255,255,255,0.3)] text-white text-xs font-semibold rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            Pindai Ulang
        </a>
        <p class="text-[9px] text-[#4b5e78] mt-1.5 flex items-center justify-end gap-1.5">
            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Terakhir dipindai: 1 jam lalu
        </p>
    </div>
</div>

<div class="space-y-6 pb-12">

    {{-- Top Threat Card --}}
    @php
        $highLeaks = collect($result['leaks'])->filter(fn($l) => $l['severity'] === 'high')->count();
        $medLeaks = collect($result['leaks'])->filter(fn($l) => $l['severity'] === 'medium')->count();
        $totalLeaks = count($result['leaks']);
        
        // Define threat level based on amount
        $threatLevel = $result['total_potential_savings'] >= 100000 ? 'TINGGI' : ($result['total_potential_savings'] > 0 ? 'SEDANG' : 'AMAN');
        $threatColor = $threatLevel === 'TINGGI' ? 'ef4444' : ($threatLevel === 'SEDANG' ? 'f59e0b' : '10b981');
    @endphp
    
    <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl relative overflow-hidden flex flex-col md:flex-row">
        
        {{-- Left Accent --}}
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#{{ $threatColor }}] to-transparent"></div>
        {{-- Inner Glow --}}
        <div class="absolute -left-32 top-1/2 -translate-y-1/2 w-96 h-96 bg-[#{{ $threatColor }}] rounded-full blur-[100px] opacity-[0.08] pointer-events-none"></div>

        <div class="flex-1 p-6 md:p-8 flex flex-col md:flex-row items-center gap-8 border-b md:border-b-0 md:border-r border-[rgba(255,255,255,0.04)] relative z-10">
            {{-- Radar --}}
            <div class="relative w-28 h-28 flex items-center justify-center flex-shrink-0">
                <div class="absolute inset-0 rounded-full border border-[#{{ $threatColor }}]/20"></div>
                <div class="absolute inset-2 rounded-full border border-[#{{ $threatColor }}]/40"></div>
                <div class="absolute inset-4 rounded-full border border-[#{{ $threatColor }}]/60 shadow-[0_0_20px_rgba({{ hexdec(substr($threatColor,0,2)) }},{{ hexdec(substr($threatColor,2,2)) }},{{ hexdec(substr($threatColor,4,2)) }},0.3)]"></div>
                <div class="absolute inset-0 bg-[#{{ $threatColor }}]/10 rounded-full animate-pulse"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#{{ $threatColor }}] relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            
            <div>
                <p class="text-xs text-[#94a3b8] mb-1">Risiko Kebocoran</p>
                <div class="flex items-center gap-2 mb-2">
                    <h3 class="text-2xl font-black text-[#{{ $threatColor }}]">{{ $threatLevel }}</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#{{ $threatColor }}]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                </div>
                <p class="text-xs text-[#4b5e78]">
                    Terdeteksi {{ $totalLeaks }} potensi kebocoran yang bisa menguras uangmu.
                </p>
            </div>
        </div>
        
        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center relative z-10 border-b md:border-b-0 md:border-r border-[rgba(255,255,255,0.04)]">
            <p class="text-xs text-[#94a3b8] mb-1">Estimasi Kebocoran / Bulan</p>
            <h3 class="text-3xl font-black text-[#ef4444] tracking-tight mb-1">
                Rp{{ number_format($result['total_potential_savings'], 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-[#4b5e78]">≈ Rp{{ number_format($result['total_potential_savings'] * 12, 0, ',', '.') }} / tahun</p>
        </div>

        <div class="flex-1 p-6 md:p-8 flex flex-col justify-center relative z-10">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-[#94a3b8] mb-1">Uang yang Bisa Diselamatkan</p>
                    <h3 class="text-2xl font-black text-emerald-400 tracking-tight mb-1">
                        Rp{{ number_format($result['total_potential_savings'], 0, ',', '.') }} <span class="text-sm font-normal text-[#94a3b8]">/ bln</span>
                    </h3>
                    <p class="text-[11px] text-[#4b5e78]">Rp{{ number_format($result['total_potential_savings'] * 12, 0, ',', '.') }} / tahun</p>
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
            <button class="px-4 py-1.5 bg-emerald-500/10 text-emerald-400 text-xs font-semibold rounded-full border border-emerald-500/20">
                Semua
            </button>
            <button class="px-4 py-1.5 bg-transparent hover:bg-[#111c2e] text-[#94a3b8] text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
                Risiko Tinggi <span class="bg-red-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">{{ $highLeaks }}</span>
            </button>
            <button class="px-4 py-1.5 bg-transparent hover:bg-[#111c2e] text-[#94a3b8] text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
                Risiko Sedang <span class="bg-amber-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">{{ $medLeaks }}</span>
            </button>
            <button class="px-4 py-1.5 bg-transparent hover:bg-[#111c2e] text-[#94a3b8] text-xs font-semibold rounded-full transition-colors flex items-center gap-1.5">
                Aman <span class="bg-emerald-500 text-white text-[9px] px-1.5 py-0.5 rounded-full">3</span>
            </button>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="relative">
                <select class="appearance-none bg-[#111c2e] border border-[rgba(255,255,255,0.06)] text-white text-xs font-semibold rounded-lg pl-3 pr-8 py-1.5 focus:outline-none cursor-pointer">
                    <option>Terbaru</option>
                    <option>Risiko Tertinggi</option>
                    <option>Hemat Terbesar</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#94a3b8] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </div>
            <button class="p-1.5 bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-lg text-[#94a3b8] hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
            </button>
        </div>
    </div>

    {{-- Leak Cards List --}}
    <div class="space-y-4">
        @forelse($result['leaks'] as $leak)
            @php
                $color = $leak['severity'] === 'high' ? 'ef4444' : ($leak['severity'] === 'medium' ? 'f59e0b' : '10b981');
                $badgeText = strtoupper($leak['severity']);
            @endphp
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.03)] rounded-2xl p-6 relative overflow-hidden group hover:border-[#{{ $color }}]/30 transition-colors">
                
                {{-- Left Glowing Line --}}
                <div class="absolute left-0 top-6 bottom-6 w-[3px] bg-[#{{ $color }}] rounded-r-full shadow-[0_0_10px_rgba({{ hexdec(substr($color,0,2)) }},{{ hexdec(substr($color,2,2)) }},{{ hexdec(substr($color,4,2)) }},0.8)]"></div>
                
                <div class="flex flex-col lg:flex-row gap-6 pl-2 relative z-10">
                    
                    {{-- Identity --}}
                    <div class="flex items-start gap-4 lg:w-1/3">
                        <div class="w-12 h-12 rounded-xl border border-[#{{ $color }}]/20 bg-[#{{ $color }}]/5 flex items-center justify-center text-[#{{ $color }}] flex-shrink-0">
                            @if($leak['severity'] === 'high')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-bold text-white text-base truncate max-w-[200px]">{{ $leak['title'] }}</h4>
                                <span class="bg-[#{{ $color }}]/10 text-[#{{ $color }}] text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">{{ $badgeText }}</span>
                            </div>
                            <p class="text-[11px] text-[#4b5e78]">Rp{{ number_format($leak['potential_savings'], 0, ',', '.') }} / Monthly</p>
                        </div>
                    </div>
                    
                    {{-- Details & Recommendation --}}
                    <div class="lg:w-2/3 flex flex-col justify-between">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <h5 class="text-sm font-bold text-white mb-1">{{ $leak['title'] }}</h5>
                                <p class="text-xs text-[#94a3b8] leading-relaxed">{!! $leak['description'] !!}</p>
                            </div>
                            <button class="text-[#4b5e78] hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </button>
                        </div>
                        
                        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.03)] rounded-lg p-3 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                                <p class="text-[11px] text-[#94a3b8]">{!! $leak['recommendation'] !!}</p>
                            </div>
                            @if($leak['potential_savings'] > 0)
                                <span class="text-[10px] font-bold text-[#{{ $color }}] tracking-wide whitespace-nowrap">Hemat Rp{{ number_format($leak['potential_savings'], 0, ',', '.') }}/bln</span>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        @empty
            <div class="bg-[#0b121f] rounded-2xl p-10 text-center border border-[rgba(255,255,255,0.04)]">
                <p class="text-[#94a3b8]">Yeay! Tidak terdeteksi ada pemborosan di akun Anda.</p>
            </div>
        @endforelse
    </div>

    {{-- Bottom Mini Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        {{-- Stat 1 --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-xl p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center flex-shrink-0 border border-emerald-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-white mb-1">Cara Kerja Deteksi Kebocoran</h4>
                <p class="text-[10px] text-[#4b5e78] mb-2 leading-tight">Kami menganalisis pola pembayaran, auto-renewal, dan aktivitas untuk menemukan potensi kebocoran.</p>
                <a href="#" class="text-[10px] font-bold text-emerald-400 hover:text-emerald-300">Pelajari Selengkapnya →</a>
            </div>
        </div>

        {{-- Stat 2 --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-xl p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center flex-shrink-0 border border-indigo-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
            </div>
            <div>
                <p class="text-[10px] text-[#94a3b8] mb-0.5">Total Pengeluaran Bulan Ini</p>
                <h4 class="text-xl font-black text-white mb-0.5">Rp{{ number_format(Auth::user()->monthlyExpense(), 0, ',', '.') }}</h4>
                <p class="text-[10px] text-[#4b5e78]">{{ Auth::user()->activeSubscriptions()->count() }} Layanan Aktif</p>
            </div>
        </div>

        {{-- Stat 3 --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-xl p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0 border border-blue-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <p class="text-[10px] text-[#94a3b8] mb-0.5">Rata-rata Kebocoran / Bulan</p>
                <h4 class="text-xl font-black text-white mb-0.5">Rp{{ number_format($result['total_potential_savings'], 0, ',', '.') }}</h4>
                @php
                    $expense = Auth::user()->monthlyExpense();
                    $pct = $expense > 0 ? round(($result['total_potential_savings'] / $expense) * 100, 1) : 0;
                @endphp
                <p class="text-[10px] text-[#4b5e78]">{{ $pct }}% dari total pengeluaran</p>
            </div>
        </div>
    </div>

</div>

@endsection
