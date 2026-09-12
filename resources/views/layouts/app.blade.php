<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Tatagih - Kelola subscription dan recurring expense Anda dengan mudah">
    <title>@yield('title', 'Tatagih') - Subscription Manager</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="/css/tailwind-compiled.css?v={{ time() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('tatagih_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (localStorage.getItem('tatagih_sidebar_collapsed') === 'true') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>
    <style>
        :root {
            --accent-primary: #10b981 !important;
            --accent-secondary: #059669 !important;
            --accent-tertiary: #34d399 !important;
            --accent-gradient: #10b981 !important;
            --accent-gradient-wide: #10b981 !important;
            --accent-glow: transparent !important;
            --shadow-glow: none !important;
        }
        .btn-primary {
            background: #10b981 !important;
            color: #ffffff !important;
            border: none !important;
        }
        .btn-primary:hover {
            background: #059669 !important;
        }
        .card {
            background: #0d1526 !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: none !important;
            border-radius: 10px !important;
        }
        .rounded-2xl, .rounded-3xl {
            border-radius: 10px !important;
        }
        .rounded-xl {
            border-radius: 8px !important;
        }

        .admin-sidebar {
            background-color: #0b1120;
            border-right: 1px solid var(--border-color);
            width: 270px;
            max-width: 85vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .admin-sidebar.open {
            transform: translateX(0) !important;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.6);
        }

        .admin-header {
            height: 64px;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 40;
            gap: 0.5rem;
        }

        .admin-main {
            margin-left: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-body);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            min-width: 0;
            overflow-x: hidden;
        }

        @media (min-width: 768px) {
            .admin-header {
                padding: 0 1.5rem;
                gap: 1rem;
            }
        }

        @media (min-width: 1024px) {
            .admin-sidebar {
                transform: translateX(0) !important;
                width: 260px;
                box-shadow: none !important;
            }
            .admin-sidebar.collapsed,
            html.sidebar-collapsed .admin-sidebar {
                width: 76px;
            }
            .admin-main {
                margin-left: 260px;
                width: calc(100% - 260px);
                max-width: calc(100% - 260px);
            }
            .admin-main.sidebar-collapsed,
            html.sidebar-collapsed .admin-main {
                margin-left: 76px;
                width: calc(100% - 76px);
                max-width: calc(100% - 76px);
            }
        }

        .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            color: var(--text-secondary);
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: background-color 0.2s ease, color 0.2s ease;
            margin-bottom: 3px;
            text-decoration: none;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .nav-link.active {
            background-color: var(--bg-body) !important;
            color: #10b981 !important;
            font-weight: 700;
            border-radius: 20px 0 0 20px !important;
            margin-right: -12px;
            padding-right: 18px;
            box-shadow: none !important;
            position: relative;
            z-index: 10;
        }

        .nav-link.active svg {
            color: #10b981 !important;
            opacity: 1 !important;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            top: -20px;
            right: 0;
            width: 20px;
            height: 20px;
            background-color: transparent;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M20 0C20 11.046 11.046 20 0 20H20V0Z' fill='%2303060D'/%3E%3C/svg%3E");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            pointer-events: none;
            z-index: 10;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -20px;
            right: 0;
            width: 20px;
            height: 20px;
            background-color: transparent;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M20 20C20 8.954 11.046 0 0 0H20V20Z' fill='%2303060D'/%3E%3C/svg%3E");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            pointer-events: none;
            z-index: 10;
        }

        .nav-link svg {
            width: 1.15rem;
            height: 1.15rem;
            flex-shrink: 0;
            opacity: 0.75;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover svg {
            opacity: 1;
            transform: scale(1.05);
        }

        [x-cloak] {
            display: none !important;
        }

        .nav-sublink {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 0.75rem;
            color: var(--text-secondary);
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-sublink:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-sublink.active {
            color: #10b981 !important;
            font-weight: 700;
            background-color: rgba(16, 185, 129, 0.12) !important;
        }

        .nav-sublink .sublink-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #475569;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .nav-sublink.active .sublink-dot {
            background-color: #10b981;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
        }

        .admin-sidebar .collapsed-only {
            display: none !important;
        }

        .admin-sidebar .expanded-only {
            display: block !important;
        }

        .admin-sidebar.collapsed .collapsed-only,
        html.sidebar-collapsed .admin-sidebar .collapsed-only {
            display: block !important;
        }

        .admin-sidebar.collapsed .expanded-only,
        html.sidebar-collapsed .admin-sidebar .expanded-only {
            display: none !important;
        }

        .admin-sidebar.collapsed .nav-group-children,
        html.sidebar-collapsed .admin-sidebar .nav-group-children {
            display: none !important;
        }

        .admin-sidebar.collapsed .nav-group-chevron,
        html.sidebar-collapsed .admin-sidebar .nav-group-chevron {
            display: none !important;
        }

        [data-theme="light"] .nav-sublink {
            color: #64748b !important;
        }

        [data-theme="light"] .nav-sublink:hover {
            color: #0f172a !important;
            background-color: #f1f5f9 !important;
        }

        [data-theme="light"] .nav-sublink.active {
            color: #059669 !important;
            background-color: rgba(16, 185, 129, 0.12) !important;
        }

        [data-theme="light"] .nav-sublink .sublink-dot {
            background-color: #cbd5e1;
        }

        [data-theme="light"] .nav-sublink.active .sublink-dot {
            background-color: #059669;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            height: 68px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            overflow: hidden;
            transition: padding 0.3s ease;
        }

        .sidebar-logo-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            text-decoration: none;
        }

        .sidebar-logo-text {
            display: flex;
            flex-direction: column;
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.2s ease, max-width 0.3s ease;
            overflow: hidden;
            max-width: 150px;
        }

        .sidebar-collapse-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .sidebar-collapse-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.15);
        }

        .section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin: 1.25rem 0 0.4rem 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s ease, margin 0.3s ease, height 0.3s ease;
        }

        @media (min-width: 1024px) {
            .admin-sidebar.collapsed .sidebar-header,
            html.sidebar-collapsed .admin-sidebar .sidebar-header {
                padding: 0;
                justify-content: center;
            }

            .admin-sidebar.collapsed .sidebar-logo-text,
            html.sidebar-collapsed .admin-sidebar .sidebar-logo-text {
                opacity: 0;
                max-width: 0;
                display: none;
            }

            .admin-sidebar.collapsed .sidebar-collapse-btn,
            html.sidebar-collapsed .admin-sidebar .sidebar-collapse-btn {
                display: none;
            }

            .admin-sidebar.collapsed .section-label,
            html.sidebar-collapsed .admin-sidebar .section-label {
                margin: 0.85rem 0.5rem 0.4rem;
                height: 1px;
                background: rgba(255, 255, 255, 0.06);
                font-size: 0;
                color: transparent;
                padding: 0;
            }

            .admin-sidebar.collapsed .nav-link,
            html.sidebar-collapsed .admin-sidebar .nav-link {
                width: 44px;
                margin-left: auto;
                margin-right: auto;
                padding: 0.65rem 0;
                justify-content: center;
                border-radius: 12px;
                position: relative;
            }

            .admin-sidebar.collapsed .nav-link.active,
            html.sidebar-collapsed .admin-sidebar .nav-link.active {
                width: calc(100% + 12px);
                margin-right: -12px;
                margin-left: 0;
                padding: 0.65rem 0;
                justify-content: center;
                border-radius: 20px 0 0 20px !important;
                background-color: var(--bg-body) !important;
            }

            .admin-sidebar.collapsed .nav-link.active::before,
            html.sidebar-collapsed .admin-sidebar .nav-link.active::before {
                display: block !important;
                top: -20px;
                right: 0;
                width: 20px;
                height: 20px;
            }

            .admin-sidebar.collapsed .nav-link.active::after,
            html.sidebar-collapsed .admin-sidebar .nav-link.active::after {
                display: block !important;
                bottom: -20px;
                right: 0;
                width: 20px;
                height: 20px;
            }

            .admin-sidebar.collapsed .nav-link-text,
            html.sidebar-collapsed .admin-sidebar .nav-link-text {
                display: none;
            }

            .admin-sidebar.collapsed .nav-badge,
            html.sidebar-collapsed .admin-sidebar .nav-badge {
                position: absolute;
                top: 4px;
                right: 4px;
                width: 8px;
                height: 8px;
                min-width: 8px;
                padding: 0;
                font-size: 0;
                border-radius: 50%;
                border: 2px solid #0b1120;
            }

            .admin-sidebar.collapsed .sidebar-user-info,
            .admin-sidebar.collapsed .sidebar-user-chevron,
            html.sidebar-collapsed .admin-sidebar .sidebar-user-info,
            html.sidebar-collapsed .admin-sidebar .sidebar-user-chevron {
                display: none;
            }

            .admin-sidebar.collapsed .sidebar-user-link,
            html.sidebar-collapsed .admin-sidebar .sidebar-user-link {
                justify-content: center;
                padding: 4px 0;
            }

            .admin-sidebar.collapsed .nav-link[data-tooltip]::after,
            html.sidebar-collapsed .admin-sidebar .nav-link[data-tooltip]::after {
                content: attr(data-tooltip);
                position: absolute;
                left: calc(100% + 14px);
                top: 50%;
                transform: translateY(-50%) translateX(-6px);
                background: #0f172a;
                color: #ffffff;
                padding: 6px 12px;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 600;
                white-space: nowrap;
                pointer-events: none;
                opacity: 0;
                visibility: hidden;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
                z-index: 100;
            }

            .admin-sidebar.collapsed .nav-link[data-tooltip]:hover::after,
            html.sidebar-collapsed .admin-sidebar .nav-link[data-tooltip]:hover::after {
                opacity: 1;
                visibility: visible;
                transform: translateY(-50%) translateX(0);
            }
        }

        [data-theme="light"] {
            --bg-body: #eef2f6 !important;
            --bg-primary: #f8fafc !important;
            --bg-secondary: #eef2f6 !important;
            --bg-card: #ffffff !important;
            --bg-card-hover: #f8fafc !important;
            --bg-elevated: #e2e8f0 !important;
            --text-primary: #0f172a !important;
            --text-secondary: #475569 !important;
            --text-muted: #64748b !important;
            --border-color: rgba(15, 23, 42, 0.08) !important;
            --border-light: rgba(15, 23, 42, 0.12) !important;
        }

        [data-theme="light"] body {
            background-color: #eef2f6 !important;
            color: #0f172a !important;
        }

        [data-theme="light"] .admin-sidebar {
            background-color: #ffffff !important;
            border-right: 1px solid rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .sidebar-header {
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .sidebar-collapse-btn {
            border-color: rgba(15, 23, 42, 0.1);
            background: #f8fafc;
            color: #64748b;
        }

        [data-theme="light"] .sidebar-collapse-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: rgba(15, 23, 42, 0.2);
        }

        [data-theme="light"] .admin-sidebar div.border-b,
        [data-theme="light"] .admin-sidebar div.border-t {
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .admin-sidebar .text-white {
            color: #0f172a !important;
        }

        [data-theme="light"] .admin-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .admin-header h2 {
            color: #0f172a !important;
        }

        [data-theme="light"] .admin-main {
            background-color: #eef2f6 !important;
        }

        [data-theme="light"] .card {
            background-color: #ffffff !important;
            border: 1px solid rgba(15, 23, 42, 0.08) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
            color: #0f172a !important;
            border-radius: 10px !important;
        }

        [data-theme="light"] .item-row {
            background-color: #f8fafc !important;
            border: 1px solid rgba(15, 23, 42, 0.06) !important;
            color: #0f172a !important;
        }

        [data-theme="light"] .item-row:hover {
            background-color: #f1f5f9 !important;
        }

        [data-theme="light"] .nav-link {
            color: #475569 !important;
        }

        [data-theme="light"] .nav-link:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        [data-theme="light"] .nav-link.active {
            background-color: #eef2f6 !important;
            color: #059669 !important;
        }

        [data-theme="light"] .nav-link.active svg {
            color: #059669 !important;
        }

        [data-theme="light"] .nav-link.active::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M20 0C20 11.046 11.046 20 0 20H20V0Z' fill='%23EEF2F6'/%3E%3C/svg%3E");
        }

        [data-theme="light"] .nav-link.active::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='M20 20C20 8.954 11.046 0 0 0H20V20Z' fill='%23EEF2F6'/%3E%3C/svg%3E");
        }

        @media (min-width: 1024px) {
            [data-theme="light"] .admin-sidebar.collapsed .section-label,
            [data-theme="light"].sidebar-collapsed .admin-sidebar .section-label {
                background: rgba(15, 23, 42, 0.08);
            }

            [data-theme="light"] .admin-sidebar.collapsed .nav-badge,
            [data-theme="light"].sidebar-collapsed .admin-sidebar .nav-badge {
                border-color: #ffffff;
            }

            [data-theme="light"] .admin-sidebar.collapsed .nav-link[data-tooltip]::after,
            [data-theme="light"].sidebar-collapsed .admin-sidebar .nav-link[data-tooltip]::after {
                background: #0f172a;
                color: #ffffff;
                border-color: rgba(15, 23, 42, 0.15);
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            }
        }

        [data-theme="light"] .section-title,
        [data-theme="light"] .section-title span,
        [data-theme="light"] h1,
        [data-theme="light"] h2,
        [data-theme="light"] h3,
        [data-theme="light"] h4 {
            color: #0f172a !important;
        }

        [data-theme="light"] .section-desc {
            color: #64748b !important;
        }

        [data-theme="light"] .btn-secondary {
            background-color: #f1f5f9 !important;
            border: 1px solid #cbd5e1 !important;
            color: #334155 !important;
        }

        [data-theme="light"] .btn-ghost {
            color: #475569 !important;
        }

        [data-theme="light"] .btn-ghost:hover {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }

        [data-theme="light"] input,
        [data-theme="light"] select,
        [data-theme="light"] textarea {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
        }

        [data-theme="light"] input::placeholder,
        [data-theme="light"] textarea::placeholder {
            color: #94a3b8 !important;
        }

        [data-theme="light"] .bg-\[\#0f172a\],
        [data-theme="light"] .bg-\[\#0b121f\],
        [data-theme="light"] .bg-\[\#0b1120\],
        [data-theme="light"] .bg-\[\#111c2e\],
        [data-theme="light"] .bg-\[\#080d19\] {
            background-color: #ffffff !important;
            color: #0f172a !important;
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .bg-\[\#192a42\],
        [data-theme="light"] .bg-\[\#152236\],
        [data-theme="light"] .bg-\[\#1e293b\] {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .border-\[\#1e293b\],
        [data-theme="light"] .border-\[\#1f2937\],
        [data-theme="light"] .border-\[\#334155\],
        [data-theme="light"] .border-\[rgba\(255\,255\,255\,0\.06\)\],
        [data-theme="light"] .border-\[rgba\(255\,255\,255\,0\.04\)\],
        [data-theme="light"] .border-\[rgba\(255\,255\,255\,0\.03\)\],
        [data-theme="light"] .border-\[rgba\(255\,255\,255\,0\.1\)\] {
            border-color: rgba(15, 23, 42, 0.08) !important;
        }

        [data-theme="light"] .text-\[\#f1f5f9\],
        [data-theme="light"] .text-white,
        [data-theme="light"] .text-slate-200,
        [data-theme="light"] .text-slate-300 {
            color: #0f172a !important;
        }

        [data-theme="light"] .text-\[\#94a3b8\],
        [data-theme="light"] .text-\[\#64748b\],
        [data-theme="light"] .text-slate-400 {
            color: #475569 !important;
        }

        [data-theme="light"] .text-\[\#4b5e78\],
        [data-theme="light"] .text-\[\#475569\] {
            color: #64748b !important;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body x-data="{
    sidebarOpen: false,
    sidebarCollapsed: localStorage.getItem('tatagih_sidebar_collapsed') === 'true',
    currentTheme: localStorage.getItem('tatagih_theme') || 'dark',
    toggleTheme() {
        this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('tatagih_theme', this.currentTheme);
        document.documentElement.setAttribute('data-theme', this.currentTheme);
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: this.currentTheme } }));
    },
    toggleSidebar() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
        localStorage.setItem('tatagih_sidebar_collapsed', this.sidebarCollapsed);
        if (this.sidebarCollapsed) {
            document.documentElement.classList.add('sidebar-collapsed');
        } else {
            document.documentElement.classList.remove('sidebar-collapsed');
        }
    }
}">

    <div x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 z-40 lg:hidden">
    </div>

    <aside class="admin-sidebar" :class="{ 'open': sidebarOpen, 'collapsed': sidebarCollapsed }">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="Tatagih Logo" class="h-9 w-auto flex-shrink-0">
                <div class="sidebar-logo-text">
                    <span class="text-base font-bold text-white tracking-tight leading-none">Tatagih</span>
                    <span class="text-[10px] text-[#64748b] font-medium mt-0.5">Subscription Manager</span>
                </div>
            </a>

        </div>

        <div class="flex-1 overflow-y-auto py-4 px-3 hide-scrollbar">
            @if(auth()->check() && !auth()->user()->isAdmin())
            <p class="section-label">Main Menu</p>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                <span class="nav-link-text">Dashboard</span>
            </a>

            <a href="{{ route('subscriptions.index') }}" class="nav-link {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}" data-tooltip="Subscriptions">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <span class="nav-link-text">Subscriptions</span>
            </a>

            @php
                $pendingValidationsCount = \App\Models\SubscriptionShare::where('owner_id', Auth::id())->whereNotNull('payment_proof_path')->where('payment_status', 'pending')->count();
            @endphp
            <a href="{{ route('payments.index') }}" class="nav-link flex justify-between items-center {{ request()->routeIs('payments.*') ? 'active' : '' }}" data-tooltip="Pusat Pembayaran">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    <span class="nav-link-text">Pusat Pembayaran</span>
                </div>
                @if($pendingValidationsCount > 0)
                    <span class="nav-badge bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center">{{ $pendingValidationsCount }}</span>
                @endif
            </a>

            <p class="section-label">Social & Tim</p>

            <a href="{{ route('shares.index') }}" class="nav-link {{ request()->routeIs('shares.*') ? 'active' : '' }}" data-tooltip="Split Bill">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                <span class="nav-link-text">Split Bill</span>
            </a>

            <a href="{{ url('/discover') }}" class="nav-link {{ request()->is('discover') ? 'active' : '' }}" data-tooltip="Cari Teman Patungan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <span class="nav-link-text">Cari Teman Patungan</span>
            </a>

            <a href="{{ route('social.index') }}" class="nav-link {{ request()->routeIs('social.*') ? 'active' : '' }}" data-tooltip="Daftar Teman">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <span class="nav-link-text">Daftar Teman</span>
            </a>

            <p class="section-label">Analisis & Intelijen</p>

            <a href="{{ route('leaks.index') }}" class="nav-link {{ request()->routeIs('leaks.*') ? 'active' : '' }}" data-tooltip="Deteksi Pemborosan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <span class="nav-link-text">Deteksi Pemborosan</span>
            </a>

            <a href="{{ route('comparisons.index') }}" class="nav-link {{ request()->routeIs('comparisons.*') ? 'active' : '' }}" data-tooltip="Komparasi">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                <span class="nav-link-text">Komparasi</span>
            </a>

            <div class="nav-group mb-0.5">
                <div class="collapsed-only">
                    <a href="{{ route('assistant') }}"
                       class="nav-link {{ request()->routeIs('assistant') ? 'active' : '' }}"
                       data-tooltip="Ringkasan Audit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="nav-link-text">Ringkasan Audit</span>
                    </a>
                    <a href="{{ route('assistant.chat') }}"
                       class="nav-link {{ request()->routeIs('assistant.chat*') ? 'active' : '' }}"
                       data-tooltip="TATA Chatbot">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span class="nav-link-text">TATA Chatbot</span>
                    </a>
                </div>

                <div class="expanded-only" x-data="{ open: {{ request()->routeIs('assistant*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                            type="button"
                            class="w-full nav-link flex items-center justify-between cursor-pointer {{ (request()->routeIs('assistant*') && !request()->routeIs('assistant') && !request()->routeIs('assistant.chat*')) ? 'active' : '' }}"
                            :class="{ 'text-white': open }">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="nav-link-text">TATA Asisten</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="nav-group-chevron w-3.5 h-3.5 transition-transform duration-200 opacity-60 flex-shrink-0" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak class="nav-group-children pl-4 ml-4 border-l border-[var(--border-color)] space-y-1 mt-1 mb-2">
                        <a href="{{ route('assistant') }}"
                           class="nav-sublink cursor-pointer {{ request()->routeIs('assistant') ? 'active' : '' }}">
                            <span class="sublink-dot"></span>
                            <span class="nav-link-text">Ringkasan Audit</span>
                        </a>

                        <a href="{{ route('assistant.chat') }}"
                           class="nav-sublink cursor-pointer {{ request()->routeIs('assistant.chat*') ? 'active' : '' }}">
                            <span class="sublink-dot"></span>
                            <span class="nav-link-text">TATA Chatbot</span>
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('telegram.connect') }}" class="nav-link {{ request()->routeIs('telegram.*') ? 'active' : '' }}" data-tooltip="Integrasi Telegram">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span class="nav-link-text">Integrasi Telegram</span>
            </a>
            @endif

            @if(auth()->check() && auth()->user()->isAdmin())
            <p class="section-label">Admin</p>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Admin Overview">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" /></svg>
                <span class="nav-link-text">Admin Overview</span>
            </a>

            <a href="{{ route('admin.subscriptions') }}" class="nav-link {{ request()->routeIs('admin.subscriptions') ? 'active' : '' }}" data-tooltip="Semua Langganan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <span class="nav-link-text">Semua Langganan</span>
            </a>

            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" data-tooltip="Kelola User">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                <span class="nav-link-text">Kelola User</span>
            </a>
            @endif

            <div class="h-4"></div>
        </div>

        <div class="sidebar-user-container px-4 py-3 border-t border-[rgba(255,255,255,0.06)]">
            <a href="{{ route('profile.edit') }}" class="sidebar-user-link flex items-center gap-3 p-2 rounded-lg hover:bg-[rgba(255,255,255,0.04)] transition-colors group">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
                @else
                    <div class="sidebar-user-avatar flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="sidebar-user-info flex-1 min-w-0">
                    <p class="text-sm font-semibold text-[#f1f5f9] truncate">{{ auth()->user()->name }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-user-chevron h-4 w-4 text-[#4b5e78] group-hover:text-[#94a3b8] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
    </aside>

    <main class="admin-main flex flex-col min-h-screen" :class="{ 'sidebar-collapsed': sidebarCollapsed }">
        <header class="admin-header">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-[#94a3b8] hover:text-white rounded-lg transition-colors" aria-label="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                <button @click="toggleSidebar()" class="hidden lg:flex p-2 rounded-xl border border-[var(--border-color)] bg-[var(--bg-card)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:border-emerald-500 transition-all items-center justify-center cursor-pointer shadow-sm" :title="sidebarCollapsed ? 'Perluas Sidebar' : 'Ciutkan Sidebar'" aria-label="Toggle sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300" :class="{ 'rotate-180': sidebarCollapsed }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
                <div class="min-w-0 flex-1">
                    <h2 class="font-bold text-[#f1f5f9] tracking-tight text-lg truncate">Halo, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                    <p class="text-xs text-[#4b5e78] hidden md:block font-medium">@yield('header_desc', 'Kelola detail subscription Anda dengan mudah.')</p>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-3 shrink-0">
                <button @click="toggleTheme()"
                        class="p-2 rounded-xl border border-[var(--border-color)] bg-[var(--bg-card)] text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:border-emerald-500 transition-all flex items-center justify-center cursor-pointer shadow-sm"
                        :title="currentTheme === 'light' ? 'Beralih ke Dark Mode' : 'Beralih ke Light Mode'">
                    <template x-if="currentTheme === 'light'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </template>
                    <template x-if="currentTheme === 'dark'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </template>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1 rounded-lg hover:bg-[rgba(255,255,255,0.04)] transition-colors">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-lg object-cover">
                        @else
                            <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-52 rounded-xl shadow-lg border border-[var(--border-color)] bg-[var(--bg-card)] overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-[var(--border-color)]">
                            <p class="text-sm font-semibold text-[var(--text-primary)]">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[var(--text-muted)] truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-[var(--text-secondary)] hover:bg-[var(--bg-elevated)] hover:text-[var(--text-primary)] transition-colors">
                            <div class="flex items-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Pengaturan Profil
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-500/10 transition-colors flex items-center gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                @yield('actions')
            </div>
        </header>

        <div class="flex-1 p-5 md:p-7 max-w-7xl mx-auto w-full flex flex-col">
            <div class="w-full flex-1">
                @yield('content')
            </div>

            <div class="mt-auto pt-3 pb-2 border-t border-[rgba(255,255,255,0.04)] text-center text-[10px] text-[#4b5e78]">
                © 2026 Tatagih. All rights reserved.
            </div>
        </div>
    </main>

    @if(!request()->routeIs('subscriptions.create') && !request()->routeIs('subscriptions.edit'))
    <a href="{{ route('subscriptions.create') }}" class="md:hidden fixed bottom-5 right-5 w-12 h-12 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl flex items-center justify-center shadow-lg z-40">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
    </a>
    @endif

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed bottom-5 left-1/2 -translate-x-1/2 md:left-auto md:translate-x-0 md:right-5 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg font-medium text-sm flex items-center gap-2.5 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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
         class="fixed bottom-5 left-1/2 -translate-x-1/2 md:left-auto md:translate-x-0 md:right-5 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg font-medium text-sm flex items-center gap-2.5 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        {{ session('error') }}
    </div>
    @endif

    @yield('scripts')
</body>
</html>
