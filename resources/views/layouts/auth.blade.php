<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Tatagih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const savedTheme = localStorage.getItem('tatagih_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <style>
        :root {
            --bg-body: #03060D;
            --bg-card: #0b121f;
            --bg-card-secondary: #111c2e;
            --bg-input: #111c2e;
            --border-color: rgba(255, 255, 255, 0.06);
            --border-input: rgba(255, 255, 255, 0.08);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #4b5e78;
            --accent-emerald: #10b981;
            --accent-hover: #059669;
        }

        [data-theme="light"] {
            --bg-body: #eef2f6;
            --bg-card: #ffffff;
            --bg-card-secondary: #f8fafc;
            --bg-input: #f8fafc;
            --border-color: rgba(15, 23, 42, 0.08);
            --border-input: rgba(15, 23, 42, 0.12);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --accent-emerald: #10b981;
            --accent-hover: #059669;
        }

        [x-cloak] {
            display: none !important;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .auth-bg {
            background-color: var(--bg-body) !important;
            height: 100vh;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
            color: var(--text-primary);
        }

        @media (max-width: 1023px) {
            html, body {
                height: auto;
                min-height: 100%;
            }
            .auth-bg {
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
                padding: 2rem 0;
            }
        }

        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            padding: 1.5rem;
        }

        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        [data-theme="light"] .auth-card {
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .auth-card .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-card .logo-section img {
            height: 48px;
            margin: 0 auto 0.75rem;
        }

        .auth-card .logo-section h1 {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .auth-card .logo-section p {
            color: var(--text-muted);
            font-size: 0.82rem;
            margin-top: 0.3rem;
        }

        .auth-input-group {
            margin-bottom: 1.15rem;
        }

        .auth-input-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
        }

        .auth-input-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--bg-input);
            border: 1px solid var(--border-input);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 0.85rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        .auth-input-group input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
        }

        .auth-input-group input::placeholder {
            color: var(--text-muted);
        }

        .auth-input-group .error-msg {
            color: #ef4444;
            font-size: 0.72rem;
            margin-top: 0.3rem;
        }

        .auth-submit {
            width: 100%;
            padding: 0.8rem;
            background: #10b981;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            transition: filter 0.2s ease, transform 0.1s ease;
            font-family: inherit;
            margin-top: 0.5rem;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
        }

        .auth-submit:hover {
            filter: brightness(1.08);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0;
        }

        .auth-divider span {
            font-size: 0.72rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .theme-toggle-btn {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 50;
            padding: 0.6rem;
            border-radius: 0.85rem;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }

        .theme-toggle-btn:hover {
            color: var(--text-primary);
            border-color: #10b981;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="auth-bg" x-data="{
    currentTheme: localStorage.getItem('tatagih_theme') || 'dark',
    toggleTheme() {
        this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('tatagih_theme', this.currentTheme);
        document.documentElement.setAttribute('data-theme', this.currentTheme);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: this.currentTheme } }));
    }
}">

    <button @click="toggleTheme()"
            class="theme-toggle-btn"
            :title="currentTheme === 'light' ? 'Ubah ke Dark Mode' : 'Ubah ke Light Mode'"
            aria-label="Toggle theme">

        <svg x-show="currentTheme === 'dark'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>

        <svg x-show="currentTheme === 'light'" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>

    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>
