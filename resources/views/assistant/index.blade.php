@extends('layouts.app')
@section('title', 'AI Financial Assistant')
@section('heading', 'AI Financial Assistant')
@section('subheading', 'Analisis pengeluaran dan rekomendasi penghematan cerdas')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="card" style="border-left: 3px solid var(--accent-primary);">
        <div class="flex items-start gap-4">
            <div class="icon-box flex-shrink-0" style="background: rgba(124, 58, 237, 0.12);"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></div>
            <div>
                <h3 class="section-title mb-1">Ringkasan Analisis AI</h3>
                <p class="text-sm font-semibold mb-3" style="color: var(--text-secondary);">{{ $analysis['summary'] }}</p>
                @if($analysis['potential_savings'] > 0)
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold" style="background: var(--success-bg); color: var(--success);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Potensi Hemat: Rp{{ number_format($analysis['potential_savings'], 0, ',', '.') }}/bulan
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="stat-card">
            <span class="stat-label">Pengeluaran Bulanan</span>
            <p class="stat-value" style="font-size: 1.5rem;">Rp{{ number_format($analysis['total_monthly'], 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <span class="stat-label">Proyeksi Tahunan</span>
            <p class="stat-value" style="font-size: 1.5rem;">Rp{{ number_format($analysis['total_yearly'], 0, ',', '.') }}</p>
        </div>
        <div class="stat-card">
            <span class="stat-label">Estimasi Hemat / Bulan</span>
            <p class="stat-value" style="font-size: 1.5rem; color: var(--success);">Rp{{ number_format($analysis['potential_savings'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card" x-data="{
        selectedSubs: [],
        totalSaving: 0,
        toggleSub() { this.totalSaving = this.selectedSubs.reduce((acc, val) => acc + Number(val), 0); }
    }">
        <h3 class="section-title mb-2"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg> Simulasi Penghematan</h3>
        <p class="section-desc mb-4">Pilih subscription untuk dibatalkan/downgrade:</p>
        <div class="space-y-2 mb-5">
            @foreach(auth()->user()->activeSubscriptions as $sub)
            <label class="item-row cursor-pointer">
                <div class="flex items-center gap-3">
                    <input type="checkbox" value="{{ $sub->monthly_amount }}" x-model="selectedSubs" @change="toggleSub()" class="w-4 h-4 rounded" style="accent-color: var(--accent-primary);">
                    <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ $sub->name }}</span>
                </div>
                <span class="text-sm font-bold" style="color: var(--text-secondary);">Rp{{ number_format($sub->monthly_amount, 0, ',', '.') }}/bln</span>
            </label>
            @endforeach
        </div>
        <div class="item-row" style="border-color: var(--accent-primary); background: rgba(124, 58, 237, 0.06);">
            <div>
                <p class="stat-label">Hasil Simulasi:</p>
                <p class="text-lg font-extrabold" style="color: var(--success);">Rp<span x-text="new Intl.NumberFormat('id-ID').format(totalSaving)">0</span>/bulan</p>
            </div>
            <div class="text-right">
                <p class="stat-label">Per Tahun:</p>
                <p class="text-lg font-extrabold" style="color: var(--text-primary);">Rp<span x-text="new Intl.NumberFormat('id-ID').format(totalSaving * 12)">0</span></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <h3 class="section-title mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg> Insights</h3>
            <div class="space-y-3">
                @foreach($analysis['insights'] as $insight)
                <div class="item-row flex-col items-start gap-2">
                    <div class="flex items-start gap-3">
                        <span class="text-lg">{!! $insight['icon'] !!}</span>
                        <div>
                            <p class="font-bold text-xs uppercase" style="color: var(--text-primary);">{{ $insight['title'] }}</p>
                            <p class="text-xs mt-1" style="color: var(--text-secondary);">{{ $insight['description'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <h3 class="section-title mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg> Rekomendasi</h3>
            <div class="space-y-2">
                @foreach($analysis['recommendations'] as $rec)
                <div class="item-row text-xs"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg> {{ $rec }}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
