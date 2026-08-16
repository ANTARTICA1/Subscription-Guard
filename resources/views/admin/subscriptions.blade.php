@extends('layouts.app')
@section('title', 'Semua Langganan')
@section('heading', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg> Semua Langganan')
@section('subheading', 'Daftar semua subscription pengguna Tatagih')

@section('content')
<div class="card">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th>User</th>
                    <th>Harga</th>
                    <th>Siklus</th>
                    <th>Status</th>
                    <th>Ditambahkan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $s)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold text-white shadow-md" style="background: {{ $s->category->color ?? '#64748b' }};">
                                {{ strtoupper(substr($s->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="font-semibold block" style="color: var(--text-primary);">{{ $s->name }}</span>
                                <span class="text-[10px] uppercase font-bold" style="color: {{ $s->category->color ?? '#64748b' }};">{{ $s->category->name ?? 'Lainnya' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-sm" style="color: var(--text-primary);">{{ $s->user->name }}</span>
                        </div>
                    </td>
                    <td class="font-bold" style="color: var(--text-primary);">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                    <td><span class="badge badge-active" style="background: rgba(99,102,241,0.1); color: #6366f1;">{{ ucfirst($s->billing_cycle) }}</span></td>
                    <td>
                        @if($s->status === 'active')
                            <span class="badge badge-active">Aktif</span>
                        @else
                            <span class="badge badge-pending">Nonaktif</span>
                        @endif
                    </td>
                    <td style="color: var(--text-muted); font-size: 13px;">{{ $s->created_at->translatedFormat('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection
