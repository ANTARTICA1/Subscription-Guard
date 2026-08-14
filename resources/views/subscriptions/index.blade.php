@extends('layouts.app')
@section('title', 'Subscriptions')

@section('content')
@section('actions')
    <div class="flex items-center gap-2 md:gap-3">
        <a href="{{ route('subscriptions.export') }}" class="px-3 md:px-4 py-2 md:py-2.5 bg-[#080d19] border border-[rgba(255,255,255,0.06)] hover:bg-[rgba(255,255,255,0.03)] text-white text-[10px] md:text-xs font-bold rounded-lg md:rounded-xl flex items-center gap-1.5 md:gap-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            <span class="hidden sm:inline">Export</span>
        </a>
        
        <a href="{{ route('subscriptions.create') }}" class="px-3 md:px-4 py-2 md:py-2.5 bg-gradient-to-r from-[#3b82f6] to-[#06b6d4] text-white text-[10px] md:text-xs font-bold rounded-lg md:rounded-xl flex items-center gap-1.5 md:gap-2 hover:opacity-90 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            <span class="hidden sm:inline">Tambah</span>
        </a>
    </div>
@endsection


{{-- 4 Metric Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    
    {{-- Card 1: Total Subscription --}}
    <div class="bg-gradient-to-br from-[#1e1536] to-[#0f172a] border border-purple-500/20 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[11px] text-purple-200/60 font-semibold mb-1">Total Subscription</p>
                <h3 class="text-3xl font-bold text-white">{{ $totalActiveCount }}</h3>
                <p class="text-[10px] text-purple-200/50 mt-1">Aktif saat ini</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
            </div>
        </div>
    </div>
    
    {{-- Card 2: Pengeluaran Bulan Ini --}}
    <div class="bg-gradient-to-br from-[#102a24] to-[#0f172a] border border-emerald-500/20 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[11px] text-emerald-200/60 font-semibold mb-1">Pengeluaran Bulan Ini</p>
                <h3 class="text-2xl font-bold text-white mb-1">Rp{{ number_format($monthlySpending, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-[#94a3b8] mt-1"><span class="text-emerald-400 font-bold">+8%</span> dari bulan lalu</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
        </div>
    </div>
    
    {{-- Card 3: Akan Datang --}}
    <div class="bg-gradient-to-br from-[#2a1a10] to-[#0f172a] border border-orange-500/20 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[11px] text-orange-200/60 font-semibold mb-1">Akan Datang</p>
                <h3 class="text-3xl font-bold text-white">{{ $upcomingCount }}</h3>
                <p class="text-[10px] text-orange-200/50 mt-1">Dalam 7 hari</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-400 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
        </div>
    </div>
    
    {{-- Card 4: Total Hemat --}}
    <div class="bg-gradient-to-br from-[#101a2a] to-[#0f172a] border border-blue-500/20 rounded-2xl p-5 relative overflow-hidden">
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[11px] text-blue-200/60 font-semibold mb-1">Total Hemat</p>
                <h3 class="text-2xl font-bold text-white mb-1">Rp{{ number_format($totalSavings, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-[#94a3b8] mt-1">Dari deteksi pemborosan</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>
    
</div>

{{-- Main Dashboard Layout --}}
<div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-2">
    
    {{-- Left Column (Takes 2/3 or 3/4) --}}
    <div class="lg:col-span-2 xl:col-span-3 space-y-6">
        
        {{-- Subscription Aktif List Box --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-6">
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold text-white">Subscription Aktif</h3>
                    <span class="px-2 py-0.5 rounded-lg bg-[#192a42] text-[#94a3b8] text-[10px] font-bold">{{ $totalActiveCount }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative hidden sm:block">
                        <select class="appearance-none bg-[#080d19] border border-[rgba(255,255,255,0.06)] text-[#94a3b8] text-xs font-semibold rounded-lg pl-4 pr-8 py-2 focus:outline-none focus:border-indigo-500 transition-colors">
                            <option>Semua Kategori</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#4b5e78] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                    <button class="px-4 py-2 bg-[#080d19] border border-[rgba(255,255,255,0.06)] text-[#f1f5f9] text-xs font-semibold rounded-lg flex items-center gap-2 hover:bg-[rgba(255,255,255,0.03)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#94a3b8]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Filter
                    </button>
                </div>
            </div>

            <div class="flex flex-col">
                @foreach($subscriptions as $sub)
                @php
                    $isActive = $sub->status === 'active';
                    $progressPercent = $isActive ? max(0, min(100, 100 - ($sub->days_until_payment * 3.33))) : 0;
                    $progressColor = $sub->days_until_payment <= 3 ? 'bg-amber-500' : 'bg-emerald-500';
                @endphp
                <div class="flex flex-col sm:flex-row sm:items-center justify-between py-4 border-b border-[rgba(255,255,255,0.03)] group">
                    
                    {{-- Identity --}}
                    <div class="flex items-center gap-4 sm:w-5/12 mb-3 sm:mb-0">
                        @if($sub->logo)
                        <div class="w-10 h-10 flex-shrink-0 bg-[#080d19] border border-[rgba(255,255,255,0.03)] rounded-full p-2 flex items-center justify-center">
                            <img src="{{ $sub->logo }}" alt="{{ $sub->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                        </div>
                        @else
                        <div class="w-10 h-10 flex-shrink-0 rounded-full flex items-center justify-center text-lg font-bold" style="background: {{ $sub->category->color ?? '#3b82f6' }}15; color: {{ $sub->category->color ?? '#3b82f6' }}">
                            <span class="text-sm font-extrabold uppercase">{{ substr($sub->category->name ?? 'S', 0, 1) }}</span>
                        </div>
                        @endif
                        
                        <div>
                            <h4 class="font-bold text-[#f1f5f9] text-sm leading-tight">{{ $sub->name }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs text-[#94a3b8]">{{ $sub->category->name ?? 'Lainnya' }}</span>
                                @if($isActive)
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 font-bold tracking-wide uppercase">ACTIVE</span>
                                @else
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-[#192a42] text-[#94a3b8] font-bold tracking-wide uppercase">INACTIVE</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Billing --}}
                    <div class="sm:w-4/12 mb-3 sm:mb-0">
                        <p class="text-xs font-bold text-white mb-1">
                            Rp{{ number_format($sub->amount, 0, ',', '.') }} <span class="text-[10px] text-[#4b5e78] font-normal">/ {{ ucfirst($sub->billing_cycle) }}</span>
                        </p>
                        @if($isActive)
                            <p class="text-[10px] text-[#94a3b8] mb-1.5">Renews in {{ $sub->days_until_payment }} hari lagi</p>
                            <div class="w-48 h-0.5 bg-[#192a42] rounded-full overflow-hidden">
                                <div class="h-full {{ $progressColor }} rounded-full" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        @else
                            <p class="text-[10px] text-red-400 mb-1.5">Expired {{ abs($sub->days_until_payment) }} hari yang lalu</p>
                            <div class="w-48 h-0.5 bg-[#192a42] rounded-full overflow-hidden"></div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 justify-end sm:w-3/12">
                        @if($isActive)
                            <a href="{{ route('subscriptions.show', $sub) }}" class="px-4 py-1.5 bg-[#080d19] border border-[rgba(255,255,255,0.06)] hover:bg-[#192a42] text-[#f1f5f9] text-xs font-semibold rounded-lg transition-colors">
                                Kelola
                            </a>
                        @else
                            <form method="POST" action="{{ route('subscriptions.toggle-status', $sub) }}">
                                @csrf
                                <button type="submit" class="px-4 py-1.5 bg-[#080d19] border border-[rgba(255,255,255,0.06)] hover:bg-[#192a42] text-[#f1f5f9] text-xs font-semibold rounded-lg transition-colors whitespace-nowrap">
                                    Aktifkan Kembali
                                </button>
                            </form>
                        @endif
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="p-1.5 bg-[#080d19] border border-[rgba(255,255,255,0.06)] hover:bg-[#192a42] rounded-lg text-[#94a3b8] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                            </button>
                            <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-36 bg-[#111c2e] border border-[rgba(255,255,255,0.1)] rounded-xl shadow-xl z-50 overflow-hidden py-1">
                                <a href="{{ route('subscriptions.edit', $sub) }}" class="flex items-center gap-2 px-4 py-2 text-xs text-[#f1f5f9] hover:bg-[#192a42] transition-colors">Edit</a>
                                @if($isActive)
                                <form method="POST" action="{{ route('subscriptions.toggle-status', $sub) }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-2 text-xs text-[#f1f5f9] hover:bg-[#192a42] transition-colors">Pause</button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('subscriptions.destroy', $sub) }}" onsubmit="return confirm('Hapus subscription ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full flex items-center gap-2 text-left px-4 py-2 text-xs text-red-400 hover:bg-red-500/10 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button class="w-full mt-4 py-3 bg-[#080d19] hover:bg-[#0a1222] border border-[rgba(255,255,255,0.03)] rounded-xl text-xs font-semibold text-[#f1f5f9] transition-colors">
                Lihat Semua Subscription
            </button>
        </div>

        {{-- Kategori Populer --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-white">Kategori Populer</h3>
                <a href="#" class="text-xs text-indigo-400 hover:text-indigo-300">Lihat semua</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($popularCategories->take(5) as $cat)
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl p-4 flex items-center gap-3 hover:border-[rgba(255,255,255,0.15)] transition-colors cursor-pointer">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-extrabold uppercase" style="background: {{ $cat->color }}15; color: {{ $cat->color }}">
                        {{ substr($cat->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">{{ $cat->name }}</p>
                        <p class="text-[10px] text-[#94a3b8]">{{ $cat->active_count }} aktif</p>
                    </div>
                </div>
                @endforeach
                {{-- If less than 5, we can show a placeholder or let it be --}}
                @if($popularCategories->count() < 5)
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl p-4 flex items-center gap-3 opacity-50 cursor-not-allowed">
                    <div class="w-8 h-8 rounded-lg bg-[#192a42] text-[#4b5e78] flex items-center justify-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-white">Lainnya</p>
                        <p class="text-[10px] text-[#94a3b8]">-</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Right Column (Takes 1/3 or 1/4) --}}
    <div class="lg:col-span-1 space-y-6">
        
        {{-- Pembayaran Mendatang --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[13px] font-bold text-white">Pembayaran Mendatang</h3>
                <a href="#" class="text-[10px] text-indigo-400 hover:text-indigo-300">Lihat semua</a>
            </div>
            
            <div class="space-y-4 mb-5">
                @forelse($upcomingPayments as $payment)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($payment->logo)
                        <div class="w-6 h-6 flex-shrink-0 bg-[#080d19] rounded-full p-1 flex items-center justify-center">
                            <img src="{{ $payment->logo }}" class="w-full h-full object-contain">
                        </div>
                        @else
                        <div class="w-6 h-6 flex-shrink-0 rounded-full flex items-center justify-center text-[10px] font-bold" style="background: {{ $payment->category->color ?? '#3b82f6' }}15; color: {{ $payment->category->color ?? '#3b82f6' }}">
                            {!! $payment->category->icon ?? 'S' !!}
                        </div>
                        @endif
                        <p class="text-[11px] font-semibold text-[#f1f5f9]">{{ $payment->name }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-right">
                        <p class="text-[10px] text-[#94a3b8]">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-bold {{ $payment->days_until_payment <= 3 ? 'text-amber-500' : 'text-emerald-500' }} w-14">{{ $payment->days_until_payment }} hari lagi</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-[#4b5e78] text-center py-2">Tidak ada tagihan dalam waktu dekat.</p>
                @endforelse
            </div>
            
            <button class="w-full py-2.5 bg-[#192a42] hover:bg-[#1e3350] border border-[rgba(255,255,255,0.03)] rounded-xl text-[11px] font-bold text-indigo-300 transition-colors">
                Lihat Kalender Lengkap
            </button>
        </div>

        {{-- Pengeluaran Bulanan (Chart Dummy) --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-6 relative">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[13px] font-bold text-white">Pengeluaran Bulanan</h3>
                <div class="relative">
                    <select class="appearance-none bg-transparent border border-[rgba(255,255,255,0.06)] text-[#94a3b8] text-[10px] font-semibold rounded-lg pl-2 pr-6 py-1 focus:outline-none focus:border-indigo-500">
                        <option>6 Bulan Terakhir</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#4b5e78] absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            
            <div class="mb-4">
                <h4 class="text-xl font-bold text-white mb-1">Rp{{ number_format($monthlySpending, 0, ',', '.') }} <span class="text-[10px] text-emerald-400 font-normal">+8% <span class="text-[#4b5e78]">dari bulan lalu</span></span></h4>
            </div>
            
            {{-- Real Chart --}}
            <div class="h-36 w-full mt-6 relative">
                <canvas id="monthlySpendingChart"></canvas>
            </div>
        </div>

        {{-- Tips Hemat --}}
        <div class="bg-[#19150d] border border-amber-500/20 rounded-2xl p-6 relative overflow-hidden">
            <div class="absolute top-4 right-4 w-10 h-10 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
            </div>
            
            <h3 class="text-sm font-bold text-amber-500 mb-4">Tips Hemat</h3>
            
            <p class="text-xs text-[#f1f5f9] mb-2 leading-relaxed">
                Kamu bisa hemat hingga <span class="text-emerald-400 font-bold">Rp248.000/bulan</span>
            </p>
            <p class="text-[10px] text-[#94a3b8] mb-5 leading-relaxed">
                Batalkan 2 subscription yang jarang digunakan.
            </p>
            
            <a href="{{ route('leaks.index') }}" class="inline-block px-4 py-2 border border-amber-500/30 hover:bg-amber-500/10 text-amber-500 text-[10px] font-bold rounded-lg transition-colors text-center">
                Lihat Rekomendasi
            </a>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlySpendingChart');
    if (ctx) {
        const context = ctx.getContext('2d');
        const gradient = context.createLinearGradient(0, 0, 0, 128);
        gradient.addColorStop(0, 'rgba(168, 85, 247, 0.4)');
        gradient.addColorStop(1, 'rgba(168, 85, 247, 0)');

        new Chart(context, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    data: @json($chartData),
                    borderColor: '#a855f7',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#a855f7',
                    pointBorderColor: '#111c2e',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#9333ea',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        displayColors: false,
                        callbacks: {
                            label: (context) => 'Rp' + new Intl.NumberFormat('id-ID').format(context.raw)
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#4b5e78', font: { size: 9, family: 'Inter' } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255,255,255,0.03)', drawBorder: false },
                        ticks: {
                            color: '#4b5e78',
                            font: { size: 9, family: 'Inter' },
                            maxTicksLimit: 4,
                            callback: function(v) {
                                if (v >= 1000000) return (v / 1000000).toFixed(1) + 'M';
                                if (v >= 1000) return (v / 1000) + 'K';
                                return v;
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
