@extends('layouts.app')
@section('title', 'Komparasi Subscriptions')
@section('heading', 'Komparasi Subscriptions')
@section('subheading', 'Bandingkan harga, fitur, dan nilai terbaik dari layanan populer')

@section('content')

@php
$allTemplates = [];
foreach($templates as $category => $items) {
    foreach($items as $item) {
        foreach($item['plans'] as $plan) {
            $allTemplates[] = [
                'type' => 'template',
                'id' => 't_' . md5($item['name'] . $plan['name']),
                'name' => $item['name'] . ' - ' . $plan['name'],
                'logo' => $item['logo'],
                'price' => $plan['price'],
                'cycle' => $plan['cycle'] ?? 'monthly',
                'category' => $category,
                'source' => 'Template'
            ];
        }
    }
}
$mySubs = [];
foreach($mySubscriptions as $sub) {
    $mySubs[] = [
        'type' => 'mysub',
        'id' => 'm_' . $sub->id,
        'name' => $sub->name,
        'logo' => null,
        'price' => $sub->amount,
        'cycle' => $sub->billing_cycle,
        'category' => $sub->category->name ?? 'Lainnya',
        'source' => 'Langganan Saya'
    ];
}
$availableOptions = array_merge($mySubs, $allTemplates);
@endphp

