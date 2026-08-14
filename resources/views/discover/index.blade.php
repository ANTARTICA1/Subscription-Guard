@extends('layouts.app')
@section('title', 'Cari Teman Patungan')

@section('content')
<div x-data="discoverPage()" class="pb-10">
    
    {{-- Header Page --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#f1f5f9]">Grup Publik Terbuka</h2>
                <p class="text-xs text-[#94a3b8] mt-0.5">Bergabunglah dengan grup publik untuk berbagi biaya langganan.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('shares.index') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-bold rounded-xl flex items-center gap-2 hover:opacity-90 transition-opacity whitespace-nowrap shadow-lg shadow-indigo-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Buat Grup Saya
            </a>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        
        {{-- Left Content: 3 Columns Wide --}}
        <div class="xl:col-span-3 space-y-6">
            
            {{-- Filter Bar --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative flex-1">
                    <input type="text" x-model="search" placeholder="Cari grup atau layanan..." class="w-full bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-xl pl-10 pr-4 py-3 text-sm text-[#f1f5f9] focus:outline-none focus:border-indigo-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                
                {{-- Dummy Selects just for exact UI matching --}}
                <div class="flex gap-3">
                    <div class="relative w-40">
                        <select class="w-full bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm text-[#94a3b8] appearance-none focus:outline-none focus:border-indigo-500 transition-colors">
                            <option>Semua Kategori</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    </div>
                    <div class="relative w-32">
                        <select class="w-full bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-xl pl-9 pr-4 py-3 text-sm text-[#94a3b8] appearance-none focus:outline-none focus:border-indigo-500 transition-colors">
                            <option>Terbaru</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" /></svg>
                    </div>
                </div>
            </div>

            {{-- Empty State --}}
            <template x-if="filteredGroups.length === 0">
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-[#4b5e78] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <h4 class="text-[#f1f5f9] font-bold text-lg">Tidak ada grup ditemukan</h4>
                    <p class="text-[#94a3b8] text-sm mt-1" x-text="search ? 'Coba gunakan kata kunci lain.' : 'Belum ada grup publik saat ini.'"></p>
                </div>
            </template>

            {{-- Featured Card (First Item) --}}
            <template x-if="featuredGroup">
                <div class="bg-gradient-to-br from-[#1a1235] via-[#0f172a] to-[#0a1120] border border-indigo-500/20 rounded-2xl p-6 relative overflow-hidden shadow-[0_0_40px_rgba(79,70,229,0.05)]">
                    
                    {{-- Decorative gradient blob --}}
                    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                        
                        {{-- Left: Identity --}}
                        <div class="flex items-center gap-5">
                            <div class="w-24 h-24 rounded-2xl bg-[#080d19] border border-[rgba(255,255,255,0.06)] flex items-center justify-center p-3 shadow-lg">
                                <template x-if="featuredGroup.logo">
                                    <img :src="featuredGroup.logo" class="w-full h-full object-contain">
                                </template>
                                <template x-if="!featuredGroup.logo">
                                    <span x-html="featuredGroup.category ? featuredGroup.category.icon : ''" class="text-4xl" :style="`color: ${featuredGroup.category ? featuredGroup.category.color : '#fff'}`"></span>
                                </template>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        Publik
                                    </span>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2" x-text="featuredGroup.name"></h3>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30" x-text="featuredGroup.category ? featuredGroup.category.name : 'Subscription'"></span>
                                
                                <p class="text-xs text-[#94a3b8] mt-4 flex items-center gap-1.5">
                                    Host: <strong class="text-white" x-text="featuredGroup.user.name"></strong>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                </p>
                            </div>
                        </div>

                        {{-- Right: Button (Desktop) --}}
                        <div class="hidden md:block">
                            <a :href="featuredGroup.join_url" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-cyan-500 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-indigo-500/25 hover:scale-105 inline-block text-sm">
                                Minta Bergabung
                            </a>
                        </div>
                    </div>

                    {{-- Middle: Stats Grid --}}
                    <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-6 border-t border-[rgba(255,255,255,0.06)]">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#192a42] text-indigo-400 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#94a3b8] mb-0.5">Anggota Saat Ini</p>
                                <p class="text-xs font-bold text-white"><span class="text-emerald-400" x-text="featuredGroup.shares.length + 1"></span> orang</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#192a42] text-cyan-400 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#94a3b8] mb-0.5">Estimasi Patungan</p>
                                <p class="text-xs font-bold text-purple-400">Rp<span x-text="formatMoney(Math.round(featuredGroup.amount / (featuredGroup.shares.length + 2)))"></span> <span class="text-[9px] text-[#4b5e78] font-normal">/bln</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#192a42] text-purple-400 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#94a3b8] mb-0.5">Siklus Billing</p>
                                <p class="text-xs font-bold text-white capitalize" x-text="featuredGroup.billing_cycle"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#192a42] text-emerald-400 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#94a3b8] mb-0.5">Keamanan</p>
                                <p class="text-xs font-bold text-emerald-400">Terverifikasi</p>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom: Description & Avatars --}}
                    <div class="relative z-10 mt-6 flex flex-col md:flex-row md:items-end justify-between gap-6">
                        <div class="flex-1">
                            <p class="text-xs text-[#94a3b8] flex items-start gap-2 max-w-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Akun langganan publik. Kuota sangat terbatas, segera gabung sebelum penuh!
                            </p>
                            
                            {{-- Avatars --}}
                            <div class="flex items-center mt-4">
                                <div class="w-8 h-8 rounded-full bg-indigo-500 border-2 border-[#111c2e] text-white flex items-center justify-center text-xs font-bold shadow-md z-10 relative">
                                    <span x-text="featuredGroup.user.name.substring(0,1)"></span>
                                </div>
                                <template x-for="(share, i) in featuredGroup.shares.slice(0, 3)" :key="share.id">
                                    <div class="w-8 h-8 rounded-full bg-[#192a42] border-2 border-[#111c2e] text-white flex items-center justify-center text-xs font-bold shadow-md -ml-3" :class="`z-[${9-i}] relative`">
                                        <span x-text="share.friend_name.substring(0,1)"></span>
                                    </div>
                                </template>
                                <template x-if="featuredGroup.shares.length > 3">
                                    <div class="w-8 h-8 rounded-full bg-[#080d19] border-2 border-[#111c2e] text-[#94a3b8] flex items-center justify-center text-[10px] font-bold shadow-md -ml-3 z-0 relative">
                                        +<span x-text="featuredGroup.shares.length - 3"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Mobile button --}}
                        <div class="md:hidden w-full mt-4">
                            <a :href="featuredGroup.join_url" class="w-full text-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-cyan-500 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-indigo-500/25 block text-sm">
                                Minta Bergabung
                            </a>
                        </div>
                    </div>

                </div>
            </template>

            {{-- Other Groups (Grup Lainnya) --}}
            <template x-if="otherGroups.length > 0">
                <div class="mt-8 pt-4">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-bold text-[#f1f5f9]">Grup Lainnya</h3>
                            <p class="text-xs text-[#94a3b8] mt-0.5">Temukan lebih banyak grup patungan yang tersedia untukmu.</p>
                        </div>
                        <button class="w-8 h-8 rounded-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] flex items-center justify-center text-[#94a3b8] hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <template x-for="group in otherGroups" :key="group.id">
                            <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-5 hover:border-[rgba(255,255,255,0.15)] transition-all hover:scale-[1.02] flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="w-12 h-12 rounded-xl bg-[#080d19] border border-[rgba(255,255,255,0.03)] flex items-center justify-center p-2 shadow-sm">
                                            <template x-if="group.logo">
                                                <img :src="group.logo" class="w-full h-full object-contain">
                                            </template>
                                            <template x-if="!group.logo">
                                                <span x-html="group.category ? group.category.icon : ''" class="text-2xl" :style="`color: ${group.category ? group.category.color : '#fff'}`"></span>
                                            </template>
                                        </div>
                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Publik</span>
                                    </div>
                                    <h4 class="font-bold text-[#f1f5f9] text-base mb-1" x-text="group.name"></h4>
                                    <p class="text-[10px] text-[#94a3b8] mb-4" x-text="group.category ? group.category.name : 'Subscription'"></p>
                                    
                                    <div class="space-y-2 mb-6">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-[#4b5e78]">Anggota</span>
                                            <span class="font-bold text-[#f1f5f9]"><span x-text="group.shares.length + 1"></span> orang</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-[#4b5e78]">Estimasi</span>
                                            <span class="font-bold text-indigo-400">Rp<span x-text="formatMoney(Math.round(group.amount / (group.shares.length + 2)))"></span><span class="text-[9px] font-normal text-[#4b5e78]">/bln</span></span>
                                        </div>
                                    </div>
                                </div>
                                <a :href="group.join_url" class="w-full text-center px-4 py-2.5 bg-[#192a42] hover:bg-[#1e3350] text-white text-xs font-bold rounded-xl transition-colors border border-[rgba(255,255,255,0.06)]">
                                    Minta Bergabung
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        {{-- Right Sidebar --}}
        <div class="xl:col-span-1 space-y-6">
            
            {{-- Info Box 1 --}}
            <div class="bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-2xl p-6">
                <h3 class="font-bold text-[#f1f5f9] mb-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Kenapa Gabung Grup?
                </h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[#94a3b8] leading-tight">Hemat hingga 70% biaya langganan</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[#94a3b8] leading-tight">Akun tetap aman & terverifikasi</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[#94a3b8] leading-tight">Kelola anggota dengan mudah</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[#94a3b8] leading-tight">Pembayaran transparan</span>
                    </li>
                </ul>

                <hr class="border-[rgba(255,255,255,0.06)] my-6">

                <h3 class="font-bold text-[#f1f5f9] mb-5">Bagaimana Cara Gabung?</h3>
                <div class="relative">
                    {{-- Vertical dashed line --}}
                    <div class="absolute left-[11px] top-2 bottom-2 w-px border-l border-dashed border-[#192a42]"></div>
                    
                    <div class="space-y-5">
                        <div class="flex items-start gap-4 relative">
                            <div class="w-6 h-6 rounded-full bg-[#192a42] text-indigo-400 flex items-center justify-center text-[10px] font-bold flex-shrink-0 z-10 outline outline-4 outline-[#080d19]">1</div>
                            <div>
                                <p class="text-xs font-bold text-[#f1f5f9]">Kirim permintaan bergabung</p>
                                <p class="text-[10px] text-[#4b5e78] mt-1">Host akan menerima notifikasi.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 relative">
                            <div class="w-6 h-6 rounded-full bg-[#192a42] text-indigo-400 flex items-center justify-center text-[10px] font-bold flex-shrink-0 z-10 outline outline-4 outline-[#080d19]">2</div>
                            <div>
                                <p class="text-xs font-bold text-[#f1f5f9]">Tunggu persetujuan</p>
                                <p class="text-[10px] text-[#4b5e78] mt-1">Biasanya dalam hitungan menit.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 relative">
                            <div class="w-6 h-6 rounded-full bg-[#192a42] text-indigo-400 flex items-center justify-center text-[10px] font-bold flex-shrink-0 z-10 outline outline-4 outline-[#080d19]">3</div>
                            <div>
                                <p class="text-xs font-bold text-[#f1f5f9]">Bayar & nikmati layanan</p>
                                <p class="text-[10px] text-[#4b5e78] mt-1">Akses langsung setelah pembayaran.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA Box --}}
            <div class="bg-gradient-to-br from-[#1e1536] to-[#0f172a] border border-purple-500/20 rounded-2xl p-6 relative overflow-hidden shadow-[0_0_30px_rgba(168,85,247,0.05)]">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                
                <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="font-bold text-[#f1f5f9] mb-2">Buat grup sendiri dan ajak temanmu!</h3>
                <p class="text-[10px] text-[#94a3b8] mb-6">Kelola grupmu sendiri dan mulai hemat bareng.</p>
                
                <a href="{{ route('shares.index') }}" class="w-full block text-center px-4 py-3 bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold rounded-xl transition-colors shadow-lg shadow-purple-500/25">
                    Buat Grup Sekarang &rsaquo;
                </a>
            </div>

        </div>
    </div>
</div>

<script>
function discoverPage() {
    return {
        search: '',
        groups: @json($publicSubscriptions),
        
        get filteredGroups() {
            if (!this.search) return this.groups;
            const term = this.search.toLowerCase();
            return this.groups.filter(g => 
                g.name.toLowerCase().includes(term) || 
                (g.category && g.category.name.toLowerCase().includes(term)) ||
                g.user.name.toLowerCase().includes(term)
            );
        },
        
        get featuredGroup() {
            return this.filteredGroups.length > 0 ? this.filteredGroups[0] : null;
        },
        
        get otherGroups() {
            return this.filteredGroups.length > 1 ? this.filteredGroups.slice(1) : [];
        },
        
        formatMoney(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }
    }
}
</script>
@endsection
