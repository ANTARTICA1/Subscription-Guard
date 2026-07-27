@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<h2 class="text-xl font-bold mb-6" style="color: var(--text-primary);">Masuk ke Akun</h2>

@if($errors->any())
<div class="mb-4 p-3 rounded-xl" style="background: var(--danger-bg); border: 1px solid var(--danger); color: var(--danger); font-size: 0.85rem;">
    {{ $errors->first() }}
</div>
@endif

@if(session('status'))
<div class="mb-4 p-3 rounded-xl" style="background: var(--success-bg); border: 1px solid var(--success); color: var(--success); font-size: 0.85rem;">
    {{ session('status') }}
</div>
@endif

<form method="POST" action="{{ url('/login') }}">
    @csrf
    <div class="mb-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@email.com" required autofocus>
    </div>
    <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
    </div>
    <div class="flex items-center justify-between mb-6">
        <label class="flex items-center gap-2 cursor-pointer text-sm" style="color: var(--text-secondary);">
            <input type="checkbox" name="remember" class="rounded" style="accent-color: var(--accent-primary);">
            Ingat saya
        </label>
        <a href="{{ route('password.request') }}" class="text-sm font-medium" style="color: var(--accent-primary);">Lupa password?</a>
    </div>
    <button type="submit" class="btn-primary w-full justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
        Masuk
    </button>
</form>
@endsection

@section('footer')
Belum punya akun? <a href="{{ route('register') }}" class="font-semibold" style="color: var(--accent-primary);">Daftar sekarang</a>
@endsection
