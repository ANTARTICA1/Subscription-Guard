@extends('layouts.app')
@section('title', 'Edit ' . $subscription->name)
@section('heading', 'Edit Subscription')
@section('subheading', $subscription->name)

@section('content')
<div class="max-w-2xl">
    <div class="card">
        @if($errors->any())
        <div class="mb-6 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('subscriptions.update', $subscription) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="logo" value="{{ old('logo', $subscription->logo) }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="form-label text-[#94a3b8]">Nama Subscription *</label>
                    <input type="text" name="name" value="{{ old('name', $subscription->name) }}" class="form-input" required>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Kategori *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $subscription->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Nominal (IDR) *</label>
                    <input type="number" name="amount" value="{{ old('amount', $subscription->amount) }}" class="form-input" min="0" step="1000" required>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Mata Uang</label>
                    <select name="currency" class="form-select">
                        <option value="IDR" {{ old('currency', $subscription->currency) == 'IDR' ? 'selected' : '' }}>IDR</option>
                        <option value="USD" {{ old('currency', $subscription->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Siklus Billing *</label>
                    <select name="billing_cycle" class="form-select" required>
                        <option value="monthly" {{ old('billing_cycle', $subscription->billing_cycle) == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ old('billing_cycle', $subscription->billing_cycle) == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        <option value="weekly" {{ old('billing_cycle', $subscription->billing_cycle) == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="daily" {{ old('billing_cycle', $subscription->billing_cycle) == 'daily' ? 'selected' : '' }}>Harian</option>
                    </select>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Tanggal Pembayaran *</label>
                    <input type="number" name="payment_date" value="{{ old('payment_date', $subscription->payment_date) }}" class="form-input" min="1" max="31" required>
                    <p class="text-[11px] mt-1 text-[#4b5e78]">Tgl jatuh tempo tagihan (contoh: isi 25 jika ditagih tiap tgl 25)</p>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Tanggal Mulai *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $subscription->start_date->format('Y-m-d')) }}" class="form-input" required>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Tanggal Berakhir</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $subscription->end_date?->format('Y-m-d')) }}" class="form-input">
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Ingatkan H-</label>
                    <input type="number" name="reminder_days" value="{{ old('reminder_days', $subscription->reminder_days) }}" class="form-input" min="1" max="30" required>
                    <p class="text-[11px] mt-1 text-[#4b5e78]">Contoh: isi 3 untuk notifikasi 3 hari sebelum jatuh tempo</p>
                </div>

                <div>
                    <label class="form-label text-[#94a3b8]">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $subscription->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="cancelled" {{ old('status', $subscription->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="form-label text-[#94a3b8]">Deskripsi</label>
                    <textarea name="description" class="form-input" rows="3">{{ old('description', $subscription->description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-[rgba(255,255,255,0.06)] hover:border-[rgba(255,255,255,0.1)] transition-colors">
                        <input type="hidden" name="auto_renew" value="0">
                        <input type="checkbox" name="auto_renew" value="1" {{ old('auto_renew', $subscription->auto_renew) ? 'checked' : '' }}
                               class="w-4 h-4 rounded" style="accent-color: #10b981;">
                        <div>
                            <span class="text-sm font-semibold text-[#f1f5f9]">Auto Renewal</span>
                            <p class="text-xs text-[#4b5e78]">Subscription diperpanjang otomatis</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 mt-8 pt-4 border-t border-[rgba(255,255,255,0.06)]">
                <button type="submit" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('subscriptions.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
