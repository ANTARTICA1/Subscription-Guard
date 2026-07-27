@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<h2 class="text-xl font-bold mb-6" style="color: var(--text-primary);">Buat Akun Baru</h2>

@if($errors->any())
<div class="mb-4 p-3 rounded-xl" style="background: var(--danger-bg); border: 1px solid var(--danger); color: var(--danger); font-size: 0.85rem;">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ url('/register') }}">
    @csrf
    <div class="mb-4">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Nama lengkap" required autofocus>
    </div>

    <div class="mb-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="nama@email.com" required>
    </div>

    <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
    </div>

    <div class="mb-6">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
    </div>

    <button type="submit" class="btn-primary w-full justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
        Daftar
    </button>
</form>
@endsection

@section('footer')
Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold" style="color: var(--accent-primary);">Masuk</a>
@endsection
