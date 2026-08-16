@extends('layouts.app')
@section('title', 'Pusat Pembayaran & Validasi')
@section('header_desc', 'Kelola pengeluaran & validasi patungan dengan mudah.')

@section('content')



<div x-data="{ activeTab: 'pengeluaran' }">
    
    <div class="flex gap-2 mb-8">
        <button @click="activeTab = 'pengeluaran'; setTimeout(() => window.initBarChart(), 50)" 
                :class="activeTab === 'pengeluaran' ? 'bg-[#111c2e] border-emerald-500 text-emerald-400' : 'bg-transparent border-[rgba(255,255,255,0.06)] text-[#94a3b8] hover:text-white'"
                class="px-5 py-2.5 rounded-xl border flex items-center gap-2 transition-all text-sm font-bold shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pengeluaran Pribadi
        </button>
        <button @click="activeTab = 'validasi'; setTimeout(() => window.dispatchEvent(new Event('resize')), 50)" 
                :class="activeTab === 'validasi' ? 'bg-[#111c2e] border-emerald-500 text-emerald-400' : 'bg-transparent border-[rgba(255,255,255,0.06)] text-[#94a3b8] hover:text-white'"
                class="px-5 py-2.5 rounded-xl border flex items-center gap-2 transition-all text-sm font-bold shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Validasi Patungan
        </button>
    </div>

    
    <div x-show="activeTab === 'validasi'" x-cloak>
        
        
        @php
            $pendingTotal = $pendingVerifications->sum('split_amount');
            $pendingCount = $pendingVerifications->count();
            $approvedTotal = collect($historyValidations)->sum('split_amount'); 
            $approvedCount = collect($historyValidations)->count();
            
            // Dummy logic or simple calculation for active friends
            $activeFriendsCount = Auth::user()->subscriptionShares->unique('friend_user_id')->count();
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-5 flex flex-col justify-between relative overflow-hidden shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-white mb-0.5">Menunggu Validasi</h4>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-white">{{ $pendingCount }}</span>
                            <span class="text-[10px] text-[#4b5e78]">bukti pembayaran</span>
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-t border-[rgba(255,255,255,0.04)]">
                    <p class="text-[10px] text-[#94a3b8]">Total nominal <span class="font-bold text-purple-400">Rp{{ number_format($pendingTotal, 0, ',', '.') }}</span></p>
                </div>
            </div>

            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-5 flex flex-col justify-between relative overflow-hidden shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-white mb-0.5">Sudah Divalidasi</h4>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-white">{{ collect($historyValidations)->count() }}</span>
                            <span class="text-[10px] text-[#4b5e78]">bukti pembayaran</span>
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-t border-[rgba(255,255,255,0.04)]">
                    <p class="text-[10px] text-[#94a3b8]">Total nominal <span class="font-bold text-emerald-400">Rp{{ number_format($approvedTotal, 0, ',', '.') }}</span></p>
                </div>
            </div>

            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-5 flex flex-col justify-between relative overflow-hidden shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-white mb-0.5">Ditolak</h4>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-white">0</span>
                            <span class="text-[10px] text-[#4b5e78]">bukti pembayaran</span>
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-t border-[rgba(255,255,255,0.04)]">
                    <p class="text-[10px] text-[#94a3b8]">Total nominal <span class="font-bold text-red-400">Rp0</span></p>
                </div>
            </div>

            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-5 flex flex-col justify-between relative overflow-hidden shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-white mb-0.5">Teman Patungan</h4>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-white">{{ $activeFriendsCount }}</span>
                            <span class="text-[10px] text-[#4b5e78]">orang</span>
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-t border-[rgba(255,255,255,0.04)]">
                    <p class="text-[10px] text-blue-400 font-bold">Aktif patungan bersama</p>
                </div>
            </div>
        </div>

        
        <div class="flex flex-col sm:flex-row gap-3 mb-6">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" placeholder="Cari teman atau layanan..." class="w-full bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-xl pl-9 pr-4 py-2.5 text-xs text-white focus:outline-none focus:border-emerald-500 transition-colors">
            </div>
            
            <div class="relative w-full sm:w-48">
                <select class="w-full bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-xl pl-4 pr-10 py-2.5 text-xs text-[#94a3b8] focus:outline-none focus:border-emerald-500 appearance-none cursor-pointer">
                    <option>Semua Status</option>
                    <option>Menunggu Validasi</option>
                    <option>Sudah Divalidasi</option>
                    <option>Ditolak</option>
                </select>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4b5e78] pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            
            <div class="flex gap-3">
                <div class="relative w-32">
                    <select class="w-full bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-xl pl-4 pr-10 py-2.5 text-xs text-[#94a3b8] focus:outline-none focus:border-emerald-500 appearance-none cursor-pointer">
                        <option>Terbaru</option>
                        <option>Terlama</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-[#4b5e78] pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
                <button class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] hover:bg-[#111c2e] text-[#94a3b8] p-2.5 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                </button>
            </div>
        </div>

        
        <div class="mb-4">
            <h3 class="text-[13px] font-bold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Menunggu Validasi ({{ $pendingCount }})
            </h3>
            <p class="text-[10px] text-[#4b5e78] mt-1 ml-6">Validasi bukti transfer dari teman Anda.</p>
        </div>

        
        <div class="space-y-3 mb-10">
            @forelse($pendingVerifications as $share)
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-4 flex flex-col lg:flex-row lg:items-center justify-between gap-4 transition-all hover:bg-[#111c2e]" x-data="{ showBukti: false }">
                
                
                <div class="flex items-center gap-3 min-w-[200px]">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-[#192a42] flex items-center justify-center font-bold text-[#f1f5f9] text-sm overflow-hidden border border-[rgba(255,255,255,0.06)]">
                            @if($share->friendUser && $share->friendUser->avatar)
                                <img src="{{ Storage::url($share->friendUser->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($share->friend_name) }}&background=192a42&color=fff" alt="Avatar" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#0b121f] rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#f1f5f9] text-sm leading-tight">{{ $share->friend_name }}</h4>
                        <p class="text-[10px] text-emerald-400 font-medium">@{{ strtolower(str_replace(' ', '', $share->friend_name)) }}</p>
                    </div>
                </div>

                
                <div class="flex items-center gap-3 min-w-[180px]">
                    @if($share->subscription->logo)
                        <div class="w-7 h-7 bg-[#080d19] border border-[rgba(255,255,255,0.03)] rounded-full p-1 flex items-center justify-center shrink-0">
                            <img src="{{ $share->subscription->logo }}" alt="{{ $share->subscription->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                        </div>
                    @else
                        <div class="w-6 h-6 bg-[#192a42] rounded flex items-center justify-center text-[#94a3b8] text-[10px] font-bold">
                            {{ substr($share->subscription->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-[#f1f5f9] text-xs leading-tight">{{ $share->subscription->name }}</h4>
                        <p class="text-[10px] text-[#4b5e78]">Tagihan bulanan</p>
                    </div>
                </div>

                
                <div class="min-w-[120px]">
                    <p class="text-[9px] text-[#4b5e78] uppercase tracking-wider mb-0.5">Nominal Dibayar</p>
                    <p class="font-bold text-white text-sm">{{ $share->formatted_split_amount }}</p>
                </div>

                
                <div class="min-w-[140px]">
                    <p class="text-[9px] text-[#4b5e78] uppercase tracking-wider mb-0.5">Dikirim pada</p>
                    <p class="text-xs text-[#f1f5f9]">{{ $share->updated_at->translatedFormat('d M Y, H:i') }}</p>
                </div>

                
                <div class="flex items-center gap-4 border-t lg:border-t-0 border-[rgba(255,255,255,0.06)] pt-4 lg:pt-0 mt-2 lg:mt-0 w-full lg:w-auto justify-end">
                    
                    
                    <div @click="showBukti = true" class="relative w-12 h-14 bg-[#192a42] rounded-lg border border-[rgba(255,255,255,0.06)] overflow-hidden cursor-pointer group shrink-0 shadow-sm">
                        <img src="{{ Storage::url($share->payment_proof_path) }}" alt="Bukti" class="w-full h-full object-cover opacity-80 group-hover:opacity-50 transition-opacity">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" /></svg>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('shares.reject-proof', $share->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK bukti transfer ini?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-transparent border border-red-500/30 hover:bg-red-500/10 text-red-400 font-bold rounded-xl text-xs transition-colors">Tolak</button>
                        </form>
                        <form method="POST" action="{{ route('shares.mark-paid', $share->id) }}">
                            @csrf
                            <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-xs transition-colors shadow-[0_2px_10px_rgba(16,185,129,0.3)]">Setujui</button>
                        </form>
                        <button class="w-8 h-8 flex items-center justify-center bg-transparent hover:bg-[#192a42] border border-[rgba(255,255,255,0.06)] rounded-xl text-[#94a3b8] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
                        </button>
                    </div>
                </div>

                
                <div x-show="showBukti" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-[#03060D]/90 backdrop-blur-sm" @click.away="showBukti = false">
                    <div class="bg-[#0b121f] p-5 rounded-2xl max-w-sm w-full border border-[rgba(255,255,255,0.06)] text-center relative shadow-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-white">Bukti Transfer - {{ $share->friend_name }}</h4>
                            <button @click="showBukti = false" class="text-[#4b5e78] hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="bg-[#111c2e] p-2 rounded-xl mb-6 shadow-sm border border-[rgba(255,255,255,0.04)]">
                            <img src="{{ Storage::url($share->payment_proof_path) }}" alt="Bukti Transfer" class="w-full rounded-lg object-contain max-h-[60vh]">
                        </div>
                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('shares.reject-proof', $share->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-transparent border border-red-500/30 hover:bg-red-500/10 text-red-400 font-bold py-2.5 rounded-xl text-xs transition-colors">Tolak</button>
                            </form>
                            <form method="POST" action="{{ route('shares.mark-paid', $share->id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 rounded-xl text-xs transition-colors shadow-[0_2px_10px_rgba(16,185,129,0.3)]">Setujui</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            @empty
            <div class="bg-[#0b121f] border border-dashed border-[rgba(255,255,255,0.1)] rounded-2xl p-10 flex flex-col items-center justify-center text-center">
                <div class="w-12 h-12 bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-full flex items-center justify-center text-[#4b5e78] mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h4 class="font-bold text-white text-sm mb-1">Tidak Ada Antrean Validasi</h4>
                <p class="text-xs text-[#4b5e78]">Semua bukti transfer dari teman Anda sudah divalidasi atau belum ada yang membayar.</p>
            </div>
            @endforelse
        </div>

        
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[13px] font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Riwayat Validasi Terakhir
                </h3>
                <a href="#" class="text-[11px] text-[#94a3b8] hover:text-white transition-colors flex items-center gap-1">
                    Lihat Semua Riwayat
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
            
            <div class="md:hidden flex items-center justify-end gap-1 text-[10px] text-[#4b5e78] italic mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                <span>Geser tabel</span>
            </div>
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl overflow-x-auto w-full">
                <table class="w-full min-w-[500px] text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-[#111c2e] border-b border-[rgba(255,255,255,0.04)] text-[#94a3b8] text-[10px] font-bold uppercase tracking-widest">
                            <th class="px-6 py-3 font-medium">Teman</th>
                            <th class="px-6 py-3 font-medium">Layanan</th>
                            <th class="px-6 py-3 font-medium">Nominal</th>
                            <th class="px-6 py-3 font-medium text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[rgba(255,255,255,0.02)]">
                        @forelse($historyValidations as $history)
                        <tr class="hover:bg-[#111c2e]/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#192a42] flex items-center justify-center font-bold text-[#f1f5f9] text-xs">
                                        {{ substr($history->friend_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-white">{{ $history->friend_name }}</div>
                                        <div class="text-[10px] text-[#4b5e78]">{{ $history->updated_at->translatedFormat('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-white">{{ $history->subscription->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-white">{{ collect(explode(' ', $history->formatted_split_amount))->last() }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center gap-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold px-2 py-1 rounded-md border border-emerald-500/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    LUNAS
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-[#4b5e78]">Belum ada riwayat validasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div x-show="activeTab === 'pengeluaran'" x-cloak>
        
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 relative overflow-hidden shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-[#94a3b8] font-medium tracking-wide mb-1">Total Pengeluaran</p>
                        <h2 class="text-3xl font-black text-white mb-2 leading-none">Rp{{ number_format($totalPaid, 0, ',', '.') }}</h2>
                        <p class="text-[10px] text-[#4b5e78] flex items-center gap-1">
                            <span class="{{ $totalPaidDiffPct >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $totalPaidDiffPct < 0 ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                {{ abs($totalPaidDiffPct) }}%
                            </span>
                            dari bulan lalu
                        </p>
                    </div>
                </div>
                
                <div class="w-24 h-12 opacity-50 shrink-0 self-end xl:self-center">
                    <svg viewBox="0 0 100 30" class="w-full h-full stroke-emerald-500" fill="none" stroke-width="2"><path d="{{ $totalPaidSparkline }}" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 relative overflow-hidden shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400 shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-[#94a3b8] font-medium tracking-wide mb-1">Transaksi Bulan Ini</p>
                        <div class="flex items-baseline gap-2 mb-2">
                            <h2 class="text-3xl font-black text-white leading-none">{{ $thisMonthCount }}</h2>
                            <span class="text-xs text-[#4b5e78]">{{ now()->translatedFormat('M Y') }}</span>
                        </div>
                        <p class="text-[10px] text-[#4b5e78] flex items-center gap-1">
                            <span class="{{ $trxCountDiff >= 0 ? 'text-emerald-400' : 'text-red-400' }} font-bold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 {{ $trxCountDiff < 0 ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                {{ abs($trxCountDiff) }}
                            </span>
                            transaksi dari bulan lalu
                        </p>
                    </div>
                </div>
                
                <div class="w-24 h-12 opacity-50 shrink-0 self-end xl:self-center">
                    <svg viewBox="0 0 100 30" class="w-full h-full stroke-purple-500" fill="none" stroke-width="2"><path d="{{ $transactionCountSparkline }}" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            
            <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 relative overflow-hidden shadow-sm flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-400 shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <div>
                        <p class="text-xs text-[#94a3b8] font-medium tracking-wide mb-1">Subscription Aktif</p>
                        <h2 class="text-3xl font-black text-white mb-2 leading-none">{{ $activeSubCount }}</h2>
                        <p class="text-[10px] text-[#4b5e78]">
                            @if($activeSubDiff > 0)
                                <span class="text-emerald-400">Naik {{ $activeSubDiff }}</span> dari bulan lalu
                            @elseif($activeSubDiff < 0)
                                <span class="text-red-400">Turun {{ abs($activeSubDiff) }}</span> dari bulan lalu
                            @else
                                Layanan terhubung, sama seperti bulan lalu
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="w-24 h-12 opacity-50 shrink-0 self-end xl:self-center">
                    <svg viewBox="0 0 100 30" class="w-full h-full stroke-amber-500" fill="none" stroke-width="2"><path d="{{ $activeSubSparkline }}" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
        </div>

        
        <div class="flex flex-col lg:flex-row gap-6">
            
            
            <div class="w-full lg:w-2/3 flex flex-col gap-6">
                
                
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="font-bold text-[#f1f5f9] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#94a3b8]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            Grafik Pengeluaran (6 Bulan)
                        </h4>
                        <select class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-lg px-3 py-1.5 text-xs text-[#94a3b8] focus:outline-none focus:border-emerald-500 cursor-pointer">
                            <option>6 Bulan Terakhir</option>
                            <option>Tahun Ini</option>
                        </select>
                    </div>
                    <div class="h-64 relative w-full">
                        <canvas id="paymentBarChart"></canvas>
                    </div>
                </div>

                
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-[rgba(255,255,255,0.04)] flex items-center justify-between">
                        <h4 class="font-bold text-[#f1f5f9] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#94a3b8]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            Pengeluaran Terbaru
                        </h4>
                        <a href="#" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-medium transition-colors">Lihat Semua</a>
                    </div>
                    
                    <div class="md:hidden flex items-center justify-end gap-1 text-[10px] text-[#4b5e78] italic mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                        <span>Geser tabel</span>
                    </div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full min-w-[600px] text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-[#111c2e] text-[#4b5e78] text-[10px] font-bold uppercase tracking-widest border-b border-[rgba(255,255,255,0.04)]">
                                    <th class="px-5 py-3 font-medium">Subscription</th>
                                    <th class="px-5 py-3 font-medium">Nominal</th>
                                    <th class="px-5 py-3 font-medium">Tanggal</th>
                                    <th class="px-5 py-3 font-medium text-center">Status</th>
                                    <th class="px-5 py-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[rgba(255,255,255,0.02)]">
                                @forelse($payments->take(5) as $payment)
                                <tr class="hover:bg-[#111c2e]/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-[#080d19] flex items-center justify-center p-1.5 shrink-0 border border-[rgba(255,255,255,0.03)]">
                                                @if($payment->subscription->logo)
                                                    <img src="{{ $payment->subscription->logo }}" alt="{{ $payment->subscription->name }}" class="w-full h-full object-contain" onerror="this.style.display='none'">
                                                @else
                                                    <span class="text-xs font-bold text-[#94a3b8]">{{ substr($payment->subscription->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <span class="text-xs font-bold text-white">{{ $payment->subscription->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-xs font-bold text-white">
                                        Rp{{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-4 text-xs text-[#94a3b8]">
                                        {{ Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-flex items-center gap-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold px-2.5 py-1 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Terverifikasi
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <form method="POST" action="{{ route('payments.destroy', $payment->id) }}" onsubmit="return confirm('Hapus catatan pembayaran ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[#4b5e78] hover:text-red-400 transition-colors p-1" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-[#4b5e78]">Belum ada catatan pembayaran pribadi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            
            <div class="w-full lg:w-1/3 flex flex-col gap-6">
                
                
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-sm flex-1">
                    <h4 class="font-bold text-[#f1f5f9] flex items-center gap-2 mb-6">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        Catat Pengeluaran
                    </h4>
                    
                    <form method="POST" action="{{ route('payments.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-white mb-2 uppercase tracking-widest">Subscription</label>
                            <div class="relative">
                                <select name="subscription_id" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-4 pr-10 py-3 text-xs text-white focus:outline-none focus:border-emerald-500 appearance-none cursor-pointer hover:border-[rgba(255,255,255,0.1)] transition-colors" required>
                                    <option value="">Pilih subscription...</option>
                                    @foreach($subscriptions as $sub)
                                        <option value="{{ $sub->id }}" data-amount="{{ $sub->amount }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-[#4b5e78] pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-white mb-2 uppercase tracking-widest">Nominal (IDR)</label>
                            <input type="number" name="amount" id="inline_amount" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-emerald-500 hover:border-[rgba(255,255,255,0.1)] transition-colors" placeholder="Masukkan nominal" required min="1">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-white mb-2 uppercase tracking-widest">Tanggal</label>
                            <div class="relative">
                                <input type="date" name="payment_date" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-emerald-500 hover:border-[rgba(255,255,255,0.1)] transition-colors appearance-none [&::-webkit-calendar-picker-indicator]:opacity-0" value="{{ date('Y-m-d') }}" required max="{{ date('Y-m-d') }}">
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-[#4b5e78] pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="status" value="paid">
                        
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl text-xs transition-all shadow-[0_4px_15px_rgba(16,185,129,0.2)] flex items-center justify-center gap-2 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                            Simpan Catatan
                        </button>
                    </form>
                </div>

                
                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-sm relative overflow-hidden">
                    <h4 class="font-bold text-[#f1f5f9] mb-4 text-sm">Ringkasan Kategori Layanan</h4>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 relative shrink-0">
                            <canvas id="categoryDonutChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-[9px] text-[#94a3b8]">Total</span>
                                <span class="text-xs font-bold text-white">Rp{{ number_format($totalCategorySum / 1000, 0, ',', '.') }}k</span>
                            </div>
                        </div>
                        <div class="flex-1 space-y-3">
                            @forelse(array_slice($donutLabels, 0, 3) as $i => $label)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $donutColors[$i] }}"></span>
                                    <span class="text-[10px] font-bold text-white">{{ $label }}</span>
                                </div>
                                <span class="text-[10px] text-[#94a3b8]">{{ $donutPercentages[$i] }}%</span>
                            </div>
                            @empty
                            <div class="text-center">
                                <span class="text-[10px] text-[#94a3b8]">Belum ada kategori</span>
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

        Chart.defaults.color = '#4b5e78';
        Chart.defaults.font.family = 'Instrument Sans, sans-serif';

        window.initBarChart = function() {
            if (window.barChartInitialized) return;
            const ctxBar = document.getElementById('paymentBarChart');
            if (ctxBar && ctxBar.offsetParent !== null) {
                window.barChartInitialized = true;
                const barCtx = ctxBar.getContext('2d');
                const gradient = barCtx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, '#10b981'); 
                gradient.addColorStop(1, 'rgba(16, 185, 129, 0.1)');

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
                                backgroundColor: '#080d19',
                                titleColor: '#94a3b8',
                                bodyColor: '#f1f5f9',
                                borderColor: 'rgba(255,255,255,0.1)',
                                borderWidth: 1,
                                padding: 12,
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
                                    color: 'rgba(255, 255, 255, 0.03)',
                                    drawBorder: false 
                                },
                                border: { display: false },
                                ticks: {
                                    padding: 10,
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
                                    padding: 10,
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
                        borderColor: '#0b121f',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#080d19',
                            titleColor: '#94a3b8',
                            bodyColor: '#f1f5f9',
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
