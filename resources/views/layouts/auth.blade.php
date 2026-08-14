<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - Tatagih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-bg {
            background-color: #03060D;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .auth-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-bg::after {
            content: '';
            position: absolute;
            bottom: -40%;
            right: -15%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            padding: 1.5rem;
        }
        .auth-card {
            background: #0d1526;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 20px;
            padding: 2.5rem;
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
            color: #f1f5f9;
            letter-spacing: -0.02em;
        }
        .auth-card .logo-section p {
            color: #4b5e78;
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
            color: #94a3b8;
            margin-bottom: 0.4rem;
        }
        .auth-input-group input {
            width: 100%;
            padding: 0.7rem 1rem;
            background: #080d19;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 10px;
            color: #f1f5f9;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s ease;
        }
        .auth-input-group input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
        }
        .auth-input-group input::placeholder {
            color: #4b5e78;
        }
        .auth-input-group .error-msg {
            color: #ef4444;
            font-size: 0.72rem;
            margin-top: 0.3rem;
        }
        .auth-submit {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            transition: filter 0.2s ease;
            font-family: 'Inter', sans-serif;
            margin-top: 0.5rem;
        }
        .auth-submit:hover {
            filter: brightness(1.1);
        }
        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: #4b5e78;
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
            color: #4b5e78;
            white-space: nowrap;
        }
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.06);
        }
    </style>
</head>
<body class="auth-bg">
    <div class="auth-container">
        @yield('content')
    </div>
</body>
</html>
