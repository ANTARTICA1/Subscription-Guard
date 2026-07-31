@extends('layouts.app')
@section('title', 'Deteksi Pemborosan')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h2 class="text-2xl font-extrabold text-[var(--text-primary)]">Deteksi Pemborosan</h2>
            <p class="text-[var(--text-secondary)] mt-1">Sistem pintar mendeteksi anomali pengeluaran dan peluang optimasi.</p>
        </div>
    </div>

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            
            <div class="flex items-center gap-5 md:col-span-1">
                <div class="relative w-24 h-24 flex items-center justify-center rounded-full border-4 {{ $result['efficiency_score'] >= 80 ? 'border-emerald-500' : ($result['efficiency_score'] >= 50 ? 'border-amber-500' : 'border-red-500') }} bg-[var(--bg-primary)] shadow-inner">
                    <span class="text-3xl font-black {{ $result['efficiency_score'] >= 80 ? 'text-emerald-500' : ($result['efficiency_score'] >= 50 ? 'text-amber-500' : 'text-red-500') }}">{{ $result['efficiency_score'] }}%</span>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-[var(--text-primary)]">Tingkat Efisiensi</h3>
                    <p class="text-sm text-[var(--text-secondary)] mt-1">
                        @if($result['efficiency_score'] >= 80)
                            Sangat Efisien
                        @elseif($result['efficiency_score'] >= 50)
                            Cukup Efisien
                        @else
                            Banyak Pemborosan
                        @endif
                    </p>
                </div>
            </div>


            <div class="md:col-span-2 flex flex-col md:flex-row gap-6 md:justify-end">
                <div class="bg-[var(--bg-primary)] rounded-xl p-5 border border-[var(--border-light)] min-w-[200px]">
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Potensi Hemat / Bulan</p>
                    <p class="text-2xl font-black text-emerald-600">Rp{{ number_format($result['total_potential_savings'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-[var(--bg-primary)] rounded-xl p-5 border border-[var(--border-light)] min-w-[200px]">
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Potensi Hemat / Tahun</p>
                    <p class="text-2xl font-black text-emerald-600">Rp{{ number_format($result['total_potential_savings'] * 12, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-bold text-[var(--text-primary)] mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Temuan Analisis
        </h3>

        <div class="grid grid-cols-1 gap-4">
            @forelse($result['leaks'] as $leak)
                <div class="bg-[var(--bg-card)] border {{ $leak['severity'] === 'high' ? 'border-red-200' : 'border-[var(--border-color)]' }} rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
                    
                    @if($leak['severity'] === 'high')
                        <div class="absolute top-0 left-0 w-1 h-full bg-red-500"></div>
                    @endif

                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-5">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-12 h-12 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-light)] flex items-center justify-center text-[var(--text-secondary)]">
                                @if($leak['icon'] === 'layers')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                @elseif($leak['icon'] === 'droplet')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                @elseif($leak['icon'] === 'refresh-cw')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <h4 class="font-bold text-[var(--text-primary)] text-lg">{{ $leak['title'] }}</h4>
                                    @if($leak['severity'] === 'high')
                                        <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">High Impact</span>
                                    @endif
                                </div>
                                <p class="text-[var(--text-secondary)] text-sm leading-relaxed mb-3">{!! $leak['description'] !!}</p>
                                
                                <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 inline-block w-full">
                                    <p class="text-sm text-indigo-900"><strong class="font-bold">Rekomendasi:</strong> {!! $leak['recommendation'] !!}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($leak['potential_savings'] > 0)
                        <div class="md:text-right flex-shrink-0 md:min-w-[150px]">
                            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Bisa Hemat</p>
                            <p class="text-lg font-black text-emerald-600">Rp{{ number_format($leak['potential_savings'], 0, ',', '.') }}<span class="text-xs font-medium text-[var(--text-muted)]">/bln</span></p>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-12 text-center">
                    <div class="w-20 h-20 mx-auto bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[var(--text-primary)] mb-2">Semua Aman!</h3>
                    <p class="text-[var(--text-secondary)]">AI kami tidak menemukan kebocoran pengeluaran yang signifikan. Pertahankan kesehatan finansial Anda!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
