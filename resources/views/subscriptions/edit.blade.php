@extends('layouts.app')
@section('title', 'Edit ' . $subscription->name)
@section('heading', 'Edit Subscription')
@section('subheading', $subscription->name)

@section('content')
<div class="max-w-2xl">
    <div class="card">
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; font-size: 0.85rem;">
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
                    <label class="form-label">Nama Subscription *</label>
                    <input type="text" name="name" value="{{ old('name', $subscription->name) }}" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Kategori *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $subscription->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Nominal (IDR) *</label>
                    <input type="number" name="amount" value="{{ old('amount', $subscription->amount) }}" class="form-input" min="0" step="1000" required>
                </div>

                <div>
                    <label class="form-label">Mata Uang</label>
                    <select name="currency" class="form-select">
                        <option value="IDR" {{ old('currency', $subscription->currency) == 'IDR' ? 'selected' : '' }}>IDR</option>
                        <option value="USD" {{ old('currency', $subscription->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Siklus Billing *</label>
                    <select name="billing_cycle" class="form-select" required>
                        <option value="monthly" {{ old('billing_cycle', $subscription->billing_cycle) == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ old('billing_cycle', $subscription->billing_cycle) == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        <option value="weekly" {{ old('billing_cycle', $subscription->billing_cycle) == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="daily" {{ old('billing_cycle', $subscription->billing_cycle) == 'daily' ? 'selected' : '' }}>Harian</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Tanggal Pembayaran *</label>
                    <input type="number" name="payment_date" value="{{ old('payment_date', $subscription->payment_date) }}" class="form-input" min="1" max="366" required>
                </div>

                <div>
                    <label class="form-label">Tanggal Mulai *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $subscription->start_date->format('Y-m-d')) }}" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Tanggal Berakhir</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $subscription->end_date?->format('Y-m-d')) }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">Ingatkan H-</label>
                    <input type="number" name="reminder_days" value="{{ old('reminder_days', $subscription->reminder_days) }}" class="form-input" min="1" max="30" required>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $subscription->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="cancelled" {{ old('status', $subscription->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-input" rows="3">{{ old('description', $subscription->description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="auto_renew" value="0">
                        <input type="checkbox" name="auto_renew" value="1" {{ old('auto_renew', $subscription->auto_renew) ? 'checked' : '' }}
                               class="w-5 h-5 rounded" style="accent-color: var(--accent-primary);">
                        <div>
                            <span class="text-sm font-medium" style="color: var(--text-primary);">Auto Renewal</span>
                            <p class="text-xs" style="color: var(--text-muted);">Subscription diperpanjang otomatis</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('subscriptions.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
