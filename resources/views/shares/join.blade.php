@extends('layouts.app')
@section('title', 'Gabung Grup Patungan')
@section('heading', '🤝 Undangan Gabung Grup Patungan')
@section('subheading', 'Anda diundang untuk bergabung dalam grup patungan subscription.')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card text-center py-8">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4" style="background: rgba(99, 102, 241, 0.15);">
            {{ $subscription->category->icon ?? '📦' }}
        </div>

        <h3 class="text-xl font-extrabold mb-1" style="color: var(--text-primary);">{{ $subscription->name }}</h3>
        <p class="text-xs mb-4" style="color: var(--text-muted);">Diprakarsai oleh: <strong>{{ $subscription->user->name }}</strong> ({{ $subscription->user->user_tag }})</p>

        <div class="p-4 rounded-xl border mb-6 text-left space-y-2" style="background: var(--bg-primary); border-color: var(--border-color);">
            <div class="flex justify-between text-xs">
                <span style="color: var(--text-muted);">Total Biaya Layanan:</span>
                <span class="font-bold" style="color: var(--text-primary);">{{ $subscription->formatted_amount }}/{{ $subscription->billing_cycle }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span style="color: var(--text-muted);">Anggota Grup Saat Ini:</span>
                <span class="font-bold" style="color: var(--accent-primary);">{{ $subscription->shares->count() + 1 }} Orang</span>
            </div>
            <div class="flex justify-between text-xs pt-2 border-t" style="border-color: var(--border-color);">
                <span class="font-bold" style="color: var(--text-primary);">Bagian Anda jika Bergabung:</span>
                <span class="font-extrabold text-sm" style="color: #34d399;">Rp{{ number_format($splitAmount, 0, ',', '.') }}/bln</span>
            </div>
        </div>

        <form method="POST" action="{{ route('shares.confirm-join', $subscription->invite_code) }}">
            @csrf
            <button type="submit" class="btn-primary w-full justify-center text-sm py-3 mb-2">
                🤝 Konfirmasi & Gabung Grup Patungan
            </button>
        </form>

        <a href="{{ route('shares.index') }}" class="btn-secondary w-full justify-center text-xs">
            Batal
        </a>
    </div>
</div>
@endsection
