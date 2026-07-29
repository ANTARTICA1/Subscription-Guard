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
    <div class="stat-card" x-data="{ count: 0 }" x-init="
        let target = {{ $activeCount }};
        let step = Math.ceil(target / 30);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 30);
    ">
        <div class="flex items-center justify-between">
            <span class="stat-label">Active Subscriptions</span>
            <div class="icon-box" style="background: var(--success-bg);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" style="color: var(--success);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
        <div>
            <p class="stat-value" x-text="count"></p>
            <p class="stat-sub">Layanan aktif dipantau</p>
        </div>
    </div>

    <div class="stat-card" x-data="{ count: 0 }" x-init="
        let target = {{ $monthlyExpense }};
        let step = Math.ceil(target / 40);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 25);
    ">
        <div class="flex items-center justify-between">
            <span class="stat-label">Pengeluaran Bulanan</span>
            <div class="icon-box" style="background: var(--warning-bg);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" style="color: var(--warning);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
        <div>
            <p class="stat-value" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(count)"></p>
            <p class="stat-sub">Total estimasi per bulan</p>
        </div>
    </div>

    <div class="stat-card" x-data="{ count: 0 }" x-init="
        let target = {{ $yearlyExpense }};
        let step = Math.ceil(target / 40);
        let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 25);
    ">
        <div class="flex items-center justify-between">
            <span class="stat-label">Proyeksi Tahunan</span>
            <div class="icon-box" style="background: var(--info-bg);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" style="color: var(--info);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
        </div>
        <div>
            <p class="stat-value" x-text="'Rp' + new Intl.NumberFormat('id-ID').format(count)"></p>
            <p class="stat-sub">Estimasi 12 bulan</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between">
            <span class="stat-label">Kategori Aktif</span>
            <div class="icon-box" style="background: rgba(124,58,237,0.12);">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" style="color: var(--accent-primary);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
            </div>
        </div>
        <div>
            <p class="stat-value">{{ $categoryCount }}</p>
            <p class="stat-sub">Kategori digunakan</p>
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
                <div class="flex items-center gap-3">
                    @if($sub->logo)
                    <div class="w-10 h-10 flex-shrink-0 bg-white border border-[var(--border-color)] rounded-xl p-1.5 flex items-center justify-center">
                        <img src="{{ $sub->logo }}" alt="{{ $sub->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                    </div>
                    @else
                    <div class="icon-box" style="background: {{ $sub->category->color }}15;">
                        {{ $sub->category->icon }}
                    </div>
                    @endif
                    <div>
                        <p class="text-sm font-bold" style="color: var(--text-primary);">{{ $sub->name }}</p>
                        <p class="text-xs" style="color: var(--text-muted);">{{ $sub->next_payment_date->translatedFormat('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="font-extrabold text-sm" style="color: var(--text-primary);">{{ $sub->formatted_amount }}</p>
                        <span class="badge text-xs" style="background: {{ $sub->days_until_payment <= 1 ? 'var(--danger-bg)' : ($sub->days_until_payment <= 3 ? 'var(--warning-bg)' : 'var(--success-bg)') }}; color: {{ $sub->days_until_payment <= 1 ? 'var(--danger)' : ($sub->days_until_payment <= 3 ? 'var(--warning)' : 'var(--success)') }};">
                            {{ $sub->days_until_payment === 0 ? 'HARI INI' : $sub->days_until_payment . ' hari' }}
                        </span>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <form method="POST" action="{{ route('subscriptions.mark-paid', $sub) }}">
                            @csrf
                            <button type="submit" class="btn-primary text-[10px] sm:text-xs py-1.5 px-3 w-full">Bayar</button>
                        </form>
                        @if($sub->cancel_url)
                        <a href="{{ $sub->cancel_url }}" target="_blank" class="btn-secondary text-[10px] py-1 px-2 text-center text-[var(--danger)] hover:bg-[var(--danger-bg)] hover:border-[var(--danger)] transition-colors">Setop</a>
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
        <h3 class="section-title mb-5 flex items-center gap-2">
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


<div class="card">
    <h3 class="section-title mb-5 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
        Notifikasi Terbaru
    </h3>
    <div class="space-y-2.5">
        @forelse($recentNotifications as $notif)
        <div class="item-row">
            <div class="flex items-center gap-3">
                <span class="text-lg">
                    @if($notif->type === 'due_date')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--danger)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    @elseif($notif->type === 'H-1')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--warning)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--info)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @endif
                </span>
                <div>
                    <p class="text-xs font-bold" style="color: var(--text-primary);">{{ $notif->subscription->name ?? 'System' }} — {{ $notif->type }}</p>
                    <p class="text-xs" style="color: var(--text-muted);">{{ Str::limit($notif->message, 90) }}</p>
                </div>
            </div>
            <span class="badge badge-{{ $notif->status === 'sent' ? 'active' : ($notif->status === 'pending' ? 'pending' : 'failed') }}">
                {{ strtoupper($notif->status) }}
            </span>
        </div>
        @empty
        <div class="empty-state py-6 flex flex-col items-center justify-center">
            <span class="empty-icon text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--text-muted)] mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </span>
            <p class="empty-title text-lg mt-2">Kotak Masuk Kosong</p>
            <p class="empty-desc text-sm">Belum ada notifikasi baru untuk Anda hari ini.</p>
        </div>
        @endforelse
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

    // Spending Chart
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

    // Category Chart
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
                    labels: {
                        color: tickColor,
                        font: { size: 11, family: 'Inter' },
                        padding: 14,
                        usePointStyle: true,
                        pointStyleWidth: 10,
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
