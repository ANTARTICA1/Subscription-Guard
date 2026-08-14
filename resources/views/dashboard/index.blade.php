@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan & kontrol subscription Anda')

@section('actions')
<a href="{{ route('subscriptions.create') }}" class="btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
    Tambah
</a>
@endsection

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="card hover:-translate-y-1" x-data="{ count: 0 }" x-init="
        let target = {{ $activeCount }};
        let step = Math.ceil(target / 30);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 30);
    ">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center justify-center" style="width: 40px; height: 40px; border-radius: 12px; background-color: rgba(147, 51, 234, 0.15); color: #a855f7;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-sm font-semibold" style="color: var(--text-secondary);">Active Subscriptions</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-lg xl:text-xl font-black leading-tight tracking-tight whitespace-nowrap" style="color: var(--text-primary);" x-text="count"></p>
                <p class="font-medium mt-1.5 truncate" style="font-size: 11px; color: var(--text-muted);">Layanan aktif digunakan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6 xl:w-16 xl:h-8">
                <svg viewBox="0 0 100 30" class="w-full h-full" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke: #9333ea; fill: none; overflow: visible;">
                    <path d="{{ $activeSparkline }} L100,35 L0,35 Z" style="fill: rgba(147, 51, 234, 0.15); stroke: none;" />
                    <path d="{{ $activeSparkline }}" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card hover:-translate-y-1" x-data="{ count: 0 }" x-init="
        let target = {{ $monthlyExpense }};
        let step = Math.ceil(target / 40);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 25);
    ">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center justify-center" style="width: 40px; height: 40px; border-radius: 12px; background-color: rgba(34, 197, 94, 0.15); color: #4ade80;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-sm font-semibold" style="color: var(--text-secondary);">Pengeluaran Bulanan</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-lg xl:text-xl font-black leading-tight tracking-tight whitespace-nowrap" style="color: var(--text-primary);" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(count)"></p>
                <p class="font-medium mt-1.5 truncate" style="font-size: 11px; color: var(--text-muted);">Total estimasi per bulan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6 xl:w-16 xl:h-8">
                <svg viewBox="0 0 100 30" class="w-full h-full" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke: #16a34a; fill: none; overflow: visible;">
                    <path d="{{ $monthlySparkline }} L100,35 L0,35 Z" style="fill: rgba(22, 163, 74, 0.15); stroke: none;" />
                    <path d="{{ $monthlySparkline }}" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card hover:-translate-y-1" x-data="{ count: 0 }" x-init="
        let target = {{ $yearlyExpense }};
        let step = Math.ceil(target / 40);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 25);
    ">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center justify-center" style="width: 40px; height: 40px; border-radius: 12px; background-color: rgba(14, 165, 233, 0.15); color: #38bdf8;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <span class="text-sm font-semibold" style="color: var(--text-secondary);">Proyeksi Tahunan</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-lg xl:text-xl font-black leading-tight tracking-tight whitespace-nowrap" style="color: var(--text-primary);" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(count)"></p>
                <p class="font-medium mt-1.5 truncate" style="font-size: 11px; color: var(--text-muted);">Estimasi 12 bulan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6 xl:w-16 xl:h-8">
                <svg viewBox="0 0 100 30" class="w-full h-full" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke: #0284c7; fill: none; overflow: visible;">
                    <path d="{{ $yearlySparkline }} L100,35 L0,35 Z" style="fill: rgba(2, 132, 199, 0.15); stroke: none;" />
                    <path d="{{ $yearlySparkline }}" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card hover:-translate-y-1">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center justify-center" style="width: 40px; height: 40px; border-radius: 12px; background-color: rgba(249, 115, 22, 0.15); color: #fb923c;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
            </div>
            <span class="text-sm font-semibold" style="color: var(--text-secondary);">Kategori Aktif</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-lg xl:text-xl font-black leading-tight tracking-tight whitespace-nowrap" style="color: var(--text-primary);">{{ $categoryCount }}</p>
                <p class="font-medium mt-1.5 truncate" style="font-size: 11px; color: var(--text-muted);">Kategori digunakan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6 xl:w-16 xl:h-8">
                <svg viewBox="0 0 100 30" class="w-full h-full" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke: #ea580c; fill: none; overflow: visible;">
                    <path d="{{ $categorySparkline }} L100,35 L0,35 Z" style="fill: rgba(234, 88, 12, 0.15); stroke: none;" />
                    <path d="{{ $categorySparkline }}" />
                </svg>
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="card lg:col-span-2">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="section-title">Tren Pengeluaran (6 Bulan)</h3>
                <p class="section-desc">Data realisasi dari riwayat pembayaran</p>
            </div>
            <a href="{{ route('payments.index') }}" class="btn-ghost text-xs">Lihat Semua →</a>
        </div>
        <div style="position: relative; height: 260px;">
            <canvas id="spendingChart"></canvas>
        </div>
    </div>

    
    <div class="card flex flex-col justify-between">
        <div>
            <h3 class="section-title mb-1">Subscription Health</h3>
            <p class="section-desc">Skor efisiensi pengeluaran</p>
        </div>

        <div class="flex flex-col items-center py-4">
            <div class="score-ring mb-3" x-data="{ score: 0 }" x-init="
                setTimeout(() => { score = {{ $healthScore['score'] }}; }, 300);
            ">
                <svg viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="48" stroke="var(--border-color)" stroke-width="8" fill="none"/>
                    <circle cx="60" cy="60" r="48"
                            stroke="{{ $healthScore['color'] }}"
                            stroke-width="8"
                            fill="none"
                            stroke-dasharray="{{ 2 * 3.14159 * 48 }}"
                            stroke-dashoffset="{{ 2 * 3.14159 * 48 * (1 - $healthScore['score'] / 100) }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 1.5s cubic-bezier(0.22, 1, 0.36, 1);"/>
                </svg>
                <span class="score-value" style="color: {{ $healthScore['color'] }};">{{ $healthScore['score'] }}</span>
            </div>

            <span class="badge" style="background: {{ $healthScore['color'] }}15; color: {{ $healthScore['color'] }}; font-size: 0.7rem;">
                {{ strtoupper($healthScore['label']) }}
            </span>
        </div>

        @if(!empty($healthScore['recommendations']))
        <div class="item-row text-xs flex items-center gap-2" style="border-color: {{ $healthScore['color'] }}30;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" style="color: {{ $healthScore['color'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ $healthScore['recommendations'][0] }}</span>
        </div>
        @endif
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="card lg:col-span-1">
        <div class="flex items-center justify-between mb-5">
            <h3 class="section-title flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Tagihan Terdekat
            </h3>
        </div>

        <div class="space-y-3">
            @forelse($upcoming as $sub)
            <div class="item-row">
                <div class="flex items-center gap-3" style="min-width: 0; flex: 1;">
                    @if($sub->logo)
                    <div class="w-10 h-10 flex-shrink-0 bg-white border border-[var(--border-color)] rounded-xl p-1.5 flex items-center justify-center">
                        <img src="{{ $sub->logo }}" alt="{{ $sub->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                    </div>
                    @else
                    <div class="icon-box flex-shrink-0" style="background: {{ $sub->category->color }}15;">
                        {{ $sub->category->icon }}
                    </div>
                    @endif
                    <div style="min-width: 0; flex: 1;">
                        <p class="text-sm font-bold truncate" style="color: var(--text-primary);" title="{{ $sub->name }}">{{ $sub->name }}</p>
                        <p class="text-xs truncate" style="color: var(--text-muted);">{{ $sub->next_payment_date->translatedFormat('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                    <p class="font-extrabold text-sm" style="color: var(--text-primary);">{{ $sub->formatted_amount }}</p>
                    <div class="flex items-center gap-2">
                        <span class="badge" style="font-size: 9px; padding: 0.2rem 0.5rem; background: {{ $sub->days_until_payment <= 1 ? 'var(--danger-bg)' : ($sub->days_until_payment <= 3 ? 'var(--warning-bg)' : 'var(--success-bg)') }}; color: {{ $sub->days_until_payment <= 1 ? 'var(--danger)' : ($sub->days_until_payment <= 3 ? 'var(--warning)' : 'var(--success)') }};">
                            {{ $sub->days_until_payment === 0 ? 'HARI INI' : $sub->days_until_payment . ' hr' }}
                        </span>
                        <form method="POST" action="{{ route('subscriptions.mark-paid', $sub) }}">
                            @csrf
                            <button type="submit" class="btn-primary" style="font-size: 10px; padding: 0.3rem 0.7rem;">Bayar</button>
                        </form>
                        @if($sub->cancel_url)
                        <a href="{{ $sub->cancel_url }}" target="_blank" class="btn-secondary" style="font-size: 10px; padding: 0.3rem 0.6rem; color: var(--danger);">Setop</a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state py-6 flex flex-col items-center justify-center">
                <span class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--success)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </span>
                <p class="empty-title text-lg mt-2">Aman Terkendali!</p>
                <p class="empty-desc text-sm">Tidak ada tagihan yang harus dibayar dalam 7 hari ke depan. Waktunya bersantai.</p>
            </div>
            @endforelse
        </div>
    </div>

    
    <div class="card lg:col-span-1">
        <h3 class="section-title mb-8 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
            Distribusi Kategori
        </h3>
        
        @if($categoryData->isEmpty())
        <div class="empty-state py-4 flex flex-col items-center justify-center" style="height: 250px;">
            <span class="empty-icon text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--text-muted)] mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /></svg>
            </span>
            <p class="empty-title text-base mt-2">Belum Ada Data</p>
            <p class="empty-desc text-xs">Tambahkan subscription untuk melihat distribusi kategorinya di sini.</p>
        </div>
        @else
        <div style="position: relative; height: 250px;" class="flex items-center justify-center">
            <canvas id="categoryChart"></canvas>
        </div>
        @endif
    </div>

    
    <div class="card lg:col-span-1" x-data="miniCalendar()" x-init="init()">
        <div class="flex items-center justify-between mb-4">
            <h3 class="section-title flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Kalender
            </h3>
            <span class="text-xs font-bold" style="color: var(--text-primary);" x-text="monthTitle"></span>
        </div>

        <div class="grid gap-1 mb-2" style="grid-template-columns: repeat(7, minmax(0, 1fr));">
            <template x-for="day in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']">
                <div class="text-center text-[10px] font-bold py-1" style="color: var(--text-muted);" x-text="day"></div>
            </template>
        </div>

        <div class="grid gap-1" style="grid-template-columns: repeat(7, minmax(0, 1fr));">
            <template x-for="(day, index) in calendarDays" :key="index">
                <div @click="if(day.hasEvent) selectedDay = day" 
                     class="relative w-full pt-[100%] rounded-md transition-colors" 
                     :class="(day.day > 0 ? (day.isToday ? 'bg-[var(--accent-primary)] text-white' : (day.hasEvent ? 'bg-[var(--bg-elevated)] cursor-pointer hover:bg-[var(--border-color)]' : '')) : '') + (selectedDay && selectedDay.day === day.day && day.day > 0 ? ' ring-2 ring-[var(--accent-primary)] ring-offset-1 ring-offset-[var(--bg-secondary)]' : '')"
                     :title="day.hasEvent ? day.events.map(e => e.title).join(', ') : ''">
                    <div class="absolute inset-0 flex items-center justify-center text-xs font-medium">
                        <span x-text="day.day > 0 ? day.day : ''" :class="day.hasEvent && !day.isToday ? 'text-[var(--accent-primary)] font-bold' : ''"></span>
                        <template x-if="day.hasEvent">
                            <div class="absolute bottom-1 flex gap-0.5 justify-center w-full">
                                <template x-for="event in day.events.slice(0, 3)">
                                    <div class="w-1 h-1 rounded-full" :style="'background-color:' + (day.isToday ? 'white' : event.color)"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
        
        <div class="mt-4 pt-3 border-t border-[var(--border-color)] min-h-[4rem] flex flex-col justify-center">
            <template x-if="selectedDay">
                <div>
                    <p class="text-[11px] font-bold text-[var(--text-primary)] mb-2" x-text="'Tagihan tgl ' + selectedDay.day + ' ' + monthTitle + ':'"></p>
                    <div class="space-y-1.5">
                        <template x-for="event in selectedDay.events">
                            <div class="flex items-center gap-2 text-xs">
                                <div class="w-2 h-2 rounded-full flex-shrink-0" :style="'background-color:' + event.color"></div>
                                <span class="text-[var(--text-secondary)] font-medium truncate" x-text="event.title"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            <template x-if="!selectedDay && hasAnyEvent">
                <p class="text-[11px] text-[var(--text-muted)] text-center">Klik tanggal bertitik untuk melihat detail</p>
            </template>
            <template x-if="!hasAnyEvent">
                <p class="text-[11px] text-[var(--text-muted)] text-center">Tidak ada tagihan bulan ini</p>
            </template>
        </div>
    </div>
</div>


<div class="mt-4 p-6 flex flex-col md:flex-row items-center justify-between relative overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
    <!-- Background glowing effect for dark mode -->
    <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full pointer-events-none" style="background: var(--accent-primary); filter: blur(80px); opacity: 0.15;"></div>
    <div class="absolute -left-20 -bottom-20 w-64 h-64 rounded-full pointer-events-none" style="background: var(--info); filter: blur(80px); opacity: 0.15;"></div>

    <div class="flex flex-col sm:flex-row items-center gap-5 relative z-10 w-full md:w-auto text-center sm:text-left">
        <!-- Dummy Profile Stack -->
        <div class="flex -space-x-3 flex-shrink-0">
            <img class="w-12 h-12 rounded-full object-cover" style="border: 2px solid var(--bg-card);" src="https://i.pravatar.cc/150?u=1" alt="Teman 1">
            <img class="w-12 h-12 rounded-full object-cover" style="border: 2px solid var(--bg-card);" src="https://i.pravatar.cc/150?u=2" alt="Teman 2">
            <img class="w-12 h-12 rounded-full object-cover" style="border: 2px solid var(--bg-card);" src="https://i.pravatar.cc/150?u=3" alt="Teman 3">
            <div class="w-12 h-12 rounded-full flex items-center justify-center text-xs font-bold text-white z-10" style="background: var(--bg-elevated); border: 2px solid var(--bg-card);">+3</div>
        </div>
        <div>
            <h4 class="text-base font-extrabold mb-1" style="color: var(--text-primary);">Patungan Tagihan? (Share Subs)</h4>
            <p class="text-xs font-medium" style="color: var(--text-secondary);">Bagi tagihan otomatis dengan teman. Lacak siapa yang belum bayar tanpa canggung.</p>
        </div>
    </div>
    <div class="mt-5 md:mt-0 flex items-center justify-center w-full md:w-auto relative z-10" style="transform: translateY(-12px);">
        <a href="#" class="btn-primary rounded-full text-xs font-bold" style="box-shadow: 0 0 15px var(--accent-glow);">
            Coba Share Subs
        </a>
    </div>
</div>

<script>
function miniCalendar() {
    return {
        currentDate: new Date(),
        events: @json($calendarEvents),
        calendarDays: [],
        monthTitle: '',
        selectedDay: null,
        hasAnyEvent: false,
        init() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            this.monthTitle = months[month] + ' ' + year;
            const firstDay = new Date(year, month, 1);
            let startDay = firstDay.getDay() - 1;
            if (startDay < 0) startDay = 6;
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();
            this.calendarDays = [];
            for (let i = 0; i < startDay; i++) { this.calendarDays.push({ day: 0, events: [], hasEvent: false, isToday: false }); }
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                const dayEvents = this.events.filter(e => e.date === dateStr);
                const isToday = today.getDate() === d && today.getMonth() === month && today.getFullYear() === year;
                this.calendarDays.push({ day: d, events: dayEvents, hasEvent: dayEvents.length > 0, isToday });
            }
            this.hasAnyEvent = this.events.length > 0;
            
            const todayObj = this.calendarDays.find(d => d.isToday && d.hasEvent);
            if (todayObj) this.selectedDay = todayObj;
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
    const gridColor = isDark ? 'rgba(148, 163, 184, 0.06)' : 'rgba(124, 58, 237, 0.06)';
    const tickColor = isDark ? '#586882' : '#7c7399';

    const spendingCtx = document.getElementById('spendingChart').getContext('2d');
    const gradient = spendingCtx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, 'rgba(124, 58, 237, 0.25)');
    gradient.addColorStop(1, 'rgba(124, 58, 237, 0)');

    new Chart(spendingCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pengeluaran',
                data: @json($chartData),
                borderColor: '#7c3aed',
                backgroundColor: gradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#7c3aed',
                pointBorderColor: isDark ? '#111827' : '#ffffff',
                pointBorderWidth: 3,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1500, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    titleColor: isDark ? '#f1f5f9' : '#1e1b4b',
                    bodyColor: isDark ? '#94a3b8' : '#4c1d95',
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 12,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: tickColor, font: { size: 11, family: 'Inter' } } },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: {
                        color: tickColor,
                        font: { size: 11, family: 'Inter' },
                        callback: function(v) {
                            if (v >= 1000000) return 'Rp' + (v / 1000000).toFixed(1) + 'Jt';
                            if (v >= 1000) return 'Rp' + (v / 1000) + 'Rb';
                            return 'Rp' + v;
                        }
                    }
                }
            }
        }
    });

    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($categoryData);
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                data: Object.values(categoryData),
                backgroundColor: ['#7c3aed', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#06b6d4', '#ec4899', '#64748b'],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutQuart' },
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    title: {
                        display: true,
                        text: '',
                        padding: { top: 8 }
                    },
                    labels: {
                        color: tickColor,
                        font: { size: 11, family: 'Inter' },
                        padding: 15,
                        usePointStyle: true,
                        boxWidth: 10,
                        boxHeight: 10
                    }
                },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#ffffff',
                    titleColor: isDark ? '#f1f5f9' : '#1e1b4b',
                    bodyColor: isDark ? '#94a3b8' : '#4c1d95',
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 12,
                    padding: 12,
                    callbacks: {
                        label: (ctx) => ctx.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                    }
                }
            }
        }
    });
});
</script>
@endsection
