<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatagih Kelola Subscription & Tagihan Berulang Anda</title>
    <meta name="description" content="Kelola subscription dan recurring expense dengan mudah. Pantau tagihan, terima reminder otomatis via Telegram, dan cegah pemotongan saldo tanpa sadar.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/tailwind-compiled.css?v={{ time() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --surface-base: #060a14;
            --surface-card: #0c1322;
            --surface-elevated: #111b2e;
            --surface-nav: #0a1020;
            --text-primary: #e8ecf4;
            --text-secondary: #7b8ca5;
            --text-muted: #3d4f6a;
            --accent: #10b981;
            --accent-hover: #34d399;
            --accent-muted: rgba(16, 185, 129, 0.12);
            --border: rgba(255,255,255,0.05);
            --border-hover: rgba(255,255,255,0.1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--surface-base);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.6;
            overflow-x: hidden;
        }

        ::selection {
            background: rgba(16, 185, 129, 0.3);
            color: #fff;
        }

        .lp-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(6, 10, 20, 0.85);
            backdrop-filter: saturate(180%) blur(12px);
            -webkit-backdrop-filter: saturate(180%) blur(12px);
            border-bottom: 1px solid var(--border);
            transition: background 0.3s ease;
        }

        .lp-nav__inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lp-nav__logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .lp-nav__logo img {
            height: 36px;
            width: auto;
        }

        .lp-nav__logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.03em;
        }

        .lp-nav__links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .lp-nav__link {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s ease;
            position: relative;
        }

        .lp-nav__link:hover {
            color: var(--text-primary);
        }

        .lp-nav__link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: var(--accent);
            transition: width 0.25s ease;
        }

        .lp-nav__link:hover::after {
            width: 100%;
        }

        .lp-nav__actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lp-btn-ghost {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .lp-btn-ghost:hover {
            color: var(--text-primary);
            background: rgba(255,255,255,0.04);
        }

        .lp-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            font-weight: 700;
            color: #fff;
            background: var(--accent);
            padding: 9px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .lp-btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
        }

        .lp-btn-primary--lg {
            font-size: 0.95rem;
            padding: 14px 32px;
            border-radius: 12px;
        }

        .lp-btn-primary--lg:hover {
            box-shadow: 0 6px 24px rgba(16, 185, 129, 0.25);
        }

        .lp-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-secondary);
            background: transparent;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid var(--border);
        }

        .lp-btn-secondary:hover {
            border-color: var(--border-hover);
            color: var(--text-primary);
            background: rgba(255,255,255,0.03);
        }

        .lp-hero {
            padding: 160px 32px 100px;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .lp-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 20px;
            padding: 6px 14px;
            background: var(--accent-muted);
            border-radius: 100px;
            border: 1px solid rgba(16, 185, 129, 0.15);
        }

        .lp-hero__eyebrow-dot {
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
        }

        .lp-hero__title {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.08;
            letter-spacing: -0.035em;
            color: var(--text-primary);
            margin-bottom: 22px;
        }

        .lp-hero__title-accent {
            color: var(--accent);
        }

        .lp-hero__desc {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 520px;
            font-weight: 500;
        }

        .lp-hero__ctas {
            display: flex;
            gap: 14px;
            align-items: center;
            margin-bottom: 48px;
        }

        .lp-hero__stats {
            display: flex;
            gap: 40px;
            border-top: 1px solid var(--border);
            padding-top: 32px;
        }

        .lp-hero__stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .lp-hero__stat-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 6px;
        }

        .lp-hero-visual {
            position: relative;
        }

        .lp-mock {
            background: linear-gradient(135deg, rgba(20, 28, 48, 0.9) 0%, rgba(12, 19, 34, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 28px;
            position: relative;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05), 0 24px 48px -12px rgba(0, 0, 0, 0.6);
            overflow: hidden;
        }

        .lp-mock::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.5;
            z-index: 0;
            pointer-events: none;
        }

        .lp-mock > * {
            position: relative;
            z-index: 1;
        }

        .lp-mock__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .lp-mock__title {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .lp-mock__badge {
            font-size: 0.62rem;
            font-weight: 700;
            color: var(--accent);
            background: var(--accent-muted);
            padding: 3px 10px;
            border-radius: 6px;
        }

        .lp-mock-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            margin-bottom: 10px;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.02);
        }

        .lp-mock-row:hover {
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            transform: translateX(4px);
        }

        .lp-mock-row__icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 800;
            flex-shrink: 0;
        }

        .lp-mock-row__info { flex: 1; }

        .lp-mock-row__name {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .lp-mock-row__sub {
            font-size: 0.65rem;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .lp-mock-row__price {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .lp-mock-row__status {
            font-size: 0.58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .lp-mock-notif {
            position: absolute;
            top: -16px;
            right: -16px;
            background: var(--surface-elevated);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            animation: notifFloat 3s ease-in-out infinite;
            z-index: 5;
        }

        @keyframes notifFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .lp-mock-notif__icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #2563eb15;
            color: #60a5fa;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lp-mock-notif__text {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.4;
        }

        .lp-mock-notif__time {
            font-size: 0.6rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .lp-mock-ring {
            position: absolute;
            bottom: -24px;
            left: -24px;
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: var(--surface-elevated);
            border: 1px solid var(--border);
            padding: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 5;
            animation: notifFloat 4s ease-in-out 0.5s infinite;
        }

        .lp-mock-ring__value {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .lp-mock-ring__label {
            font-size: 0.5rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .lp-section {
            padding: 120px 32px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .lp-section--alt {
            background: var(--surface-card);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .lp-section--alt .lp-section { padding: 120px 32px; }

        .lp-section__eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
        }

        .lp-section__title {
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1.15;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .lp-section__desc {
            font-size: 1.05rem;
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 600px;
            font-weight: 500;
        }

        .lp-section__center {
            text-align: center;
        }

        .lp-section__center .lp-section__desc {
            margin: 0 auto 60px;
        }

        .ftr-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 56px;
            text-align: left;
        }

        .ftr-hero {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: #0d1526;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }
        .ftr-hero:hover { border-color: rgba(255,255,255,0.12); }

        .ftr-hero__left {
            padding: 40px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .ftr-hero__right {
            background: rgba(16, 185, 129, 0.04);
            padding: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-left: 1px solid rgba(255,255,255,0.04);
        }

        .ftr-hero__emoji {
            font-size: 2.2rem;
            margin-bottom: 20px;
            display: block;
            line-height: 1;
        }

        .ftr-hero__tag {
            display: inline-block;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #10b981;
            margin-bottom: 16px;
        }

        .ftr-hero__title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #f1f5f9;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .ftr-hero__desc {
            font-size: 0.92rem;
            color: #64748b;
            line-height: 1.7;
            margin: 0 0 20px;
            max-width: 420px;
        }

        .ftr-hero__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
            margin-top: 8px;
        }
        .ftr-hero__chip {
            font-size: 0.85rem;
            font-weight: 600;
            color: #10b981;
            display: flex;
            align-items: center;
        }
        .ftr-hero__chip:not(:last-child)::after {
            content: '•';
            margin-left: 16px;
            color: rgba(255, 255, 255, 0.2);
            font-size: 1.2rem;
        }

        .ftr-hero__mock {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 14px;
            padding: 16px 20px;
            width: 100%;
            max-width: 340px;
        }
        .ftr-hero__mock-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .ftr-hero__mock-row:last-child { border-bottom: none; }
        .ftr-hero__mock-name {
            font-size: 0.78rem;
            font-weight: 600;
            color: #cbd5e1;
        }
        .ftr-hero__mock-val {
            font-size: 0.72rem;
            font-weight: 700;
            color: #94a3b8;
            font-variant-numeric: tabular-nums;
        }
        .ftr-hero__mock-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .ftr-item {
            background: #0d1526;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 18px;
            padding: 32px 30px 36px;
            transition: border-color 0.3s ease, transform 0.3s ease;
            position: relative;
            min-height: 200px;
        }
        .ftr-item:hover {
            border-color: rgba(255,255,255,0.12);
            transform: translateY(-2px);
        }

        .ftr-item__emoji {
            font-size: 1.6rem;
            margin-bottom: 16px;
            display: block;
            line-height: 1;
        }

        .ftr-item__tag {
            display: inline-block;
            font-size: 0.58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--fc);
            margin-bottom: 12px;
        }

        .ftr-item__title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 10px;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .ftr-item__desc {
            font-size: 0.84rem;
            color: #64748b;
            line-height: 1.65;
            margin: 0;
        }

        .ftr-wide {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0;
            background: #0d1526;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px;
            overflow: hidden;
            transition: border-color 0.3s ease;
        }
        .ftr-wide:hover { border-color: rgba(255,255,255,0.12); }

        .ftr-wide__cell {
            padding: 32px 30px;
            border-right: 1px solid rgba(255,255,255,0.04);
        }
        .ftr-wide__cell:last-child { border-right: none; }

        .ftr-wide__emoji {
            font-size: 1.4rem;
            margin-bottom: 14px;
            display: block;
            line-height: 1;
        }
        .ftr-wide__title {
            font-size: 1rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }
        .ftr-wide__desc {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 768px) {
            .ftr-grid { grid-template-columns: 1fr; }
            .ftr-hero { grid-template-columns: 1fr; }
            .ftr-hero__right { border-left: none; border-top: 1px solid rgba(255,255,255,0.04); }
            .ftr-hero__left { padding: 28px 24px; }
            .ftr-wide { grid-template-columns: 1fr; }
            .ftr-wide__cell { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.04); }
            .ftr-wide__cell:last-child { border-bottom: none; }
        }

        .hw-timeline {
            display: flex;
            gap: 40px;
            margin-top: 56px;
            text-align: left;
            position: relative;
        }

        .hw-step {
            flex: 1;
            position: relative;
            padding: 24px 0 0 0;
            border-top: 2px solid rgba(255,255,255,0.04);
            transition: border-color 0.4s ease;
        }
        .hw-step:hover {
            border-top-color: rgba(255,255,255,0.15);
        }

        .hw-step__num {
            font-size: 5rem;
            font-weight: 900;
            color: transparent;
            -webkit-text-stroke: 1.5px rgba(255,255,255,0.08);
            letter-spacing: -0.04em;
            line-height: 0.8;
            margin-bottom: 24px;
            display: inline-block;
            position: relative;
            z-index: 1;
            transition: transform 0.4s ease, -webkit-text-stroke 0.4s ease;
        }
        .hw-step:hover .hw-step__num {
            -webkit-text-stroke: 1.5px rgba(255,255,255,0.25);
            transform: scale(1.05) translateX(4px);
            transform-origin: left bottom;
        }

        .hw-step__emoji {
            font-size: 1.8rem;
            display: block;
            margin-bottom: 18px;
            line-height: 1;
        }

        .hw-step__title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 10px;
            letter-spacing: -0.02em;
            line-height: 1.25;
        }

        .hw-step__desc {
            font-size: 0.84rem;
            color: #64748b;
            line-height: 1.65;
            margin: 0 0 18px;
            max-width: 300px;
        }

        .hw-step__tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--c, #10b981);
            margin-top: 12px;
            position: relative;
            padding-bottom: 6px;
        }
        .hw-step__tag::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 24px;
            height: 2px;
            background: var(--c, #10b981);
            opacity: 0.4;
            border-radius: 2px;
            transition: width 0.4s ease, opacity 0.4s ease;
        }
        .hw-step:hover .hw-step__tag::after {
            width: 100%;
            opacity: 0.8;
        }

        .hw-step__tag svg {
            width: 22px !important;
            height: 22px !important;
            min-width: 22px;
            flex-shrink: 0;
            color: var(--c, #94a3b8);
        }

        .hw-step:not(:last-child) .hw-step__inner {
            padding-right: 28px;
        }

        .hw-step__inner {
            padding-bottom: 8px;
        }

        @media (max-width: 768px) {
            .hw-timeline {
                flex-direction: column;
                gap: 32px;
            }
            .hw-step:not(:last-child)::after { display: none; }
            .hw-step:not(:last-child) .hw-step__inner {
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                padding-right: 0;
                padding-bottom: 32px;
            }
            .hw-step { padding: 0; }
        }

        .lp-split {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 80px;
            align-items: center;
        }

        .lp-split__features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 32px 0 36px;
        }

        .lp-split__feat {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .lp-split__feat-check {
            width: 24px;
            height: 24px;
            border-radius: 7px;
            background: var(--accent-muted);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lp-split__feat-check svg {
            width: 14px;
            height: 14px;
        }

        .lp-split-mock {
            background: linear-gradient(135deg, rgba(20, 28, 48, 0.9) 0%, rgba(12, 19, 34, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05), 0 24px 48px -12px rgba(0, 0, 0, 0.6);
        }
        
        .lp-split-mock::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.5;
            z-index: 0;
            pointer-events: none;
        }

        .lp-split-mock > * {
            position: relative;
            z-index: 1;
        }

        .lp-split-mock__header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .lp-split-mock__icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--accent);
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.02);
        }

        .lp-split-mock__info { flex: 1; }

        .lp-split-mock__name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .lp-split-mock__price {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .lp-split-mock__body {
            padding: 20px 24px;
        }

        .lp-split-mock__member {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 14px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.02);
        }
        
        .lp-split-mock__member:hover {
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            transform: translateX(-4px);
        }

        .lp-split-mock__member-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lp-split-mock__avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 800;
            color: #fff;
        }

        .lp-split-mock__member-name {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .lp-split-mock__member-role {
            font-size: 0.6rem;
            color: var(--text-muted);
        }

        .lp-testimonials {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-top: 64px;
        }

        .lp-testimonial {
            background: var(--surface-base);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px;
            transition: border-color 0.2s ease;
        }

        .lp-testimonial:hover {
            border-color: var(--border-hover);
        }

        .lp-testimonial__stars {
            display: flex;
            gap: 2px;
            margin-bottom: 16px;
        }

        .lp-testimonial__stars svg {
            width: 16px;
            height: 16px;
            color: #f59e0b;
            fill: #f59e0b;
        }

        .lp-testimonial__text {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 20px;
            font-weight: 500;
            font-style: italic;
        }

        .lp-testimonial__author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .lp-testimonial__avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            color: #fff;
        }

        .lp-testimonial__name {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .lp-testimonial__desc {
            font-size: 0.68rem;
            color: var(--text-muted);
        }

        .lp-faqs {
            max-width: 720px;
            margin: 64px auto 0;
            text-align: left;
        }

        .lp-faq {
            border: 1px solid var(--border);
            border-radius: 14px;
            margin-bottom: 10px;
            overflow: hidden;
            background: var(--surface-card);
            transition: border-color 0.2s ease;
        }

        .lp-faq:hover {
            border-color: var(--border-hover);
        }

        .lp-faq__trigger {
            width: 100%;
            text-align: left;
            padding: 18px 24px;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 0.88rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            transition: background 0.15s ease;
        }

        .lp-faq__trigger:hover {
            background: rgba(255,255,255,0.02);
        }

        .lp-faq__trigger svg {
            width: 18px;
            height: 18px;
            color: var(--text-muted);
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .lp-faq__answer {
            padding: 0 24px 20px;
            font-size: 0.82rem;
            color: var(--text-secondary);
            line-height: 1.7;
            font-weight: 500;
        }

        .lp-cta-section {
            border-top: 1px solid var(--border);
            background: var(--surface-card);
        }

        .lp-cta {
            max-width: 720px;
            margin: 0 auto;
            text-align: center;
            padding: 120px 32px;
        }

        .lp-cta__title {
            font-size: 2.8rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            color: var(--text-primary);
            margin-bottom: 16px;
            line-height: 1.1;
        }

        .lp-cta__desc {
            font-size: 1.05rem;
            color: var(--text-secondary);
            margin-bottom: 40px;
            font-weight: 500;
            line-height: 1.7;
        }

        .lp-footer {
            border-top: 1px solid var(--border);
            padding: 32px;
            text-align: center;
        }

        .lp-footer__text {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .lp-reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .lp-reveal--active {
            opacity: 1;
            transform: translateY(0);
        }

        .lp-reveal--scale {
            opacity: 0;
            transform: scale(0.96);
            transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .lp-reveal--scale.lp-reveal--active {
            opacity: 1;
            transform: scale(1);
        }

        .lp-nav__hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
        }

        .lp-nav__hamburger svg { width: 22px; height: 22px; }

        .lp-nav__mobile-menu {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            background: var(--surface-nav);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px 24px;
            z-index: 99;
        }

        .lp-nav__mobile-menu a {
            display: block;
            padding: 12px 0;
            color: var(--text-secondary);
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px solid var(--border);
        }

        .lp-nav__mobile-menu a:last-child {
            border-bottom: none;
        }

        @media (max-width: 1024px) {
            .lp-hero {
                grid-template-columns: 1fr;
                padding: 140px 24px 80px;
                gap: 48px;
            }
            .lp-hero__title { font-size: 2.8rem; }
            .lp-features { grid-template-columns: 1fr 1fr; }
            .lp-steps { grid-template-columns: 1fr 1fr 1fr; gap: 32px; }
            .lp-split { grid-template-columns: 1fr; gap: 48px; }
            .lp-section__title { font-size: 2rem; }
            .lp-cta__title { font-size: 2.2rem; }
        }

        @media (max-width: 768px) {
            .lp-nav__links { display: none; }
            .lp-nav__hamburger { display: flex; }
            .lp-hero__title { font-size: 2.2rem; }
            .lp-hero__stats { gap: 24px; flex-wrap: wrap; }
            .lp-hero__stat-value { font-size: 1.4rem; }
            .lp-features { grid-template-columns: 1fr; }
            .lp-steps { grid-template-columns: 1fr; gap: 40px; }
            .lp-steps::before { display: none; }
            .lp-testimonials { grid-template-columns: 1fr; }
            .lp-section { padding: 80px 20px; }
            .lp-section--alt .lp-section { padding: 80px 20px; }
            .lp-hero__ctas { flex-direction: column; align-items: flex-start; }
            .lp-cta { padding: 80px 20px; }
        }        /* AI Assistant Section */
        .lp-ai-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-top: 48px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (min-width: 768px) {
            .lp-ai-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: auto auto;
            }
            .lp-ai-card--main {
                grid-row: span 2;
            }
            .lp-ai-card--wide {
                grid-column: span 2;
            }
        }

        .lp-ai-card {
            background: rgba(11, 18, 31, 0.7);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), border-color 0.3s ease, box-shadow 0.3s ease;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 220px;
        }

        .lp-ai-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255,255,255,0.1);
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.5);
        }

        .lp-ai-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.1), transparent 70%);
            pointer-events: none;
        }

        .lp-ai-card:nth-child(2)::before {
            background: radial-gradient(circle at top right, rgba(239, 68, 68, 0.08), transparent 70%);
        }

        .lp-ai-card:nth-child(3)::before {
            background: radial-gradient(circle at top right, rgba(245, 158, 11, 0.08), transparent 70%);
        }

        .lp-ai-card__title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
            position: relative;
            z-index: 2;
        }

        .lp-ai-card__desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.6;
            position: relative;
            z-index: 2;
        }
        
        .lp-ai-card__visual {
            position: absolute;
            top: 32px;
            right: 32px;
            color: rgba(255,255,255,0.06);
            z-index: 1;
            transition: all 0.5s ease;
        }

        .lp-ai-card:hover .lp-ai-card__visual {
            color: rgba(255,255,255,0.12);
            transform: scale(1.05);
        }

        .lp-glow-text {
            background: linear-gradient(135deg, #a855f7, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
    </style>
</head>
<body x-data="{ mobileMenu: false }">

    <nav class="lp-nav">
        <div class="lp-nav__inner">
            <a href="/" class="lp-nav__logo">
                <img src="{{ asset('images/logo.png') }}" alt="Tatagih">
                <span class="lp-nav__logo-text">Tatagih</span>
            </a>

            <div class="lp-nav__links">
                <a href="#fitur" class="lp-nav__link">Fitur</a>
                <a href="#cara-kerja" class="lp-nav__link">Cara Kerja</a>
                <a href="#split-bill" class="lp-nav__link">Split Bill</a>
                <a href="#faq" class="lp-nav__link">FAQ</a>
            </div>

            <div class="lp-nav__actions">
                <a href="{{ route('login') }}" class="lp-btn-ghost">Masuk</a>
                <a href="{{ route('register') }}" class="lp-btn-primary">Daftar Gratis</a>
                <button class="lp-nav__hamburger" @click="mobileMenu = !mobileMenu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>
        </div>

        <div class="lp-nav__mobile-menu" x-show="mobileMenu" x-transition @click.away="mobileMenu = false" :style="mobileMenu ? 'display:block' : 'display:none'">
            <a href="#fitur" @click="mobileMenu = false">Fitur</a>
            <a href="#cara-kerja" @click="mobileMenu = false">Cara Kerja</a>
            <a href="#split-bill" @click="mobileMenu = false">Split Bill</a>
            <a href="#faq" @click="mobileMenu = false">FAQ</a>
            <a href="{{ route('login') }}" style="color: var(--text-primary);">Masuk</a>
            <a href="{{ route('register') }}" style="color: var(--accent); font-weight: 700;">Daftar Gratis →</a>
        </div>
    </nav>

    <section class="lp-hero">
        <div class="lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
            <h1 class="lp-hero__title">
                Jangan Biarkan<br>
                Tagihan Berulang<br>
                <span class="lp-hero__title-accent">Menggerus Saldomu</span>
            </h1>

            <p class="lp-hero__desc">
                Catat semua langganan, dapatkan reminder via Telegram, deteksi pemborosan dan patungan subscription mu dengan teman semua dalam satu platform.
            </p>

            <div class="lp-hero__ctas">
                <a href="{{ route('register') }}" class="lp-btn-primary lp-btn-primary--lg">
                    Mulai Sekarang Gratis
                </a>
                <a href="#cara-kerja" class="lp-btn-secondary">
                    Lihat Cara Kerja
                </a>
            </div>

            <div class="lp-hero__stats">
                <div>
                    <div class="lp-hero__stat-value">100%</div>
                    <div class="lp-hero__stat-label">Gratis Selamanya</div>
                </div>
                <div>
                    <div class="lp-hero__stat-value">24/7</div>
                    <div class="lp-hero__stat-label">Telegram Bot Aktif</div>
                </div>
                <div>
                    <div class="lp-hero__stat-value">∞</div>
                    <div class="lp-hero__stat-label">Unlimited Subscription</div>
                </div>
            </div>
        </div>

        <div class="lp-hero-visual lp-reveal--scale" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 200ms;">

            <div class="lp-mock-notif">
                <div class="lp-mock-notif__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                </div>
                <div>
                    <div class="lp-mock-notif__text">Netflix jatuh tempo 3 hari lagi</div>
                    <div class="lp-mock-notif__time">via Telegram · Baru saja</div>
                </div>
            </div>

            <div class="lp-mock">
                <div class="lp-mock__header">
                    <span class="lp-mock__title">Subscription Aktif</span>
                    <span class="lp-mock__badge">5 Layanan</span>
                </div>

                <div class="lp-mock-row">
                    <div class="lp-mock-row__icon" style="background: #fff; padding: 6px;"><img src="https://icon.horse/icon/netflix.com" alt="Netflix" style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;"></div>
                    <div class="lp-mock-row__info">
                        <div class="lp-mock-row__name">Netflix Premium</div>
                        <div class="lp-mock-row__sub">Streaming · Bulanan</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="lp-mock-row__price">Rp186.000</div>
                        <div class="lp-mock-row__status" style="color: #f97066; background: rgba(249,112,102,0.1);">3 hari lagi</div>
                    </div>
                </div>

                <div class="lp-mock-row">
                    <div class="lp-mock-row__icon" style="background: #fff; padding: 6px;"><img src="https://icon.horse/icon/spotify.com" alt="Spotify" style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;"></div>
                    <div class="lp-mock-row__info">
                        <div class="lp-mock-row__name">Spotify Family</div>
                        <div class="lp-mock-row__sub">Musik · Bulanan</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="lp-mock-row__price">Rp86.900</div>
                        <div class="lp-mock-row__status" style="color: var(--accent); background: var(--accent-muted);">12 hari lagi</div>
                    </div>
                </div>

                <div class="lp-mock-row">
                    <div class="lp-mock-row__icon" style="background: #fff; padding: 6px;"><img src="https://icon.horse/icon/youtube.com" alt="YouTube" style="width: 100%; height: 100%; object-fit: contain; border-radius: 4px;"></div>
                    <div class="lp-mock-row__info">
                        <div class="lp-mock-row__name">YouTube Premium</div>
                        <div class="lp-mock-row__sub">Streaming · Bulanan</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="lp-mock-row__price">Rp109.000</div>
                        <div class="lp-mock-row__status" style="color: var(--accent); background: var(--accent-muted);">18 hari lagi</div>
                    </div>
                </div>
            </div>

            <div class="lp-mock-ring">
                <div class="lp-mock-ring__value" style="color: var(--accent);">82</div>
                <div class="lp-mock-ring__label">Skor</div>
            </div>
        </div>
    </section>

    <div class="lp-section--alt" id="fitur">
        <div class="lp-section lp-section__center">
            <div class="lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
                <div class="lp-section__eyebrow">Kenapa Tatagih?</div>
                <h2 class="lp-section__title">Semua yang Kamu Butuhkan<br>untuk Kelola Tagihan</h2>
                <p class="lp-section__desc">Dari pencatatan sederhana sampai analisis cerdas Tatagih punya semua fitur supaya keuangan berlanggananmu tetap terkendali.</p>
            </div>

            <div class="ftr-grid">

                <div class="ftr-hero lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay:50ms">
                    <div class="ftr-hero__left">

                        <span class="ftr-hero__tag">Fitur Utama</span>
                        <h3 class="ftr-hero__title">Catat Semua Langganan<br>dalam Satu Tempat</h3>
                        <p class="ftr-hero__desc">Netflix, Spotify, gym, hosting catat unlimited subscription dengan kategori, siklus bayar, dan tanggal jatuh tempo. Tidak ada lagi tagihan yang terlupakan.</p>
                        <div class="ftr-hero__chips">
                            <span class="ftr-hero__chip">Unlimited</span>
                            <span class="ftr-hero__chip">Multi-kategori</span>
                            <span class="ftr-hero__chip">Auto-jadwal</span>
                        </div>
                    </div>
                    <div class="ftr-hero__right">
                        <div class="ftr-hero__mock">
                            <div class="ftr-hero__mock-row">
                                <span class="ftr-hero__mock-name"><img src="https://icon.horse/icon/netflix.com" style="width: 14px; height: 14px; border-radius: 4px; display: inline-block; margin-right: 8px; vertical-align: middle;">Netflix</span>
                                <span class="ftr-hero__mock-val">Rp186.000</span>
                            </div>
                            <div class="ftr-hero__mock-row">
                                <span class="ftr-hero__mock-name"><img src="https://icon.horse/icon/spotify.com" style="width: 14px; height: 14px; border-radius: 4px; display: inline-block; margin-right: 8px; vertical-align: middle;">Spotify</span>
                                <span class="ftr-hero__mock-val">Rp86.900</span>
                            </div>
                            <div class="ftr-hero__mock-row">
                                <span class="ftr-hero__mock-name"><img src="https://icon.horse/icon/youtube.com" style="width: 14px; height: 14px; border-radius: 4px; display: inline-block; margin-right: 8px; vertical-align: middle;">YouTube</span>
                                <span class="ftr-hero__mock-val">Rp109.000</span>
                            </div>
                            <div class="ftr-hero__mock-row">
                                <span class="ftr-hero__mock-name"><img src="https://icon.horse/icon/figma.com" style="width: 14px; height: 14px; border-radius: 4px; display: inline-block; margin-right: 8px; vertical-align: middle;">Figma</span>
                                <span class="ftr-hero__mock-val">$15/mo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ftr-item lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="--fc:#38bdf8; transition-delay:100ms">

                    <span class="ftr-item__tag">Telegram Bot</span>
                    <h3 class="ftr-item__title">Reminder via Telegram</h3>
                    <p class="ftr-item__desc">Bot cerdas mengirim reminder H-7, H-3, dan H-1 sebelum tagihan jatuh tempo langsung ke chat Telegram Anda.</p>
                </div>

                <div class="ftr-item lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="--fc:#fbbf24; transition-delay:150ms">

                    <span class="ftr-item__tag">Hemat Saldo</span>
                    <h3 class="ftr-item__title">Deteksi Pemborosan</h3>
                    <p class="ftr-item__desc">Analisis otomatis menemukan langganan yang jarang dipakai atau terlalu mahal agar Anda bisa berhemat tepat waktu.</p>
                </div>

                <div class="ftr-item lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="--fc:#f43f5e; transition-delay:200ms">

                    <span class="ftr-item__tag">Patungan</span>
                    <h3 class="ftr-item__title">Split Bill / Patungan</h3>
                    <p class="ftr-item__desc">Bagi biaya subscription dengan teman. Lacak siapa yang sudah bayar, kirim reminder, dan validasi bukti transfer.</p>
                </div>

                <div class="ftr-item lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="--fc:#a855f7; transition-delay:250ms">

                    <span class="ftr-item__tag">Asisten Cerdas</span>
                    <h3 class="ftr-item__title">TATA Assistant</h3>
                    <p class="ftr-item__desc">Asisten cerdas yang menganalisis pengeluaran, memberi rekomendasi penghematan, dan menghitung skor kesehatan keuangan.</p>
                </div>

                <div class="ftr-wide lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay:300ms">
                    <div class="ftr-wide__cell">

                        <h4 class="ftr-wide__title">Komparasi Layanan</h4>
                        <p class="ftr-wide__desc">Bandingkan Netflix vs Disney+, Spotify vs YouTube Music untuk cari yang paling value for money.</p>
                    </div>
                    <div class="ftr-wide__cell">

                        <h4 class="ftr-wide__title">100% Aman</h4>
                        <p class="ftr-wide__desc">Tidak perlu data kartu kredit atau akses rekening. Tatagih hanya mencatat dan mengingatkan.</p>
                    </div>
                    <div class="ftr-wide__cell">

                        <h4 class="ftr-wide__title">Gratis Selamanya</h4>
                        <p class="ftr-wide__desc">Semua fitur tersedia gratis tanpa batasan. Tidak ada biaya tersembunyi atau upsell.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lp-section" id="cara-kerja">
        <div class="lp-section__center lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
            <div class="lp-section__eyebrow">Simpel & Terstruktur</div>
            <h2 class="lp-section__title">Cara Kerja Tatagih</h2>
            <p class="lp-section__desc">Hanya butuh 3 langkah mudah untuk mengontrol semua langganan dan mencegah saldo terpotong tanpa sadar.</p>
        </div>

        <div class="hw-timeline">
            <div class="hw-step lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 100ms">
                <div class="hw-step__inner">
                    <div class="hw-step__num">01</div>
                    <h3 class="hw-step__title">Catat Langganan</h3>
                    <p class="hw-step__desc">Masukkan nama layanan, harga, dan siklus pembayaran. Sistem otomatis menghitung jadwal jatuh tempo secara akurat.</p>
                    <span class="hw-step__tag" style="--c: #10b981;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" style="width: 22px; height: 22px; min-width: 22px; display: block;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Input cepat & otomatis</span>
                </div>
            </div>

            <div class="hw-step lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 200ms">
                <div class="hw-step__inner">
                    <div class="hw-step__num">02</div>
                    <h3 class="hw-step__title">Hubungkan Telegram</h3>
                    <p class="hw-step__desc">Kirim kode verifikasi ke bot Telegram kami. Setelah terhubung, pengingat tagihan akan dikirim otomatis ke HP Anda.</p>
                    <span class="hw-step__tag" style="--c: #38bdf8;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" style="width: 22px; height: 22px; min-width: 22px; display: block;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg> Reminder H-7, H-3, H-1</span>
                </div>
            </div>

            <div class="hw-step lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 300ms">
                <div class="hw-step__inner">
                    <div class="hw-step__num">03</div>
                    <h3 class="hw-step__title">Kontrol & Hemat</h3>
                    <p class="hw-step__desc">Pantau pengeluaran, deteksi pemborosan, dan batalkan layanan yang tidak terpakai sebelum terjadi auto-renewal.</p>
                    <span class="hw-step__tag" style="--c: #fbbf24;"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" style="width: 22px; height: 22px; min-width: 22px; display: block;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg> Anti tagihan siluman</span>
                </div>
            </div>
        </div>
    </div>

    <div class="lp-section--alt" id="split-bill">
        <div class="lp-section">
            <div class="lp-split">
                <div class="lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
                    <div class="lp-section__eyebrow">Fitur Andalan</div>
                    <h2 class="lp-section__title">Sistem Patungan<br>yang Transparan</h2>
                    <p class="lp-section__desc">Internet kos, langganan keluarga, atau subscription kantor bagi biayanya otomatis dan lacak siapa yang nunggak.</p>

                    <div class="lp-split__features">
                        <div class="lp-split__feat">
                            <div class="lp-split__feat-check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg></div>
                            Pembagian biaya otomatis
                        </div>
                        <div class="lp-split__feat">
                            <div class="lp-split__feat-check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg></div>
                            Invite teman via QR Code
                        </div>
                        <div class="lp-split__feat">
                            <div class="lp-split__feat-check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg></div>
                            Upload & validasi bukti transfer
                        </div>
                        <div class="lp-split__feat">
                            <div class="lp-split__feat-check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg></div>
                            Reminder tagih via Telegram
                        </div>
                    </div>

                    <a href="{{ route('register') }}" class="lp-btn-primary lp-btn-primary--lg">
                        Coba Split Bill
                    </a>
                </div>

                <div class="lp-reveal--scale" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 150ms;">
                    <div class="lp-split-mock">
                        <div class="lp-split-mock__header">
                            <div class="lp-split-mock__icon" style="background: transparent; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <img src="https://icon.horse/icon/netflix.com" alt="Netflix" style="width: 28px; height: 28px; border-radius: 6px; object-fit: contain;">
                            </div>
                            <div class="lp-split-mock__info">
                                <div class="lp-split-mock__name">Patungan Netflix Premium</div>
                                <div class="lp-split-mock__price">Rp186.000 / bulan · 4 anggota</div>
                            </div>
                        </div>
                        <div class="lp-split-mock__body">
                            <div class="lp-split-mock__member">
                                <div class="lp-split-mock__member-left">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Gung" class="lp-split-mock__avatar" style="object-fit: cover;">
                                    <div>
                                        <div class="lp-split-mock__member-name">Gung Krisna</div>
                                        <div class="lp-split-mock__member-role">Ketua Grup</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.68rem; font-weight: 700; color: var(--text-muted); margin-bottom: 3px;">Rp46.500</div>
                                    <span style="font-size: 0.58rem; font-weight: 700; padding: 3px 8px; border-radius: 5px; background: var(--accent-muted); color: var(--accent); text-transform: uppercase; letter-spacing: 0.04em;">Lunas</span>
                                </div>
                            </div>
                            <div class="lp-split-mock__member">
                                <div class="lp-split-mock__member-left">
                                    <img src="https://randomuser.me/api/portraits/men/44.jpg" alt="Bagas Saputra" class="lp-split-mock__avatar" style="object-fit: cover;">
                                    <div>
                                        <div class="lp-split-mock__member-name">Bagas Saputra</div>
                                        <div class="lp-split-mock__member-role">Anggota</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.68rem; font-weight: 700; color: var(--text-muted); margin-bottom: 3px;">Rp46.500</div>
                                    <span style="font-size: 0.58rem; font-weight: 700; padding: 3px 8px; border-radius: 5px; background: #f59e0b15; color: #f59e0b; text-transform: uppercase; letter-spacing: 0.04em;">Menunggak</span>
                                </div>
                            </div>
                            <div class="lp-split-mock__member">
                                <div class="lp-split-mock__member-left">
                                    <img src="https://randomuser.me/api/portraits/women/10.jpg" alt="Keisha Anindya" class="lp-split-mock__avatar" style="object-fit: cover;">
                                    <div>
                                        <div class="lp-split-mock__member-name">Keisha Anindya</div>
                                        <div class="lp-split-mock__member-role">Anggota</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.68rem; font-weight: 700; color: var(--text-muted); margin-bottom: 3px;">Rp46.500</div>
                                    <span style="font-size: 0.58rem; font-weight: 700; padding: 3px 8px; border-radius: 5px; background: var(--accent-muted); color: var(--accent); text-transform: uppercase; letter-spacing: 0.04em;">Lunas</span>
                                </div>
                            </div>
                            <div class="lp-split-mock__member">
                                <div class="lp-split-mock__member-left">
                                    <img src="https://randomuser.me/api/portraits/women/11.jpg" alt="Citra Maharani" class="lp-split-mock__avatar" style="object-fit: cover;">
                                    <div>
                                        <div class="lp-split-mock__member-name">Citra Maharani</div>
                                        <div class="lp-split-mock__member-role">Anggota</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.68rem; font-weight: 700; color: var(--text-muted); margin-bottom: 3px;">Rp46.500</div>
                                    <span style="font-size: 0.58rem; font-weight: 700; padding: 3px 8px; border-radius: 5px; background: var(--accent-muted); color: var(--accent); text-transform: uppercase; letter-spacing: 0.04em;">Lunas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lp-section--alt" style="background: linear-gradient(to bottom, transparent, rgba(11,18,31,0.5) 20%, rgba(11,18,31,0.5) 80%, transparent);" id="ai-assistant">
        <div class="lp-section lp-section__center">
            <div class="lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
                <h2 class="lp-section__title">Dilengkapi <span class="lp-glow-text">Tata Asisten</span></h2>
                <p class="lp-section__desc">Bukan sekadar pencatat biasa. Tatagih bertindak layaknya analis keuangan pribadi Anda, mendeteksi setiap kebocoran dana sekecil apa pun.</p>
            </div>

            <div class="lp-ai-grid">

                <div class="lp-ai-card lp-ai-card--main lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 50ms; min-height: 380px;">
                    <div class="lp-ai-card__visual" style="top: 20%; right: 50%; transform: translateX(50%);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="140" height="140" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div class="lp-ai-card__title">Health Score 360°</div>
                    <div class="lp-ai-card__desc">Tata mengevaluasi kesehatan finansial Anda, mulai dari efisiensi tagihan hingga perencanaan jangka panjang. Dapatkan skor 0-100 secara real-time.</div>
                </div>

                <div class="lp-ai-card lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 150ms;">
                    <div class="lp-ai-card__visual">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M10 14l4 4m0-4l-4 4"/></svg>
                    </div>
                    <div class="lp-ai-card__title">Deteksi Tsunami Tagihan</div>
                    <div class="lp-ai-card__desc">Peringatan otomatis saat jadwal tagihan menumpuk di hari yang sama, menyelamatkan arus kas bulanan Anda dari gelombang tagihan.</div>
                </div>

                <div class="lp-ai-card lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 250ms;">
                    <div class="lp-ai-card__visual">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="7.5 4.21 12 6.81 16.5 4.21"/><polyline points="7.5 19.79 7.5 14.6 3 12"/><polyline points="21 12 16.5 14.6 16.5 19.79"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                    <div class="lp-ai-card__title">Pelacak Tumpang Tindih</div>
                    <div class="lp-ai-card__desc">Mendeteksi langganan rival. Mengapa bayar Netflix dan Prime Video sekaligus jika fungsinya sama dan bisa bergantian?</div>
                </div>
                
                <div class="lp-ai-card lp-ai-card--wide lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 350ms; min-height: 180px;">
                    <div class="lp-ai-card__visual" style="top: auto; bottom: 32px; right: 32px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    </div>
                    <div class="lp-ai-card__title">Peringatan Inflasi Gaya Hidup</div>
                    <div class="lp-ai-card__desc" style="max-width: 60%;">Tata mengawasi total beban Anda. Jika tagihan melampaui batas wajar maka sistem akan memberi intervensi untuk mencegah gaya hidup yang boros.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="lp-section">
        <div class="lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
            <div class="lp-section__eyebrow">Testimoni</div>
            <h2 class="lp-section__title">Dipercaya Pengguna</h2>
            <p class="lp-section__desc">Apa kata mereka tentang Tatagih.</p>
        </div>

        <div class="lp-testimonials">
            <div class="lp-testimonial lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 100ms;">
                <div class="lp-testimonial__stars">
                    @for($i = 0; $i < 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    @endfor
                </div>
                <p class="lp-testimonial__text">"Fitur notifikasi Telegramnya mantep banget King. Dulu sering kebobolan auto renewal Spotify padahal udah jarang dipakai. UI nya juga mantap parah."</p>
                <div class="lp-testimonial__author">
                    <img src="https://randomuser.me/api/portraits/men/33.jpg" alt="Dimas R." class="lp-testimonial__avatar" style="object-fit: cover;">
                    <div>
                        <div class="lp-testimonial__name">Dimas R.</div>
                        <div class="lp-testimonial__desc">Software Developer</div>
                    </div>
                </div>
            </div>

            <div class="lp-testimonial lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 200ms;">
                <div class="lp-testimonial__stars">
                    @for($i = 0; $i < 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    @endfor
                </div>
                <p class="lp-testimonial__text">"Mengelola tagihan dan patungan langganan jadi gampang. Fitur Split Bill membantu banget buat mencatat siapa yang nunggak. 10/10 Recommended!"</p>
                <div class="lp-testimonial__author">
                    <img src="https://randomuser.me/api/portraits/women/33.jpg" alt="Anita K." class="lp-testimonial__avatar" style="object-fit: cover;">
                    <div>
                        <div class="lp-testimonial__name">Anita K.</div>
                        <div class="lp-testimonial__desc">Mahasiswa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lp-section--alt" id="faq">
        <div class="lp-section lp-section__center">
            <div class="lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
                <div class="lp-section__eyebrow">FAQ</div>
                <h2 class="lp-section__title">Pertanyaan Umum</h2>
                <p class="lp-section__desc">Jawaban untuk pertanyaan yang sering ditanyakan.</p>
            </div>

            <div class="lp-faqs" x-data="{ active: null }">
                <div class="lp-faq lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')">
                    <button class="lp-faq__trigger" @click="active = active === 1 ? null : 1">
                        Apakah Tatagih gratis digunakan?
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :style="active === 1 ? 'transform: rotate(180deg)' : ''"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 1" x-collapse>
                        <div class="lp-faq__answer">Ya, Tatagih 100% gratis untuk semua fitur mencatat subscription, notifikasi Telegram, split bill, dan analisis pemborosan. Tidak ada biaya tersembunyi atau batasan jumlah langganan.</div>
                    </div>
                </div>

                <div class="lp-faq lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 50ms;">
                    <button class="lp-faq__trigger" @click="active = active === 2 ? null : 2">
                        Bagaimana cara bot Telegram bekerja?
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :style="active === 2 ? 'transform: rotate(180deg)' : ''"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 2" x-collapse>
                        <div class="lp-faq__answer">Setelah mendaftar, buka menu "Integrasi Telegram" di dashboard. Kirim kode verifikasi ke bot kami, dan akun Anda langsung terhubung. Bot akan otomatis mengirim reminder H-7, H-3, dan H-1 sebelum tagihan jatuh tempo.</div>
                    </div>
                </div>

                <div class="lp-faq lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 100ms;">
                    <button class="lp-faq__trigger" @click="active = active === 3 ? null : 3">
                        Apakah data saya aman?
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :style="active === 3 ? 'transform: rotate(180deg)' : ''"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 3" x-collapse>
                        <div class="lp-faq__answer">Sangat aman. Tatagih tidak meminta atau menyimpan nomor kartu kredit Anda. Aplikasi ini hanya berfungsi sebagai pencatat cerdas dan pengingat jadwal tidak ada akses ke rekening atau metode pembayaran Anda.</div>
                    </div>
                </div>

                <div class="lp-faq lp-reveal" x-intersect.once="$el.classList.add('lp-reveal--active')" style="transition-delay: 150ms;">
                    <button class="lp-faq__trigger" @click="active = active === 4 ? null : 4">
                        Bagaimana cara kerja fitur Split Bill?
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" :style="active === 4 ? 'transform: rotate(180deg)' : ''"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 4" x-collapse>
                        <div class="lp-faq__answer">Buat grup patungan dari subscription Anda, undang teman via link atau QR Code. Biaya otomatis dibagi rata. Anggota bisa upload bukti transfer, dan ketua grup bisa verifikasi dan kirim reminder via Telegram.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <footer class="lp-footer">
        <p class="lp-footer__text">&copy; {{ date('Y') }} Tatagih. All rights reserved.</p>
    </footer>

</body>
</html>
