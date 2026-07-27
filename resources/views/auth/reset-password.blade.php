@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<h2 class="text-xl font-bold mb-6" style="color: var(--text-primary);">Reset Password</h2>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-input" required>
    </div>

    <div class="mb-4">
        <label class="form-label">Password Baru</label>
        <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required>
    </div>

    <div class="mb-6">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-input" required>
    </div>

    <button type="submit" class="btn-primary w-full justify-center">Reset Password</button>
</form>
@endsection
