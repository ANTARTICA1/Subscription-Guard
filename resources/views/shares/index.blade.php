@extends('layouts.app')
@section('title', 'Split Bill')

@section('content')
<div x-data="splitBillApp()" x-init="init()" class="space-y-8 pb-12">
    
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-2xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[#f1f5f9]">Split Bill & Patungan</h2>
                <p class="text-xs text-[#94a3b8] mt-0.5">Kelola grup patungan, verifikasi pembayaran, dan bagi tagihan dengan rapi</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <div class="xl:col-span-3 space-y-6">
            <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl flex items-stretch overflow-hidden h-14">
                <div class="flex-1 flex items-center justify-center gap-3 text-sm font-semibold relative" :class="step >= 1 ? 'bg-[#192a42] text-white' : 'text-[#4b5e78]'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px]" :class="step >= 1 ? 'bg-indigo-500 text-white' : 'bg-[#080d19] text-[#4b5e78]'">1</span>
                    Pilih Subscription
                    <div class="absolute -right-3 top-0 bottom-0 w-6 z-10 hidden sm:block">
                        <svg class="h-full w-full text-[#111c2e]" preserveAspectRatio="none" viewBox="0 0 24 100" fill="currentColor"><polygon points="0,0 24,50 0,100" /></svg>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center gap-3 text-sm font-semibold relative" :class="step >= 2 ? 'bg-[#192a42] text-white' : 'text-[#4b5e78]'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px]" :class="step >= 2 ? 'bg-indigo-500 text-white' : 'bg-[#080d19] text-[#4b5e78]'">2</span>
                    Pilih Teman
                    <div class="absolute -right-3 top-0 bottom-0 w-6 z-10 hidden sm:block">
                        <svg class="h-full w-full text-[#111c2e]" preserveAspectRatio="none" viewBox="0 0 24 100" fill="currentColor"><polygon points="0,0 24,50 0,100" /></svg>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center gap-3 text-sm font-semibold" :class="step >= 3 ? 'bg-[#192a42] text-white' : 'text-[#4b5e78]'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px]" :class="step >= 3 ? 'bg-indigo-500 text-white' : 'bg-[#080d19] text-[#4b5e78]'">3</span>
                    Kirim Undangan
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-[460px]">
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
                                <p class="text-[10px] text-[#4b5e78] mb-4 leading-relaxed">Tambahkan langganan terlebih dahulu sebelum membagikan tagihan.</p>
                                <a href="{{ route('subscriptions.create') }}" class="inline-block px-4 py-2 bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-500 hover:text-white transition-colors rounded-lg text-xs font-bold">Tambah Sekarang</a>
                            </div>
                        </template>
                    </div>
                </div>

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

                <div class="bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-2xl p-4 flex flex-col h-full overflow-hidden" :class="step < 2 ? 'opacity-50 pointer-events-none' : ''">
                    <h3 class="font-bold text-[#f1f5f9] mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                        Anggota Terpilih <span class="bg-[#192a42] text-[#94a3b8] text-[9px] px-1.5 py-0.5 rounded-full" x-text="selectedFriends.length"></span>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl p-5 shadow-lg relative h-full flex flex-col">
                <h3 class="font-bold text-[#f1f5f9] mb-6 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
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
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-[#192a42] flex items-center justify-center text-[9px]">{{ substr(auth()->user()->name, 0, 1) }}</div>
                                    <span class="text-[#f1f5f9]">{{ auth()->user()->name }}</span>
                                </div>
                                <span class="text-emerald-400">Rp<span x-text="formatMoney(splitAmount)"></span></span>
                            </div>
                            
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

                <div x-show="totalAmount > 0 && splitAmount < totalAmount" class="bg-indigo-500/10 border border-indigo-500/20 rounded-xl p-3 mb-6 flex gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
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

                    <div class="mb-5 bg-[#080d19] border border-[rgba(255,255,255,0.04)] rounded-xl p-3 flex items-start gap-3">
                        <div class="pt-0.5">
                            <input type="checkbox" name="is_public" value="1" id="is_public" class="w-4 h-4 rounded border-[#334155] bg-[#111c2e] text-indigo-500 focus:ring-indigo-500 focus:ring-offset-[#0f172a]" checked>
                        </div>
                        <div class="flex-1">
                            <label for="is_public" class="text-xs font-bold text-white cursor-pointer block mb-0.5">Tampilkan di Cari Teman Patungan</label>
                            <p class="text-[9px] text-[#94a3b8] leading-tight">Pengguna lain dapat menemukan grup ini di menu Discover.</p>
                        </div>
                    </div>

                    <button type="submit" :disabled="selectedFriends.length === 0" class="w-full bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 rounded-xl transition-all text-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        Kirim Undangan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 pt-4">
        <div class="xl:col-span-3" x-data="{ activeTab: 'saya' }">
            <div class="flex items-center gap-6 border-b border-[#1f2937] mb-6">
                <button @click="activeTab = 'saya'" class="pb-3 text-sm font-semibold transition-colors relative" :class="activeTab === 'saya' ? 'text-[#f1f5f9]' : 'text-[#4b5e78] hover:text-[#f1f5f9]'">
                    Patungan Saya ({{ $mySharedSubscriptions->count() }})
                    <div x-show="activeTab === 'saya'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500 rounded-t-full"></div>
                </button>
                <button @click="activeTab = 'bergabung'" class="pb-3 text-sm font-semibold transition-colors relative" :class="activeTab === 'bergabung' ? 'text-[#f1f5f9]' : 'text-[#4b5e78] hover:text-[#f1f5f9]'">
                    Saya Bergabung ({{ $sharedWithMe->count() }})
                    <div x-show="activeTab === 'bergabung'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-indigo-500 rounded-t-full"></div>
                </button>
            </div>

            <div x-show="activeTab === 'saya'" x-transition.opacity>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($mySharedSubscriptions as $sub)
                        @php
                            $paidCount = $sub->shares->where('payment_status', 'paid')->count();
                            $totalMembers = $sub->shares->count();
                            $allPaid = $totalMembers > 0 && $paidCount === $totalMembers;
                        @endphp
                        <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl p-5 hover:border-[#334155] transition-colors flex flex-col justify-between relative">
                            @if($sub->pending_proofs_count > 0)
                                <div class="absolute -top-2 right-4 bg-amber-500 text-black text-[10px] font-bold px-2 py-0.5 rounded z-10">
                                    {{ $sub->pending_proofs_count }} bukti menunggu
                                </div>
                            @endif

                            <div>
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 rounded-xl bg-[#0b1120] border border-[#1e293b] flex items-center justify-center flex-shrink-0 p-2 overflow-hidden">
                                        @if($sub->logo)
                                            <img src="{{ $sub->logo }}" class="w-full h-full object-contain">
                                        @else
                                            <span style="color: {{ $sub->category->color ?? '#6366f1' }}; font-size: 18px;">{!! $sub->category->icon ?? '' !!}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-white text-[15px] leading-tight truncate" title="{{ $sub->name }}">{{ $sub->name }}</h4>
                                        <p class="text-[11px] text-[#64748b] mt-0.5">{{ $sub->shares->count() + 1 }} anggota<span class="mx-1.5 text-[#334155]">/</span><span class="text-[10px] {{ $sub->is_public ? 'text-emerald-500' : 'text-[#64748b]' }}">{{ $sub->is_public ? 'Publik' : 'Privat' }}</span></p>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <p class="text-[10px] uppercase tracking-wider text-[#475569] font-semibold mb-1">Porsi kamu</p>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-2xl font-extrabold text-white tracking-tight">Rp{{ number_format($sub->amount / ($sub->shares->count() + 1), 0, ',', '.') }}</span>
                                        <span class="text-[11px] text-[#475569]">/ Rp{{ number_format($sub->amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="border-t border-[#1e293b] pt-4 mb-4 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#64748b]">Pembayaran</span>
                                        <span class="text-[11px] font-semibold {{ $allPaid ? 'text-emerald-400' : 'text-[#94a3b8]' }}">{{ $paidCount }}/{{ $totalMembers }} lunas</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#64748b]">Jatuh tempo</span>
                                        <span class="text-[11px] font-medium {{ $sub->days_until_payment <= 3 ? 'text-amber-400' : 'text-white' }}">{{ $sub->days_until_payment }} hari lagi <span class="text-[#475569] font-normal">({{ $sub->next_payment_date->translatedFormat('d M') }})</span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 pt-3 border-t border-[#1e293b]">
                                <button @click="openSquadModal({{ json_encode($sub) }})" class="flex-1 text-xs text-indigo-400 hover:text-indigo-300 font-semibold py-2 transition-colors text-left flex items-center gap-1.5">
                                    Kelola anggota
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </button>
                                <button @click="copyText('{{ route('shares.join', $sub->invite_code) }}', 'Link undangan berhasil disalin!')" title="Salin link" class="text-[#475569] hover:text-white p-1.5 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center bg-[#0b121f] border border-[#1e293b] rounded-2xl p-8">
                            <h4 class="text-sm font-bold text-white mb-1">Belum Ada Grup Patungan Aktif</h4>
                            <p class="text-xs text-[#64748b] max-w-sm mx-auto">Pilih langganan di formulir atas dan tambahkan teman untuk mulai membagi tagihan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div x-show="activeTab === 'bergabung'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($sharedWithMe as $share)
                        <div class="bg-[#0f172a] border border-[#1e293b] rounded-2xl p-5 hover:border-[#334155] transition-colors flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-10 h-10 rounded-xl bg-[#0b1120] border border-[#1e293b] flex items-center justify-center flex-shrink-0 p-2 overflow-hidden">
                                        @if($share->subscription->logo)
                                            <img src="{{ $share->subscription->logo }}" class="w-full h-full object-contain">
                                        @else
                                            <span style="color: {{ $share->subscription->category->color ?? '#6366f1' }}; font-size: 18px;">{!! $share->subscription->category->icon ?? '' !!}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-white text-[15px] leading-tight truncate" title="{{ $share->subscription->name }}">{{ $share->subscription->name }}</h4>
                                        <p class="text-[11px] text-[#64748b] mt-0.5 truncate">Ketua: {{ $share->owner->name }}</p>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <p class="text-[10px] uppercase tracking-wider text-[#475569] font-semibold mb-1">Tagihan kamu</p>
                                    <span class="text-2xl font-extrabold text-white tracking-tight">{{ $share->formatted_split_amount }}</span>
                                </div>

                                <div class="border-t border-[#1e293b] pt-4 mb-4 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#64748b]">Status</span>
                                        @if($share->payment_status === 'paid')
                                            <span class="text-[11px] font-semibold text-emerald-400">Lunas</span>
                                        @elseif($share->payment_proof_path)
                                            <span class="text-[11px] font-semibold text-blue-400">Menunggu verifikasi</span>
                                        @elseif($share->rejection_reason)
                                            <span class="text-[11px] font-semibold text-red-400">Ditolak</span>
                                        @else
                                            <span class="text-[11px] font-semibold text-amber-400">Belum bayar</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#64748b]">Jatuh tempo</span>
                                        <span class="text-[11px] font-medium text-white">{{ $share->due_date ? $share->due_date->translatedFormat('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-[#64748b]">Anggota</span>
                                        <span class="text-[11px] font-medium text-[#94a3b8]">{{ $share->subscription->shares->count() + 1 }} orang</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-[#1e293b]">
                                <button @click="openMemberPaymentModal({{ json_encode($share) }})" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold py-2 transition-colors flex items-center gap-1.5">
                                    Detail & pembayaran
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center bg-[#0b121f] border border-[#1e293b] rounded-2xl p-8">
                            <h4 class="text-sm font-bold text-white mb-1">Belum Bergabung Patungan Apapun</h4>
                            <p class="text-xs text-[#64748b] max-w-sm mx-auto mb-4">Temukan grup patungan terbuka untuk menghemat pengeluaran langganan.</p>
                            <a href="{{ route('discover.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">Cari Grup Patungan</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="bg-[#0f172a] border border-[#1e293b] rounded-3xl p-5 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-[#f1f5f9] text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Aktivitas Terbaru
                    </h3>
                </div>
                
                <div class="space-y-4">
                    @forelse($activities as $act)
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 {{ $act['type'] === 'paid' ? 'bg-emerald-500/20 text-emerald-400' : ($act['type'] === 'proof' ? 'bg-blue-500/20 text-blue-400' : ($act['type'] === 'rejected' ? 'bg-red-500/20 text-red-400' : 'bg-indigo-500/20 text-indigo-400')) }}">
                                @if($act['type'] === 'paid')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                @elseif($act['type'] === 'proof')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                @elseif($act['type'] === 'rejected')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] text-[#f1f5f9] font-medium leading-tight">{{ $act['title'] }}</p>
                                <p class="text-[10px] text-[#94a3b8] mt-0.5 truncate">{{ $act['desc'] }} • {{ $act['time'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] text-[#4b5e78] py-4 text-center">Belum ada aktivitas patungan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div x-show="squadModalOpen" class="fixed flex items-center justify-center p-4" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 9999; background: rgba(0,0,0,0.8); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center;" x-cloak x-transition>
        <div @click.away="squadModalOpen = false" class="bg-[#0f172a] border border-[#1e293b] rounded-2xl shadow-2xl overflow-hidden flex flex-col" style="width: 100%; max-width: 520px; max-height: 90vh; margin: auto;">
            <div class="px-6 py-5 border-b border-[#1e293b] flex items-center justify-between">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-[#0b1120] border border-[#1e293b] flex items-center justify-center p-2 flex-shrink-0">
                        <template x-if="activeSquad && activeSquad.logo">
                            <img :src="activeSquad.logo" class="w-full h-full object-contain">
                        </template>
                        <template x-if="!activeSquad || !activeSquad.logo">
                            <span x-html="activeSquad && activeSquad.category ? activeSquad.category.icon : ''" :style="`color: ${activeSquad && activeSquad.category ? activeSquad.category.color : '#6366f1'}`"></span>
                        </template>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-white text-base leading-tight truncate" x-text="activeSquad ? activeSquad.name : ''"></h3>
                        <p class="text-xs text-[#64748b] mt-0.5" x-text="activeSquad ? ((activeSquad.shares ? activeSquad.shares.length : 0) + 1) + ' Anggota Patungan' : ''"></p>
                    </div>
                </div>
                <button @click="squadModalOpen = false" class="text-[#64748b] hover:text-white p-1.5 rounded-lg hover:bg-white/5 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-4 custom-scrollbar flex-1">
                <template x-if="activeSquad">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between pb-4 border-b border-[#1e293b]">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block mb-1">Porsi Per Orang</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-extrabold text-white">Rp<span x-text="formatMoney(Math.round(activeSquad.amount / ((activeSquad.shares ? activeSquad.shares.length : 0) + 1)))"></span></span>
                                    <span class="text-xs text-[#64748b]">/ total Rp<span x-text="formatMoney(activeSquad.amount)"></span></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block mb-1">Jatuh Tempo</span>
                                <span class="text-xs font-semibold" :class="activeSquad.days_until_payment <= 3 ? 'text-amber-400 font-bold' : 'text-slate-200'" x-text="activeSquad.days_until_payment !== undefined ? activeSquad.days_until_payment + ' hari lagi' : '-'"></span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3 text-xs pb-4 border-b border-[#1e293b]">
                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                <span class="text-[11px] text-[#64748b] font-medium flex-shrink-0">Tautan:</span>
                                <span class="font-mono text-[11px] text-[#94a3b8] truncate" x-text="getInviteUrl(activeSquad.invite_code)"></span>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button @click="copyText(getInviteUrl(activeSquad.invite_code), 'Link undangan berhasil disalin!')" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors">
                                    Salin Link
                                </button>
                                <span class="text-[#334155]">|</span>
                                <form :action="'/shares/' + activeSquad.id + '/toggle-public'" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold transition-colors" :class="activeSquad.is_public ? 'text-emerald-400 hover:text-emerald-300' : 'text-[#94a3b8] hover:text-white'">
                                        <span x-text="activeSquad.is_public ? 'Publik' : 'Privat'"></span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="pb-4 border-b border-[#1e293b]">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b]">Rekening Pembayaran (Host)</span>
                                <button @click="editPaymentInfo = !editPaymentInfo" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">
                                    <span x-text="editPaymentInfo ? 'Tutup' : 'Ubah Rekening'"></span>
                                </button>
                            </div>
                            <div x-show="!editPaymentInfo" class="text-xs text-[#94a3b8]">
                                @if(auth()->user()->bank_name)
                                    <span class="font-bold text-white">{{ auth()->user()->bank_name }}</span>
                                    <span class="font-mono text-slate-300 mx-1.5">{{ auth()->user()->account_number }}</span>
                                    <span>a.n {{ auth()->user()->account_holder ?? auth()->user()->name }}</span>
                                @else
                                    <span class="text-amber-400 font-medium">Belum diatur. Tambahkan rekening agar anggota dapat mentransfer.</span>
                                @endif
                            </div>
                            <div x-show="editPaymentInfo" x-cloak class="pt-2">
                                <form action="{{ route('shares.payment-info') }}" method="POST" class="space-y-2">
                                    @csrf
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <input type="text" name="bank_name" value="{{ auth()->user()->bank_name }}" placeholder="Bank / E-Wallet" class="bg-[#0b1120] border border-[#1e293b] rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-indigo-500" required>
                                        <input type="text" name="account_number" value="{{ auth()->user()->account_number }}" placeholder="Nomor Rekening" class="bg-[#0b1120] border border-[#1e293b] rounded-lg px-3 py-2 text-xs text-white font-mono focus:outline-none focus:border-indigo-500" required>
                                        <input type="text" name="account_holder" value="{{ auth()->user()->account_holder ?? auth()->user()->name }}" placeholder="Atas Nama" class="bg-[#0b1120] border border-[#1e293b] rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-indigo-500" required>
                                    </div>
                                    <button type="submit" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-semibold transition-colors">Simpan Rekening</button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b]">Daftar Anggota (<span x-text="(activeSquad.shares ? activeSquad.shares.length : 0) + 1"></span>)</span>
                                <form :action="'/shares/' + activeSquad.id + '/reset-cycle'" method="POST" onsubmit="return confirm('Mulai periode siklus tagihan baru? Status pembayaran semua anggota akan di-reset menjadi pending.')">
                                    @csrf
                                    <button type="submit" class="text-xs text-amber-400 hover:text-amber-300 font-semibold flex items-center gap-1.5 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        Mulai Siklus Baru
                                    </button>
                                </form>
                            </div>

                            <div class="divide-y divide-[#1e293b] border-t border-b border-[#1e293b]">
                                <div class="py-3 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-[#0b1120] text-indigo-400 border border-[#1e293b] flex items-center justify-center text-xs font-bold">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-white leading-tight">{{ auth()->user()->name }} (Anda)</p>
                                            <span class="text-[10px] text-[#64748b]">Host / Pemilik Langganan</span>
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold text-emerald-400">Sudah Bayar</span>
                                </div>

                                <template x-for="share in activeSquad.shares" :key="share.id">
                                    <div class="py-3 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                                <div class="w-8 h-8 rounded-lg bg-[#0b1120] text-[#94a3b8] border border-[#1e293b] flex items-center justify-center text-xs font-bold flex-shrink-0">
                                                    <span x-text="((share.friend_user ? share.friend_user.name : share.friend_name) || 'U').substring(0, 2).toUpperCase()"></span>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-white leading-tight truncate" x-text="share.friend_user ? share.friend_user.name : share.friend_name"></p>
                                                    <p class="text-[11px] text-[#64748b]">Tagihan: <strong class="text-slate-300 font-semibold">Rp<span x-text="formatMoney(share.split_amount)"></span></strong></p>
                                                </div>
                                            </div>
                                            <div>
                                                <template x-if="share.payment_status === 'paid'">
                                                    <span class="text-xs font-semibold text-emerald-400">Sudah Bayar</span>
                                                </template>
                                                <template x-if="share.payment_status !== 'paid' && share.payment_proof_path">
                                                    <span class="text-xs font-semibold text-blue-400">Verifikasi Bukti</span>
                                                </template>
                                                <template x-if="share.payment_status !== 'paid' && !share.payment_proof_path">
                                                    <span class="text-xs font-semibold text-red-400">Belum Bayar</span>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between gap-2 pt-1">
                                            <div class="flex items-center gap-2">
                                                <template x-if="share.payment_proof_path">
                                                    <button @click="openProofLightbox('/storage/' + share.payment_proof_path)" class="text-xs text-blue-400 hover:text-blue-300 font-semibold transition-colors flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                        Lihat Bukti
                                                    </button>
                                                </template>
                                                <template x-if="share.payment_proof_path && share.payment_status !== 'paid'">
                                                    <span class="text-[#334155]">|</span>
                                                </template>
                                                <template x-if="share.payment_status !== 'paid'">
                                                    <form :action="'/shares/' + share.id + '/mark-paid'" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-xs text-emerald-400 hover:text-emerald-300 font-semibold transition-colors flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                            Tandai Lunas
                                                        </button>
                                                    </form>
                                                </template>
                                                <template x-if="share.payment_proof_path && share.payment_status !== 'paid'">
                                                    <span class="text-[#334155]">|</span>
                                                </template>
                                                <template x-if="share.payment_proof_path && share.payment_status !== 'paid'">
                                                    <button @click="openRejectModal(share.id)" class="text-xs text-red-400 hover:text-red-300 font-semibold transition-colors">
                                                        Tolak Bukti
                                                    </button>
                                                </template>
                                            </div>

                                            <div class="flex items-center gap-1.5">
                                                <a :href="getWhatsappUrl(share, activeSquad)" target="_blank" class="w-7 h-7 rounded-full inline-flex items-center justify-center bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition-colors" title="Tagih via WhatsApp">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                </a>
                                                <form :action="'/shares/' + share.id + '/send-reminder'" method="POST" class="inline-flex items-center m-0 p-0">
                                                    @csrf
                                                    <button type="submit" class="w-7 h-7 rounded-full inline-flex items-center justify-center bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition-colors" title="Pengingat Telegram">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .24z"/></svg>
                                                    </button>
                                                </form>
                                                <form :action="'/shares/' + share.id" method="POST" onsubmit="return confirm('Keluarkan anggota ini dari grup patungan?')" class="inline-flex items-center m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-7 h-7 rounded-full inline-flex items-center justify-center bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-colors" title="Keluarkan Anggota">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div x-show="memberModalOpen" class="fixed flex items-center justify-center p-4" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 9999; background: rgba(0,0,0,0.8); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center;" x-cloak x-transition>
        <div @click.away="memberModalOpen = false" class="bg-[#0f172a] border border-[#1e293b] rounded-2xl shadow-2xl overflow-hidden flex flex-col" style="width: 100%; max-width: 480px; max-height: 90vh; margin: auto;">
            <div class="px-6 py-5 border-b border-[#1e293b] flex items-center justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-[#0b1120] border border-[#1e293b] flex items-center justify-center p-2 flex-shrink-0">
                        <template x-if="activeMemberShare && activeMemberShare.subscription && activeMemberShare.subscription.logo">
                            <img :src="activeMemberShare.subscription.logo" class="w-full h-full object-contain">
                        </template>
                        <template x-if="!activeMemberShare || !activeMemberShare.subscription || !activeMemberShare.subscription.logo">
                            <span x-html="activeMemberShare && activeMemberShare.subscription && activeMemberShare.subscription.category ? activeMemberShare.subscription.category.icon : ''" :style="`color: ${activeMemberShare && activeMemberShare.subscription && activeMemberShare.subscription.category ? activeMemberShare.subscription.category.color : '#6366f1'}`"></span>
                        </template>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-white text-base leading-tight truncate" x-text="activeMemberShare && activeMemberShare.subscription ? activeMemberShare.subscription.name : 'Detail Tagihan'"></h3>
                        <p class="text-xs text-[#64748b] mt-0.5 truncate" x-text="'Host: ' + (activeMemberShare && activeMemberShare.owner ? activeMemberShare.owner.name : '')"></p>
                    </div>
                </div>
                <button @click="memberModalOpen = false" class="text-[#64748b] hover:text-white p-1.5 rounded-lg hover:bg-white/5 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-4 custom-scrollbar flex-1">
                <template x-if="activeMemberShare">
                    <div class="space-y-4">
                        <div class="flex items-start justify-between pb-4 border-b border-[#1e293b]">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block mb-1">Tagihan Anda</span>
                                <span class="text-2xl font-extrabold text-white">Rp<span x-text="formatMoney(activeMemberShare.split_amount)"></span></span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block mb-1">Status</span>
                                <template x-if="activeMemberShare.payment_status === 'paid'">
                                    <span class="text-xs font-semibold text-emerald-400">Lunas</span>
                                </template>
                                <template x-if="activeMemberShare.payment_status !== 'paid' && activeMemberShare.payment_proof_path">
                                    <span class="text-xs font-semibold text-blue-400">Verifikasi Host</span>
                                </template>
                                <template x-if="activeMemberShare.payment_status !== 'paid' && !activeMemberShare.payment_proof_path">
                                    <span class="text-xs font-semibold text-amber-400">Belum Bayar</span>
                                </template>
                            </div>
                        </div>

                        <template x-if="activeMemberShare.rejection_reason">
                            <div class="p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-xs space-y-1">
                                <p class="font-bold text-red-400">Bukti Pembayaran Ditolak</p>
                                <p class="text-[#94a3b8]" x-text="activeMemberShare.rejection_reason"></p>
                            </div>
                        </template>

                        <div class="pb-4 border-b border-[#1e293b] space-y-1.5">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block">Rekening Pembayaran Host</span>
                            <div class="text-xs space-y-1 text-[#94a3b8]">
                                <div class="flex items-center justify-between">
                                    <span>Bank / E-Wallet</span>
                                    <span class="font-semibold text-white" x-text="activeMemberShare.owner && activeMemberShare.owner.bank_name ? activeMemberShare.owner.bank_name : '-'"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Nomor Rekening</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-semibold text-white" x-text="activeMemberShare.owner && activeMemberShare.owner.account_number ? activeMemberShare.owner.account_number : '-'"></span>
                                        <template x-if="activeMemberShare.owner && activeMemberShare.owner.account_number">
                                            <button @click="copyText(activeMemberShare.owner.account_number, 'Nomor rekening berhasil disalin!')" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">Salin</button>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Atas Nama</span>
                                    <span class="font-semibold text-white" x-text="activeMemberShare.owner && activeMemberShare.owner.account_holder ? activeMemberShare.owner.account_holder : (activeMemberShare.owner ? activeMemberShare.owner.name : '')"></span>
                                </div>
                            </div>
                        </div>

                        <template x-if="activeMemberShare.payment_status === 'paid'">
                            <div class="py-2 text-center text-xs text-emerald-400 font-semibold">
                                Pembayaran Anda telah dikonfirmasi lunas oleh host.
                            </div>
                        </template>

                        <template x-if="activeMemberShare.payment_status !== 'paid'">
                            <div class="space-y-3 pt-1">
                                <template x-if="activeMemberShare.payment_proof_path">
                                    <div class="space-y-1.5">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block">Bukti Yang Dikirim</span>
                                        <div class="relative rounded-xl overflow-hidden border border-[#1e293b] bg-black/40 max-h-36 flex items-center justify-center">
                                            <img :src="'/storage/' + activeMemberShare.payment_proof_path" class="max-h-36 object-contain">
                                            <button @click="openProofLightbox('/storage/' + activeMemberShare.payment_proof_path)" class="absolute bottom-2 right-2 px-2.5 py-1 bg-black/70 hover:bg-black text-white rounded text-[11px] font-semibold transition-colors">
                                                Perbesar
                                            </button>
                                        </div>
                                    </div>
                                </template>

                                <form :action="'/shares/' + activeMemberShare.id + '/upload-proof'" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#64748b] block" x-text="activeMemberShare.payment_proof_path ? 'Unggah Ulang Bukti Transfer' : 'Unggah Bukti Transfer'"></span>
                                    <input type="file" name="proof" required accept="image/*" class="block w-full text-xs text-[#94a3b8] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#1e293b] file:text-white hover:file:bg-slate-700 bg-[#0b1120] border border-[#1e293b] rounded-xl cursor-pointer">
                                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl text-xs transition-colors">
                                        Kirim Bukti Pembayaran
                                    </button>
                                </form>
                            </div>
                        </template>

                        <div class="pt-1">
                            <form :action="'/shares/' + activeMemberShare.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari grup patungan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-1 text-center text-xs text-[#64748b] hover:text-red-400 transition-colors">
                                    Keluar dari Grup Patungan
                                </button>
                            </form>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div x-show="rejectModalOpen" class="fixed flex items-center justify-center p-4" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 9999; background: rgba(0,0,0,0.85); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center;" x-cloak x-transition>
        <div @click.away="rejectModalOpen = false" class="bg-[#0f172a] border border-[#1e293b] rounded-2xl shadow-2xl p-5" style="width: 100%; max-width: 400px; margin: auto;">
            <h3 class="font-bold text-white text-sm mb-1">Tolak Bukti Transfer</h3>
            <p class="text-xs text-[#64748b] mb-4">Berikan alasan penolakan untuk anggota.</p>

            <form :action="'/shares/' + rejectShareId + '/reject-proof'" method="POST" class="space-y-4">
                @csrf
                <div>
                    <textarea name="rejection_reason" rows="3" placeholder="Alasan (contoh: nominal kurang, bukti buram)" class="w-full bg-[#0b1120] border border-[#1e293b] rounded-xl p-3 text-xs text-white focus:outline-none focus:border-indigo-500" required></textarea>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" @click="rejectModalOpen = false" class="px-3 py-1.5 text-xs text-[#64748b] hover:text-white font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-3.5 py-1.5 bg-red-600 hover:bg-red-500 text-white rounded-lg text-xs font-semibold transition-colors">Tolak Bukti</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="lightboxOpen" class="fixed flex items-center justify-center p-4" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; z-index: 9999; background: rgba(0,0,0,0.9); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center;" x-cloak x-transition>
        <div @click.away="lightboxOpen = false" class="relative flex flex-col items-center" style="max-width: 800px; max-height: 90vh; margin: auto;">
            <button @click="lightboxOpen = false" class="absolute -top-10 right-0 text-white hover:text-slate-300 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <img :src="lightboxSrc" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain border border-[rgba(255,255,255,0.1)]">
        </div>
    </div>

    <div x-show="toastShow" class="fixed bottom-6 right-6 z-[130] bg-indigo-600 text-white text-xs font-bold px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-2" x-cloak x-transition>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span x-text="toastMessage"></span>
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
function splitBillApp() {
    return {
        step: 1,
        subs: @json($mySubscriptions->filter(fn($s) => !$s->is_personal)->values()),
        friends: @json($friends),
        
        searchSub: '',
        searchFriend: '',
        
        selectedSubId: null,
        selectedFriends: [],

        squadModalOpen: false,
        activeSquad: null,
        editPaymentInfo: false,

        memberModalOpen: false,
        activeMemberShare: null,

        rejectModalOpen: false,
        rejectShareId: null,

        lightboxOpen: false,
        lightboxSrc: '',

        toastShow: false,
        toastMessage: '',
        
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

        openSquadModal(sub) {
            this.activeSquad = sub;
            this.editPaymentInfo = false;
            this.squadModalOpen = true;
        },

        openMemberPaymentModal(share) {
            this.activeMemberShare = share;
            this.memberModalOpen = true;
        },

        openRejectModal(shareId) {
            this.rejectShareId = shareId;
            this.rejectModalOpen = true;
        },

        openProofLightbox(src) {
            this.lightboxSrc = src;
            this.lightboxOpen = true;
        },

        getInviteUrl(code) {
            return window.location.origin + '/shares/join/' + (code || 'GRP-DEMO');
        },

        getWhatsappUrl(share, squad) {
            const friendName = share.friend_user ? share.friend_user.name : share.friend_name;
            const subName = squad ? squad.name : 'Langganan';
            const amount = 'Rp' + this.formatMoney(share.split_amount);
            const joinUrl = this.getInviteUrl(squad.invite_code);
            const bankName = "{{ auth()->user()->bank_name ?? 'Bank' }}";
            const accNo = "{{ auth()->user()->account_number ?? '-' }}";
            const accHolder = "{{ auth()->user()->account_holder ?? auth()->user()->name }}";

            let text = "Halo " + friendName + ",\n\n"
                + "Pengingat patungan langganan " + subName + " di Tatagih:\n"
                + "- Tagihan Anda: " + amount + "\n"
                + "- Host: {{ auth()->user()->name }}\n";

            if (accNo !== '-') {
                text += "- Transfer ke: " + bankName + " - " + accNo + " (a.n " + accHolder + ")\n";
            }

            text += "\nMohon konfirmasi bukti transfer melalui:\n" + joinUrl;

            return 'https://api.whatsapp.com/send?text=' + encodeURIComponent(text);
        },

        copyText(text, msg) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text);
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                } catch (err) {}
                document.body.removeChild(textArea);
            }
            this.toastMessage = msg || 'Teks berhasil disalin!';
            this.toastShow = true;
            setTimeout(() => {
                this.toastShow = false;
            }, 3000);
        },

        formatMoney(amount) {
            return new Intl.NumberFormat('id-ID').format(amount || 0);
        }
    }
}
</script>
@endsection
