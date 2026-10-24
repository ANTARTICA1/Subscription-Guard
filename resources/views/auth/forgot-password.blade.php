@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
<div class="auth-card">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Tatagih Logo">
        <h1>Lupa Password?</h1>
        <p>Masukkan email Anda dan kami akan mengirimkan link reset</p>
    </div>

    @if(session('status'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-xl text-sm mb-4 font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="auth-input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-submit">Kirim Link Reset Password</button>
    </form>

    <div class="auth-footer">
        Ingat password Anda? <a href="{{ route('login') }}">Kembali ke login</a>
    </div>
</div>
@endsection
