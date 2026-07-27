@extends('layouts.app')
@section('title', 'AI Financial Assistant')
@section('heading', 'AI Financial Assistant')
@section('subheading', 'Analisis pengeluaran dan rekomendasi penghematan cerdas')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="card" style="border-left: 3px solid var(--accent-primary);">
        <div class="flex items-start gap-4">
            <div class="icon-box flex-shrink-0" style="background: rgba(124, 58, 237, 0.12);">🤖</div>
            <div>
                <h3 class="section-title mb-1">Ringkasan Analisis AI</h3>
                <p class="text-sm font-semibold mb-3" style="color: var(--text-secondary);">{{ $analysis['summary'] }}</p>
                @if($analysis['potential_savings'] > 0)
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold" style="background: var(--success-bg); color: var(--success);">
                    💰 Potensi Hemat: Rp{{ number_format($analysis['potential_savings'], 0, ',', '.') }}/bulan
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
        <h3 class="section-title mb-2">🧮 Simulasi Penghematan</h3>
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
            <h3 class="section-title mb-4">💡 Insights</h3>
            <div class="space-y-3">
                @foreach($analysis['insights'] as $insight)
                <div class="item-row flex-col items-start gap-2">
                    <div class="flex items-start gap-3">
                        <span class="text-lg">{{ $insight['icon'] }}</span>
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
            <h3 class="section-title mb-4">📝 Rekomendasi</h3>
            <div class="space-y-2">
                @foreach($analysis['recommendations'] as $rec)
                <div class="item-row text-xs">👉 {{ $rec }}</div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
