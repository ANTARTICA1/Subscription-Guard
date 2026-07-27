@extends('layouts.app')
@section('title', 'Tambah Subscription')
@section('heading', 'Tambah Subscription')
@section('subheading', 'Isi formulir atau pilih preset populer')

@section('content')
<div class="max-w-3xl">
    
    @php
        $categoryMap = $categories->pluck('id', 'name')->toJson();
        $templatesJson = json_encode($templates ?? []);
    @endphp
    
    <div x-data="{
        showModal: false,
        templates: {{ $templatesJson }},
        categoryMap: {{ $categoryMap }},
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
            
            document.getElementById('input_name').value = name;
            
            let catSelect = document.getElementById('select_category');
            if(categoryId) {
                catSelect.value = categoryId;
            }
            
            document.getElementById('input_amount').value = plan.price;
            document.getElementById('select_cycle').value = plan.cycle || 'monthly';
            
            this.closeModal();
        }
    }">
        <div class="card mb-6 flex items-center justify-between">
            <div>
                <h3 class="font-bold flex items-center gap-2" style="color: var(--text-primary);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    Pilih Template Cepat
                </h3>
                <p class="text-xs mt-1" style="color: var(--text-muted);">Isi otomatis nama dan harga dari layanan populer</p>
            </div>
            <button type="button" @click="openModal()" class="btn-primary py-2 px-4 text-sm whitespace-nowrap">
                Telusuri Template
            </button>
        </div>

        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-75" @click="closeModal()"></div>
                
                <div x-show="showModal" x-transition.scale class="relative inline-block w-full max-w-4xl p-4 sm:p-6 overflow-hidden text-left align-middle transition-all transform bg-[var(--bg-secondary)] shadow-xl rounded-2xl border border-[var(--border-color)]">
                    <div class="flex justify-between items-center mb-5 border-b border-[var(--border-color)] pb-3">
                        <h3 class="text-lg font-bold text-[var(--text-primary)]">Template Subscription</h3>
                        <button @click="closeModal()" class="text-2xl text-[var(--text-muted)] hover:text-white">&times;</button>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-4 sm:gap-6 h-[70vh] sm:h-[60vh]">
                        <!-- Sidebar -->
                        <div class="w-full md:w-1/4 overflow-y-auto border-b md:border-b-0 md:border-r border-[var(--border-color)] pb-4 md:pb-0 md:pr-4 flex md:flex-col flex-row gap-2" style="scrollbar-width: thin;">
                            <template x-for="(items, categoryName) in templates" :key="categoryName">
                                <button @click="activeCategory = categoryName; selectedTemplate = null;"
                                        :class="activeCategory === categoryName ? 'bg-[var(--accent-primary)] text-white shadow-lg' : 'text-[var(--text-secondary)] hover:bg-[var(--bg-elevated)]'"
                                        class="flex-shrink-0 w-auto md:w-full text-left px-4 py-2.5 rounded-xl mb-1 text-sm font-semibold transition-all whitespace-nowrap md:whitespace-normal"
                                        x-text="categoryName">
                                </button>
                            </template>
                        </div>
                        
                        <!-- Content -->
                        <div class="w-full md:w-3/4 overflow-y-auto pb-4 pr-1">
                            <div x-show="!selectedTemplate" class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                                <template x-for="item in templates[activeCategory]" :key="item.name">
                                    <div @click="selectTemplate(item)" class="cursor-pointer border border-[var(--border-color)] bg-[var(--bg-elevated)] p-4 rounded-xl hover:border-[var(--accent-primary)] hover:shadow-lg transition-all text-center flex flex-col items-center justify-center gap-3">
                                        <img :src="item.logo" :alt="item.name" class="w-12 h-12 object-contain bg-white rounded-lg p-1.5 shadow-sm" onerror="this.style.display='none'">
                                        <h4 class="font-bold text-sm text-[var(--text-primary)]" x-text="item.name"></h4>
                                    </div>
                                </template>
                            </div>
                            
                            <div x-show="selectedTemplate" style="display: none;" class="p-4 sm:p-5 border border-[var(--border-color)] bg-[var(--bg-elevated)] rounded-xl">
                                <div class="flex items-center gap-4 mb-6">
                                    <button @click="selectedTemplate = null" class="btn-secondary py-1.5 px-4 text-xs flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                        Kembali
                                    </button>
                                </div>
                                
                                <div class="flex items-center gap-5 mb-6">
                                    <img x-bind:src="selectedTemplate?.logo" class="w-16 h-16 object-contain bg-white rounded-xl p-2 shadow-sm" onerror="this.style.display='none'">
                                    <div>
                                        <h2 class="text-xl sm:text-2xl font-black text-[var(--text-primary)]" x-text="selectedTemplate?.name"></h2>
                                        <p class="text-sm text-[var(--text-muted)] mt-1">
                                            <span class="inline-block w-2 h-2 rounded-full bg-[var(--accent-primary)] mr-1"></span>
                                            <span x-text="selectedTemplate?.category"></span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-[var(--bg-primary)] p-4 rounded-xl border border-[var(--border-color)] mb-6">
                                    <h4 class="font-bold text-sm mb-3 text-[var(--text-secondary)] flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                                        Pilih Paket Tersedia
                                    </h4>
                                    <div class="space-y-2 max-h-64 overflow-y-auto pr-1" style="scrollbar-width: thin;">
                                        <template x-for="(plan, index) in selectedTemplate?.plans" :key="index">
                                            <label class="flex flex-col sm:flex-row sm:items-center justify-between p-3 border rounded-xl cursor-pointer transition-all"
                                                   :class="Number(selectedPlanIndex) === index ? 'border-[var(--accent-primary)] bg-[var(--bg-elevated)] ring-1 ring-[var(--accent-primary)]' : 'border-[var(--border-color)] hover:border-[var(--text-muted)]'">
                                                <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                                    <input type="radio" name="plan_selection" :value="index" x-model="selectedPlanIndex" class="w-4 h-4" style="accent-color: var(--accent-primary);">
                                                    <span class="font-bold text-[var(--text-primary)]" x-text="plan.name"></span>
                                                </div>
                                                <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto pl-7 sm:pl-0">
                                                    <span class="text-xs text-[var(--text-muted)] mr-3" x-text="plan.cycle === 'yearly' ? 'Per Tahun' : 'Per Bulan'"></span>
                                                    <span class="font-mono font-bold text-lg text-[var(--accent-primary)]" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(plan.price)"></span>
                                                </div>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end border-t border-[var(--border-color)] pt-4">
                                    <button @click="applyTemplate()" class="btn-primary w-full sm:w-auto py-3 px-6 shadow-lg shadow-blue-500/20">
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

    
    <div class="card">
        @if($errors->any())
        <div class="mb-6 p-3 rounded-xl" style="background: var(--danger-bg); border: 1px solid var(--danger); color: var(--danger); font-size: 0.85rem;">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('subscriptions.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="form-label">Nama Subscription *</label>
                    <input type="text" id="input_name" name="name" value="{{ old('name') }}" class="form-input" placeholder="Contoh: Netflix Premium" required>
                </div>
                <div>
                    <label class="form-label">Kategori *</label>
                    <select id="select_category" name="category_id" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Nominal (IDR) *</label>
                    <input type="number" id="input_amount" name="amount" value="{{ old('amount') }}" class="form-input" placeholder="186000" min="0" step="1000" required>
                </div>
                <div>
                    <label class="form-label">Mata Uang</label>
                    <select name="currency" class="form-select">
                        <option value="IDR" {{ old('currency', 'IDR') == 'IDR' ? 'selected' : '' }}>IDR - Rupiah</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - Dollar</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Siklus Billing *</label>
                    <select id="select_cycle" name="billing_cycle" class="form-select" required>
                        <option value="monthly" {{ old('billing_cycle', 'monthly') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        <option value="weekly" {{ old('billing_cycle') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="daily" {{ old('billing_cycle') == 'daily' ? 'selected' : '' }}>Harian</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Tanggal Pembayaran *</label>
                    <input type="number" id="input_paydate" name="payment_date" value="{{ old('payment_date', 1) }}" class="form-input" placeholder="1-31" min="1" max="366" required>
                    <p class="text-xs mt-1" style="color: var(--text-muted);">Hari ke-berapa dalam siklus</p>
                </div>
                <div>
                    <label class="form-label">Tanggal Mulai *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Tanggal Berakhir</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-input">
                    <p class="text-xs mt-1" style="color: var(--text-muted);">Kosongkan jika tanpa batas</p>
                </div>
                <div>
                    <label class="form-label">Ingatkan H- Hari</label>
                    <input type="number" name="reminder_days" value="{{ old('reminder_days', 3) }}" class="form-input" min="1" max="30" required>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-input" rows="2" placeholder="Catatan opsional...">{{ old('description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="auto_renew" value="0">
                        <input type="checkbox" name="auto_renew" value="1" {{ old('auto_renew', true) ? 'checked' : '' }} class="w-4 h-4 rounded" style="accent-color: var(--accent-primary);">
                        <div>
                            <span class="text-sm font-semibold" style="color: var(--text-primary);">Auto Renewal</span>
                            <p class="text-xs" style="color: var(--text-muted);">Subscription diperpanjang otomatis oleh penyedia</p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-8 pt-4" style="border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn-primary"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg> Simpan</button>
                <a href="{{ route('subscriptions.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
