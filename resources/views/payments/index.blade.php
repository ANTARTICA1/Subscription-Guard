@extends('layouts.app')
@section('title', 'Pusat Pembayaran & Validasi')
@section('header_desc', 'Kelola pengeluaran & validasi patungan dengan rapi.')

@section('content')

<div x-data="{ activeTab: 'pengeluaran' }" class="space-y-6">

    <div class="flex items-center gap-6 border-b border-[var(--border-color)]">
        <button @click="activeTab = 'pengeluaran'; setTimeout(() => window.initBarChart(), 50)"
                :class="activeTab === 'pengeluaran' ? 'border-[var(--text-primary)] text-[var(--text-primary)] font-bold' : 'border-transparent text-[var(--text-muted)] hover:text-[var(--text-primary)]'"
                class="pb-3 border-b-2 flex items-center gap-2 transition-all text-xs font-semibold -mb-px">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pengeluaran Pribadi
        </button>
        <button @click="activeTab = 'validasi'; setTimeout(() => window.dispatchEvent(new Event('resize')), 50)"
                :class="activeTab === 'validasi' ? 'border-[var(--text-primary)] text-[var(--text-primary)] font-bold' : 'border-transparent text-[var(--text-muted)] hover:text-[var(--text-primary)]'"
                class="pb-3 border-b-2 flex items-center gap-2 transition-all text-xs font-semibold -mb-px">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Validasi Patungan
            @if(isset($pendingVerifications) && $pendingVerifications->count() > 0)
                <span class="px-1.5 py-0.5 text-[10px] rounded bg-[var(--bg-elevated)] text-[var(--text-secondary)] font-bold border border-[var(--border-color)]">{{ $pendingVerifications->count() }}</span>
            @endif
        </button>
    </div>

    <div x-show="activeTab === 'validasi'" x-cloak class="space-y-6">

        @php
            $pendingTotal = $pendingVerifications->sum('split_amount');
            $pendingCount = $pendingVerifications->count();
            $approvedTotal = collect($historyValidations)->sum('split_amount');
            $approvedCount = collect($historyValidations)->count();
            $activeFriendsCount = Auth::user()->subscriptionShares->unique('friend_user_id')->count();
        @endphp

        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-[var(--border-color)] overflow-hidden shadow-sm">
            
            <div class="p-4 flex flex-col justify-between">
                <div>
                    <div class="mb-1.5">
                        <h4 class="text-[11px] font-semibold text-[var(--text-secondary)]">Menunggu Validasi</h4>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl font-black text-[var(--text-primary)] tracking-tight">{{ $pendingCount }}</span>
                        <span class="text-[10px] text-[var(--text-muted)]">bukti</span>
                    </div>
                </div>
                <div class="pt-2.5 mt-2 border-t border-[var(--border-color)]/60">
                    <p class="text-[10px] text-[var(--text-muted)]">Total <span class="font-semibold text-[var(--text-secondary)]">Rp{{ number_format($pendingTotal, 0, ',', '.') }}</span></p>
                </div>
            </div>

            <div class="p-4 flex flex-col justify-between">
                <div>
                    <div class="mb-1.5">
                        <h4 class="text-[11px] font-semibold text-[var(--text-secondary)]">Sudah Divalidasi</h4>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl font-black text-[var(--text-primary)] tracking-tight">{{ collect($historyValidations)->count() }}</span>
                        <span class="text-[10px] text-[var(--text-muted)]">bukti</span>
                    </div>
                </div>
                <div class="pt-2.5 mt-2 border-t border-[var(--border-color)]/60">
                    <p class="text-[10px] text-[var(--text-muted)]">Total <span class="font-semibold text-[var(--text-secondary)]">Rp{{ number_format($approvedTotal, 0, ',', '.') }}</span></p>
                </div>
            </div>

            <div class="p-4 flex flex-col justify-between">
                <div>
                    <div class="mb-1.5">
                        <h4 class="text-[11px] font-semibold text-[var(--text-secondary)]">Ditolak</h4>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl font-black text-[var(--text-primary)] tracking-tight">{{ $rejectedCount ?? 0 }}</span>
                        <span class="text-[10px] text-[var(--text-muted)]">bukti</span>
                    </div>
                </div>
                <div class="pt-2.5 mt-2 border-t border-[var(--border-color)]/60">
                    <p class="text-[10px] text-[var(--text-muted)]">Total <span class="font-semibold text-[var(--text-secondary)]">Rp{{ number_format($rejectedTotal ?? 0, 0, ',', '.') }}</span></p>
                </div>
            </div>

            <div class="p-4 flex flex-col justify-between">
                <div>
                    <div class="mb-1.5">
                        <h4 class="text-[11px] font-semibold text-[var(--text-secondary)]">Teman Patungan</h4>
                    </div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl font-black text-[var(--text-primary)] tracking-tight">{{ $activeFriendsCount }}</span>
                        <span class="text-[10px] text-[var(--text-muted)]">orang</span>
                    </div>
                </div>
                <div class="pt-2.5 mt-2 border-t border-[var(--border-color)]/60">
                    <p class="text-[10px] text-[var(--text-muted)] font-medium">Aktif patungan bersama</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-2.5">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" placeholder="Cari teman atau layanan..." class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-md pl-8 pr-3 py-1.5 text-xs text-[var(--text-primary)] placeholder-[var(--text-muted)] focus:outline-none focus:border-slate-400 transition-colors">
            </div>

            <div class="relative w-full sm:w-44">
                <select class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-md pl-3 pr-8 py-1.5 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 appearance-none cursor-pointer">
                    <option>Semua Status</option>
                    <option>Menunggu Validasi</option>
                    <option>Sudah Divalidasi</option>
                    <option>Ditolak</option>
                </select>
                <div class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>

            <div class="relative w-32">
                <select class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-md pl-3 pr-8 py-1.5 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 appearance-none cursor-pointer">
                    <option>Terbaru</option>
                    <option>Terlama</option>
                </select>
                <div class="absolute right-2.5 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
        </div>

        <div>
            <div class="mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Menunggu Validasi ({{ $pendingCount }})
                </h3>
            </div>

            <div class="space-y-2.5">
                @forelse($pendingVerifications as $share)
                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-3.5 flex flex-col lg:flex-row lg:items-center justify-between gap-3 transition-all hover:border-[var(--border-color)]" x-data="{ showBukti: false }">

                    <div class="flex items-center gap-2.5 min-w-[180px]">
                        <div class="relative">
                            <div class="w-8 h-8 rounded-lg bg-[var(--bg-elevated)] flex items-center justify-center font-bold text-[var(--text-primary)] text-xs overflow-hidden border border-[var(--border-color)]">
                                @if($share->friendUser && $share->friendUser->avatar)
                                    <img src="{{ Storage::url($share->friendUser->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($share->friend_name) }}&background=192a42&color=fff" alt="Avatar" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="absolute bottom-0 right-0 w-2 h-2 bg-slate-400 border border-[var(--bg-card)] rounded-full"></div>
                        </div>
                        <div>
                            <h4 class="font-bold text-[var(--text-primary)] text-xs leading-tight">{{ $share->friend_name }}</h4>
                            <p class="text-[9px] text-[var(--text-muted)] font-normal">@{{ strtolower(str_replace(' ', '', $share->friend_name)) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 min-w-[160px]">
                        @if($share->subscription->logo)
                            <div class="w-6 h-6 bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-md p-1 flex items-center justify-center shrink-0">
                                <img src="{{ $share->subscription->logo }}" alt="{{ $share->subscription->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                            </div>
                        @else
                            <div class="w-6 h-6 bg-[var(--bg-elevated)] rounded-md flex items-center justify-center text-[var(--text-muted)] text-[9px] font-bold">
                                {{ substr($share->subscription->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-[var(--text-primary)] text-xs leading-tight">{{ $share->subscription->name }}</h4>
                            <p class="text-[9px] text-[var(--text-muted)]">Tagihan bulanan</p>
                        </div>
                    </div>

                    <div class="min-w-[110px]">
                        <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-wider">Nominal</p>
                        <p class="font-bold text-[var(--text-primary)] text-xs">{{ $share->formatted_split_amount }}</p>
                    </div>

                    <div class="min-w-[120px]">
                        <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-wider">Dikirim</p>
                        <p class="text-[10px] text-[var(--text-muted)]">{{ $share->updated_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>

                    <div class="flex items-center gap-3 border-t lg:border-t-0 border-[var(--border-color)]/60 pt-3 lg:pt-0 mt-1 lg:mt-0 w-full lg:w-auto justify-end">
                        <div @click="showBukti = true" class="relative w-10 h-12 bg-[var(--bg-elevated)] rounded-md border border-[var(--border-color)] overflow-hidden cursor-pointer group shrink-0">
                            <img src="{{ Storage::url($share->payment_proof_path) }}" alt="Bukti" class="w-full h-full object-cover opacity-80 group-hover:opacity-50 transition-opacity">
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <form method="POST" action="{{ route('shares.reject-proof', $share->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK bukti transfer ini?');">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-transparent border border-red-500/30 hover:bg-red-500/10 text-red-400 font-semibold rounded-md text-xs transition-colors">Tolak</button>
                            </form>
                            <form method="POST" action="{{ route('shares.mark-paid', $share->id) }}">
                                @csrf
                                <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-md text-xs transition-colors">Setujui</button>
                            </form>
                        </div>
                    </div>

                    <div x-show="showBukti" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" @click.away="showBukti = false">
                        <div class="bg-[#0f172a] p-4 rounded-xl max-w-sm w-full border border-[#1e293b] text-center relative shadow-2xl">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-xs font-bold text-white">Bukti Transfer - {{ $share->friend_name }}</h4>
                                <button @click="showBukti = false" class="text-[#64748b] hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="bg-[#0b1120] p-1.5 rounded-lg mb-4 border border-[#1e293b]">
                                <img src="{{ Storage::url($share->payment_proof_path) }}" alt="Bukti Transfer" class="w-full rounded object-contain max-h-[60vh]">
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('shares.reject-proof', $share->id) }}" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-transparent border border-red-500/30 hover:bg-red-500/10 text-red-400 font-semibold py-1.5 rounded-md text-xs transition-colors">Tolak</button>
                                </form>
                                <form method="POST" action="{{ route('shares.mark-paid', $share->id) }}" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-1.5 rounded-md text-xs transition-colors">Setujui</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                @empty
                <div class="py-10 flex flex-col items-center justify-center text-center">
                    <div class="w-9 h-9 rounded-full bg-[var(--bg-elevated)] flex items-center justify-center text-[var(--text-muted)] mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-xs font-semibold text-[var(--text-primary)]">Tidak Ada Pembayaran Menunggu</p>
                    <p class="text-[10px] text-[var(--text-muted)] mt-0.5">Semua bukti pembayaran dari teman patungan telah divalidasi.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg overflow-hidden shadow-sm">
            <div class="p-3.5 border-b border-[var(--border-color)] flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--text-primary)]">Riwayat Validasi</h3>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap text-xs">
                    <thead>
                        <tr class="bg-[var(--bg-elevated)]/40 text-[var(--text-muted)] text-[10px] font-bold uppercase tracking-wider border-b border-[var(--border-color)]">
                            <th class="px-4 py-2.5">Teman</th>
                            <th class="px-4 py-2.5">Subscription</th>
                            <th class="px-4 py-2.5">Nominal</th>
                            <th class="px-4 py-2.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border-color)]/50">
                        @forelse($historyValidations as $history)
                        <tr class="hover:bg-[var(--bg-elevated)]/30 transition-colors">
                            <td class="px-4 py-3">
                                <span class="font-bold text-[var(--text-primary)]">{{ $history->friend_name }}</span>
                            </td>
                            <td class="px-4 py-3 text-[var(--text-muted)]">
                                {{ $history->subscription->name }}
                            </td>
                            <td class="px-4 py-3 font-bold text-[var(--text-primary)]">
                                {{ collect(explode(' ', $history->formatted_split_amount))->last() }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center gap-1 bg-[var(--bg-elevated)] text-[var(--text-secondary)] text-[10px] font-medium px-2 py-0.5 rounded border border-[var(--border-color)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-xs text-[var(--text-muted)]">Belum ada riwayat validasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'pengeluaran'" x-cloak class="space-y-6">

        <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-[var(--border-color)] overflow-hidden shadow-sm">
            
            <div class="p-5 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] text-[var(--text-muted)] font-medium mb-1">Total Pengeluaran</p>
                    <h2 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">Rp{{ number_format($totalPaid, 0, ',', '.') }}</h2>
                    <p class="text-[10px] text-[var(--text-muted)] mt-2 flex items-center gap-1">
                        <span class="text-[var(--text-secondary)] font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $totalPaidDiffPct < 0 ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                            {{ abs($totalPaidDiffPct) }}%
                        </span>
                        <span>dari bulan lalu</span>
                    </p>
                </div>
            </div>

            <div class="p-5 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] text-[var(--text-muted)] font-medium mb-1">Transaksi Bulan Ini</p>
                    <div class="flex items-baseline gap-2">
                        <h2 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">{{ $thisMonthCount }}</h2>
                        <span class="text-[10px] text-[var(--text-muted)]">{{ now()->translatedFormat('M Y') }}</span>
                    </div>
                    <p class="text-[10px] text-[var(--text-muted)] mt-2 flex items-center gap-1">
                        <span class="text-[var(--text-secondary)] font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $trxCountDiff < 0 ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                            {{ abs($trxCountDiff) }}
                        </span>
                        <span>transaksi dari bulan lalu</span>
                    </p>
                </div>
            </div>

            <div class="p-5 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] text-[var(--text-muted)] font-medium mb-1">Subscription Aktif</p>
                    <h2 class="text-2xl font-black text-[var(--text-primary)] leading-none tracking-tight">{{ $activeSubCount }}</h2>
                    <p class="text-[10px] text-[var(--text-muted)] mt-2">
                        @if($activeSubDiff > 0)
                            <span class="text-[var(--text-secondary)] font-medium">Naik {{ $activeSubDiff }}</span> dari bulan lalu
                        @elseif($activeSubDiff < 0)
                            <span class="text-[var(--text-secondary)] font-medium">Turun {{ abs($activeSubDiff) }}</span> dari bulan lalu
                        @else
                            Layanan terhubung, sama seperti bulan lalu
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-8 space-y-6">

                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            Grafik Pengeluaran (6 Bulan)
                        </h4>
                        <select class="bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-md px-2.5 py-1 text-xs text-[var(--text-muted)] focus:outline-none focus:border-slate-400 cursor-pointer">
                            <option>6 Bulan Terakhir</option>
                            <option>Tahun Ini</option>
                        </select>
                    </div>
                    <div class="h-64 relative w-full">
                        <canvas id="paymentBarChart"></canvas>
                    </div>
                </div>

                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg shadow-sm overflow-hidden">
                    <div class="p-3.5 border-b border-[var(--border-color)] flex items-center justify-between">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            Pengeluaran Terbaru
                        </h4>
                    </div>

                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse whitespace-nowrap text-xs">
                            <thead>
                                <tr class="bg-[var(--bg-elevated)]/40 text-[var(--text-muted)] text-[10px] font-bold uppercase tracking-wider border-b border-[var(--border-color)]">
                                    <th class="px-4 py-2.5 font-medium">Subscription</th>
                                    <th class="px-4 py-2.5 font-medium">Nominal</th>
                                    <th class="px-4 py-2.5 font-medium">Tanggal</th>
                                    <th class="px-4 py-2.5 font-medium text-center">Status</th>
                                    <th class="px-4 py-2.5 w-8"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[var(--border-color)]/50">
                                @forelse($payments->take(5) as $payment)
                                <tr class="hover:bg-[var(--bg-elevated)]/30 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2.5">
                                             <div class="w-7 h-7 rounded-md bg-[var(--bg-elevated)] flex items-center justify-center p-1 shrink-0 border border-[var(--border-color)]">
                                                @if($payment->subscription->logo)
                                                    <img src="{{ $payment->subscription->logo }}" alt="{{ $payment->subscription->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                                                @else
                                                    <span class="text-[10px] font-bold text-[var(--text-muted)]">{{ substr($payment->subscription->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <span class="text-xs font-bold text-[var(--text-primary)]">{{ $payment->subscription->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-bold text-[var(--text-primary)]">
                                        Rp{{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-[var(--text-muted)]">
                                        {{ Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center gap-1 bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-secondary)] text-[10px] font-medium px-2 py-0.5 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Terverifikasi
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('payments.destroy', $payment->id) }}" onsubmit="return confirm('Hapus catatan pembayaran ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[var(--text-muted)] hover:text-red-400 transition-colors p-1" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-xs text-[var(--text-muted)]">Belum ada catatan pembayaran pribadi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-4 space-y-6">

                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-5 shadow-sm">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-[var(--text-primary)] flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Catat Pengeluaran
                    </h4>

                    <form method="POST" action="{{ route('payments.store') }}" class="space-y-3.5">
                        @csrf

                        <div>
                            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Subscription</label>
                            <div class="relative">
                                <select name="subscription_id" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-md pl-3 pr-8 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 appearance-none cursor-pointer transition-colors" required>
                                    <option value="">Pilih subscription...</option>
                                    @foreach($subscriptions as $sub)
                                        <option value="{{ $sub->id }}" data-amount="{{ $sub->amount }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[var(--text-muted)] pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Nominal (IDR)</label>
                            <input type="number" name="amount" id="inline_amount" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-md px-3 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" placeholder="Masukkan nominal" required min="1">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-[var(--text-muted)] mb-1 uppercase tracking-wider">Tanggal</label>
                            <div class="relative">
                                <input type="date" name="payment_date" class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-md px-3 py-2 text-xs text-[var(--text-primary)] focus:outline-none focus:border-slate-400 transition-colors" value="{{ date('Y-m-d') }}" required max="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <input type="hidden" name="status" value="paid">

                        <button type="submit" class="btn-primary w-full py-2.5 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition-all mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                            Simpan Catatan
                        </button>
                    </form>
                </div>

                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-lg p-4 shadow-sm">
                    <h4 class="font-bold text-[var(--text-primary)] mb-3 text-xs uppercase tracking-wider">Kategori Layanan</h4>

                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 relative shrink-0">
                            <canvas id="categoryDonutChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-[8px] text-[var(--text-muted)]">Total</span>
                                <span class="text-[11px] font-bold text-[var(--text-primary)]">Rp{{ number_format($totalCategorySum / 1000, 0, ',', '.') }}k</span>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            @forelse(array_slice($donutLabels, 0, 3) as $i => $label)
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $donutColors[$i] }}"></span>
                                    <span class="text-[11px] font-semibold text-[var(--text-primary)] truncate">{{ $label }}</span>
                                </div>
                                <span class="text-[10px] text-[var(--text-muted)] shrink-0">{{ $donutPercentages[$i] }}%</span>
                            </div>
                            @empty
                            <div class="text-center py-2">
                                <span class="text-[10px] text-[var(--text-muted)]">Belum ada kategori</span>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subSelect = document.querySelector('select[name="subscription_id"]');
        const amountInput = document.getElementById('inline_amount');

        if (subSelect && amountInput) {
            subSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.dataset.amount) {
                    amountInput.value = selectedOption.dataset.amount;
                }
            });
        }

        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = 'Instrument Sans, sans-serif';

        window.initBarChart = function() {
            if (window.barChartInitialized) return;
            const ctxBar = document.getElementById('paymentBarChart');
            if (ctxBar && ctxBar.offsetParent !== null) {
                window.barChartInitialized = true;
                const barCtx = ctxBar.getContext('2d');
                const gradient = barCtx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, '#64748b');
                gradient.addColorStop(1, 'rgba(100, 116, 139, 0.15)');

                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode(array_reverse($chartLabels)) !!},
                        datasets: [{
                            label: 'Pengeluaran (Rp)',
                            data: {!! json_encode(array_reverse($chartData)) !!},
                            backgroundColor: gradient,
                            borderRadius: 4,
                            borderSkipped: false,
                            barPercentage: 0.5,
                            categoryPercentage: 0.8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleColor: '#94a3b8',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: (document.documentElement.getAttribute('data-theme') === 'light') ? 'rgba(15, 23, 42, 0.05)' : 'rgba(148, 163, 184, 0.06)',
                                    drawBorder: false
                                },
                                border: { display: false },
                                ticks: {
                                    color: (document.documentElement.getAttribute('data-theme') === 'light') ? '#475569' : '#94a3b8',
                                    padding: 8,
                                    font: { size: 10 },
                                    callback: function(value) {
                                        if(value >= 1000000) return 'Rp' + (value/1000000).toFixed(1) + 'M';
                                        if(value >= 1000) return 'Rp' + (value/1000).toFixed(0) + 'Rb';
                                        return value;
                                    }
                                }
                            },
                            x: {
                                grid: { display: false },
                                border: { display: false },
                                ticks: {
                                    color: (document.documentElement.getAttribute('data-theme') === 'light') ? '#475569' : '#94a3b8',
                                    padding: 8,
                                    font: { size: 10 }
                                }
                            }
                        }
                    }
                });
            }
        };

        setTimeout(() => window.initBarChart(), 100);

        const ctxDonut = document.getElementById('categoryDonutChart');
        if (ctxDonut) {
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($donutLabels) !!},
                    datasets: [{
                        data: {!! json_encode($donutData) !!},
                        backgroundColor: {!! json_encode($donutColors) !!},
                        borderWidth: 2,
                        borderColor: document.documentElement.getAttribute('data-theme') === 'light' ? '#ffffff' : '#0d1726',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#94a3b8',
                            bodyColor: '#ffffff',
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            padding: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
