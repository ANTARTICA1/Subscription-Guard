@extends('layouts.app')
@section('title', 'Gabung Grup Patungan')

@section('content')
<div class="max-w-md mx-auto py-6">
    <div class="card p-8 text-center shadow-2xl relative overflow-hidden">
        <div class="w-14 h-14 rounded-xl bg-[var(--bg-elevated)] border border-[var(--border-color)] flex items-center justify-center mx-auto mb-5 p-2.5">
            @if($subscription->logo)
                <img src="{{ $subscription->logo }}" class="w-full h-full object-contain">
            @else
                <span style="color: {{ $subscription->category->color ?? '#6366f1' }}; font-size: 22px;">{!! $subscription->category->icon ?? '' !!}</span>
            @endif
        </div>

        <h3 class="text-xl font-bold text-[var(--text-primary)] mb-1">{{ $subscription->name }}</h3>
        <p class="text-xs text-[var(--text-muted)] mb-6">Diprakarsai oleh <strong class="text-[var(--text-primary)]">{{ $subscription->user->name }}</strong> ({{ $subscription->user->user_tag }})</p>

        <div class="p-4 rounded-xl bg-[var(--bg-elevated)] border border-[var(--border-color)] mb-6 text-left space-y-2.5">
            <div class="flex justify-between items-center text-xs">
                <span class="text-[var(--text-muted)]">Total Biaya Layanan</span>
                <span class="font-semibold text-[var(--text-primary)]">{{ $subscription->formatted_amount }} / {{ $subscription->billing_cycle }}</span>
            </div>
            <div class="flex justify-between items-center text-xs">
                <span class="text-[var(--text-muted)]">Anggota Saat Ini</span>
                <span class="font-semibold text-[var(--text-secondary)]">{{ $subscription->shares->count() + 1 }} Orang</span>
            </div>
            <div class="flex justify-between items-center text-xs pt-2.5 border-t border-[var(--border-color)]">
                <span class="font-semibold text-[var(--text-primary)]">Bagian Anda</span>
                <span class="font-extrabold text-base text-emerald-500">Rp{{ number_format($splitAmount, 0, ',', '.') }}/bulan</span>
            </div>
        </div>

        @if($subscription->user->bank_name)
            <div class="p-3.5 rounded-xl bg-[var(--bg-elevated)] border border-[var(--border-color)] mb-6 text-left text-xs space-y-1">
                <p class="text-[10px] text-[var(--text-muted)] font-bold uppercase tracking-wider">Rekening Pembayaran Host</p>
                <p class="text-[var(--text-primary)] font-semibold">{{ $subscription->user->bank_name }} - {{ $subscription->user->account_number }}</p>
                <p class="text-[11px] text-[var(--text-muted)]">a.n {{ $subscription->user->account_holder ?? $subscription->user->name }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('shares.confirm-join', $subscription->invite_code) }}">
            @csrf
            <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl text-xs transition-colors flex items-center justify-center gap-2 mb-2 cursor-pointer shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                Konfirmasi & Gabung Grup
            </button>
        </form>

        <a href="{{ route('shares.index') }}" class="block w-full py-2 text-xs text-[var(--text-muted)] hover:text-[var(--text-primary)] font-medium transition-colors">
            Batal
        </a>
    </div>
</div>
@endsection
