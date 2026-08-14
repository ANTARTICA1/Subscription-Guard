@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="auth-card">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Tatagih Logo">
        <h1>Reset Password</h1>
        <p>Buat password baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="auth-input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="nama@email.com" required>
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-input-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
            @error('password')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-input-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required>
        </div>

        <button type="submit" class="auth-submit">Reset Password</button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('login') }}">← Kembali ke halaman login</a>
    </div>
</div>
@endsection
