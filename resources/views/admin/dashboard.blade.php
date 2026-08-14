@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')
@section('subheading', 'Statistik platform Tatagih')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card indigo">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(99,102,241,0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#6366f1"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        </div>
        <p class="text-3xl font-black" style="color: var(--text-primary);">{{ $totalUsers }}</p>
        <p class="text-sm" style="color: var(--text-muted);">Total User</p>
    </div>

    <div class="stat-card emerald">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(16,185,129,0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#10b981"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
        </div>
        <p class="text-3xl font-black" style="color: var(--text-primary);">{{ $activeSubscriptions }}</p>
        <p class="text-sm" style="color: var(--text-muted);">Subscription Aktif</p>
    </div>

    <div class="stat-card amber">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(245,158,11,0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#f59e0b"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
        </div>
        <p class="text-3xl font-black" style="color: var(--text-primary);">{{ $totalReminders }}</p>
        <p class="text-sm" style="color: var(--text-muted);">Reminder Terkirim</p>
    </div>

    <div class="stat-card rose">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3" style="background: rgba(244,63,94,0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#f43f5e"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
        </div>
        <p class="text-3xl font-black" style="color: var(--text-primary);">{{ $totalSubscriptions }}</p>
        <p class="text-sm" style="color: var(--text-muted);">Total Subscription</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <div class="card">
        <h3 class="text-lg font-bold mb-4" style="color: var(--text-primary);">Pertumbuhan User</h3>
        <canvas id="userChart" height="150"></canvas>
    </div>

    
    <div class="card">
        <h3 class="text-lg font-bold mb-4" style="color: var(--text-primary);">Kategori Populer</h3>
        @foreach($popularCategories as $cat)
        <div class="flex items-center gap-3 p-3 rounded-xl mb-2" style="background: var(--bg-primary);">
            <span class="text-xl font-extrabold uppercase">{{ substr($cat->name, 0, 1) }}</span>
            <div class="flex-1">
                <p class="font-semibold text-sm" style="color: var(--text-primary);">{{ $cat->name }}</p>
                <div class="w-full h-2 rounded-full mt-1" style="background: var(--border-color);">
                    <div class="h-2 rounded-full" style="width: {{ $totalSubscriptions > 0 ? ($cat->subscriptions_count / $totalSubscriptions * 100) : 0 }}%; background: {{ $cat->color }};"></div>
                </div>
            </div>
            <span class="text-sm font-bold" style="color: var(--text-secondary);">{{ $cat->subscriptions_count }}</span>
        </div>
        @endforeach
    </div>
</div>


<div class="card">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold" style="color: var(--text-primary);"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg> User Terbaru</h3>
        <a href="{{ route('admin.users') }}" class="text-sm font-medium" style="color: var(--accent-primary);">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th></tr>
            </thead>
            <tbody>
                @foreach($recentUsers as $u)
                <tr>
                    <td class="font-semibold" style="color: var(--text-primary);">{{ $u->name }}</td>
                    <td style="color: var(--text-secondary);">{{ $u->email }}</td>
                    <td><span class="badge {{ $u->role === 'admin' ? 'badge-pending' : 'badge-active' }}">{{ $u->role }}</span></td>
                    <td style="color: var(--text-muted);">{{ $u->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('userChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'User Baru',
                data: @json($chartData),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#6366f1',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#64748b' } },
                y: { grid: { color: 'rgba(99,102,241,0.06)' }, ticks: { color: '#64748b' } }
            }
        }
    });
});
</script>
@endsection
