@extends('layouts.app')
@section('title', 'Daftar Teman')

@section('content')



<div class="space-y-6 pb-12">

    {{-- Decorative Header --}}
    <div class="bg-gradient-to-r from-[#0b121f] to-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-8 relative overflow-hidden flex items-center justify-between">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-14 h-14 bg-[#192a42] rounded-2xl flex items-center justify-center text-white shadow-lg border border-[rgba(255,255,255,0.06)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white mb-1 tracking-tight">Tambah Teman</h2>
                <p class="text-[13px] text-[#94a3b8]">Temukan temanmu dengan mudah menggunakan User Tag unik mereka.</p>
            </div>
        </div>
        
        {{-- Right Illustration --}}
        <div class="hidden md:flex items-center gap-4 relative z-10 mr-10">
            {{-- Decorative elements --}}
            <svg class="absolute top-0 right-32 text-emerald-500/20 w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l3 9 9 3-9 3-3 9-3-9-9-3 9-3z"/></svg>
            <svg class="absolute bottom-0 -right-4 text-purple-500/20 w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0l3 9 9 3-9 3-3 9-3-9-9-3 9-3z"/></svg>
            
            <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            
            <div class="flex items-center">
                <div class="w-8 h-px bg-emerald-500/30 border-t border-dashed border-emerald-500/50"></div>
                <div class="w-8 h-8 rounded-full border border-[rgba(255,255,255,0.1)] bg-[#0b121f] flex items-center justify-center text-[#94a3b8] mx-2 relative top-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <div class="w-8 h-px bg-purple-500/30 border-t border-dashed border-purple-500/50"></div>
            </div>
            
            <div class="w-16 h-16 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
        </div>
    </div>

    {{-- 3 Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- Column 1: Cari Teman & Tips --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6">
                <h3 class="font-bold text-white mb-1">Cari Teman dengan User Tag</h3>
                <p class="text-[11px] text-[#94a3b8] mb-6">Minta tag unik dari temanmu untuk menambahkannya.</p>
                
                <form method="POST" action="{{ route('social.add') }}">
                    @csrf
                    <div class="relative flex items-center mb-4">
                        <div class="absolute left-4 text-[#4b5e78] font-mono text-sm">@</div>
                        <input type="text" name="user_tag" class="w-full bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:outline-none focus:border-emerald-500 transition-colors" placeholder="Masukkan User Tag (contoh: TAG-A1B2C3)" required>
                    </div>
                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-[0_0_15px_rgba(16,185,129,0.15)] flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Cari & Tambahkan
                    </button>
                </form>
            </div>
            
            <div class="bg-[#0b121f] border border-emerald-500/20 rounded-2xl p-6 relative overflow-hidden">
                {{-- Decorative bg --}}
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-emerald-500/5 rounded-tl-full pointer-events-none"></div>
                
                <div class="flex items-center gap-2 mb-4 relative z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
                    <h4 class="font-bold text-white">Tips</h4>
                </div>
                
                <p class="text-xs text-[#94a3b8] leading-relaxed mb-6 relative z-10 pr-8">
                    User Tag bisa ditemukan di profil masing-masing temanmu.
                </p>
                
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl p-3 inline-flex items-center gap-3 relative z-10 transform rotate-[-2deg] ml-8 shadow-lg">
                    <div class="w-6 h-6 bg-[#080d19] rounded-md flex items-center justify-center text-[#4b5e78]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                    </div>
                    <span class="text-emerald-400 font-mono text-[11px] font-bold tracking-widest">{{ $user->user_tag }}</span>
                </div>
            </div>
        </div>

        {{-- Column 2: Teman Tersedia --}}
        <div class="lg:col-span-5 bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl flex flex-col relative overflow-hidden">
            <div class="p-6 border-b border-[rgba(255,255,255,0.04)] flex items-center justify-between">
                <h3 class="font-bold text-white">Teman Tersedia</h3>
                <a href="#" class="flex items-center gap-1.5 text-[10px] text-[#94a3b8] hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    Segarkan
                </a>
            </div>
            
            <div class="p-6 space-y-4 flex-1">
                @forelse($suggestedFriends as $suggested)
                <div class="flex items-center justify-between p-4 bg-[#080d19] border border-[rgba(255,255,255,0.04)] rounded-xl group hover:border-[rgba(255,255,255,0.1)] transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full border border-[rgba(255,255,255,0.1)] overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($suggested->name) }}&background=0b121f&color=10b981" alt="{{ $suggested->name }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white mb-0.5">{{ explode(' ', $suggested->name)[0] }}</p>
                            <p class="text-[10px] text-emerald-400 font-mono tracking-wide">{{ $suggested->user_tag }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('social.add') }}">
                        @csrf
                        <input type="hidden" name="user_tag" value="{{ $suggested->user_tag }}">
                        <button type="submit" class="w-8 h-8 rounded-lg bg-[#111c2e] text-[#4b5e78] group-hover:text-emerald-400 group-hover:bg-emerald-500/10 flex items-center justify-center transition-all" title="Tambah">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                    </form>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-[#4b5e78] py-8">
                    <p class="text-xs">Tidak ada sugesti teman saat ini.</p>
                </div>
                @endforelse
            </div>
            
            
        </div>

        {{-- Column 3: Teman Terhubung --}}
        <div class="lg:col-span-3 bg-[#111c2e] border border-[rgba(255,255,255,0.04)] rounded-2xl flex flex-col relative overflow-hidden">
            <div class="p-6 border-b border-[rgba(255,255,255,0.04)]">
                <h3 class="font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Teman Terhubung ({{ $friends->count() }})
                </h3>
            </div>
            
            <div class="p-6 space-y-4">
                @forelse($friends as $friend)
                <div class="flex items-center justify-between p-4 bg-[#080d19] border border-[rgba(255,255,255,0.04)] rounded-xl group hover:border-[rgba(255,255,255,0.1)] transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full border border-[rgba(255,255,255,0.1)] overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($friend->name) }}&background=192a42&color=fff" alt="{{ $friend->name }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-white mb-0.5">{{ explode(' ', $friend->name)[0] }}</p>
                            <p class="text-[9px] text-emerald-400 font-mono tracking-wide">{{ $friend->user_tag }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('social.remove', $friend->id) }}" onsubmit="return confirm('Hapus teman ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-7 h-7 rounded bg-transparent text-[#4b5e78] hover:text-red-500 flex items-center justify-center transition-colors" title="Hapus Teman">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
                @empty
                @endforelse
                
                {{-- Empty State Box --}}
                <div class="p-6 border border-dashed border-[#4b5e78] rounded-xl text-center">
                    <div class="w-10 h-10 bg-[#111c2e] rounded-full flex items-center justify-center text-[#4b5e78] mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </div>
                    <p class="text-[11px] font-bold text-white mb-1">Belum ada teman lainnya</p>
                    <p class="text-[10px] text-[#94a3b8]">Tambahkan lebih banyak teman untuk mulai patungan.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom Action Banner --}}
    <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center text-white flex-shrink-0 shadow-[0_0_20px_rgba(147,51,234,0.3)]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
            </div>
            <p class="text-[11px] text-[#94a3b8] max-w-sm leading-relaxed">
                Setelah menambahkan teman, kamu bisa langsung membuat patungan atau mengundang mereka ke grup yang sudah ada.
            </p>
        </div>
        <a href="{{ route('shares.index') }}" class="w-full md:w-auto bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition-colors text-[11px] flex items-center justify-center gap-2">
            Buat Patungan Sekarang
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </a>
    </div>

</div>

@endsection
