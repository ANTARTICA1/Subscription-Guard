@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan & kontrol subscription Anda')

@section('actions')
<a href="{{ route('subscriptions.create') }}" class="btn-primary px-3 py-1.5 text-xs font-bold rounded-lg flex items-center gap-1.5 shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
    <span class="hidden sm:inline">Tambah</span>
</a>
@endsection

@section('content')

<div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-[var(--border-color)] overflow-hidden shadow-sm mb-6">
    
    <div class="p-4 flex flex-col justify-between" x-data="{ count: 0 }" x-init="
        let target = {{ $activeCount }};
        let step = Math.ceil(target / 30);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 30);
    ">
        <div class="mb-2">
            <span class="text-xs font-semibold text-[var(--text-secondary)]">Active Subscriptions</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-xl font-extrabold text-[var(--text-primary)] leading-tight tracking-tight" x-text="count"></p>
                <p class="text-[10px] text-[var(--text-muted)] mt-1 truncate">Layanan aktif digunakan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6">
                <svg viewBox="0 0 100 30" class="w-full h-full stroke-emerald-500" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $activeSparkline }}" />
                </svg>
            </div>
        </div>
    </div>

    <div class="p-4 flex flex-col justify-between" x-data="{ count: 0 }" x-init="
        let target = {{ $monthlyExpense }};
        let step = Math.ceil(target / 40);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 25);
    ">
        <div class="mb-2">
            <span class="text-xs font-semibold text-[var(--text-secondary)]">Pengeluaran Bulanan</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-xl font-extrabold text-[var(--text-primary)] leading-tight tracking-tight whitespace-nowrap" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(count)"></p>
                <p class="text-[10px] text-[var(--text-muted)] mt-1 truncate">Total estimasi per bulan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6">
                <svg viewBox="0 0 100 30" class="w-full h-full stroke-green-500" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $monthlySparkline }}" />
                </svg>
            </div>
        </div>
    </div>

    <div class="p-4 flex flex-col justify-between" x-data="{ count: 0 }" x-init="
        let target = {{ $yearlyExpense }};
        let step = Math.ceil(target / 40);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 25);
    ">
        <div class="mb-2">
            <span class="text-xs font-semibold text-[var(--text-secondary)]">Proyeksi Tahunan</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-xl font-extrabold text-[var(--text-primary)] leading-tight tracking-tight whitespace-nowrap" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(count)"></p>
                <p class="text-[10px] text-[var(--text-muted)] mt-1 truncate">Estimasi 12 bulan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6">
                <svg viewBox="0 0 100 30" class="w-full h-full stroke-sky-500" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $yearlySparkline }}" />
                </svg>
            </div>
        </div>
    </div>

    <div class="p-4 flex flex-col justify-between">
        <div class="mb-2">
            <span class="text-xs font-semibold text-[var(--text-secondary)]">Kategori Aktif</span>
        </div>
        <div class="flex items-end justify-between gap-2 min-w-0">
            <div class="min-w-0">
                <p class="text-xl font-extrabold text-[var(--text-primary)] leading-tight tracking-tight">{{ $categoryCount }}</p>
                <p class="text-[10px] text-[var(--text-muted)] mt-1 truncate">Kategori digunakan</p>
            </div>
            <div class="flex-shrink-0 w-12 h-6">
                <svg viewBox="0 0 100 30" class="w-full h-full stroke-amber-500" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="{{ $categorySparkline }}" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-6">

    <div class="lg:col-span-8 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)]">Tren Pengeluaran (6 Bulan)</h3>
                <p class="text-[10px] text-[var(--text-muted)] mt-0.5">Data realisasi dari riwayat pembayaran</p>
            </div>
            <a href="{{ route('payments.index') }}" class="text-xs font-semibold text-emerald-500 hover:text-emerald-600 transition-colors">Lihat Semua →</a>
        </div>
        <div style="position: relative; height: 260px;">
            <canvas id="spendingChart"></canvas>
        </div>
    </div>

    <div class="lg:col-span-4 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm flex flex-col justify-between">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)]">Subscription Health</h3>
                <p class="text-[10px] text-[var(--text-muted)] mt-0.5">{{ $healthScore['personality'] ? 'AI: ' . $healthScore['personality'] : 'Evaluasi AI Tata Asisten' }}</p>
            </div>
            <a href="{{ route('assistant') }}" class="text-xs font-semibold text-emerald-500 hover:text-emerald-600 transition-colors flex items-center gap-1">
                <span>Tata Asisten</span>
                <span>→</span>
            </a>
        </div>

        <div class="flex flex-col items-center py-3">
            <div class="score-ring mb-2" x-data="{ score: 0 }" x-init="
                setTimeout(() => { score = {{ $healthScore['has_data'] ? $healthScore['score'] : 0 }}; }, 300);
            ">
                <svg viewBox="0 0 120 120" class="w-28 h-28">
                    <circle cx="60" cy="60" r="48" stroke="var(--border-color)" stroke-width="8" fill="none"/>
                    <circle cx="60" cy="60" r="48"
                            stroke="{{ $healthScore['color'] }}"
                            stroke-width="8"
                            fill="none"
                            stroke-dasharray="{{ 2 * 3.14159 * 48 }}"
                            stroke-dashoffset="{{ $healthScore['has_data'] ? 2 * 3.14159 * 48 * (1 - $healthScore['score'] / 100) : 2 * 3.14159 * 48 }}"
                            stroke-linecap="round"
                            style="transition: stroke-dashoffset 1.5s cubic-bezier(0.22, 1, 0.36, 1);"/>
                </svg>
                <span class="score-value font-black text-2xl" style="color: {{ $healthScore['color'] }};">
                    {{ $healthScore['has_data'] ? $healthScore['score'] : '-' }}
                </span>
            </div>

            <span class="px-2.5 py-0.5 rounded-md font-bold text-[10px] uppercase tracking-wider" style="background: {{ $healthScore['color'] }}15; color: {{ $healthScore['color'] }};">
                {{ strtoupper($healthScore['label']) }}
            </span>
        </div>

        @if(!empty($healthScore['recommendations']))
        <a href="{{ route('assistant') }}" class="p-2.5 rounded-md flex items-center gap-2 text-[11px] border border-[var(--border-color)] bg-transparent hover:border-emerald-500/40 transition-colors group cursor-pointer text-[var(--text-secondary)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 flex-shrink-0" style="color: {{ $healthScore['color'] }};" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span class="font-medium leading-tight truncate group-hover:text-[var(--text-primary)] transition-colors">{!! strip_tags($healthScore['recommendations'][0]) !!}</span>
        </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-[var(--border-color)]/60">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Tagihan Terdekat
            </h3>
            <span class="text-[10px] font-semibold text-[var(--text-muted)]">{{ count($upcoming) }} tagihan</span>
        </div>

        <div class="divide-y divide-[var(--border-color)]/50">
            @forelse($upcoming as $sub)
            <div class="py-2.5 first:pt-0 last:pb-0 flex items-center justify-between gap-2.5">
                <div class="flex items-center gap-2.5 min-w-0 flex-1">
                    @if($sub->logo)
                    <div class="w-8 h-8 flex-shrink-0 bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-md p-1 flex items-center justify-center">
                        <img src="{{ $sub->logo }}" alt="{{ $sub->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                    </div>
                    @else
                    <div class="w-8 h-8 flex-shrink-0 rounded-md flex items-center justify-center text-sm" style="background: {{ $sub->category->color }}15;">
                        {{ $sub->category->icon }}
                    </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold truncate text-[var(--text-primary)]" title="{{ $sub->name }}">{{ $sub->name }}</p>
                        <p class="text-[10px] truncate text-[var(--text-muted)]">{{ $sub->next_payment_date->translatedFormat('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 flex-shrink-0">
                    <p class="font-extrabold text-xs text-[var(--text-primary)]">{{ $sub->formatted_amount }}</p>
                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded" style="background: {{ $sub->days_until_payment <= 1 ? 'var(--danger-bg)' : ($sub->days_until_payment <= 3 ? 'var(--warning-bg)' : 'var(--success-bg)') }}; color: {{ $sub->days_until_payment <= 1 ? 'var(--danger)' : ($sub->days_until_payment <= 3 ? 'var(--warning)' : 'var(--success)') }};">
                        {{ $sub->days_until_payment === 0 ? 'HARI INI' : $sub->days_until_payment . ' hr' }}
                    </span>
                    <form method="POST" action="{{ route('subscriptions.mark-paid', $sub) }}">
                        @csrf
                        <button type="submit" class="btn-primary text-[10px] font-bold px-2 py-1 rounded-md">Bayar</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-8 text-center text-[var(--text-muted)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500 mx-auto mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <p class="text-xs font-bold text-[var(--text-primary)]">Aman Terkendali!</p>
                <p class="text-[10px] mt-0.5">Tidak ada tagihan dalam 7 hari ke depan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm">
        <div class="pb-3 mb-3 border-b border-[var(--border-color)]/60">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                Distribusi Kategori
            </h3>
        </div>

        @if($categoryData->isEmpty())
        <div class="py-8 text-center text-[var(--text-muted)]">
            <p class="text-xs font-bold text-[var(--text-primary)]">Belum Ada Data</p>
            <p class="text-[10px] mt-0.5">Tambahkan subscription untuk melihat distribusi kategori.</p>
        </div>
        @else
        <div style="position: relative; height: 220px;" class="flex items-center justify-center">
            <canvas id="categoryChart"></canvas>
        </div>
        @endif
    </div>

    <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm" x-data="miniCalendar()" x-init="init()">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-[var(--border-color)]/60">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Kalender
            </h3>
            <span class="text-xs font-bold text-[var(--text-primary)]" x-text="monthTitle"></span>
        </div>

        <div class="grid gap-1 mb-2" style="grid-template-columns: repeat(7, minmax(0, 1fr));">
            <template x-for="day in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']">
                <div class="text-center text-[9px] font-bold py-0.5 text-[var(--text-muted)]" x-text="day"></div>
            </template>
        </div>

        <div class="grid gap-1" style="grid-template-columns: repeat(7, minmax(0, 1fr));">
            <template x-for="(day, index) in calendarDays" :key="index">
                <div @click="if(day.hasEvent) selectedDay = day"
                     class="relative w-full pt-[100%] rounded transition-colors"
                     :class="(day.day > 0 ? (day.isToday ? 'bg-emerald-500 text-white font-bold' : (day.hasEvent ? 'bg-[var(--bg-elevated)] cursor-pointer hover:bg-[var(--border-color)]' : '')) : '') + (selectedDay && selectedDay.day === day.day && day.day > 0 ? ' ring-2 ring-emerald-500' : '')"
                     :title="day.hasEvent ? day.events.map(e => e.title).join(', ') : ''">
                    <div class="absolute inset-0 flex items-center justify-center text-[11px] font-medium">
                        <span x-text="day.day > 0 ? day.day : ''" :class="day.hasEvent && !day.isToday ? 'text-emerald-500 font-bold' : ''"></span>
                        <template x-if="day.hasEvent">
                            <div class="absolute bottom-0.5 flex gap-0.5 justify-center w-full">
                                <template x-for="event in day.events.slice(0, 3)">
                                    <div class="w-1 h-1 rounded-full" :style="'background-color:' + (day.isToday ? 'white' : event.color)"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <div class="mt-3 pt-2.5 border-t border-[var(--border-color)]/60 min-h-[3rem] flex flex-col justify-center">
            <template x-if="selectedDay">
                <div>
                    <p class="text-[10px] font-bold text-[var(--text-primary)] mb-1" x-text="'Tagihan tgl ' + selectedDay.day + ' ' + monthTitle + ':'"></p>
                    <div class="space-y-1">
                        <template x-for="event in selectedDay.events">
                            <div class="flex items-center gap-1.5 text-[11px]">
                                <div class="w-1.5 h-1.5 rounded-full flex-shrink-0" :style="'background-color:' + event.color"></div>
                                <span class="text-[var(--text-secondary)] font-medium truncate" x-text="event.title"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            <template x-if="!selectedDay && hasAnyEvent">
                <p class="text-[10px] text-[var(--text-muted)] text-center">Klik tanggal bertitik untuk melihat detail</p>
            </template>
            <template x-if="!hasAnyEvent">
                <p class="text-[10px] text-[var(--text-muted)] text-center">Tidak ada tagihan bulan ini</p>
            </template>
        </div>
    </div>
</div>

<div class="mt-4 p-6 flex flex-col md:flex-row items-center justify-between relative overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; box-shadow: var(--shadow-sm);">
    <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full pointer-events-none" style="background: var(--accent-primary); filter: blur(80px); opacity: 0.15;"></div>
    <div class="absolute -left-20 -bottom-20 w-64 h-64 rounded-full pointer-events-none" style="background: var(--info); filter: blur(80px); opacity: 0.15;"></div>

    <div class="flex flex-col sm:flex-row items-center gap-5 relative z-10 w-full md:w-auto text-center sm:text-left">
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
        <a href="{{ route('shares.index') }}" class="btn-primary rounded-full text-xs font-bold" style="box-shadow: 0 0 15px var(--accent-glow);">
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
    const gridColor = isDark ? 'rgba(148, 163, 184, 0.06)' : 'rgba(15, 23, 42, 0.06)';
    const tickColor = isDark ? '#64748b' : '#64748b';

    const spendingCanvas = document.getElementById('spendingChart');
    if (spendingCanvas) {
        const spendingCtx = spendingCanvas.getContext('2d');
        const gradient = spendingCtx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(spendingCtx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pengeluaran',
                    data: @json($chartData),
                    borderColor: '#10b981',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: isDark ? '#111827' : '#ffffff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1200, easing: 'easeOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#94a3b8',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10,
                        callbacks: {
                            label: (ctx) => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { color: tickColor, font: { size: 10, family: 'Inter' } } },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: {
                            color: tickColor,
                            font: { size: 10, family: 'Inter' },
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
    }

    const categoryCanvas = document.getElementById('categoryChart');
    if (categoryCanvas) {
        const categoryCtx = categoryCanvas.getContext('2d');
        const categoryData = @json($categoryData);
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(categoryData),
                datasets: [{
                    data: Object.values(categoryData),
                    backgroundColor: ['#10b981', '#38bdf8', '#f59e0b', '#ef4444', '#06b6d4', '#6366f1', '#ec4899', '#64748b'],
                    borderWidth: 2,
                    borderColor: isDark ? '#0d1726' : '#ffffff',
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1000, easing: 'easeOutQuart' },
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: tickColor,
                            font: { size: 10, family: 'Inter' },
                            padding: 12,
                            usePointStyle: true,
                            boxWidth: 8,
                            boxHeight: 8
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#94a3b8',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10,
                        callbacks: {
                            label: (ctx) => ctx.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw)
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
