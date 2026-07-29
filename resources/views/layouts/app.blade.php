<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Tatagih - Kelola subscription dan recurring expense Anda dengan mudah">
    <title>@yield('title', 'Tatagih') - Subscription Manager</title>
    <link rel="stylesheet" href="/css/tailwind-compiled.css?v={{ time() }}">
    @vite(['resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
    <script>
        document.documentElement.setAttribute('data-theme', 'light');
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', system-ui, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        
        .admin-sidebar {
            background-color: #0b1120;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform 0.3s ease;
        }
        
        .admin-main {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-primary);
        }
        
        .admin-header {
            height: 70px;
            background-color: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #94a3b8;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }
        
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, #0ea5e9 0%, #10b981 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        .nav-link svg {
            width: 1.25rem;
            height: 1.25rem;
            opacity: 0.8;
        }

        .nav-link.active svg {
            opacity: 1;
        }
        
        .section-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            margin: 1.5rem 0 0.5rem 1rem;
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: false }" data-theme="light">

    
    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/50 z-40 lg:hidden">
    </div>

    
    <aside class="admin-sidebar" :class="{ 'open': sidebarOpen }">
        
        <div class="flex items-center gap-3 px-6 h-[70px] border-b border-[rgba(255,255,255,0.05)]">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-black" style="background: var(--accent-gradient);">T</div>
            <span class="text-lg font-bold text-white tracking-tight">Tatagih</span>
        </div>

        
        <div class="flex-1 overflow-y-auto py-4 px-4 scrollbar-hide">
            <p class="section-label">Main Menu</p>
            
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                Dashboard
            </a>

            <a href="{{ route('subscriptions.index') }}" class="nav-link {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Subscriptions
            </a>

            @php
                $pendingValidationsCount = \App\Models\SubscriptionShare::where('owner_id', Auth::id())->whereNotNull('payment_proof_path')->where('payment_status', 'pending')->count();
            @endphp
            <a href="{{ route('payments.index') }}" class="nav-link flex justify-between items-center {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Pusat Pembayaran
                </div>
                @if($pendingValidationsCount > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingValidationsCount }}</span>
                @endif
            </a>

            <p class="section-label">Social & Tim</p>

            <a href="{{ route('shares.index') }}" class="nav-link {{ request()->routeIs('shares.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Split Bill
            </a>

            <a href="{{ url('/discover') }}" class="nav-link {{ request()->is('discover') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Cari Teman Patungan
            </a>

            <a href="{{ route('social.index') }}" class="nav-link {{ request()->routeIs('social.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                Daftar Teman
            </a>

            <p class="section-label">Analisis & Intelijen</p>

            <a href="{{ route('leaks.index') }}" class="nav-link {{ request()->routeIs('leaks.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Deteksi Pemborosan
            </a>

            <a href="{{ route('comparisons.index') }}" class="nav-link {{ request()->routeIs('comparisons.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Komparasi
            </a>

            <a href="{{ route('assistant') }}" class="nav-link {{ request()->routeIs('assistant') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                AI Assistant
            </a>

            <a href="{{ route('telegram.connect') }}" class="nav-link {{ request()->routeIs('telegram.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                Integrasi Telegram
            </a>
            
            <div class="h-8"></div> 
        </div>
    </aside>

    
    <main class="admin-main">
        
        <header class="admin-header">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-[var(--text-secondary)] hover:text-[var(--text-primary)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <div>
                    <h2 class="font-extrabold text-[var(--text-primary)] tracking-tight" style="font-size: 1.35rem;">Halo, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                    <p class="text-xs text-[var(--text-muted)] mt-1 hidden md:block font-medium">Ringkasan & kontrol subscription anda</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                
                <div class="hidden md:flex items-center bg-white shadow-sm transition-all" style="border: 1px solid #e2e8f0; border-radius: 9999px; padding: 6px 16px;">
                    <input type="text" placeholder="Cari subscription, kategori, atau..." style="background: transparent; border: none; outline: none; font-size: 12px; width: 220px; color: #334155;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" style="color: #0ea5e9;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                
                <button class="transition-colors relative flex items-center justify-center bg-white shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 50%; width: 34px; height: 34px; color: #64748b;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                </button>

                
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center justify-center transition-colors bg-white shadow-sm" style="border: 1px solid #e2e8f0; border-radius: 50%; padding: 3px; width: 34px; height: 34px;">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div class="rounded-full bg-[#e0e7ff] text-[#4f46e5] flex items-center justify-center font-bold" style="width: 28px; height: 28px; font-size: 11px; background-color: #e0e7ff; color: #4f46e5;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    
                    <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-48 rounded-xl shadow-lg border border-[var(--border-color)] bg-[var(--bg-secondary)] overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-[var(--border-color)]">
                            <p class="text-sm font-bold text-[var(--text-primary)]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[var(--text-muted)] truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[var(--text-secondary)] hover:bg-[var(--bg-elevated)] hover:text-[var(--text-primary)] transition-colors">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Pengaturan Profil
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                @yield('actions')
            </div>
        </header>

        
        <div class="p-6 md:p-8 max-w-7xl mx-auto w-full flex-1">
            @yield('content')
        </div>
    </main>

    
    <a href="{{ route('subscriptions.create') }}" class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-[var(--accent-primary)] text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all z-40">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
    </a>

    
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 md:left-auto md:translate-x-0 md:right-6 bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg font-medium text-sm flex items-center gap-3 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 md:left-auto md:translate-x-0 md:right-6 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg font-medium text-sm flex items-center gap-3 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        {{ session('error') }}
    </div>
    @endif
</body>
</html>
