@extends('layouts.app')
@section('title', 'Cari Teman Patungan')
@section('heading', 'Cari Teman Patungan')
@section('subheading', 'Temukan grup patungan publik yang sedang mencari anggota')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="section-title">🌍 Grup Publik Terbuka</h3>
            <p class="section-desc">Bergabunglah dengan grup publik untuk berbagi biaya langganan.</p>
        </div>
        <a href="{{ route('shares.index') }}" class="btn-secondary text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Buat Grup Saya
        </a>
    </div>

    @if($publicSubscriptions->isEmpty())
    <div class="card flex flex-col items-center justify-center py-12">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-[var(--text-muted)] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        <p class="text-[var(--text-secondary)] font-bold text-lg">Belum ada grup publik saat ini</p>
        <p class="text-sm text-[var(--text-muted)] mt-1">Jadilah yang pertama membuka grup patungan ke publik!</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($publicSubscriptions as $sub)
        @php
            $currentMembers = $sub->shares->count() + 1; // +1 untuk owner
            $estimatedSplit = round($sub->amount / ($currentMembers + 1));
        @endphp
        <div class="card flex flex-col justify-between transition-all hover:scale-[1.02] border border-[var(--border-color)]">
            <div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shadow-sm" style="background: {{ $sub->category->color ?? 'var(--bg-elevated)' }}20;">
                        {{ $sub->logo ?? ($sub->category->icon ?? '📦') }}
                    </div>
                    <span class="badge badge-accent text-xs">Publik</span>
                </div>
                <h4 class="font-bold text-lg text-[var(--text-primary)] mb-1">{{ $sub->name }}</h4>
                <p class="text-sm text-[var(--text-muted)] mb-4">Host: <span class="font-semibold text-[var(--text-secondary)]">{{ $sub->user->name }}</span></p>
                
                <div class="space-y-2 mb-6 text-sm">
                    <div class="flex justify-between">
                        <span class="text-[var(--text-muted)]">Anggota Saat Ini</span>
                        <span class="font-bold text-[var(--text-primary)]">{{ $currentMembers }} orang</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text-muted)]">Estimasi Patungan</span>
                        <span class="font-bold text-[var(--accent-primary)]">Rp{{ number_format($estimatedSplit, 0, ',', '.') }} /bln</span>
                    </div>
                </div>
            </div>
            
            <a href="{{ $sub->join_url }}" class="btn-primary w-full justify-center">
                Minta Bergabung
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
