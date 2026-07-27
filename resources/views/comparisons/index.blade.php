@extends('layouts.app')
@section('title', 'Komparasi Subscriptions')
@section('heading', 'Komparasi Subscriptions')
@section('subheading', 'Bandingkan harga, fitur, dan nilai terbaik dari layanan populer')

@section('content')
<div class="max-w-5xl space-y-8" x-data="customComparison()">
    {{-- Custom Comparison Builder --}}
    <div class="card">
        <h3 class="section-title mb-5">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                Buat Komparasi Sendiri
            </div>
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 rounded-xl border border-[var(--border-color)] bg-[var(--bg-primary)]">
            <div>
                <label class="form-label">Nama Layanan</label>
                <input type="text" x-model="newItem.name" class="form-input" placeholder="Misal: Netflix Biasa">
            </div>
            <div>
                <label class="form-label">Harga (Rp)</label>
                <input type="number" x-model="newItem.price" class="form-input" placeholder="Misal: 50000">
            </div>
            <div class="md:col-span-2">
                <label class="form-label">Fitur Utama (Pisahkan dengan koma)</label>
                <input type="text" x-model="newItem.features" class="form-input" placeholder="Misal: 4K, 4 Layar, Tanpa Iklan">
            </div>
            <div class="md:col-span-2 flex justify-end mt-2">
                <button @click="addItem()" class="btn-primary" :disabled="!newItem.name || !newItem.price">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah ke Komparasi
                </button>
            </div>
        </div>

        <div x-show="items.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-4" x-cloak>
            <template x-for="(item, index) in items" :key="index">
                <div class="p-5 rounded-xl border border-[var(--border-color)] bg-[var(--bg-primary)] flex flex-col justify-between relative">
                    <button @click="removeItem(index)" class="absolute top-3 right-3 text-red-500 hover:bg-red-500/10 p-1 rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    <div>
                        <h4 class="font-bold text-sm text-[var(--text-primary)] mb-2" x-text="item.name"></h4>
                        <p class="text-xs font-bold mb-4 text-[var(--accent-primary)]">Rp<span x-text="new Intl.NumberFormat('id-ID').format(item.price)"></span></p>
                        <ul class="space-y-1.5 text-xs mb-4 text-[var(--text-secondary)]">
                            <template x-for="(feat, fIdx) in item.features.split(',')" :key="fIdx">
                                <li class="flex items-center gap-2" x-show="feat.trim() !== ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    <span x-text="feat.trim()"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
        <div x-show="items.length === 0" class="text-center py-6 text-[var(--text-muted)] text-sm border-2 border-dashed border-[var(--border-color)] rounded-xl" x-cloak>
            Tambahkan layanan di atas untuk mulai membandingkan.
        </div>
    </div>

    {{-- Predefined Comparisons --}}
    @foreach($comparisons as $group)
    <div class="card">
        <div class="flex items-center gap-3 mb-5">
            <span class="text-2xl flex items-center justify-center p-2 rounded-xl" style="background: var(--bg-elevated); border: 1px solid var(--border-color);">{!! $group['icon'] !!}</span>
            <div>
                <h3 class="section-title">{{ $group['category'] }}</h3>
                <p class="section-desc">{{ $group['description'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($group['items'] as $idx => $item)
            <div class="p-5 rounded-xl border flex flex-col justify-between transition-all duration-500 hover:scale-[1.02]"
                 style="background: var(--bg-primary); border-color: {{ $idx === 0 ? 'var(--accent-primary)' : 'var(--border-color)' }}; {{ $idx === 0 ? 'box-shadow: 0 0 20px var(--accent-glow);' : '' }}">
                <div>
                    @if($idx === 0)
                    <span class="badge badge-accent text-xs mb-2 flex items-center gap-1 w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        BEST VALUE
                    </span>
                    @endif
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-sm" style="color: var(--text-primary);">{{ $item['name'] }}</h4>
                        <span class="badge badge-active">{{ $item['value_score'] }}</span>
                    </div>
                    <p class="text-xs font-bold mb-4" style="color: var(--accent-primary);">{{ $item['price_monthly'] }}</p>
                    <ul class="space-y-1.5 text-xs mb-4" style="color: var(--text-secondary);">
                        @foreach($item['features'] as $feat)
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" style="color: var(--success);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="pt-3 text-xs" style="border-top: 1px solid var(--border-color); color: var(--text-muted);">
                    <span class="font-semibold" style="color: var(--text-primary);">Terbaik Untuk:</span> {{ $item['best_for'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script>
function customComparison() {
    return {
        items: [],
        newItem: {
            name: '',
            price: '',
            features: ''
        },
        addItem() {
            if (this.newItem.name && this.newItem.price) {
                this.items.push({ ...this.newItem });
                this.newItem = { name: '', price: '', features: '' };
            }
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }
}
</script>
@endsection
