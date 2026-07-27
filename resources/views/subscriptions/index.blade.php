@extends('layouts.app')
@section('title', 'Subscriptions')
@section('heading', 'Subscriptions')
@section('subheading', 'Kelola semua layanan berbayar rutin Anda')

@section('actions')
<div class="flex items-center gap-2">
    <a href="{{ route('subscriptions.export') }}" class="btn-secondary text-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
        Export
    </a>
    <a href="{{ route('subscriptions.create') }}" class="btn-primary text-xs">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah
    </a>
</div>
@endsection

@section('content')

<div class="card mb-6">
    <form method="GET" class="flex flex-col sm:flex-row flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[220px] w-full">
            <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="Cari subscription...">
        </div>
        <div class="min-w-[170px] w-full sm:w-auto">
            <select name="category" class="form-select">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[150px] w-full sm:w-auto">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button type="submit" class="btn-secondary py-2 text-xs">Filter</button>
            @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('subscriptions.index') }}" class="btn-ghost text-xs">Reset</a>
            @endif
        </div>
    </form>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 morph-stagger">
    @forelse($subscriptions as $sub)
    <div class="card flex flex-col justify-between">
        <div>
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3 cursor-pointer" onclick="window.location='{{ route('subscriptions.show', $sub) }}'">
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
                        <h3 class="font-bold text-sm hover:underline" style="color: var(--text-primary);">{{ $sub->name }}</h3>
                        <p class="text-xs" style="color: var(--text-muted);">{{ $sub->category->name }}</p>
                    </div>
                </div>
                <span class="badge badge-{{ $sub->status }}">{{ strtoupper($sub->status) }}</span>
            </div>

            <div class="space-y-2 text-xs my-4 pt-3" style="border-top: 1px solid var(--border-color);">
                <div class="flex justify-between">
                    <span style="color: var(--text-muted);">Biaya:</span>
                    <span class="font-bold text-sm" style="color: var(--text-primary);">{{ $sub->formatted_amount }}</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--text-muted);">Siklus:</span>
                    <span class="font-semibold" style="color: var(--text-secondary);">{{ ucfirst($sub->billing_cycle) }}</span>
                </div>
                <div class="flex justify-between">
                    <span style="color: var(--text-muted);">Jatuh Tempo:</span>
                    <span class="font-semibold" style="color: {{ $sub->days_until_payment <= 3 ? 'var(--warning)' : 'var(--text-secondary)' }};">
                        @if($sub->status === 'active')
                            {{ $sub->days_until_payment }} hari lagi
                        @else
                            —
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div>
            @if($sub->auto_renew)
            <div class="p-2.5 rounded-lg text-xs font-semibold flex items-center gap-2 mb-3" style="background: var(--warning-bg); color: var(--warning);">
                Auto-Renewal Aktif
            </div>
            @else
            <div class="p-2.5 rounded-lg text-xs font-semibold flex items-center gap-2 mb-3" style="background: var(--border-color); color: var(--text-muted);">
                Renewal Manual
            </div>
            @endif

            <div class="flex items-center gap-2 pt-3" style="border-top: 1px solid var(--border-color);">
                <form method="POST" action="{{ route('subscriptions.mark-paid', $sub) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="btn-secondary text-xs w-full py-1.5 justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Lunas</button>
                </form>
                <form method="POST" action="{{ route('subscriptions.toggle-status', $sub) }}">
                    @csrf
                    <button type="submit" class="btn-secondary text-xs py-1.5 px-2.5">{{ $sub->status === 'active' ? '⏸️' : '▶️' }}</button>
                </form>
                <a href="{{ route('subscriptions.edit', $sub) }}" class="btn-secondary text-xs py-1.5 px-2.5"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>️</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full card">
        <div class="empty-state">
            <span class="empty-icon"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg></span>
            <p class="empty-title">Belum ada subscription</p>
            <p class="empty-desc">Tambahkan subscription pertama Anda untuk mulai mencatat tagihan.</p>
            <a href="{{ route('subscriptions.create') }}" class="btn-primary">+ Tambah Subscription</a>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $subscriptions->withQueryString()->links() }}
</div>
@endsection
