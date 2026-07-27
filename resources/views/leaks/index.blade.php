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
        <h3 class="section-title mb-5"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Indikator Kebocoran</h3>
        <div class="space-y-4">
            @forelse($result['leaks'] as $leak)
            <div class="item-row flex-col items-start gap-3" style="border-left: 3px solid {{ $leak['severity'] === 'high' ? 'var(--danger)' : 'var(--warning)' }};">
                <div class="flex items-start justify-between gap-3 w-full">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">{!! $leak['icon'] !!}</span>
                        <h4 class="font-bold text-sm" style="color: var(--text-primary);">{{ $leak['title'] }}</h4>
                    </div>
                    <span class="badge badge-{{ $leak['severity'] === 'high' ? 'cancelled' : 'pending' }}">{{ strtoupper($leak['severity']) }}</span>
                </div>
                <p class="text-xs" style="color: var(--text-secondary);">{{ $leak['description'] }}</p>
                <div class="item-row w-full">
                    <div class="flex items-center gap-2"><span class="text-xs"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg></span><span class="text-xs font-semibold" style="color: var(--text-primary);">{{ $leak['action'] }}</span></div>
                    <span class="text-xs font-bold" style="color: var(--danger);">Hemat Rp{{ number_format($leak['amount'], 0, ',', '.') }}/bln</span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <span class="empty-icon"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></span>
                <p class="empty-title">Selamat!</p>
                <p class="empty-desc">Tidak ada kebocoran uang terdeteksi.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
