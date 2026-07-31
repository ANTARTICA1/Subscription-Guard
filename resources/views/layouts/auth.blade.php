<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Tatagih</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind-compiled.css') }}?v={{ time() }}">
    @vite(['resources/js/app.js'])
</head>
<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">

    
    <div style="position: absolute; inset: 0; background: var(--bg-primary); z-index: 0;"></div>

    <div class="w-full max-w-md relative z-10" style="animation: morphIn 0.8s cubic-bezier(0.22, 1, 0.36, 1);">
        
        <div class="text-center mb-8" style="animation: morphFadeUp 0.6s ease-out 0.2s both;">
            <img src="{{ asset('images/logo.png') }}" alt="Tatagih Logo" class="mx-auto mb-6" style="width: 160px; height: auto; filter: drop-shadow(0 15px 35px rgba(139, 92, 246, 0.35)); transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);"
                 onmouseenter="this.style.transform='rotate(-5deg) scale(1.05)'"
                 onmouseleave="this.style.transform='rotate(0) scale(1)'">
            <h1 class="text-3xl font-bold" style="color: var(--text-primary); letter-spacing: -0.03em;">Tatagih</h1>
            <p class="text-sm mt-1" style="color: var(--text-muted);">Subscription Manager</p>
        </div>

        
        <div class="card" style="animation: morphIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) 0.3s both;">
            @yield('content')
        </div>

        
        <p class="text-center mt-6 text-sm" style="color: var(--text-muted); animation: morphFadeUp 0.6s ease-out 0.5s both;">
            @yield('footer')
        </p>
    </div>
</body>
</html>
