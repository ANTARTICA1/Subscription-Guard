@extends('layouts.app')
@section('title', 'Cari Teman Patungan')

@section('content')
<div x-data="discoverPage()" class="pb-10">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3.5">
            <div class="text-emerald-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-[var(--text-primary)]">Grup Publik Terbuka</h2>
                <p class="text-xs text-[var(--text-muted)] mt-0.5">Bergabunglah dengan grup publik untuk berbagi biaya langganan.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('shares.index') }}" class="btn-primary py-2.5 px-5 rounded-xl text-xs font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Buat Grup Saya
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 min-w-0">

        <div class="lg:col-span-7 xl:col-span-8 2xl:col-span-9 space-y-6 min-w-0">

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="relative flex-1">
                    <input type="text" x-model="search" placeholder="Cari grup atau layanan..." class="w-full bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl pl-10 pr-4 py-2.5 text-xs text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors placeholder-[var(--text-muted)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>

            <template x-if="filteredGroups.length === 0">
                <div class="card p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-[var(--text-muted)] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <h4 class="text-[var(--text-primary)] font-bold text-sm">Tidak ada grup ditemukan</h4>
                    <p class="text-[var(--text-muted)] text-xs mt-1" x-text="search ? 'Coba gunakan kata kunci lain.' : 'Belum ada grup publik saat ini.'"></p>
                </div>
            </template>

            <template x-for="group in filteredGroups" :key="group.id">
                <div class="card p-6 relative overflow-hidden hover:border-emerald-500/40 transition-colors">
                    <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">

                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-[var(--bg-elevated)] border border-[var(--border-color)] flex items-center justify-center p-3">
                                <template x-if="group.logo">
                                    <img :src="group.logo" class="w-full h-full object-contain">
                                </template>
                                <template x-if="!group.logo">
                                    <span x-html="group.category ? group.category.icon : ''" class="text-2xl" :style="`color: ${group.category ? group.category.color : '#10b981'}`"></span>
                                </template>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                        Publik
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[var(--bg-elevated)] text-[var(--text-secondary)]" x-text="group.category ? group.category.name : 'Subscription'"></span>
                                </div>
                                <h3 class="text-lg font-bold text-[var(--text-primary)] leading-tight" x-text="group.name"></h3>

                                <p class="text-xs text-[var(--text-muted)] mt-2 flex items-center gap-1.5">
                                    Host: <strong class="text-[var(--text-primary)]" x-text="group.user.name"></strong>
                                </p>
                            </div>
                        </div>

                        <div class="hidden md:block">
                            <template x-if="!group.shares.find(s => s.friend_user_id === userId)">
                                <form :action="`/shares/join/${group.invite_code}`" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-primary py-2.5 px-6 rounded-xl text-xs font-bold inline-block">
                                        Minta Bergabung
                                    </button>
                                </form>
                            </template>
                            <template x-if="group.shares.find(s => s.friend_user_id === userId)">
                                <span class="px-5 py-2.5 bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 font-bold rounded-xl inline-block text-xs cursor-default">
                                    <span x-text="group.shares.find(s => s.friend_user_id === userId).payment_status === 'pending' ? 'Tergabung (Belum Bayar)' : 'Tergabung (Lunas)'"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="relative z-10 grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-5 border-t border-[var(--border-color)]">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[var(--bg-elevated)] text-emerald-500 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[var(--text-muted)] mb-0.5">Anggota Saat Ini</p>
                                <p class="text-xs font-bold text-[var(--text-primary)]"><span class="text-emerald-500" x-text="group.shares.length + 1"></span> orang</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[var(--bg-elevated)] text-emerald-500 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[var(--text-muted)] mb-0.5">Estimasi Patungan</p>
                                <p class="text-xs font-bold text-emerald-500">Rp<span x-text="formatMoney(Math.round(group.amount / (group.shares.length + 2)))"></span> <span class="text-[9px] text-[var(--text-muted)] font-normal">/bln</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[var(--bg-elevated)] text-emerald-500 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[var(--text-muted)] mb-0.5">Siklus Billing</p>
                                <p class="text-xs font-bold text-[var(--text-primary)] capitalize" x-text="group.billing_cycle"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[var(--bg-elevated)] text-emerald-500 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-[var(--text-muted)] mb-0.5">Keamanan</p>
                                <p class="text-xs font-bold text-emerald-500">Terverifikasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 mt-5 flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div class="flex-1">
                            <p class="text-xs text-[var(--text-muted)] flex items-start gap-2 max-w-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Akun langganan publik. Kuota terbatas, bergabung sebelum penuh.
                            </p>

                            <div class="flex items-center mt-3">
                                <div class="w-7 h-7 rounded-full bg-emerald-500 border-2 border-[var(--bg-card)] text-white flex items-center justify-center text-[10px] font-bold shadow-sm z-10 relative">
                                    <span x-text="group.user.name.substring(0,1)"></span>
                                </div>
                                <template x-for="(share, i) in group.shares.slice(0, 3)" :key="share.id">
                                    <div class="w-7 h-7 rounded-full bg-[var(--bg-elevated)] border-2 border-[var(--bg-card)] text-[var(--text-primary)] flex items-center justify-center text-[10px] font-bold shadow-sm -ml-2" :class="`z-[${9-i}] relative`">
                                        <span x-text="share.friend_name.substring(0,1)"></span>
                                    </div>
                                </template>
                                <template x-if="group.shares.length > 3">
                                    <div class="w-7 h-7 rounded-full bg-[var(--bg-card)] border-2 border-[var(--bg-card)] text-[var(--text-muted)] flex items-center justify-center text-[9px] font-bold shadow-sm -ml-2 z-0 relative">
                                        +<span x-text="group.shares.length - 3"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="md:hidden w-full mt-3">
                            <template x-if="!group.shares.find(s => s.friend_user_id === userId)">
                                <form :action="`/shares/join/${group.invite_code}`" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full py-2.5 rounded-xl text-xs font-bold block text-center">
                                        Minta Bergabung
                                    </button>
                                </form>
                            </template>
                            <template x-if="group.shares.find(s => s.friend_user_id === userId)">
                                <div class="w-full text-center px-4 py-2.5 bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 font-bold rounded-xl text-xs">
                                    <span x-text="group.shares.find(s => s.friend_user_id === userId).payment_status === 'pending' ? 'Tergabung (Belum Bayar)' : 'Tergabung (Lunas)'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </template>
        </div>

        <div class="lg:col-span-5 xl:col-span-4 2xl:col-span-3 space-y-6 min-w-0">

            <div class="card p-6">
                <h3 class="font-bold text-[var(--text-primary)] text-sm mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Kenapa Gabung Grup?
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2.5">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[var(--text-muted)] leading-tight">Hemat hingga 70% biaya langganan</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[var(--text-muted)] leading-tight">Akun tetap aman & terverifikasi</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[var(--text-muted)] leading-tight">Kelola anggota dengan mudah</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <div class="w-4 h-4 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                        </div>
                        <span class="text-xs text-[var(--text-muted)] leading-tight">Pembayaran transparan</span>
                    </li>
                </ul>

                <hr class="border-[var(--border-color)] my-5">

                <h3 class="font-bold text-[var(--text-primary)] text-sm mb-4">Bagaimana Cara Gabung?</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">1</div>
                        <div>
                            <p class="text-xs font-bold text-[var(--text-primary)]">Kirim permintaan</p>
                            <p class="text-[10px] text-[var(--text-muted)]">Host akan menerima notifikasi.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">2</div>
                        <div>
                            <p class="text-xs font-bold text-[var(--text-primary)]">Tunggu persetujuan</p>
                            <p class="text-[10px] text-[var(--text-muted)]">Biasanya dalam hitungan menit.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] font-bold flex-shrink-0">3</div>
                        <div>
                            <p class="text-xs font-bold text-[var(--text-primary)]">Bayar & nikmati</p>
                            <p class="text-[10px] text-[var(--text-muted)]">Akses langsung setelah pembayaran.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                <h3 class="font-bold text-[var(--text-primary)] text-sm mb-1">Buat grup sendiri & ajak teman!</h3>
                <p class="text-xs text-[var(--text-muted)] mb-5">Kelola grupmu sendiri dan mulai hemat bareng.</p>

                <a href="{{ route('shares.index') }}" class="btn-primary w-full block text-center py-2.5 px-4 text-xs font-bold rounded-xl">
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
        userId: {{ auth()->id() ?? 'null' }},

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
