@extends('layouts.app')
@section('title', 'Tata Asisten')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-[var(--text-primary)]">Tata Asisten</h2>
            <p class="text-[var(--text-secondary)] mt-1">Sistem analisis prediktif dan profil finansial personal Anda.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm col-span-1 md:col-span-1">
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-2">Health Score</p>
            @if($analysis['personality'] === 'Belum Ada Data')
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black text-gray-400">-</span>
                    <span class="text-sm font-semibold text-[var(--text-secondary)]">/ 100</span>
                </div>
                <p class="text-[10px] text-[var(--text-muted)] mt-2">Belum ada data untuk dianalisis.</p>
            @else
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black {{ $analysis['health_score'] >= 80 ? 'text-emerald-500' : ($analysis['health_score'] >= 50 ? 'text-amber-500' : 'text-red-500') }}">{{ $analysis['health_score'] }}</span>
                    <span class="text-sm font-semibold text-[var(--text-secondary)]">/ 100</span>
                </div>
            @endif
        </div>
        
        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm col-span-1 md:col-span-1">
            <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-2">Profil Pengguna</p>
            <span class="inline-block bg-[var(--accent-primary)]/10 border border-[var(--accent-primary)]/20 text-[var(--accent-primary)] font-bold px-3 py-1.5 rounded-lg text-sm truncate w-full" title="{{ $analysis['personality'] }}">
                {{ $analysis['personality'] }}
            </span>
        </div>

        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm col-span-1 md:col-span-2 flex flex-col justify-center">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Pengeluaran Bulanan</p>
                    <p class="text-2xl font-black text-[var(--text-primary)]">Rp{{ number_format($analysis['total_monthly'], 0, ',', '.') }}</p>
                </div>
                <div class="text-right border-l border-[var(--border-light)] pl-4">
                    <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-1">Potensi Hemat</p>
                    <p class="text-xl font-bold text-emerald-600">Rp{{ number_format($analysis['potential_savings'], 0, ',', '.') }}<span class="text-xs font-medium text-[var(--text-muted)]">/bln</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-5 shadow-sm">
        <p class="text-xs font-bold text-[var(--text-muted)] uppercase tracking-wider mb-4">Penjelasan Skor Kesehatan Finansial (Breakdown)</p>
        @if($analysis['personality'] === 'Belum Ada Data')
        <div class="bg-[var(--bg-primary)] border border-dashed border-[var(--border-color)] rounded-xl p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-[var(--text-muted)] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            <h4 class="font-bold text-[var(--text-primary)] mb-1">Butuh Data Langganan</h4>
            <p class="text-sm text-[var(--text-secondary)]">Skor kesehatan finansial Anda akan muncul di sini setelah Anda menambahkan daftar langganan aktif. Silakan tambahkan langganan Anda terlebih dahulu.</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($analysis['health_data']['breakdown'] as $b)
            <div class="bg-[var(--bg-primary)] p-3 rounded-lg border border-[var(--border-color)]">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-bold text-[var(--text-primary)]">{{ $b['name'] }}</span>
                    <span class="text-xs font-bold {{ $b['score'] == $b['max'] ? 'text-emerald-500' : 'text-indigo-600' }}">{{ $b['score'] }}/{{ $b['max'] }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mb-2">
                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ ($b['score'] / max(1, $b['max'])) * 100 }}%"></div>
                </div>
                <p class="text-[10px] text-[var(--text-muted)] leading-tight">{{ $b['desc'] }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="space-y-6">
            <h3 class="text-lg font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Intelligence Insights
            </h3>
            
            <div class="space-y-4">
                @forelse($analysis['insights'] as $insight)
                <div class="bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl p-4 flex gap-4 items-start shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-[var(--accent-primary)]/10 border border-[var(--accent-primary)]/20 flex items-center justify-center text-[var(--accent-primary)] flex-shrink-0">
                        @if($insight['icon'] === 'trending-up')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        @elseif($insight['icon'] === 'pie-chart')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-[var(--text-primary)] mb-1">{{ $insight['title'] }}</h4>
                        <p class="text-sm text-[var(--text-secondary)] leading-relaxed">{!! $insight['description'] !!}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-[var(--text-muted)] italic">Belum ada insight yang tersedia.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-lg font-bold text-[var(--text-primary)] border-b border-[var(--border-color)] pb-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Actionable Recommendations
            </h3>
            
            <div class="space-y-3">
                @forelse($analysis['recommendations'] as $idx => $rec)
                <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 flex gap-3 shadow-sm">
                    <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">{{ $idx + 1 }}</span>
                    <p class="text-sm text-[var(--text-primary)] leading-relaxed">{!! $rec !!}</p>
                </div>
                @empty
                <div class="bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl p-6 text-center">
                    <p class="text-sm text-[var(--text-secondary)]">Kesehatan finansial langganan Anda dalam kondisi prima.</p>
                </div>
                @endforelse
            </div>

            <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl p-5 shadow-sm mt-6" x-data="{
                selectedSubs: [],
                totalSaving: 0,
                toggleSub() { this.totalSaving = this.selectedSubs.reduce((acc, val) => acc + Number(val), 0); }
            }">
                <h4 class="font-bold text-sm text-[var(--text-primary)] mb-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg> 
                    Simulasi Pemangkasan Otomatis
                </h4>
                
                <div class="max-h-40 overflow-y-auto space-y-2 mb-4 pr-2">
                    @foreach(auth()->user()->activeSubscriptions as $sub)
                    <label class="flex items-center justify-between p-2 rounded bg-[var(--bg-primary)] border border-[var(--border-light)] cursor-pointer hover:border-[var(--accent-primary)] transition-colors">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" value="{{ $sub->monthly_amount }}" x-model="selectedSubs" @change="toggleSub()" class="w-4 h-4 rounded" style="accent-color: var(--accent-primary);">
                            <span class="text-xs font-semibold text-[var(--text-primary)]">{{ $sub->name }}</span>
                        </div>
                        <span class="text-xs font-bold text-[var(--text-secondary)]">Rp{{ number_format($sub->monthly_amount, 0, ',', '.') }}</span>
                    </label>
                    @endforeach
                </div>
                
                <div class="bg-[var(--accent-primary)]/10 border border-[var(--accent-primary)]/20 rounded-lg p-3 flex justify-between items-center">
                    <span class="text-xs font-bold uppercase text-[var(--accent-primary)] tracking-wide">Uang Terselamatkan</span>
                    <span class="text-lg font-black text-emerald-500">Rp<span x-text="new Intl.NumberFormat('id-ID').format(totalSaving)">0</span><span class="text-xs font-medium">/bln</span></span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
