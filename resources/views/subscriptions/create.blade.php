@extends('layouts.app')
@section('title', 'Tambah Subscription')

@section('content')
@php
    $categoryMap = $categories->pluck('id', 'name')->toJson();
    $categoryIdToName = $categories->pluck('name', 'id')->toJson();
    $templatesJson = json_encode($templates ?? []);
@endphp

<div x-data="subscriptionForm()" class="max-w-6xl mx-auto" x-cloak>

    <div class="mb-8">
        <h2 class="text-2xl font-black text-[var(--text-primary)]">Tambah Subscription Baru</h2>
        <p class="text-[var(--text-muted)] text-sm mt-1">Isi informasi subscription Anda dengan mudah</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-500 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <div class="w-full lg:w-2/3">

            <div class="flex items-center justify-between mb-8 relative">
                <div class="absolute top-4 left-0 w-full h-[1px] bg-[var(--border-color)] z-0"></div>
                <div class="absolute top-4 left-0 h-[1px] bg-emerald-500 z-0 transition-all duration-300" :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 1 ? 'bg-emerald-500 text-white' : 'bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-muted)]'">
                        1
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 1 ? 'text-[var(--text-primary)]' : 'text-[var(--text-muted)]'">Informasi</p>
                        <p class="text-[9px] text-[var(--text-muted)] hidden sm:block">Detail dasar subscription</p>
                    </div>
                </div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 2 ? 'bg-emerald-500 text-white' : 'bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-muted)]'">
                        2
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 2 ? 'text-[var(--text-primary)]' : 'text-[var(--text-muted)]'">Jadwal</p>
                        <p class="text-[9px] text-[var(--text-muted)] hidden sm:block">Atur siklus & tanggal</p>
                    </div>
                </div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 3 ? 'bg-emerald-500 text-white' : 'bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-muted)]'">
                        3
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 3 ? 'text-[var(--text-primary)]' : 'text-[var(--text-muted)]'">Reminder</p>
                        <p class="text-[9px] text-[var(--text-muted)] hidden sm:block">Atur notifikasi</p>
                    </div>
                </div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 4 ? 'bg-emerald-500 text-white' : 'bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-muted)]'">
                        4
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 4 ? 'text-[var(--text-primary)]' : 'text-[var(--text-muted)]'">Konfirmasi</p>
                        <p class="text-[9px] text-[var(--text-muted)] hidden sm:block">Review & simpan</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('subscriptions.store') }}" id="subscriptionFormElement">
                @csrf
                <input type="hidden" name="logo" x-model="form.logo">
                <input type="hidden" name="status" value="active">
                <input type="hidden" name="currency" value="IDR">

                <div x-show="step === 1" x-transition.opacity.duration.200ms class="space-y-5 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between pb-4 border-b border-[var(--border-color)]">
                        <div>
                            <h3 class="text-sm font-bold text-[var(--text-primary)]">Informasi Dasar</h3>
                            <p class="text-xs text-[var(--text-muted)] mt-0.5">Lengkapi rincian layanan langganan Anda</p>
                        </div>
                        <button type="button" @click="openModal()" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-[var(--bg-elevated)] hover:bg-[var(--border-color)]/50 border border-[var(--border-color)] text-[var(--text-primary)] transition-colors shadow-xs cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            <span>Pilih Template</span>
                        </button>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Nama Subscription <span class="text-emerald-500">*</span></label>
                        <div class="relative flex items-center">
                            <template x-if="form.logo">
                                <div class="absolute left-3 w-6 h-6 rounded-md bg-[var(--bg-elevated)] border border-[var(--border-color)] p-0.5 flex items-center justify-center">
                                    <img :src="form.logo" class="w-full h-full object-contain">
                                </div>
                            </template>
                            <input type="text" name="name" x-model="form.name" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-sm text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors" :class="form.logo ? 'pl-11' : ''" placeholder="Contoh: Netflix Premium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Kategori <span class="text-emerald-500">*</span></label>
                        <select id="select_category" name="category_id" x-model="form.category_id" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-sm text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Nominal (IDR) <span class="text-emerald-500">*</span></label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-sm font-bold text-[var(--text-muted)]">Rp</span>
                                <input type="number" name="amount" x-model="form.amount" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl pl-11 pr-4 py-3 text-sm font-bold text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors" placeholder="186000" min="0" step="1000" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Siklus Billing <span class="text-emerald-500">*</span></label>
                            <div class="flex items-center gap-1 bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl p-1">
                                <template x-for="cycle in ['Mingguan', 'Bulanan', 'Tahunan']">
                                    <button type="button" @click="setCycle(cycle)"
                                            :class="form.billing_cycle === getCycleValue(cycle) ? 'bg-emerald-500 text-white font-bold shadow-sm' : 'border border-transparent text-[var(--text-secondary)] hover:text-[var(--text-primary)]'"
                                            class="flex-1 py-2 text-xs font-semibold rounded-lg transition-colors text-center cursor-pointer"
                                            x-text="cycle"></button>
                                </template>
                            </div>
                            <input type="hidden" name="billing_cycle" x-model="form.billing_cycle">
                        </div>
                    </div>
                </div>

                <div x-show="step === 2" x-transition.opacity.duration.200ms style="display: none;" class="space-y-5 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm">
                    <div class="pb-4 border-b border-[var(--border-color)]">
                        <h3 class="text-sm font-bold text-[var(--text-primary)]">Jadwal & Siklus</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Tentukan tanggal penagihan dan durasi langganan</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Tanggal Pembayaran <span class="text-emerald-500">*</span></label>
                            <input type="number" name="payment_date" x-model="form.payment_date" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-sm font-bold text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors" placeholder="1-31" min="1" max="31" required>
                            <p class="text-xs mt-1 text-[var(--text-muted)]">Tanggal jatuh tempo tagihan (contoh: isi 25 jika ditagih tiap tanggal 25)</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Tanggal Mulai <span class="text-emerald-500">*</span></label>
                            <input type="date" name="start_date" x-model="form.start_date" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-sm text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Tanggal Berakhir</label>
                            <input type="date" name="end_date" x-model="form.end_date" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-sm text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors">
                            <p class="text-xs mt-1 text-[var(--text-muted)]">Kosongkan jika berlangganan tanpa batas waktu</p>
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <label class="flex items-center gap-3 cursor-pointer p-4 rounded-xl border border-[var(--border-color)] hover:border-emerald-500/30 transition-colors bg-[var(--bg-elevated)]" :class="form.auto_renew ? 'border-emerald-500/30 bg-emerald-500/5' : ''">
                                <input type="hidden" name="auto_renew" value="0">
                                <input type="checkbox" name="auto_renew" value="1" x-model="form.auto_renew" class="w-5 h-5 rounded" style="accent-color: #10b981;">
                                <div>
                                    <span class="text-sm font-bold text-[var(--text-primary)]">Auto Renewal (Perpanjang Otomatis)</span>
                                    <p class="text-xs text-[var(--text-muted)]">Subscription ini diperpanjang otomatis oleh penyedia layanan.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div x-show="step === 3" x-transition.opacity.duration.200ms style="display: none;" class="space-y-5 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm">
                    <div class="pb-4 border-b border-[var(--border-color)]">
                        <h3 class="text-sm font-bold text-[var(--text-primary)]">Atur Pengingat</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Notifikasi sebelum tanggal jatuh tempo</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Ingatkan Saya Pada (H- Hari) <span class="text-emerald-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <input type="range" x-model="form.reminder_days" min="1" max="14" class="flex-1 h-2 bg-[var(--border-color)] rounded-lg appearance-none cursor-pointer" style="accent-color: #10b981;">
                            <div class="w-14 h-12 bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl flex items-center justify-center font-black text-emerald-600 dark:text-emerald-400 text-lg">
                                <span x-text="form.reminder_days"></span>
                            </div>
                        </div>
                        <p class="text-xs mt-3 text-[var(--text-muted)]">Notifikasi akan dikirim <span class="font-bold text-[var(--text-primary)]" x-text="form.reminder_days"></span> hari sebelum tanggal jatuh tempo (<span class="font-bold text-[var(--text-primary)]" x-text="form.payment_date"></span> setiap bulannya).</p>
                        <input type="hidden" name="reminder_days" x-model="form.reminder_days">
                    </div>

                    <div class="pt-4 border-t border-[var(--border-color)]">
                        <label class="block text-xs font-bold text-[var(--text-secondary)] mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="description" x-model="form.description" class="w-full bg-[var(--bg-card)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-sm text-[var(--text-primary)] focus:outline-none focus:border-emerald-500 transition-colors" rows="3" placeholder="Contoh: Akun patungan dengan teman kantor..."></textarea>
                    </div>
                </div>

                <div x-show="step === 4" x-transition.opacity.duration.200ms style="display: none;" class="space-y-5 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-8 shadow-sm text-center">
                    <div class="w-14 h-14 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500 mx-auto mb-3 border border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-[var(--text-primary)] mb-1">Semua Sudah Siap</h3>
                    <p class="text-xs text-[var(--text-muted)] mb-2 max-w-sm mx-auto">Periksa ringkasan subscription di panel sebelah kanan.</p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-bold mb-6">Jika sudah sesuai, klik "Simpan Subscription" di bawah.</p>
                </div>

            </form>

            <div class="mt-6 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 sticky bottom-4 z-20 shadow-xl">

                <div class="flex flex-col items-center md:items-start text-center md:text-left min-w-[120px]">
                    <span class="text-xs font-bold text-[var(--text-muted)]">Total <span x-text="form.billing_cycle === 'yearly' ? 'Per Tahun' : (form.billing_cycle === 'weekly' ? 'Per Minggu' : 'Per Bulan')"></span></span>
                    <span class="text-xl font-black text-[var(--text-primary)]" x-text="formatCurrency(form.amount)"></span>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
                    <button type="button" @click="step === 1 ? window.location.href='{{ route('subscriptions.index') }}' : prevStep()" class="flex-1 md:flex-none px-6 py-3 bg-[var(--bg-elevated)] border border-[var(--border-color)] hover:border-[var(--text-muted)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] rounded-xl text-xs font-semibold transition-all text-center">
                        <span x-text="step === 1 ? 'Batal' : 'Kembali'"></span>
                    </button>
                    <button type="button" @click="nextStep()" x-show="step < 4" class="flex-1 md:flex-none px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-emerald-500/20 flex items-center justify-center gap-2">
                        <span x-text="step === 1 ? 'Lanjut: Atur Jadwal' : (step === 2 ? 'Lanjut: Reminder' : 'Review & Simpan')"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                    <button type="button" @click="submitForm()" x-show="step === 4" style="display: none;" class="flex-1 md:flex-none px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-emerald-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Subscription
                    </button>
                </div>
            </div>

        </div>

        <div class="w-full lg:w-1/3">
            <div class="sticky top-6">
                <div class="flex items-center gap-2 mb-4 text-[var(--text-muted)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <span class="text-xs font-bold">Preview Subscription</span>
                </div>

                <div class="bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex flex-col gap-4 mb-6 pb-6 border-b border-[var(--border-color)]">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-xl bg-[var(--bg-elevated)] border border-[var(--border-color)] p-2 flex items-center justify-center shrink-0">
                                    <template x-if="form.logo">
                                        <img :src="form.logo" class="w-full h-full object-contain">
                                    </template>
                                    <template x-if="!form.logo">
                                        <span class="text-xl font-bold text-[var(--text-muted)]" x-text="(form.name || 'S').substring(0, 1)"></span>
                                    </template>
                                </div>
                                <div>
                                    <h3 class="font-bold text-[var(--text-primary)] text-base leading-tight mb-1.5" x-text="form.name || 'Nama Layanan'"></h3>
                                    <template x-if="categoryName">
                                        <span class="inline-block bg-[var(--bg-elevated)] text-[var(--text-secondary)] text-[11px] font-semibold px-2.5 py-1 rounded-md border border-[var(--border-color)]" x-text="categoryName"></span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6 pb-6 border-b border-[var(--border-color)]">
                            <div class="flex items-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div>
                                    <p class="text-xs text-[var(--text-muted)] mb-0.5">Harga</p>
                                    <p class="text-sm font-bold text-[var(--text-primary)]" x-text="formatCurrency(form.amount)"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                <div>
                                    <p class="text-xs text-[var(--text-muted)] mb-0.5">Siklus</p>
                                    <p class="text-sm font-bold text-[var(--text-primary)] capitalize" x-text="form.billing_cycle === 'weekly' ? 'Mingguan' : (form.billing_cycle === 'monthly' ? 'Bulanan' : (form.billing_cycle === 'yearly' ? 'Tahunan' : 'Harian'))"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <div>
                                    <p class="text-xs text-[var(--text-muted)] mb-0.5">Pembayaran Berikutnya</p>
                                    <p class="text-sm font-bold text-[var(--text-primary)]" x-text="form.payment_date + ' ' + getNextMonth()"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6 pb-6 border-b border-[var(--border-color)]">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                <span class="text-xs font-bold text-[var(--text-primary)]">Reminder</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-[var(--text-secondary)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                <span>H-<span x-text="form.reminder_days"></span> (<span x-text="getReminderDate()"></span>)</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                <span class="text-xs font-bold text-[var(--text-primary)]">Estimasi Biaya</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs text-[var(--text-muted)]">Per bulan</span>
                                <span class="text-xs font-bold text-[var(--text-primary)]" x-text="formatCurrency(estimatedMonthly)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-[var(--text-muted)]">Per tahun</span>
                                <span class="text-sm font-black text-emerald-600 dark:text-emerald-400" x-text="formatCurrency(estimatedYearly)"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showModal"
         x-cloak
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 overflow-hidden">

        <div x-show="showModal"
             x-transition:enter="ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60"
             @click="closeModal()"></div>

        <div x-show="showModal"
             x-transition:enter="ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-4xl p-5 sm:p-6 text-left theme-card shadow-2xl rounded-2xl border theme-border z-10 flex flex-col max-h-[90vh] sm:max-h-[85vh] overflow-hidden will-change-transform">

            <div class="flex justify-between items-center mb-4 sm:mb-5 border-b theme-border pb-3 shrink-0">
                <div>
                    <h3 class="text-base font-bold theme-text-primary">Template Subscription</h3>
                    <p class="text-xs theme-text-muted mt-0.5">Pilih layanan populer untuk mengisi data subscription secara otomatis</p>
                </div>
                <button @click="closeModal()" type="button" class="w-8 h-8 rounded-lg flex items-center justify-center theme-text-muted hover:theme-text-primary hover:theme-elevated transition-colors text-xl leading-none">&times;</button>
            </div>

            <div class="flex flex-col md:flex-row gap-4 sm:gap-6 flex-1 min-h-0 overflow-hidden">
                <div class="w-full md:w-1/4 flex-shrink-0 overflow-x-auto overflow-y-hidden md:overflow-x-hidden md:overflow-y-auto border-b md:border-b-0 md:border-r theme-border pb-2 md:pb-0 md:pr-3 flex md:flex-col flex-row gap-1 custom-scrollbar">
                    <template x-for="catName in categoryList" :key="catName">
                        <button type="button" @click="activeCategory = catName; selectedTemplate = null;"
                                :class="activeCategory === catName
                                    ? 'theme-elevated theme-text-primary font-bold border-l-2 border-emerald-500 shadow-sm'
                                    : 'theme-text-secondary hover:theme-text-primary hover:theme-elevated border-l-2 border-transparent'"
                                class="flex-shrink-0 w-auto md:w-full text-left px-3.5 py-2.5 rounded-r-xl text-xs font-semibold transition-colors duration-150 whitespace-nowrap"
                                x-text="catName">
                        </button>
                    </template>
                </div>

                <div class="w-full md:w-3/4 flex-1 min-h-0 overflow-y-auto pb-4 pr-1 custom-scrollbar">
                    <div x-show="!selectedTemplate" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <template x-for="item in currentTemplates" :key="item.name">
                            <div @click="selectTemplate(item)" class="cursor-pointer border theme-border theme-elevated p-4 rounded-xl hover:border-emerald-500/50 hover:shadow-sm transition-colors duration-150 text-center flex flex-col items-center justify-center gap-3 group">
                                <div class="w-12 h-12 rounded-xl theme-card border theme-border p-2 flex items-center justify-center group-hover:border-emerald-500/40 transition-colors shrink-0">
                                    <img :src="item.logo" :alt="item.name" width="48" height="48" loading="lazy" decoding="async" class="w-full h-full object-contain" onerror="this.style.display='none'">
                                </div>
                                <h4 class="font-bold text-xs theme-text-primary" x-text="item.name"></h4>
                            </div>
                        </template>
                    </div>

                    <div x-show="selectedTemplate" style="display: none;" class="p-5 border theme-border theme-elevated rounded-xl">
                        <div class="flex items-center gap-4 mb-5">
                            <button type="button" @click="selectedTemplate = null" class="theme-card theme-text-primary border theme-border hover:theme-border py-1.5 px-3.5 text-xs flex items-center gap-2 rounded-lg transition-colors font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                Kembali
                            </button>
                        </div>

                        <div class="flex items-center gap-4 mb-5">
                            <div class="w-14 h-14 rounded-xl theme-card border theme-border p-2 flex items-center justify-center shrink-0">
                                <template x-if="selectedTemplate?.logo">
                                    <img :src="selectedTemplate.logo" width="56" height="56" loading="lazy" decoding="async" class="w-full h-full object-contain" onerror="this.style.display='none'">
                                </template>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold theme-text-primary" x-text="selectedTemplate?.name"></h2>
                                <p class="text-xs theme-text-muted mt-0.5" x-text="selectedTemplate?.category"></p>
                            </div>
                        </div>

                        <div class="theme-card p-4 rounded-xl border theme-border mb-5">
                            <h4 class="font-bold text-xs mb-3 theme-text-primary flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                                Pilih Paket Tersedia
                            </h4>
                            <div class="space-y-2 max-h-60 overflow-y-auto pr-1 custom-scrollbar">
                                <template x-for="(plan, index) in (selectedTemplate ? selectedTemplate.plans : [])" :key="index">
                                    <label class="flex flex-col sm:flex-row sm:items-center justify-between p-3 border rounded-xl cursor-pointer transition-colors duration-150"
                                           :class="Number(selectedPlanIndex) === index ? 'border-emerald-500 bg-emerald-500/5 ring-1 ring-emerald-500' : 'border theme-border hover:theme-border theme-elevated'">
                                        <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                            <input type="radio" name="plan_selection" :value="index" x-model="selectedPlanIndex" class="w-4 h-4" style="accent-color: #10b981;">
                                            <span class="font-bold text-xs theme-text-primary" x-text="plan.name"></span>
                                        </div>
                                        <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto pl-7 sm:pl-0">
                                            <span class="text-xs theme-text-muted mr-3" x-text="plan.cycle === 'yearly' ? 'Per Tahun' : 'Per Bulan'"></span>
                                            <span class="font-mono font-bold text-sm theme-text-primary" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(plan.price)"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div class="flex justify-end border-t theme-border pt-4">
                            <button type="button" @click="applyTemplate()" class="bg-emerald-500 hover:bg-emerald-600 text-white w-full sm:w-auto py-2.5 px-6 rounded-xl font-bold text-xs shadow-sm transition-colors duration-150">
                                Gunakan Template
                            </button>
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
    const RAW_TEMPLATES = Object.freeze({!! $templatesJson !!});
    const RAW_CATEGORY_MAP = Object.freeze({!! $categoryMap !!});
    const RAW_CATEGORY_ID_TO_NAME = Object.freeze({!! $categoryIdToName !!});

    function subscriptionForm() {
        return {
            step: 1,
            form: {
                name: '{{ old("name") }}',
                category_id: '{{ old("category_id") }}',
                amount: '{{ old("amount", "") }}',
                billing_cycle: '{{ old("billing_cycle", "monthly") }}',
                payment_date: '{{ old("payment_date", date("j")) }}',
                start_date: '{{ old("start_date", date("Y-m-d")) }}',
                end_date: '{{ old("end_date") }}',
                reminder_days: '{{ old("reminder_days", 3) }}',
                auto_renew: true,
                description: '{{ old("description") }}',
                logo: '{{ old("logo") }}'
            },

            showModal: false,
            activeCategory: 'Film & Streaming',
            selectedTemplate: null,
            selectedPlanIndex: 0,
            categoryList: Object.keys(RAW_TEMPLATES),

            get currentTemplates() {
                return RAW_TEMPLATES[this.activeCategory] || [];
            },

            openModal() {
                this.showModal = true;
                document.body.style.overflow = 'hidden';
            },

            closeModal() {
                this.showModal = false;
                this.selectedTemplate = null;
                document.body.style.overflow = '';
            },

            selectTemplate(template) {
                this.selectedTemplate = template;
                this.selectedPlanIndex = 0;
            },

            applyTemplate() {
                if (!this.selectedTemplate) return;

                let plan = this.selectedTemplate.plans[this.selectedPlanIndex];
                let name = this.selectedTemplate.plans.length > 1 && plan.name !== 'Standard' && plan.name !== 'Premium' && !plan.name.includes('Individual')
                    ? this.selectedTemplate.name + ' ' + plan.name
                    : this.selectedTemplate.name;

                let categoryId = RAW_CATEGORY_MAP[this.selectedTemplate.category] || '';

                this.form.name = name;
                if(categoryId) this.form.category_id = String(categoryId);
                this.form.amount = plan.price;
                this.form.billing_cycle = plan.cycle || 'monthly';
                this.form.logo = this.selectedTemplate.logo;

                this.closeModal();
            },

            nextStep() {
                if(this.step === 1 && (!this.form.name || !this.form.category_id || !this.form.amount)) {
                    alert('Mohon lengkapi Nama, Kategori, dan Nominal');
                    return;
                }
                if(this.step === 2 && (!this.form.payment_date || !this.form.start_date)) {
                    alert('Mohon lengkapi Tanggal Pembayaran dan Tanggal Mulai');
                    return;
                }
                if(this.step < 4) this.step++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            prevStep() {
                if(this.step > 1) this.step--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            submitForm() {
                document.getElementById('subscriptionFormElement').submit();
            },

            setCycle(cycleName) {
                this.form.billing_cycle = this.getCycleValue(cycleName);
            },

            getCycleValue(cycleName) {
                if(cycleName === 'Mingguan') return 'weekly';
                if(cycleName === 'Bulanan') return 'monthly';
                if(cycleName === 'Tahunan') return 'yearly';
                return 'monthly';
            },

            setCategoryByName(name) {
                let id = RAW_CATEGORY_MAP[name];
                if(id) {
                    this.form.category_id = String(id);
                }
            },

            get estimatedMonthly() {
                let amt = parseFloat(this.form.amount) || 0;
                if(this.form.billing_cycle === 'weekly') return amt * 4.33;
                if(this.form.billing_cycle === 'yearly') return amt / 12;
                if(this.form.billing_cycle === 'daily') return amt * 30;
                return amt;
            },

            get estimatedYearly() {
                let amt = parseFloat(this.form.amount) || 0;
                if(this.form.billing_cycle === 'monthly') return amt * 12;
                if(this.form.billing_cycle === 'weekly') return amt * 52;
                if(this.form.billing_cycle === 'daily') return amt * 365;
                return amt;
            },

            get categoryName() {
                if (!this.form.category_id) return '';
                return RAW_CATEGORY_ID_TO_NAME[this.form.category_id] || '';
            },

            getNextMonth() {
                const date = new Date();
                let nextM = date.getMonth() + 1;
                let nextY = date.getFullYear();
                if(nextM > 11) {
                    nextM = 0;
                    nextY++;
                }
                const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                return months[nextM] + ' ' + nextY;
            },

            getReminderDate() {
                let d = parseInt(this.form.payment_date) || 1;
                let h = parseInt(this.form.reminder_days) || 3;
                let remDate = d - h;
                const date = new Date();
                let m = date.getMonth() + 1;
                let y = date.getFullYear();
                if(m > 11) { m = 0; y++; }

                if(remDate <= 0) {
                    remDate += 30;
                    m--;
                    if(m < 0) { m = 11; y--; }
                }
                const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                return remDate + ' ' + months[m] + ' ' + y;
            },

            formatCurrency(value) {
                if(!value) return 'Rp0';
                return 'Rp' + new Intl.NumberFormat('id-ID').format(Math.round(value));
            }
        };
    }
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
    height: 4px;
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
@endsection