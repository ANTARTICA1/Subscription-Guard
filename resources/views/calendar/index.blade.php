@extends('layouts.app')
@section('title', 'Kalender')
@section('heading', 'Kalender Subscription')
@section('subheading', now()->translatedFormat('F Y'))

@section('content')
<div class="card" x-data="calendarApp()" x-init="init()">
    <div class="flex items-center justify-between mb-6">
        <button @click="prevMonth()" class="btn-secondary text-sm">← Sebelumnya</button>
        <h3 class="text-xl font-bold" style="color: var(--text-primary);" x-text="monthTitle"></h3>
        <button @click="nextMonth()" class="btn-secondary text-sm">Selanjutnya →</button>
    </div>

    <div class="calendar-grid mb-2">
        <template x-for="day in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']">
            <div class="text-center text-xs font-bold py-2" style="color: var(--text-muted);" x-text="day"></div>
        </template>
    </div>

    <div class="calendar-grid">
        <template x-for="(day, index) in calendarDays" :key="index">
            <div class="calendar-day" :class="{ 'today': day.isToday }" x-show="day.day > 0">
                <span class="text-xs font-bold" :style="day.isToday ? 'color: var(--accent-primary)' : 'color: var(--text-muted)'" x-text="day.day > 0 ? day.day : ''"></span>
                <template x-for="event in day.events">
                    <div class="calendar-event" :style="'background:' + event.color + '15; color:' + event.color">
                        <span x-text="event.icon + ' ' + event.title"></span>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <div class="mt-6 flex flex-wrap gap-4">
        @foreach($subscriptions as $sub)
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full" style="background: {{ $sub->category->color }};"></div>
            <span class="text-xs font-medium" style="color: var(--text-secondary);">{{ $sub->name }}</span>
        </div>
        @endforeach
    </div>
</div>

<script>
function calendarApp() {
    return {
        currentDate: new Date(),
        events: @json($events),
        calendarDays: [],
        monthTitle: '',
        init() { this.buildCalendar(); },
        buildCalendar() {
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
            for (let i = 0; i < startDay; i++) { this.calendarDays.push({ day: 0, events: [], isToday: false }); }
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
                const dayEvents = this.events.filter(e => e.date === dateStr);
                const isToday = today.getDate() === d && today.getMonth() === month && today.getFullYear() === year;
                this.calendarDays.push({ day: d, events: dayEvents, isToday });
            }
        },
        prevMonth() { this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1); this.buildCalendar(); },
        nextMonth() { this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1); this.buildCalendar(); }
    };
}
</script>
@endsection
