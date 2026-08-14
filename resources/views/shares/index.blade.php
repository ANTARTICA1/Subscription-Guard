@extends('layouts.app')
@section('title', 'Split Bill')

@section('content')
<div x-data="splitBillWizard()" x-init="init()" class="space-y-8">
    
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-500/20 text-indigo-400 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#f1f5f9]">Buat Patungan Baru</h2>
                <p class="text-xs text-[#94a3b8] mt-0.5">Pilih subscription, tambahkan teman, dan bagikan tagihan dengan mudah</p>
            </div>
        </div>
    </div>

    {{-- Top Wizard Section --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        
        {{-- Left 3 Columns --}}
        <div class="xl:col-span-3 space-y-6">
            {{-- Stepper --}}
            <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl flex items-stretch overflow-hidden h-14">
                <div class="flex-1 flex items-center justify-center gap-3 text-sm font-semibold relative" :class="step >= 1 ? 'bg-[#192a42] text-white' : 'text-[#4b5e78]'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px]" :class="step >= 1 ? 'bg-indigo-500 text-white' : 'bg-[#080d19] text-[#4b5e78]'">1</span>
                    Pilih Subscription
                    {{-- Chevron Arrow --}}
                    <div class="absolute -right-3 top-0 bottom-0 w-6 z-10 hidden sm:block">
                        <svg class="h-full w-full text-[#111c2e]" preserveAspectRatio="none" viewBox="0 0 24 100" fill="currentColor"><polygon points="0,0 24,50 0,100" /></svg>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center gap-3 text-sm font-semibold relative" :class="step >= 2 ? 'bg-[#192a42] text-white' : 'text-[#4b5e78]'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px]" :class="step >= 2 ? 'bg-indigo-500 text-white' : 'bg-[#080d19] text-[#4b5e78]'">2</span>
                    Pilih Teman
                    {{-- Chevron Arrow --}}
                    <div class="absolute -right-3 top-0 bottom-0 w-6 z-10 hidden sm:block">
                        <svg class="h-full w-full text-[#111c2e]" preserveAspectRatio="none" viewBox="0 0 24 100" fill="currentColor"><polygon points="0,0 24,50 0,100" /></svg>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center gap-3 text-sm font-semibold" :class="step >= 3 ? 'bg-[#192a42] text-white' : 'text-[#4b5e78]'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px]" :class="step >= 3 ? 'bg-indigo-500 text-white' : 'bg-[#080d19] text-[#4b5e78]'">3</span>
                    Kirim Undangan
                </div>
            </div>

            {{-- 3 Columns Content --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-[460px]">
                
                {{-- Col 1: Pilih Subscription --}}
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-4 flex flex-col h-full overflow-hidden">
                    <h3 class="font-bold text-[#f1f5f9] mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        Pilih Subscription
                    </h3>
                    <div class="relative mb-4">
                        <input type="text" x-model="searchSub" placeholder="Cari subscription..." class="w-full bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-xl pl-9 pr-4 py-2.5 text-xs text-[#f1f5f9] focus:outline-none focus:border-indigo-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <div class="flex-1 overflow-y-auto min-h-0 space-y-2 pr-1 custom-scrollbar">
                        <template x-for="sub in filteredSubs" :key="sub.id">
                            <div @click="selectSub(sub.id)" class="p-3 rounded-xl border transition-colors cursor-pointer flex items-center gap-3 relative" :class="selectedSubId === sub.id ? 'bg-[#080d19] border-indigo-500' : 'bg-[#080d19] border-[rgba(255,255,255,0.03)] hover:border-[rgba(255,255,255,0.1)]'">
                                <div class="w-10 h-10 rounded-lg bg-[#111c2e] flex items-center justify-center flex-shrink-0 p-1.5" :style="!sub.logo ? `color: ${sub.category ? sub.category.color : '#fff'}; background: ${sub.category ? sub.category.color : '#fff'}15` : ''">
                                    <template x-if="sub.logo">
                                        <img :src="sub.logo" class="w-full h-full object-contain">
                                    </template>
                                    <template x-if="!sub.logo">
                                        <span x-html="sub.category ? sub.category.icon : ''"></span>
                                    </template>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-[#f1f5f9] truncate" x-text="sub.name"></p>
                                    <p class="text-[10px] text-[#94a3b8] truncate" x-text="sub.category ? sub.category.name : ''"></p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-[11px] font-semibold text-[#f1f5f9]">Rp<span x-text="formatMoney(sub.amount)"></span> <span class="text-[9px] text-[#4b5e78] font-normal" x-text="'/ ' + sub.billing_cycle"></span></p>
                                        <span class="text-[8px] px-1.5 py-0.5 rounded text-emerald-400 bg-emerald-500/10 font-bold">Aktif</span>
                                    </div>
                                </div>
                                <div x-show="selectedSubId === sub.id" class="absolute right-3 w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                        </template>
                        <template x-if="filteredSubs.length === 0">
                            <div class="text-center py-6 px-4">
                                <div class="w-12 h-12 rounded-full bg-[#192a42] flex items-center justify-center text-[#4b5e78] mx-auto mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <p class="text-xs font-bold text-[#f1f5f9] mb-1">Belum ada subscription</p>
                                <p class="text-[10px] text-[#4b5e78] mb-4 leading-relaxed">Anda harus menambahkan langganan baru terlebih dahulu sebelum bisa membagikan tagihannya.</p>
                                <a href="{{ route('subscriptions.create') }}" class="inline-block px-4 py-2 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-500 hover:text-white transition-colors rounded-lg text-xs font-bold">Tambah Sekarang</a>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Col 2: Pilih Teman --}}
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-4 flex flex-col h-full overflow-hidden" :class="step < 2 ? 'opacity-50 pointer-events-none' : ''">
                    <h3 class="font-bold text-[#f1f5f9] mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        Pilih Teman
                    </h3>
                    <div class="relative mb-4">
                        <input type="text" x-model="searchFriend" placeholder="Cari teman..." class="w-full bg-[#080d19] border border-[rgba(255,255,255,0.06)] rounded-xl pl-9 pr-4 py-2.5 text-xs text-[#f1f5f9] focus:outline-none focus:border-indigo-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78] absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <div class="flex-1 overflow-y-auto min-h-0 space-y-2 pr-1 custom-scrollbar">
                        <template x-for="friend in filteredFriends" :key="friend.id">
                            <div @click="toggleFriend(friend.id)" class="p-2.5 rounded-xl border border-transparent hover:bg-[#080d19] transition-colors cursor-pointer flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#192a42] flex items-center justify-center text-xs font-bold text-[#f1f5f9]">
                                        <span x-text="friend.name.substring(0,1)"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#f1f5f9] leading-tight" x-text="friend.name"></p>
                                        <p class="text-[10px] text-[#94a3b8]" x-text="'@' + friend.user_tag"></p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-md flex items-center justify-center text-white transition-colors" :class="selectedFriends.includes(friend.id) ? 'bg-indigo-500' : 'bg-[#192a42]'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="selectedFriends.includes(friend.id) ? 'rotate-45 transition-transform' : 'transition-transform'"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Col 3: Anggota Patungan --}}
                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-4 flex flex-col h-full overflow-hidden" :class="step < 2 ? 'opacity-50 pointer-events-none' : ''">
                    <h3 class="font-bold text-[#f1f5f9] mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Anggota Patungan <span class="bg-[#192a42] text-[#94a3b8] text-[9px] px-1.5 py-0.5 rounded-full" x-text="selectedFriends.length"></span>
                    </h3>
                    <div class="flex-1 overflow-y-auto min-h-0 space-y-2 pr-1 custom-scrollbar">
                        <template x-for="friend in selectedFriendsData" :key="friend.id">
                            <div class="p-2.5 rounded-xl bg-[#080d19] border border-[rgba(255,255,255,0.03)] flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold text-white shadow-md">
                                        <span x-text="friend.name.substring(0,1)"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#f1f5f9] leading-tight" x-text="friend.name"></p>
                                        <p class="text-[10px] text-[#94a3b8]" x-text="'@' + friend.user_tag"></p>
                                    </div>
                                </div>
                                <button @click="toggleFriend(friend.id)" class="w-6 h-6 rounded-md bg-[#111c2e] flex items-center justify-center text-[#4b5e78] hover:text-red-400 hover:bg-red-400/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </template>
                        
                        <div class="border border-dashed border-[rgba(255,255,255,0.1)] rounded-xl flex items-center justify-center p-4 text-[#4b5e78] hover:border-indigo-500/50 hover:text-indigo-400 transition-colors cursor-pointer mt-2" :class="selectedFriends.length > 0 ? 'mt-2' : ''">
                            <div class="flex flex-col items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                <span class="text-xs">Tambah anggota</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Right Sidebar: Ringkasan --}}
        <div class="xl:col-span-1">
            <div class="bg-[#0f172a] border border-emerald-500/50 rounded-2xl p-5 shadow-lg relative h-full flex flex-col">
                <h3 class="font-bold text-[#f1f5f9] mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Ringkasan Patungan
                </h3>

                <template x-if="selectedSub">
                    <div class="mb-6 flex items-center gap-3 border-b border-[rgba(255,255,255,0.06)] pb-4">
                        <div class="w-10 h-10 rounded-lg bg-[#080d19] flex items-center justify-center p-1.5">
                            <template x-if="selectedSub.logo">
                                <img :src="selectedSub.logo" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!selectedSub.logo">
                                <span x-html="selectedSub.category ? selectedSub.category.icon : ''" :style="`color: ${selectedSub.category ? selectedSub.category.color : '#fff'}`"></span>
                            </template>
                        </div>
                        <div>
                            <p class="font-bold text-[#f1f5f9] text-sm leading-tight" x-text="selectedSub.name"></p>
                            <p class="text-[10px] text-[#94a3b8]" x-text="selectedSub.category ? selectedSub.category.name : ''"></p>
                        </div>
                    </div>
                </template>

                <div class="space-y-4 mb-6 flex-1">
                    <div>
                        <p class="text-[10px] text-[#94a3b8] mb-1">Total Tagihan</p>
                        <p class="text-xl font-bold text-[#f1f5f9]">Rp<span x-text="formatMoney(totalAmount)"></span> <span class="text-[10px] text-[#4b5e78] font-normal" x-text="selectedSub ? '/ ' + selectedSub.billing_cycle : ''"></span></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-[#94a3b8] mb-1">Jumlah Anggota</p>
                        <p class="text-sm font-bold text-[#f1f5f9] flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4b5e78]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <span x-text="(selectedSub ? (selectedSub.shares ? selectedSub.shares.length : 0) : 0) + 1 + selectedFriends.length"></span> orang
                        </p>
                    </div>

                    <div class="pt-2">
                        <p class="text-[10px] text-[#94a3b8] mb-2 border-b border-[rgba(255,255,255,0.06)] pb-1">Pembagian Biaya</p>
                        
                        <div class="space-y-2 max-h-32 overflow-y-auto custom-scrollbar pr-1 text-xs font-semibold">
                            {{-- You --}}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-[#192a42] flex items-center justify-center text-[9px]">{{ substr(auth()->user()->name, 0, 1) }}</div>
                                    <span class="text-[#f1f5f9]">{{ auth()->user()->name }}</span>
                                </div>
                                <span class="text-emerald-400">Rp<span x-text="formatMoney(splitAmount)"></span></span>
                            </div>
                            
                            {{-- Existing Shares --}}
                            <template x-if="selectedSub && selectedSub.shares">
                                <template x-for="share in selectedSub.shares" :key="share.id">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-full bg-[#192a42] flex items-center justify-center text-[9px]" x-text="share.friend_name.substring(0,1)"></div>
                                            <span class="text-[#f1f5f9]" x-text="share.friend_name"></span>
                                        </div>
                                        <span class="text-emerald-400">Rp<span x-text="formatMoney(splitAmount)"></span></span>
                                    </div>
                                </template>
                            </template>

                            {{-- New Selected Friends --}}
                            <template x-for="friend in selectedFriendsData" :key="friend.id">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full bg-indigo-500 text-white flex items-center justify-center text-[9px]" x-text="friend.name.substring(0,1)"></div>
                                        <span class="text-[#f1f5f9]" x-text="friend.name"></span>
                                    </div>
                                    <span class="text-emerald-400">Rp<span x-text="formatMoney(splitAmount)"></span></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Saving Info Box --}}
                <div x-show="totalAmount > 0 && splitAmount < totalAmount" class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-3 mb-6 flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    <div>
                        <p class="text-xs text-[#f1f5f9] font-bold">Hemat Rp<span x-text="formatMoney(totalAmount - splitAmount)"></span>/bulan</p>
                        <p class="text-[9px] text-[#94a3b8] mt-0.5">Dibanding berlangganan sendiri</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('shares.store') }}">
                    @csrf
                    <input type="hidden" name="subscription_id" :value="selectedSubId">
                    <template x-for="fid in selectedFriends" :key="fid">
                        <input type="hidden" name="friend_user_ids[]" :value="fid">
                    </template>
                    <button type="submit" :disabled="selectedFriends.length === 0" class="w-full bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 rounded-xl transition-all shadow-[0_0_15px_rgba(79,70,229,0.3)] text-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        Kirim Undangan
                    </button>
                    <p class="text-[9px] text-center text-[#4b5e78] mt-3">Undangan akan dikirim via Telegram</p>
                </form>

            </div>
        </div>
    </div>


    {{-- Bottom Section (Tabs & Activities) --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 pt-4">
        {{-- Tabs Area --}}
        <div class="xl:col-span-3" x-data="{ activeTab: 'saya' }">
            <div class="flex items-center gap-6 border-b border-[#1f2937] mb-6">
                <button @click="activeTab = 'saya'" class="pb-3 text-sm font-semibold transition-colors relative" :class="activeTab === 'saya' ? 'text-[#f1f5f9]' : 'text-[#4b5e78] hover:text-[#f1f5f9]'">
                    Patungan Saya
                    <div x-show="activeTab === 'saya'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500 rounded-t-full"></div>
                </button>
                <button @click="activeTab = 'bergabung'" class="pb-3 text-sm font-semibold transition-colors relative" :class="activeTab === 'bergabung' ? 'text-[#f1f5f9]' : 'text-[#4b5e78] hover:text-[#f1f5f9]'">
                    Saya Bergabung
                    <div x-show="activeTab === 'bergabung'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500 rounded-t-full"></div>
                </button>
            </div>

            {{-- Tab 1: Patungan Saya --}}
            <div x-show="activeTab === 'saya'" x-transition.opacity>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($mySharedSubscriptions as $sub)
                        <div class="bg-[#121629] border border-[#1e293b] rounded-[24px] p-5 hover:border-[#334155] transition-colors flex flex-col min-h-[220px]">
                            
                            <!-- Header: Logo + Title -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex gap-4 items-center">
                                    <!-- Logo -->
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden" style="background-color: {{ $sub->category->color }}15;">
                                        @if($sub->logo)
                                            <img src="{{ $sub->logo }}" class="w-full h-full object-contain scale-110">
                                        @else
                                            <span style="color: {{ $sub->category->color }}; font-size: 20px;">{!! $sub->category->icon !!}</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Title -->
                                    <div class="flex flex-col">
                                        <h4 class="font-bold text-white text-[15px] leading-tight mb-1" style="max-width: 130px; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                                            {{ $sub->name }} Squad
                                        </h4>
                                        <p class="text-[11px] text-[#a855f7] flex items-center gap-1.5 font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                                            {{ $sub->shares->count() + 1 }} anggota
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <a href="{{ route('subscriptions.show', $sub) }}" class="text-[#4b5e78] hover:text-white transition-colors mt-0.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" /></svg>
                                </a>
                            </div>

                            <!-- Middle: Price Box -->
                            <div class="mb-4">
                                <p class="text-[18px] font-bold text-white tracking-tight">Rp{{ number_format($sub->amount / ($sub->shares->count() + 1), 0, ',', '.') }} <span class="text-[12px] text-[#4b5e78] font-normal tracking-normal">/ orang</span></p>
                            </div>

                            <!-- Bottom: Status & Avatars -->
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex -space-x-1.5 overflow-hidden">
                                    {{-- Owner Avatar --}}
                                    <div class="inline-flex items-center justify-center w-8 h-8 rounded-full ring-2 ring-[#121629] text-white text-[11px] font-bold uppercase" style="background-color: #6366f1;">
                                        {{ substr($sub->user->name ?? 'You', 0, 2) }}
                                    </div>
                                    
                                    {{-- Share Avatars --}}
                                    @foreach($sub->shares->take(2) as $share)
                                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full ring-2 ring-[#121629] text-white text-[11px] font-bold uppercase" style="background-color: #8b5cf6;">
                                            {{ substr($share->friendUser->name ?? $share->friend_name, 0, 2) }}
                                        </div>
                                    @endforeach
                                </div>
                                @if($sub->shares->count() > 2)
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#1e293b] ring-2 ring-[#121629] text-[11px] font-bold text-white">
                                        +{{ $sub->shares->count() - 2 }}
                                    </div>
                                @endif
                            </div>

                            {{-- Progress --}}
                            <div class="mt-auto">
                                <p class="text-[11px] font-bold {{ $sub->days_until_payment <= 3 ? 'text-[#f59e0b]' : 'text-[#10b981]' }} mb-2">Renew {{ $sub->days_until_payment }} hari lagi</p>
                                <div class="w-[85%] h-1.5 bg-[#1e293b] rounded-full overflow-hidden">
                                    @php
                                        $progressPercent = 100;
                                        if ($sub->days_until_payment > 0 && $sub->days_until_payment <= 30) {
                                            $progressPercent = 100 - (($sub->days_until_payment / 30) * 100);
                                            $progressPercent = max(5, $progressPercent);
                                        } elseif ($sub->days_until_payment > 30) {
                                            $progressPercent = 5;
                                        }
                                    @endphp
                                    <div class="h-full rounded-full transition-all duration-1000" style="background-color: {{ $sub->days_until_payment <= 3 ? '#f59e0b' : '#10b981' }}; width: {{ $progressPercent }}%;"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <a href="{{ route('subscriptions.create') }}" class="border border-dashed border-[#334155] rounded-[24px] flex flex-col items-center justify-center p-5 text-[#94a3b8] hover:bg-[#1e293b] hover:border-indigo-500 hover:text-indigo-400 transition-colors cursor-pointer min-h-[220px]">
                        <div class="w-12 h-12 rounded-full border border-indigo-500/30 flex items-center justify-center mb-4 bg-indigo-500/10 text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        <span class="text-sm font-semibold text-[#f1f5f9] mb-1">Tambah Langganan Baru</span>
                        <p class="text-[10px] text-[#4b5e78] text-center px-4">Kelola semua subscription dalam satu tempat.</p>
                    </a>
                </div>
            </div>

            {{-- Tab 2: Saya Bergabung --}}
            <div x-show="activeTab === 'bergabung'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($sharedWithMe as $share)
                        <div class="bg-[#0f172a] border border-[#1e293b] rounded-xl p-5 hover:border-[rgba(255,255,255,0.1)] transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-[#080d19] flex items-center justify-center p-1.5 border border-[#1e293b]">
                                    @if($share->subscription->logo)
                                        <img src="{{ $share->subscription->logo }}" class="w-full h-full object-contain">
                                    @else
                                        <span style="color: {{ $share->subscription->category->color }}">{!! $share->subscription->category->icon !!}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-[#f1f5f9] text-sm leading-tight flex items-center justify-between">
                                        {{ $share->subscription->name }}
                                        <span class="w-5 h-5 rounded-full bg-[#1e293b] text-[#94a3b8] text-[9px] flex items-center justify-center">{{ $share->subscription->shares->count() + 1 }}</span>
                                    </h4>
                                    <p class="text-[10px] text-[#94a3b8]">Ketua: {{ $share->owner->name }}</p>
                                </div>
                            </div>
                            <div class="mb-4 text-center border-b border-[#1e293b] pb-4">
                                <p class="text-xs font-bold text-[#f1f5f9]">{{ $share->formatted_split_amount }} <span class="text-[#4b5e78] font-normal">/ orang</span></p>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                @if($share->payment_status === 'paid')
                                    <span class="text-[9px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded">LUNAS</span>
                                @elseif($share->payment_proof_path)
                                    <span class="text-[9px] font-bold text-blue-400 bg-blue-500/10 px-2 py-1 rounded">PROSES</span>
                                @else
                                    <span class="text-[9px] font-bold text-red-400 bg-red-500/10 px-2 py-1 rounded">BELUM BAYAR</span>
                                @endif
                                
                                <button class="px-3 py-1.5 rounded-lg bg-[#1e293b] hover:bg-[#334155] text-[10px] font-bold text-[#f1f5f9] transition-colors">Detail</button>
                            </div>
                            {{-- Progress --}}
                            <div class="mt-2 w-full h-1 bg-[#1e293b] rounded-full overflow-hidden">
                                <div class="h-full {{ $share->subscription->days_until_payment <= 3 ? 'bg-amber-500' : 'bg-emerald-500' }}" style="width: {{ max(0, min(100, 100 - ($share->subscription->days_until_payment * 3.3))) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-[#4b5e78] py-8 text-center col-span-full">Anda belum bergabung di patungan apapun.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Aktivitas Terbaru (Right Sidebar Bottom) --}}
        <div class="xl:col-span-1">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-xl p-5">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-[#f1f5f9] text-sm">Aktivitas Terbaru</h3>
                </div>
                
                {{-- Dummy Activities for now to match UI perfectly --}}
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#f1f5f9] font-medium leading-tight">Undangan dikirim ke Budi</p>
                            <p class="text-[9px] text-[#4b5e78] mt-0.5">2 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-[#1e293b] text-[#94a3b8] flex items-center justify-center flex-shrink-0 mt-0.5 border border-[#334155]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#f1f5f9] font-medium leading-tight">Budi bergabung dalam patungan</p>
                            <p class="text-[9px] text-[#4b5e78] mt-0.5">5 menit yang lalu</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div>
                            <p class="text-[11px] text-[#f1f5f9] font-medium leading-tight">Pembayaran Geka dikonfirmasi</p>
                            <p class="text-[9px] text-[#4b5e78] mt-0.5">1 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.1); 
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.1); 
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.2); 
}
</style>

<script>
function splitBillWizard() {
    return {
        step: 1,
        subs: @json($mySubscriptions->filter(fn($s) => !$s->is_personal)->values()),
        friends: @json($friends),
        
        searchSub: '',
        searchFriend: '',
        
        selectedSubId: null,
        selectedFriends: [],
        
        init() {
            this.$watch('selectedSubId', value => {
                if(value && this.step === 1) this.step = 2;
                if(!value) this.step = 1;
                this.updateStep();
            });
            this.$watch('selectedFriends', value => {
                this.updateStep();
            }, { deep: true });
        },
        
        updateStep() {
            if (this.selectedSubId && this.selectedFriends.length > 0) {
                this.step = 3;
            } else if (this.selectedSubId) {
                this.step = 2;
            } else {
                this.step = 1;
            }
        },

        get filteredSubs() {
            if (!this.searchSub) return this.subs;
            return this.subs.filter(s => s.name.toLowerCase().includes(this.searchSub.toLowerCase()));
        },

        get filteredFriends() {
            if (!this.searchFriend) return this.friends;
            return this.friends.filter(f => f.name.toLowerCase().includes(this.searchFriend.toLowerCase()) || f.user_tag.toLowerCase().includes(this.searchFriend.toLowerCase()));
        },
        
        get selectedSub() {
            return this.subs.find(s => s.id == this.selectedSubId);
        },
        
        get selectedFriendsData() {
            return this.friends.filter(f => this.selectedFriends.includes(f.id));
        },
        
        get totalAmount() {
            return this.selectedSub ? Number(this.selectedSub.amount) : 0;
        },
        
        get splitAmount() {
            if (!this.selectedSub) return 0;
            let existingShares = this.selectedSub.shares ? this.selectedSub.shares.length : 0;
            let totalPeople = 1 + existingShares + this.selectedFriends.length;
            return Math.round(this.totalAmount / totalPeople);
        },
        
        selectSub(id) {
            if (this.selectedSubId === id) {
                this.selectedSubId = null;
            } else {
                this.selectedSubId = id;
            }
        },

        toggleFriend(id) {
            if (this.selectedFriends.includes(id)) {
                this.selectedFriends = this.selectedFriends.filter(fid => fid !== id);
            } else {
                this.selectedFriends.push(id);
            }
        },

        formatMoney(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }
    }
}
</script>
@endsection
