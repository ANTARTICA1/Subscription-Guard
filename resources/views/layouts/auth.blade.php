<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Tatagih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind-compiled.css') }}?v={{ time() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #03060D;
            background-image: radial-gradient(circle at 50% 0%, rgba(16, 185, 129, 0.03) 0%, transparent 70%);
        }
        input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0b1121 inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans text-white items-center justify-center p-4 sm:p-6 lg:p-10 overflow-x-hidden">
    
    <!-- Huge Outer Card -->
    <div class="w-full max-w-[1150px] relative z-10 flex flex-col lg:flex-row items-center justify-between rounded-[2rem] p-6 lg:p-12 shadow-2xl gap-10 lg:gap-16" style="background-color: #0A0F1C; box-shadow: inset 0 0 0 1px rgba(255,255,255,0.03), 0 30px 60px rgba(0,0,0,0.5);">
        
        <!-- Left Side: Branding & Illustration -->
        <div class="hidden lg:flex flex-col items-center w-full lg:w-[50%]">
            @yield('left-content')
        </div>

        <!-- Right Side: Form Card -->
        <div class="w-full lg:w-[50%] max-w-[440px] mx-auto lg:mx-0">
            @yield('content')
        </div>
        
    </div>

    <!-- Footer Area (Outside the Huge Card) -->
    <div class="w-full mt-8 text-center flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-6 text-xs text-gray-500 font-medium tracking-wide">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            Privasi Terjamin
        </div>
        <div class="hidden sm:block w-1 h-1 rounded-full bg-gray-700"></div>
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            Data dienkripsi end-to-end
        </div>
        <div class="hidden sm:block w-1 h-1 rounded-full bg-gray-700"></div>
        <div>© 2026 Tatagih. All rights reserved.</div>
    </div>
</body>
</html>