<div class="max-w-5xl space-y-8" x-data="smartCompare()">
    
    <div class="card p-6 border border-[var(--border-color)]">
        <h3 class="section-title mb-2">Smart Compare</h3>
        <p class="text-sm text-[var(--text-muted)] mb-6">Bandingkan langganan Anda saat ini dengan pilihan dari template yang tersedia.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="form-label">Pilih Layanan 1</label>
                <select x-model="selectedItem1Id" class="form-input bg-[var(--bg-primary)]">
                    <option value="">-- Pilih Layanan --</option>
                    <optgroup label="Langganan Saya">
                        <template x-for="opt in options.filter(o => o.type === 'mysub')" :key="opt.id">
                            <option :value="opt.id" x-text="opt.name + ' (' + formatRupiah(opt.price) + ')'"></option>
                        </template>
                    </optgroup>
                    <optgroup label="Template Tersedia">
                        <template x-for="opt in options.filter(o => o.type === 'template')" :key="opt.id">
                            <option :value="opt.id" x-text="opt.name + ' (' + formatRupiah(opt.price) + ')'"></option>
                        </template>
                    </optgroup>
                </select>
            </div>
            <div>
                <label class="form-label">Pilih Layanan 2</label>
                <select x-model="selectedItem2Id" class="form-input bg-[var(--bg-primary)]">
                    <option value="">-- Pilih Layanan --</option>
                    <optgroup label="Langganan Saya">
                        <template x-for="opt in options.filter(o => o.type === 'mysub')" :key="opt.id">
                            <option :value="opt.id" x-text="opt.name + ' (' + formatRupiah(opt.price) + ')'"></option>
                        </template>
                    </optgroup>
                    <optgroup label="Template Tersedia">
                        <template x-for="opt in options.filter(o => o.type === 'template')" :key="opt.id">
                            <option :value="opt.id" x-text="opt.name + ' (' + formatRupiah(opt.price) + ')'"></option>
                        </template>
                    </optgroup>
                </select>
            </div>
        </div>

        <div x-show="item1 && item2" class="overflow-x-auto rounded-xl border border-[var(--border-color)]" x-cloak>
            <table class="w-full text-sm text-left">
                <thead class="bg-[var(--bg-elevated)] border-b border-[var(--border-color)]">
                    <tr>
                        <th class="p-4 font-semibold text-[var(--text-muted)] w-1/3">Parameter</th>
                        <th class="p-4 w-1/3 border-l border-[var(--border-color)]">
                            <div class="flex items-center gap-2">
                                <template x-if="item1.logo">
                                    <img :src="item1.logo" class="w-6 h-6 rounded-md bg-white p-0.5 border border-[var(--border-color)]">
                                </template>
                                <div>
                                    <span class="font-bold text-base text-[var(--text-primary)] block" x-text="item1.name"></span>
                                    <span class="text-[10px] uppercase font-bold text-[var(--text-muted)]" x-text="item1.source"></span>
                                </div>
                            </div>
                        </th>
                        <th class="p-4 w-1/3 border-l border-[var(--border-color)]">
                            <div class="flex items-center gap-2">
                                <template x-if="item2.logo">
                                    <img :src="item2.logo" class="w-6 h-6 rounded-md bg-white p-0.5 border border-[var(--border-color)]">
                                </template>
                                <div>
                                    <span class="font-bold text-base text-[var(--text-primary)] block" x-text="item2.name"></span>
                                    <span class="text-[10px] uppercase font-bold text-[var(--text-muted)]" x-text="item2.source"></span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-[var(--border-color)] bg-[var(--bg-primary)]">
                        <td class="p-4 font-semibold text-[var(--text-secondary)]">Kategori</td>
                        <td class="p-4 border-l border-[var(--border-color)]" x-text="item1.category"></td>
                        <td class="p-4 border-l border-[var(--border-color)]" x-text="item2.category"></td>
                    </tr>
                    <tr class="border-b border-[var(--border-color)] bg-[var(--bg-primary)]">
                        <td class="p-4 font-semibold text-[var(--text-secondary)]">Siklus Pembayaran</td>
                        <td class="p-4 border-l border-[var(--border-color)] capitalize" x-text="item1.cycle"></td>
                        <td class="p-4 border-l border-[var(--border-color)] capitalize" x-text="item2.cycle"></td>
                    </tr>
                    <tr class="border-b border-[var(--border-color)] bg-[var(--bg-primary)]">
                        <td class="p-4 font-semibold text-[var(--text-secondary)]">Harga (Per Bulan)</td>
                        <td class="p-4 border-l border-[var(--border-color)]">
                            <span class="font-bold block" :class="item1IsCheaper ? 'text-[var(--success)] text-lg' : 'text-[var(--text-primary)]'" x-text="formatRupiah(getMonthlyPrice(item1))"></span>
                            <span x-show="item1IsCheaper" class="badge badge-accent mt-1 text-[10px]">LEBIH HEMAT</span>
                        </td>
                        <td class="p-4 border-l border-[var(--border-color)]">
                            <span class="font-bold block" :class="item2IsCheaper ? 'text-[var(--success)] text-lg' : 'text-[var(--text-primary)]'" x-text="formatRupiah(getMonthlyPrice(item2))"></span>
                            <span x-show="item2IsCheaper" class="badge badge-accent mt-1 text-[10px]">LEBIH HEMAT</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div x-show="!item1 || !item2" class="text-center py-8 text-[var(--text-muted)] text-sm border-2 border-dashed border-[var(--border-color)] rounded-xl bg-[var(--bg-primary)]" x-cloak>
            Pilih dua layanan pada dropdown di atas untuk melihat perbandingan secara instan.
        </div>
    </div>

    
    <div class="flex items-center gap-2 mb-2 mt-10">
        <h2 class="text-xl font-bold text-[var(--text-primary)]">Rekomendasi Terbaik</h2>
    </div>
    
    @foreach($comparisons as $group)
    <div class="card p-0 overflow-hidden mb-8 border border-[var(--border-color)]">
        <div class="p-5 border-b border-[var(--border-color)] flex items-center gap-4 bg-[var(--bg-elevated)]">
            <span class="text-2xl flex items-center justify-center p-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-primary)]">{!! $group['icon'] !!}</span>
            <div>
                <h3 class="section-title mb-0">{{ $group['category'] }}</h3>
                <p class="text-sm text-[var(--text-muted)] mt-1">{{ $group['description'] }}</p>
            </div>
        </div>
        
        <div class="overflow-x-auto bg-[var(--bg-primary)]">
            <table class="w-full text-sm text-left">
                <thead class="bg-[var(--bg-primary)] border-b border-[var(--border-color)]">
                    <tr>
                        <th class="p-5 font-semibold text-[var(--text-muted)] w-1/4">Parameter</th>
                        @foreach($group['items'] as $item)
                        <th class="p-5 w-1/4 border-l border-[var(--border-color)]">
                            @if(!empty($item['is_best_value']))
                            <span class="badge text-[10px] mb-2 inline-flex items-center gap-1 font-bold" style="background: var(--accent-primary); color: white;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                SKOR TERTINGGI
                            </span>
                            @endif
                            <div class="flex items-center gap-3 mb-1">
                                @if(isset($item['logo']))
                                <img src="{{ $item['logo'] }}" class="w-8 h-8 rounded-md bg-white p-1 border border-[var(--border-color)] object-contain">
                                @endif
                                <span class="font-bold text-lg text-[var(--text-primary)]">{{ $item['name'] }}</span>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-[var(--border-color)] hover:bg-[var(--bg-elevated)] transition-colors">
                        <td class="p-5 font-semibold text-[var(--text-secondary)]">Harga</td>
                        @foreach($group['items'] as $item)
                        <td class="p-5 border-l border-[var(--border-color)]">
                            <span class="font-bold {{ !empty($item['is_cheapest']) ? 'text-[var(--success)] text-lg' : 'text-[var(--text-primary)]' }}">{{ $item['price_monthly'] }}</span>
                            @if(!empty($item['is_cheapest']))
                            <span class="text-[10px] text-[var(--success)] ml-1 font-bold uppercase block mt-1">(Termurah)</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-[var(--border-color)] hover:bg-[var(--bg-elevated)] transition-colors">
                        <td class="p-5 font-semibold text-[var(--text-secondary)]">Skor Nilai (0-100)</td>
                        @foreach($group['items'] as $item)
                        <td class="p-5 border-l border-[var(--border-color)]">
                            <span class="badge {{ !empty($item['is_best_value']) ? 'badge-active' : 'bg-[var(--bg-elevated)] text-[var(--text-secondary)] border border-[var(--border-color)]' }} text-sm py-1 px-3">{{ $item['value_score'] }}</span>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="border-b border-[var(--border-color)] hover:bg-[var(--bg-elevated)] transition-colors">
                        <td class="p-5 font-semibold text-[var(--text-secondary)] align-top">Fitur Unggulan</td>
                        @foreach($group['items'] as $item)
                        <td class="p-5 border-l border-[var(--border-color)] align-top">
                            <ul class="space-y-3">
                                @foreach($item['features'] as $feat)
                                <li class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--success)] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    <span class="text-sm text-[var(--text-secondary)]">{{ $feat }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        @endforeach
                    </tr>
                    <tr class="hover:bg-[var(--bg-elevated)] transition-colors">
                        <td class="p-5 font-semibold text-[var(--text-secondary)] align-top">Cocok Untuk</td>
                        @foreach($group['items'] as $item)
                        <td class="p-5 border-l border-[var(--border-color)] align-top">
                            <p class="text-sm text-[var(--text-muted)] leading-relaxed italic">"{{ $item['best_for'] }}"</p>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

<script>
function smartCompare() {
    return {
        options: @json($availableOptions),
        selectedItem1Id: '',
        selectedItem2Id: '',
        
        get item1() {
            return this.options.find(o => o.id === this.selectedItem1Id);
        },
        get item2() {
            return this.options.find(o => o.id === this.selectedItem2Id);
        },
        get item1IsCheaper() {
            if(!this.item1 || !this.item2) return false;
            let p1 = this.getMonthlyPrice(this.item1);
            let p2 = this.getMonthlyPrice(this.item2);
            return p1 < p2;
        },
        get item2IsCheaper() {
            if(!this.item1 || !this.item2) return false;
            let p1 = this.getMonthlyPrice(this.item1);
            let p2 = this.getMonthlyPrice(this.item2);
            return p2 < p1;
        },
        getMonthlyPrice(item) {
            let p = parseFloat(item.price);
            if(item.cycle === 'yearly') return p / 12;
            if(item.cycle === 'weekly') return p * 4;
            return p;
        },
        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(number);
        }
    }
}
</script>
@endsection
