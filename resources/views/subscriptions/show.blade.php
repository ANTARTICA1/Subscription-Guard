@extends('layouts.app')
@section('title', $subscription->name)

@section('content')



{{-- Top Actions Row --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <a href="{{ route('subscriptions.index') }}" class="inline-flex items-center gap-2 text-xs text-[#94a3b8] hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Subscriptions
    </a>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('subscriptions.edit', $subscription) }}" class="px-4 py-2 bg-[#111c2e] border border-[rgba(255,255,255,0.06)] hover:bg-[#192a42] text-white text-xs font-semibold rounded-lg flex items-center gap-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
            Edit
        </a>
        <form method="POST" action="{{ route('subscriptions.mark-paid', $subscription) }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Bayar Sekarang
            </button>
        </form>
        <form method="POST" action="{{ route('subscriptions.destroy', $subscription) }}" onsubmit="return confirm('Hapus subscription ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-900/40 hover:bg-red-800 text-red-300 hover:text-white border border-red-500/30 text-xs font-semibold rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Hapus
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-10">
    {{-- Left Column (Main Content) --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Main Identity Card with Green Glow --}}
        @php
            $subColor = $subscription->category->color ?? '#10b981';
            // Fallback to green if not set
            $glowColor = '#10b981';
        @endphp
        <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-3xl p-8 relative overflow-hidden">
            {{-- Green Glow Effect --}}
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[{{ $glowColor }}] rounded-full blur-[120px] opacity-[0.15] pointer-events-none mix-blend-screen"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row gap-8 items-start">
                {{-- Logo --}}
                <div class="w-32 h-32 rounded-full bg-white p-2 shadow-[0_0_40px_rgba(16,185,129,0.3)] flex-shrink-0 flex items-center justify-center">
                    @if($subscription->logo)
                        <img src="{{ $subscription->logo }}" alt="{{ $subscription->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl font-bold" style="color: {{ $subColor }}">
                            {!! $subscription->category->icon ?? 'S' !!}
                        </div>
                    @endif
                </div>
                
                {{-- Details --}}
                <div class="flex-1 w-full">
                    <div class="mb-8">
                        @if($subscription->status === 'active')
                            <span class="inline-block px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold tracking-widest uppercase rounded mb-3">ACTIVE</span>
                        @else
                            <span class="inline-block px-2.5 py-1 bg-[#192a42] border border-[rgba(255,255,255,0.06)] text-[#94a3b8] text-[10px] font-bold tracking-widest uppercase rounded mb-3">{{ strtoupper($subscription->status) }}</span>
                        @endif
                        <h1 class="text-3xl font-extrabold text-white mb-2 tracking-tight">{{ $subscription->name }}</h1>
                        <p class="text-sm text-[#94a3b8] flex items-center gap-2">
                            {!! $subscription->category->icon ?? '' !!}
                            {{ $subscription->category->name ?? 'Lainnya' }}
                        </p>
                    </div>
                    
                    {{-- Detail Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 border-t border-[rgba(255,255,255,0.06)] pt-6">
                        <div>
                            <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide mb-1.5 uppercase">Biaya Tagihan</p>
                            <p class="text-lg font-bold text-white">{{ $subscription->formatted_amount }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide mb-1.5 uppercase">Siklus</p>
                            <p class="text-[13px] font-bold text-white">{{ ucfirst($subscription->billing_cycle) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide mb-1.5 uppercase">Jatuh Tempo</p>
                            <p class="text-[13px] font-bold text-white mb-1">{{ $subscription->next_payment_date->translatedFormat('d F Y') }}</p>
                            <p class="text-[10px] font-bold {{ $subscription->days_until_payment <= 3 ? 'text-amber-500' : 'text-emerald-500' }}">{{ $subscription->days_until_payment }} hari lagi</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide mb-1.5 uppercase">Tanggal Mulai</p>
                            <p class="text-[13px] font-medium text-white">{{ $subscription->start_date->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide mb-1.5 uppercase">Auto Renewal</p>
                            <p class="text-[13px] font-bold flex items-center gap-1.5 {{ $subscription->auto_renew ? 'text-emerald-400' : 'text-[#94a3b8]' }}">
                                @if($subscription->auto_renew)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Aktif
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Manual
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Riwayat Pembayaran Card --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4b5e78]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Riwayat Pembayaran
                </h3>
                <div class="relative">
                    <select class="appearance-none bg-[#192a42] border border-[rgba(255,255,255,0.05)] text-[#f1f5f9] text-[11px] font-semibold rounded-lg pl-4 pr-8 py-2 focus:outline-none focus:border-emerald-500 cursor-pointer">
                        <option>Semua Status</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#94a3b8] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            <p class="text-[11px] text-[#4b5e78] mb-6">Semua transaksi untuk {{ $subscription->name }}</p>

            {{-- 3 Glow Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.03)] rounded-xl p-5 flex flex-col items-center justify-center">
                    <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide uppercase mb-2">Total Terbayar</p>
                    <p class="text-2xl font-extrabold text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.3)]">
                        Rp{{ number_format($subscription->paymentHistories->where('status', 'paid')->sum('amount'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.03)] rounded-xl p-5 flex flex-col items-center justify-center">
                    <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide uppercase mb-2">Frekuensi</p>
                    <p class="text-2xl font-extrabold text-white">
                        {{ $subscription->paymentHistories->count() }} <span class="text-sm font-normal text-[#94a3b8]">Kali</span>
                    </p>
                </div>
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.03)] rounded-xl p-5 flex flex-col items-center justify-center">
                    <p class="text-[10px] text-[#4b5e78] font-bold tracking-wide uppercase mb-2">Rata-rata</p>
                    <p class="text-2xl font-extrabold text-emerald-400 drop-shadow-[0_0_10px_rgba(52,211,153,0.3)]">
                        Rp{{ number_format($subscription->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[rgba(255,255,255,0.06)]">
                            <th class="py-3 px-4 text-[10px] text-[#4b5e78] font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-4 text-[10px] text-[#4b5e78] font-bold uppercase tracking-wider">Nominal</th>
                            <th class="py-3 px-4 text-[10px] text-[#4b5e78] font-bold uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 text-[10px] text-[#4b5e78] font-bold uppercase tracking-wider">Catatan</th>
                            <th class="py-3 px-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[rgba(255,255,255,0.03)]">
                        @forelse($subscription->paymentHistories as $history)
                        <tr class="hover:bg-[#192a42] transition-colors group">
                            <td class="py-4 px-4 text-[11px] font-bold text-white">{{ \Carbon\Carbon::parse($history->payment_date)->translatedFormat('d F Y') }}</td>
                            <td class="py-4 px-4 text-[11px] font-medium text-white">Rp{{ number_format($history->amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                @if($history->status === 'paid')
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[9px] font-bold tracking-widest uppercase rounded">PAID</span>
                                @else
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 bg-[#192a42] border border-[rgba(255,255,255,0.06)] text-[#94a3b8] text-[9px] font-bold tracking-widest uppercase rounded">{{ strtoupper($history->status) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-[11px] text-[#94a3b8] truncate max-w-[200px]">{{ $history->notes ?? 'Pembayaran dikonfirmasi via Quick Action' }}</td>
                            <td class="py-4 px-4 text-right">
                                <a href="#" class="text-[#4b5e78] group-hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-xs text-[#4b5e78]">Belum ada riwayat pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-center text-[10px] text-[#4b5e78] items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                Semua transaksi aman dan terenkripsi.
            </div>
        </div>
    </div>

    {{-- Right Column (Sidebar) --}}
    <div class="lg:col-span-1 space-y-6">
        
        {{-- Info Auto-renew --}}
        @if($subscription->auto_renew)
        <div class="bg-[#19150d] border border-amber-500/20 rounded-2xl p-6">
            <div class="flex items-start gap-3 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <h4 class="text-[11px] font-bold text-amber-500 tracking-wider uppercase mt-0.5">Info Auto-Renew</h4>
            </div>
            <p class="text-[11px] text-[#94a3b8] leading-relaxed pl-8">
                Layanan ini memperpanjang otomatis pada <span class="font-bold text-white">{{ $subscription->next_payment_date->translatedFormat('d F Y') }}</span>. Pastikan saldo Anda mencukupi untuk tagihan berikutnya.
            </p>
        </div>
        @endif

        {{-- Proyeksi Beban --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6">
            <h3 class="text-sm font-bold text-white flex items-center gap-2 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Proyeksi Beban
            </h3>
            
            <div class="space-y-4 mb-6">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-[#94a3b8]">Per Bulan:</span>
                    <span class="text-xs font-bold text-white">Rp{{ number_format($subscription->monthly_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-[#94a3b8]">12 Bulan:</span>
                    <span class="text-xs font-bold text-emerald-400">Rp{{ number_format($subscription->monthly_amount * 12, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-[#94a3b8]">3 Tahun:</span>
                    <span class="text-xs font-bold text-emerald-400">Rp{{ number_format($subscription->monthly_amount * 36, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="bg-[#0b121f] border border-emerald-500/20 rounded-xl p-4 flex gap-3 items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div class="flex-1">
                    <p class="text-[11px] font-bold text-white mb-1">Potensi hemat setahun</p>
                    <p class="text-[9px] text-[#4b5e78]">Jika Anda membatalkan layanan ini.</p>
                </div>
                <div class="text-xs font-bold text-emerald-400">
                    Rp{{ number_format($subscription->monthly_amount * 12, 0, ',', '.') }}
                </div>
            </div>
        </div>

        {{-- Patungan --}}
        <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Patungan
                </h3>
                <a href="{{ route('shares.index') }}" class="text-[11px] text-[#94a3b8] hover:text-white transition-colors">Kelola →</a>
            </div>
            
            <div class="space-y-3 mb-5">
                @php
                    // Retrieve actual shares if any
                    $shares = App\Models\SubscriptionShare::where('subscription_id', $subscription->id)->with('friendUser')->get();
                @endphp

                @forelse($shares as $share)
                    <div class="flex items-center justify-between bg-[#0b121f] border border-[rgba(255,255,255,0.03)] rounded-xl p-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($share->friendUser->name ?? $share->friend_name) }}&background=1e293b&color=fff" class="w-full h-full">
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">{{ $share->friendUser->name ?? $share->friend_name }}</p>
                                <p class="text-[10px] text-[#4b5e78] flex items-center gap-1">
                                    {{ '@' . explode(' ', strtolower($share->friendUser->name ?? $share->friend_name))[0] }}
                                    <span class="w-1.5 h-1.5 rounded-full {{ $share->payment_status === 'paid' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                </p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-md text-[9px] font-bold tracking-widest uppercase border {{ $share->payment_status === 'paid' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-amber-500/10 border-amber-500/20 text-amber-500' }}">
                            {{ strtoupper($share->payment_status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-[11px] text-[#4b5e78] text-center py-4">Belum ada patungan.</p>
                @endforelse
            </div>
            
            <a href="{{ route('shares.index') }}" class="w-full py-2.5 bg-transparent border border-dashed border-[#4b5e78] hover:border-[#94a3b8] text-[#94a3b8] hover:text-white rounded-xl text-[11px] font-semibold flex items-center justify-center gap-1.5 transition-colors">
                + Tambah anggota patungan
            </a>
        </div>
    </div>
</div>

@endsection
