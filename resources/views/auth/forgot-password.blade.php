@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
<h2 class="text-xl font-bold mb-2" style="color: var(--text-primary);">Lupa Password?</h2>
<p class="text-sm mb-6" style="color: var(--text-muted);">Masukkan email Anda untuk menerima link reset password.</p>

@if(session('status'))
<div class="mb-4 p-3 rounded-xl" style="background: var(--success-bg); border: 1px solid var(--success); color: var(--success); font-size: 0.85rem;">
    {{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@email.com" required>
    </div>

    <button type="submit" class="btn-primary w-full justify-center">Kirim Link Reset</button>
</form>
@endsection

@section('footer')
<a href="{{ route('login') }}" class="font-semibold" style="color: var(--accent-primary);">← Kembali ke Login</a>
@endsection
