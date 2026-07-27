@extends('layouts.app')
@section('title', 'Tambah Subscription')
@section('heading', 'Tambah Subscription')
@section('subheading', 'Isi formulir atau pilih preset populer')

@section('content')
<div class="max-w-3xl">
    
    <div class="card mb-6" x-data="{
        fillPreset(name, categoryId, amount, cycle, payDate) {
            document.getElementById('input_name').value = name;
            document.getElementById('select_category').value = categoryId;
            document.getElementById('input_amount').value = amount;
            document.getElementById('select_cycle').value = cycle;
            document.getElementById('input_paydate').value = payDate;
        }
    }">
        <h3 class="text-xs font-bold uppercase tracking-wider mb-3" style="color: var(--text-muted);"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Preset Cepat</h3>
        <div class="flex flex-wrap gap-2">
            <button type="button" @click="fillPreset('Netflix', 1, 186000, 'monthly', 25)" class="btn-secondary text-xs py-1.5 px-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /></svg> Netflix</button>
            <button type="button" @click="fillPreset('Spotify Premium', 1, 54990, 'monthly', 28)" class="btn-secondary text-xs py-1.5 px-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg> Spotify</button>
            <button type="button" @click="fillPreset('Disney+ Hotstar', 1, 159000, 'yearly', 15)" class="btn-secondary text-xs py-1.5 px-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg> Disney+</button>
            <button type="button" @click="fillPreset('ChatGPT Plus', 6, 315000, 'monthly', 1)" class="btn-secondary text-xs py-1.5 px-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg> ChatGPT</button>
            <button type="button" @click="fillPreset('IndiHome Broadband', 2, 330000, 'monthly', 10)" class="btn-secondary text-xs py-1.5 px-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg> IndiHome</button>
            <button type="button" @click="fillPreset('YouTube Premium', 1, 59000, 'monthly', 20)" class="btn-secondary text-xs py-1.5 px-3">▶️ YouTube</button>
            <button type="button" @click="fillPreset('iCloud 200GB', 6, 45000, 'monthly', 5)" class="btn-secondary text-xs py-1.5 px-3"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>️ iCloud</button>
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
