@extends('layouts.app')
@section('title', 'Deteksi Kebocoran Uang')
@section('heading', 'Deteksi Kebocoran Uang')
@section('subheading', 'Sistem pintar mendeteksi pemborosan dan auto-renew tidak disadari')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="card" style="border-left: 3px solid {{ $result['health_grade'] === 'A+' ? 'var(--success)' : ($result['health_grade'] === 'B' ? 'var(--warning)' : 'var(--danger)') }};">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="icon-box text-3xl font-black text-white" style="width: 64px; height: 64px; border-radius: 20px; background: {{ $result['health_grade'] === 'A+' ? 'var(--success)' : ($result['health_grade'] === 'B' ? 'var(--warning)' : 'var(--danger)') }}; font-size: 1.2rem;">
                    {{ $result['health_grade'] }}
                </div>
                <div>
                    <h3 class="text-lg font-bold" style="color: var(--text-primary);">
                        @if($result['health_grade'] === 'A+') Kondisi Sangat Sehat
                        @elseif($result['health_grade'] === 'B') Kebocoran Ringan
                        @else Waspada! Kebocoran Signifikan @endif
                    </h3>
                    <p class="text-xs" style="color: var(--text-muted);">Terdeteksi {{ $result['leak_count'] }} potensi kebocoran.</p>
                </div>
            </div>
            <div class="text-right">
                <p class="stat-label">Estimasi Kebocoran / Bln</p>
                <p class="text-2xl font-extrabold" style="color: var(--danger);">Rp{{ number_format($result['total_monthly_leak'], 0, ',', '.') }}</p>
                <p class="text-xs font-bold" style="color: var(--text-secondary);">≈ Rp{{ number_format($result['total_yearly_leak'], 0, ',', '.') }} / tahun</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="section-title mb-5">🚨 Indikator Kebocoran</h3>
        <div class="space-y-4">
            @forelse($result['leaks'] as $leak)
            <div class="item-row flex-col items-start gap-3" style="border-left: 3px solid {{ $leak['severity'] === 'high' ? 'var(--danger)' : 'var(--warning)' }};">
                <div class="flex items-start justify-between gap-3 w-full">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">{{ $leak['icon'] }}</span>
                        <h4 class="font-bold text-sm" style="color: var(--text-primary);">{{ $leak['title'] }}</h4>
                    </div>
                    <span class="badge badge-{{ $leak['severity'] === 'high' ? 'cancelled' : 'pending' }}">{{ strtoupper($leak['severity']) }}</span>
                </div>
                <p class="text-xs" style="color: var(--text-secondary);">{{ $leak['description'] }}</p>
                <div class="item-row w-full">
                    <div class="flex items-center gap-2"><span class="text-xs">💡</span><span class="text-xs font-semibold" style="color: var(--text-primary);">{{ $leak['action'] }}</span></div>
                    <span class="text-xs font-bold" style="color: var(--danger);">Hemat Rp{{ number_format($leak['amount'], 0, ',', '.') }}/bln</span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <span class="empty-icon">🎉</span>
                <p class="empty-title">Selamat!</p>
                <p class="empty-desc">Tidak ada kebocoran uang terdeteksi.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
