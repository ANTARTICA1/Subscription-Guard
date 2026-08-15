@extends('layouts.app')
@section('title', 'Tambah Subscription')

@section('content')
@php
    $categoryMap = $categories->pluck('id', 'name')->toJson();
    $templatesJson = json_encode($templates ?? []);
@endphp

<div x-data="subscriptionForm()" class="max-w-6xl mx-auto" x-cloak>
    
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-black text-white">Tambah Subscription Baru</h2>
        <p class="text-[#94a3b8] text-sm mt-1">Isi informasi subscription Anda dengan mudah</p>
    </div>

    {{-- Error messages --}}
    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        {{-- Left Column: Wizard Form --}}
        <div class="w-full lg:w-2/3">
            
            {{-- Stepper Navigation --}}
            <div class="flex items-center justify-between mb-8 relative">
                <!-- Line background -->
                <div class="absolute top-4 left-0 w-full h-[1px] bg-[rgba(255,255,255,0.06)] z-0"></div>
                <!-- Active Line -->
                <div class="absolute top-4 left-0 h-[1px] bg-emerald-500 z-0 transition-all duration-300" :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>

                <!-- Step 1 -->
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 1 ? 'bg-emerald-500 text-white' : 'bg-[#111c2e] border border-[rgba(255,255,255,0.06)] text-[#4b5e78]'">
                        1
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 1 ? 'text-white' : 'text-[#94a3b8]'">Informasi</p>
                        <p class="text-[9px] text-[#4b5e78] hidden sm:block">Detail dasar subscription</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 2 ? 'bg-emerald-500 text-white' : 'bg-[#111c2e] border border-[rgba(255,255,255,0.06)] text-[#4b5e78]'">
                        2
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 2 ? 'text-white' : 'text-[#94a3b8]'">Jadwal</p>
                        <p class="text-[9px] text-[#4b5e78] hidden sm:block">Atur siklus & tanggal</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 3 ? 'bg-emerald-500 text-white' : 'bg-[#111c2e] border border-[rgba(255,255,255,0.06)] text-[#4b5e78]'">
                        3
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 3 ? 'text-white' : 'text-[#94a3b8]'">Reminder</p>
                        <p class="text-[9px] text-[#4b5e78] hidden sm:block">Atur notifikasi</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs transition-colors shadow-sm"
                         :class="step >= 4 ? 'bg-emerald-500 text-white' : 'bg-[#111c2e] border border-[rgba(255,255,255,0.06)] text-[#4b5e78]'">
                        4
                    </div>
                    <div class="text-center mt-2">
                        <p class="text-xs font-bold" :class="step >= 4 ? 'text-white' : 'text-[#94a3b8]'">Konfirmasi</p>
                        <p class="text-[9px] text-[#4b5e78] hidden sm:block">Review & simpan</p>
                    </div>
                </div>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('subscriptions.store') }}" id="subscriptionFormElement">
                @csrf
                <input type="hidden" name="logo" x-model="form.logo">
                <input type="hidden" name="status" value="active">
                <input type="hidden" name="currency" value="IDR">
                
                {{-- STEP 1: INFORMASI --}}
                <div x-show="step === 1" x-transition.opacity.duration.300ms class="space-y-5 bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-sm relative overflow-hidden">
                    <div class="flex items-start gap-4 mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 shrink-0 border border-blue-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white mb-0.5">Informasi Dasar</h3>
                            <p class="text-[11px] text-[#4b5e78]">Lengkapi informasi dasar subscription Anda.</p>
                        </div>
                    </div>

                    <button type="button" @click="openModal()" class="w-full relative overflow-hidden group rounded-xl p-4 border border-[rgba(255,255,255,0.06)] bg-gradient-to-r from-[#111c2e] to-[#080d19] hover:from-[#192a42] hover:to-[#0b121f] transition-all text-left flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="absolute -inset-1 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white shrink-0 shadow-[0_0_15px_rgba(245,158,11,0.5)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div class="relative flex-1">
                            <h4 class="text-sm font-black text-white mb-1">Gunakan Template Cepat (Rekomendasi)</h4>
                            <p class="text-[11px] text-[#94a3b8]">Isi otomatis nama, logo, kategori, dan harga dari layanan populer.</p>
                        </div>
                        <div class="relative hidden sm:flex items-center gap-2">
                            <span class="text-xs font-bold text-yellow-500">Pilih Template</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </div>
                    </button>
                    
                    <div class="flex items-center gap-4 my-2">
                        <div class="h-[1px] flex-1 bg-[rgba(255,255,255,0.04)]"></div>
                        <span class="text-[10px] text-[#4b5e78] font-bold uppercase tracking-wider">Atau isi manual</span>
                        <div class="h-[1px] flex-1 bg-[rgba(255,255,255,0.04)]"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#94a3b8] mb-2">Nama Subscription <span class="text-emerald-500">*</span></label>
                        <div class="relative flex items-center">
                            <template x-if="form.logo">
                                <div class="absolute left-3 w-6 h-6 rounded-md bg-[#080d19] border border-[rgba(255,255,255,0.06)] p-0.5 flex items-center justify-center">
                                    <img :src="form.logo" class="w-full h-full object-contain">
                                </div>
                            </template>
                            <input type="text" name="name" x-model="form.name" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-colors" :class="form.logo ? 'pl-11' : ''" placeholder="Contoh: Netflix Premium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#94a3b8] mb-2">Kategori <span class="text-emerald-500">*</span></label>
                        <div class="flex flex-wrap gap-2 mb-2">
                            <template x-for="catBtn in ['Streaming', 'Music', 'Gaming', 'AI & Productivity']">
                                <button type="button" @click="setCategoryByName(catBtn)"
                                        class="px-4 py-2 border rounded-xl text-xs font-bold transition-all flex items-center gap-2"
                                        :class="getCategoryName() === catBtn ? 'bg-purple-500/10 border-purple-500/50 text-purple-400' : 'border-[rgba(255,255,255,0.06)] text-[#94a3b8] hover:text-white'">
                                        <span x-text="catBtn"></span>
                                </button>
                            </template>
                        </div>
                        <select id="select_category" name="category_id" x-model="form.category_id" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-colors appearance-none" required>
                            <option value="">Pilih Kategori Lainnya...</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-[#94a3b8] mb-2">Nominal (IDR) <span class="text-emerald-500">*</span></label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-sm font-bold text-[#4b5e78]">Rp</span>
                                <input type="number" name="amount" x-model="form.amount" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl pl-11 pr-4 py-3 text-sm font-bold text-white focus:outline-none focus:border-emerald-500 transition-colors" placeholder="186000" min="0" step="1000" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-[#94a3b8] mb-2">Siklus Billing <span class="text-emerald-500">*</span></label>
                            <div class="flex items-center gap-1 bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl p-1">
                                <template x-for="cycle in ['Mingguan', 'Bulanan', 'Tahunan']">
                                    <button type="button" @click="setCycle(cycle)"
                                            :class="form.billing_cycle === getCycleValue(cycle) ? 'bg-purple-500/20 border border-purple-500/30 text-purple-400 shadow-sm' : 'border border-transparent text-[#94a3b8] hover:text-white'"
                                            class="flex-1 py-2 text-xs font-bold rounded-lg transition-all text-center"
                                            x-text="cycle"></button>
                                </template>
                            </div>
                            <input type="hidden" name="billing_cycle" x-model="form.billing_cycle">
                        </div>
                    </div>

                    {{-- AI Insight Box --}}
                    <div class="mt-6 p-4 rounded-xl border border-purple-500/20 bg-gradient-to-r from-purple-500/10 to-[#0b121f] relative overflow-hidden flex items-start gap-3">
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-20 w-32 h-32 bg-purple-500 blur-3xl rounded-full"></div>
                        <div class="w-8 h-8 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-400 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <div>
                            <h4 class="text-[11px] font-bold text-white mb-1">AI Insight</h4>
                            <p class="text-[11px] text-[#94a3b8] leading-relaxed">
                                Subscription ini akan menghabiskan <span class="font-bold text-emerald-400" x-text="formatCurrency(estimatedYearly)"></span> per tahun.
                                <template x-if="form.category_id">
                                    <span>Pastikan limit budget Anda untuk kategori <span class="font-bold text-purple-400" x-text="getCategoryName()"></span> mencukupi.</span>
                                </template>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- STEP 2: JADWAL --}}
                <div x-show="step === 2" x-transition.opacity.duration.300ms style="display: none;" class="space-y-5 bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-2">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0 border border-emerald-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white mb-0.5">Jadwal & Siklus</h3>
                            <p class="text-[11px] text-[#4b5e78]">Kapan subscription ini ditagihkan?</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-[#94a3b8] mb-2">Tanggal Pembayaran <span class="text-emerald-500">*</span></label>
                            <input type="number" name="payment_date" x-model="form.payment_date" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm font-bold text-white focus:outline-none focus:border-emerald-500 transition-colors" placeholder="1-31" min="1" max="31" required>
                            <p class="text-[10px] mt-1 text-[#4b5e78]">Tgl jatuh tempo tagihan (contoh: isi 25 jika ditagih tiap tgl 25)</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-[#94a3b8] mb-2">Tanggal Mulai <span class="text-emerald-500">*</span></label>
                            <input type="date" name="start_date" x-model="form.start_date" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#94a3b8] mb-2">Tanggal Berakhir</label>
                            <input type="date" name="end_date" x-model="form.end_date" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-colors">
                            <p class="text-[10px] mt-1 text-[#4b5e78]">Kosongkan jika berlangganan tanpa batas</p>
                        </div>
                        
                        <div class="md:col-span-2 mt-2">
                            <label class="flex items-center gap-3 cursor-pointer p-4 rounded-xl border border-[rgba(255,255,255,0.06)] hover:border-emerald-500/30 transition-colors bg-[#111c2e]" :class="form.auto_renew ? 'border-emerald-500/30 bg-emerald-500/5' : ''">
                                <input type="hidden" name="auto_renew" value="0">
                                <input type="checkbox" name="auto_renew" value="1" x-model="form.auto_renew" class="w-5 h-5 rounded" style="accent-color: #10b981;">
                                <div>
                                    <span class="text-sm font-bold text-[#f1f5f9]">Auto Renewal (Perpanjang Otomatis)</span>
                                    <p class="text-[10px] text-[#94a3b8]">Subscription ini diperpanjang otomatis oleh penyedia layanan.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: REMINDER --}}
                <div x-show="step === 3" x-transition.opacity.duration.300ms style="display: none;" class="space-y-5 bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-sm">
                    <div class="flex items-start gap-4 mb-2">
                        <div class="w-10 h-10 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-400 shrink-0 border border-orange-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white mb-0.5">Atur Pengingat</h3>
                            <p class="text-[11px] text-[#4b5e78]">Jangan sampai lupa dan uang terpotong otomatis.</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#94a3b8] mb-2">Ingatkan Saya Pada (H- Hari) <span class="text-emerald-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <input type="range" x-model="form.reminder_days" min="1" max="14" class="flex-1 h-2 bg-[#192a42] rounded-lg appearance-none cursor-pointer" style="accent-color: #10b981;">
                            <div class="w-14 h-12 bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl flex items-center justify-center font-black text-emerald-400 text-lg">
                                <span x-text="form.reminder_days"></span>
                            </div>
                        </div>
                        <p class="text-[10px] mt-3 text-[#94a3b8]">Sistem akan mengirim notifikasi <span class="font-bold text-white" x-text="form.reminder_days"></span> hari sebelum tanggal jatuh tempo (<span x-text="form.payment_date"></span> setiap bulannya).</p>
                        <input type="hidden" name="reminder_days" x-model="form.reminder_days">
                    </div>

                    <div class="pt-4 border-t border-[rgba(255,255,255,0.04)]">
                        <label class="block text-xs font-bold text-[#94a3b8] mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="description" x-model="form.description" class="w-full bg-[#111c2e] border border-[rgba(255,255,255,0.06)] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-colors" rows="3" placeholder="Contoh: Akun patungan dengan teman kantor..."></textarea>
                    </div>
                </div>

                {{-- STEP 4: KONFIRMASI --}}
                <div x-show="step === 4" x-transition.opacity.duration.300ms style="display: none;" class="space-y-5 bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-8 shadow-sm text-center">
                    <div class="w-20 h-20 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400 mx-auto mb-4 border-2 border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h3 class="text-xl font-black text-white mb-2">Semua Sudah Siap!</h3>
                    <p class="text-xs text-[#94a3b8] mb-2 max-w-sm mx-auto">Silakan cek kembali ringkasan subscription Anda di panel sebelah kanan.</p>
                    <p class="text-[11px] text-emerald-400 font-bold mb-6">Jika sudah benar, klik "Simpan Subscription" di bawah.</p>
                </div>

            </form>

            {{-- Footer Navigation --}}
            <div class="mt-6 bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 sticky bottom-4 z-20 shadow-2xl">
                
                <div class="flex flex-col items-center md:items-start text-center md:text-left min-w-[120px]">
                    <span class="text-[10px] font-bold text-[#94a3b8]">Total <span x-text="form.billing_cycle === 'yearly' ? 'Per Tahun' : (form.billing_cycle === 'weekly' ? 'Per Minggu' : 'Per Bulan')"></span></span>
                    <span class="text-xl font-black text-purple-400" x-text="formatCurrency(form.amount)"></span>
                </div>
                
                <div class="hidden lg:flex items-center gap-3 bg-[#111c2e] px-4 py-2.5 rounded-xl border border-[rgba(255,255,255,0.03)] flex-1">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-white">Tips</p>
                        <p class="text-[9px] text-[#94a3b8]">Anda bisa mengubah atau menyesuaikan detail ini nanti.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
                    <button type="button" @click="step === 1 ? window.location.href='{{ route('subscriptions.index') }}' : prevStep()" class="flex-1 md:flex-none px-6 py-3 bg-transparent border border-[rgba(255,255,255,0.1)] hover:bg-[#111c2e] text-[#94a3b8] hover:text-white rounded-xl text-xs font-bold transition-all text-center">
                        <span x-text="step === 1 ? 'Batal' : 'Kembali'"></span>
                    </button>
                    <button type="button" @click="nextStep()" x-show="step < 4" class="flex-1 md:flex-none px-6 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-400 hover:to-cyan-400 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                        <span x-text="step === 1 ? 'Lanjut: Atur Jadwal' : (step === 2 ? 'Lanjut: Reminder' : 'Review & Simpan')"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                    <button type="button" @click="submitForm()" x-show="step === 4" style="display: none;" class="flex-1 md:flex-none px-8 py-3 bg-purple-500 hover:bg-purple-400 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-purple-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Simpan Subscription
                    </button>
                </div>
            </div>

        </div>

        {{-- Right Column: Live Preview --}}
        <div class="w-full lg:w-1/3">
            <div class="sticky top-6">
                <div class="flex items-center gap-2 mb-4 text-[#94a3b8]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <span class="text-xs font-bold">Preview Subscription</span>
                </div>

                <div class="bg-[#0b121f] border border-[rgba(255,255,255,0.04)] rounded-2xl p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#111c2e]/50 to-transparent z-0"></div>
                    
                    <div class="relative z-10">
                        <div class="flex flex-col gap-4 mb-6 pb-6 border-b border-[rgba(255,255,255,0.06)]">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-xl bg-[#080d19] border border-[rgba(255,255,255,0.06)] p-2 flex items-center justify-center shrink-0">
                                    <template x-if="form.logo">
                                        <img :src="form.logo" class="w-full h-full object-contain">
                                    </template>
                                    <template x-if="!form.logo">
                                        <span class="text-xl font-bold text-[#94a3b8]" x-text="(form.name || 'S').substring(0, 1)"></span>
                                    </template>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-base leading-tight mb-1.5" x-text="form.name || 'Nama Layanan'"></h3>
                                    <span class="inline-block bg-purple-500/10 text-purple-400 text-[10px] font-bold px-2.5 py-1 rounded-md border border-purple-500/20" x-text="getCategoryName()"></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5 mb-6 pb-6 border-b border-[rgba(255,255,255,0.06)]">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400 shrink-0 border border-emerald-500/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-[#94a3b8] mb-0.5">Harga</p>
                                    <p class="text-sm font-bold text-white" x-text="formatCurrency(form.amount)"></p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 shrink-0 border border-blue-500/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-[#94a3b8] mb-0.5">Siklus</p>
                                    <p class="text-sm font-bold text-white capitalize" x-text="form.billing_cycle === 'weekly' ? 'Mingguan' : (form.billing_cycle === 'monthly' ? 'Bulanan' : (form.billing_cycle === 'yearly' ? 'Tahunan' : 'Harian'))"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-400 shrink-0 border border-orange-500/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-[#94a3b8] mb-0.5">Pembayaran Berikutnya</p>
                                    <p class="text-sm font-bold text-white" x-text="form.payment_date + ' ' + getNextMonth()"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6 pb-6 border-b border-[rgba(255,255,255,0.06)]">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                <span class="text-xs font-bold text-white">Reminder</span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-[#94a3b8]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                <span>H-<span x-text="form.reminder_days"></span> (<span x-text="getReminderDate()"></span>)</span>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                <span class="text-xs font-bold text-white">Estimasi Biaya</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[11px] text-[#94a3b8]">Per bulan</span>
                                <span class="text-xs font-bold text-[#f1f5f9]" x-text="formatCurrency(estimatedMonthly)"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[11px] text-[#94a3b8]">Per tahun</span>
                                <span class="text-sm font-black text-emerald-400" x-text="formatCurrency(estimatedYearly)"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Pilih Template Cepat --}}
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-[#03060D]/80" @click="closeModal()"></div>
            
            <div x-show="showModal" x-transition.scale class="relative inline-block w-full max-w-4xl p-4 sm:p-6 overflow-hidden text-left align-middle transition-all transform bg-[#0d1526] shadow-xl rounded-2xl border border-[rgba(255,255,255,0.06)]">
                <div class="flex justify-between items-center mb-5 border-b border-[rgba(255,255,255,0.06)] pb-3">
                    <h3 class="text-lg font-bold text-[#f1f5f9]">Template Subscription</h3>
                    <button @click="closeModal()" type="button" class="text-2xl text-[#94a3b8] hover:text-[#f1f5f9]">&times;</button>
                </div>
                
                <div class="flex flex-col md:flex-row gap-4 sm:gap-6 h-[70vh] sm:h-[60vh]">
                    <!-- Sidebar -->
                    <div class="w-full md:w-1/4 flex-shrink-0 overflow-x-auto overflow-y-hidden md:overflow-x-hidden md:overflow-y-auto border-b md:border-b-0 md:border-r border-[rgba(255,255,255,0.06)] pb-4 md:pb-0 md:pr-4 flex md:flex-col flex-row gap-2 custom-scrollbar" style="scrollbar-width: thin;">
                        <template x-for="(items, categoryName) in templates" :key="categoryName">
                            <button type="button" @click="activeCategory = categoryName; selectedTemplate = null;"
                                    :class="activeCategory === categoryName ? 'bg-gradient-to-r from-emerald-500 to-cyan-500 text-white shadow-lg' : 'text-[#94a3b8] hover:bg-[#111c2e] hover:text-[#f1f5f9]'"
                                    class="flex-shrink-0 w-auto md:w-full text-left px-4 py-2.5 rounded-xl mb-1 text-sm font-semibold transition-all whitespace-nowrap"
                                    x-text="categoryName">
                            </button>
                        </template>
                    </div>
                    
                    <!-- Content -->
                    <div class="w-full md:w-3/4 overflow-y-auto pb-4 pr-1">
                        <div x-show="!selectedTemplate" class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                            <template x-for="item in templates[activeCategory]" :key="item.name">
                                <div @click="selectTemplate(item)" class="cursor-pointer border border-[rgba(255,255,255,0.06)] bg-[#111c2e] p-4 rounded-xl hover:border-emerald-500/50 hover:shadow-lg transition-all text-center flex flex-col items-center justify-center gap-3 group">
                                    <div class="w-12 h-12 rounded-xl bg-[#192a42] border border-[rgba(255,255,255,0.06)] p-1.5 flex items-center justify-center group-hover:bg-[#1e3350] transition-colors">
                                        <img :src="item.logo" :alt="item.name" class="w-full h-full object-contain" onerror="this.style.display='none'">
                                    </div>
                                    <h4 class="font-bold text-sm text-[#f1f5f9]" x-text="item.name"></h4>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="selectedTemplate" style="display: none;" class="p-4 sm:p-5 border border-[rgba(255,255,255,0.06)] bg-[#111c2e] rounded-xl">
                            <div class="flex items-center gap-4 mb-6">
                                <button type="button" @click="selectedTemplate = null" class="bg-[#0b121f] text-white border border-[rgba(255,255,255,0.06)] hover:bg-[#192a42] py-1.5 px-4 text-xs flex items-center gap-2 rounded-xl transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                    Kembali
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-5 mb-6">
                                <div class="w-16 h-16 rounded-xl bg-[#192a42] border border-[rgba(255,255,255,0.06)] p-2 flex items-center justify-center">
                                    <template x-if="selectedTemplate?.logo">
                                        <img :src="selectedTemplate.logo" class="w-full h-full object-contain" onerror="this.style.display='none'">
                                    </template>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-black text-[#f1f5f9]" x-text="selectedTemplate?.name"></h2>
                                    <p class="text-sm text-[#94a3b8] mt-1 flex items-center">
                                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                                        <span x-text="selectedTemplate?.category"></span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="bg-[#080d19] p-4 rounded-xl border border-[rgba(255,255,255,0.06)] mb-6">
                                <h4 class="font-bold text-sm mb-3 text-[#94a3b8] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                                    Pilih Paket Tersedia
                                </h4>
                                <div class="space-y-2 max-h-64 overflow-y-auto pr-1" style="scrollbar-width: thin;">
                                    <template x-for="(plan, index) in selectedTemplate?.plans" :key="index">
                                        <label class="flex flex-col sm:flex-row sm:items-center justify-between p-3 border rounded-xl cursor-pointer transition-all"
                                               :class="Number(selectedPlanIndex) === index ? 'border-emerald-500 bg-emerald-500/5 ring-1 ring-emerald-500' : 'border-[rgba(255,255,255,0.06)] hover:border-[#4b5e78]'">
                                            <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                                <input type="radio" name="plan_selection" :value="index" x-model="selectedPlanIndex" class="w-4 h-4" style="accent-color: #10b981;">
                                                <span class="font-bold" :class="Number(selectedPlanIndex) === index ? 'text-[#f1f5f9]' : 'text-[#94a3b8]'" x-text="plan.name"></span>
                                            </div>
                                            <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto pl-7 sm:pl-0">
                                                <span class="text-xs text-[#4b5e78] mr-3" x-text="plan.cycle === 'yearly' ? 'Per Tahun' : 'Per Bulan'"></span>
                                                <span class="font-mono font-bold text-lg text-emerald-400" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(plan.price)"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                            
                            <div class="flex justify-end border-t border-[rgba(255,255,255,0.06)] pt-4">
                                <button type="button" @click="applyTemplate()" class="bg-gradient-to-r from-emerald-500 to-cyan-500 text-white w-full sm:w-auto py-3 px-6 rounded-xl font-bold text-sm shadow-lg shadow-emerald-500/20 hover:from-emerald-400 hover:to-cyan-400 transition-all">
                                    Gunakan Template
                                </button>
                            </div>
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
            templates: {!! $templatesJson !!},
            categoryMap: {!! $categoryMap !!},
            activeCategory: 'Film & Streaming',
            selectedTemplate: null,
            selectedPlanIndex: 0,
            
            openModal() { this.showModal = true; },
            closeModal() { this.showModal = false; this.selectedTemplate = null; },
            
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
                    
                let categoryId = this.categoryMap[this.selectedTemplate.category] || '';
                
                this.form.name = name;
                if(categoryId) this.form.category_id = categoryId;
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
                let id = this.categoryMap[name];
                if(id) {
                    this.form.category_id = id;
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

            getCategoryName() {
                const select = document.getElementById('select_category');
                if(select && select.options[select.selectedIndex] && select.value !== '') {
                    return select.options[select.selectedIndex].text;
                }
                return 'Pilih Kategori';
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
                
                // Simplified reminder date logic for display
                if(remDate <= 0) {
                    remDate += 30; // approx
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