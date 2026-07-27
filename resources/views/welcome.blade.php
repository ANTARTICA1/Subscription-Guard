<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatagih - Kelola Subscription & Recurring Expense</title>
    <meta name="description" content="Kelola subscription dan recurring expense dengan mudah. Pantau tagihan, terima reminder otomatis via Telegram, dan cegah pemotongan saldo tanpa sadar.">
    <link rel="stylesheet" href="/css/tailwind-compiled.css?v={{ time() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .hero-card {
            background-color: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow-sm) !important;
            transition: all 0.3s ease;
        }
        .hero-card:hover {
            border-color: var(--accent-primary) !important;
            box-shadow: var(--shadow-md) !important;
            transform: translateY(-4px);
        }
        .card-title {
            color: var(--text-primary) !important;
            font-weight: 800 !important;
        }
        .card-desc {
            color: var(--text-secondary) !important;
            font-size: 0.85rem !important;
            line-height: 1.6 !important;
        }
        .section-title {
            font-weight: 900;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        .gradient-text-finance {
            color: var(--accent-primary);
        }
        .btn-finance {
            background: var(--accent-primary);
            color: #fff;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }
        .btn-finance:hover {
            background: var(--accent-secondary);
            transform: translateY(-2px);
        }
        
        /* Clean Solid Navbar */
        .solid-nav {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen font-sans" x-data>

    {{-- Navbar --}}
    <nav class="solid-nav fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-black" style="background: var(--accent-primary);">T</div>
                <span class="text-xl font-bold tracking-tight text-[var(--text-primary)]">Tatagih SaaS</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-bold text-[var(--text-secondary)]">
                <a href="#fitur" class="hover:text-[var(--text-primary)] transition-colors">Fitur</a>
                <a href="#cara-kerja" class="hover:text-[var(--text-primary)] transition-colors">Cara Kerja</a>
                <a href="#split-bill" class="hover:text-[var(--text-primary)] transition-colors">Split Bill</a>
                <a href="#faq" class="hover:text-[var(--text-primary)] transition-colors">FAQ</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-bold text-[var(--text-secondary)] hover:text-[var(--text-primary)] px-4 py-2 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="btn-finance text-sm font-bold px-5 py-2 rounded-xl">Daftar Gratis</a>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <main class="flex-1 w-full relative z-10 pt-32 pb-20">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-6 leading-tight scroll-fade-up text-[var(--text-primary)]" style="transition-delay: 100ms;" x-intersect="$el.classList.add('intersect-active')">
                Cegah Pemotongan Saldo<br>
                <span class="text-[var(--accent-primary)]">Tanpa Disadari</span>
            </h1>

            <p class="text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed font-medium text-[var(--text-secondary)] scroll-fade-up" style="transition-delay: 200ms;" x-intersect="$el.classList.add('intersect-active')">
                Aplikasi keuangan cerdas yang membantu mencatat langganan Anda, mengingatkan via Telegram, dan memfasilitasi patungan bayar subscription dengan teman secara transparan.
            </p>

            <div class="flex flex-wrap gap-4 justify-center mb-16 scroll-fade-up" style="transition-delay: 300ms;" x-intersect="$el.classList.add('intersect-active')">
                <a href="{{ route('register') }}" class="btn-finance text-base px-8 py-4 rounded-xl flex items-center gap-2">
                    Mulai Kelola Sekarang <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </a>
            </div>

            {{-- Stats Counter --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-2xl mx-auto mb-16 p-8 rounded-2xl scroll-morph bg-[var(--bg-secondary)] border border-[var(--border-color)]" style="transition-delay: 400ms;" x-intersect="$el.classList.add('intersect-active')">
                <div class="text-center">
                    <p class="text-4xl font-black text-[var(--text-primary)]">100%</p>
                    <p class="text-xs font-bold mt-2 text-[var(--text-muted)] uppercase tracking-widest">Gratis Selamanya</p>
                </div>
                <div class="text-center sm:border-l sm:border-r border-[var(--border-color)]">
                    <p class="text-4xl font-black text-[var(--text-primary)]">24/7</p>
                    <p class="text-xs font-bold mt-2 text-[var(--text-muted)] uppercase tracking-widest">Bot Reminder</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-black text-[var(--text-primary)]">∞</p>
                    <p class="text-xs font-bold mt-2 text-[var(--text-muted)] uppercase tracking-widest">Unlimited Subs</p>
                </div>
            </div>
        </div>
    </main>

    {{-- HOW IT WORKS --}}
    <section id="cara-kerja" class="py-24 relative bg-[var(--bg-secondary)] border-y border-[var(--border-color)]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 scroll-fade-up" x-intersect="$el.classList.add('intersect-active')">
                <h2 class="text-3xl md:text-5xl font-black text-[var(--text-primary)] mb-4">Cara Kerja Tatagih</h2>
                <p class="text-[var(--text-secondary)] text-lg font-medium">Tiga langkah mudah untuk menyelamatkan keuangan Anda dari auto-renewal tak terduga.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative">
                <!-- Step 1 -->
                <div class="relative scroll-morph text-center group" style="transition-delay: 100ms;" x-intersect="$el.classList.add('intersect-active')">
                    <div class="w-16 h-16 mx-auto bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl flex items-center justify-center mb-6 transition-colors group-hover:border-[var(--accent-primary)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--text-secondary)] group-hover:text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[var(--text-primary)] mb-3">1. Catat Langganan</h3>
                    <p class="text-[var(--text-secondary)] text-sm leading-relaxed font-medium">Masukkan daftar layanan streaming, hosting, atau gym Anda beserta siklus pembayarannya.</p>
                </div>
                <!-- Step 2 -->
                <div class="relative scroll-morph text-center group" style="transition-delay: 200ms;" x-intersect="$el.classList.add('intersect-active')">
                    <div class="w-16 h-16 mx-auto bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl flex items-center justify-center mb-6 transition-colors group-hover:border-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--text-secondary)] group-hover:text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[var(--text-primary)] mb-3">2. Hubungkan Telegram</h3>
                    <p class="text-[var(--text-secondary)] text-sm leading-relaxed font-medium">Bot pintar kami akan mengirimkan pengingat H-7, H-3, dan H-1 sebelum tagihan jatuh tempo.</p>
                </div>
                <!-- Step 3 -->
                <div class="relative scroll-morph text-center group" style="transition-delay: 300ms;" x-intersect="$el.classList.add('intersect-active')">
                    <div class="w-16 h-16 mx-auto bg-[var(--bg-elevated)] border border-[var(--border-color)] rounded-xl flex items-center justify-center mb-6 transition-colors group-hover:border-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--text-secondary)] group-hover:text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[var(--text-primary)] mb-3">3. Kontrol Pengeluaran</h3>
                    <p class="text-[var(--text-secondary)] text-sm leading-relaxed font-medium">Batalkan langganan tepat waktu jika tidak dipakai, atau patungan dengan teman agar lebih hemat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SPLIT BILL COMPLEX FEATURE SHOWCASE --}}
    <section id="split-bill" class="py-24 relative bg-[var(--bg-primary)]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                
                <!-- Text Content -->
                <div class="lg:w-1/2 scroll-fade-up" x-intersect="$el.classList.add('intersect-active')">
                    <h2 class="text-3xl md:text-5xl font-black text-[var(--text-primary)] leading-tight mb-4">Sistem Patungan <br><span class="text-[var(--text-secondary)]">Super Canggih</span></h2>
                    <p class="text-[var(--text-secondary)] text-lg font-medium mb-8 leading-relaxed">
                        Punya langganan Netflix atau Spotify Family? Bagi biayanya secara otomatis. Sistem kami memantau siapa yang sudah bayar dan siapa yang menunggak. Lengkap dengan validasi <strong>Bukti Transfer</strong> untuk transparansi grup.
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-[var(--text-primary)] font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Kalkulasi Pembagian Otomatis
                        </li>
                        <li class="flex items-center gap-3 text-[var(--text-primary)] font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            QR Code Invitation Link
                        </li>
                        <li class="flex items-center gap-3 text-[var(--text-primary)] font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Upload & Verifikasi Bukti TF
                        </li>
                        <li class="flex items-center gap-3 text-[var(--text-primary)] font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Auto-Reminder via Telegram
                        </li>
                    </ul>
                </div>
                
                <!-- Interactive UI Mockup -->
                <div class="lg:w-1/2 w-full scroll-morph" style="transition-delay: 200ms;" x-intersect="$el.classList.add('intersect-active')">
                    <div class="rounded-2xl border border-[var(--border-color)] bg-[var(--bg-secondary)] p-2 shadow-sm relative overflow-hidden">
                        
                        <div class="bg-[var(--bg-primary)] rounded-xl border border-[var(--border-color)] overflow-hidden relative z-10">
                            <div class="p-4 border-b border-[var(--border-color)] flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-[var(--bg-elevated)] border border-[var(--border-light)] rounded-lg flex items-center justify-center text-xl font-bold">N</div>
                                    <div>
                                        <p class="font-bold text-sm text-[var(--text-primary)]">Netflix Premium 4K</p>
                                        <p class="text-xs text-[var(--text-secondary)]">Rp46.500 / orang</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 space-y-3">
                                <!-- Member 1 -->
                                <div class="flex items-center justify-between bg-[var(--bg-elevated)] p-3 rounded-lg border border-[var(--border-color)]">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-[var(--bg-secondary)] border border-[var(--border-light)] flex items-center justify-center text-xs font-bold text-[var(--text-primary)]">A</div>
                                        <div>
                                            <p class="text-xs font-bold text-[var(--text-primary)]">Andi (Ketua)</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Member 2 -->
                                <div class="flex items-center justify-between bg-[var(--bg-elevated)] p-3 rounded-lg border border-[var(--border-color)]">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-[var(--bg-secondary)] border border-[var(--border-light)] flex items-center justify-center text-xs font-bold text-[var(--text-primary)]">B</div>
                                        <div>
                                            <p class="text-xs font-bold text-[var(--text-primary)]">Budi</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-1 bg-amber-500/10 text-amber-500 border border-amber-500/30 rounded">MENUNGGAK</span>
                                </div>
                                <!-- Member 3 -->
                                <div class="flex items-center justify-between bg-[var(--bg-elevated)] p-3 rounded-lg border border-[var(--border-color)]">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-[var(--bg-secondary)] border border-[var(--border-light)] flex items-center justify-center text-xs font-bold text-[var(--text-primary)]">C</div>
                                        <div>
                                            <p class="text-xs font-bold text-[var(--text-primary)]">Cindy</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-1 bg-[var(--accent-primary)]/10 text-[var(--accent-primary)] border border-[var(--accent-primary)]/30 rounded">LUNAS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="py-24 relative bg-[var(--bg-secondary)] border-t border-[var(--border-color)]">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-black text-[var(--text-primary)] mb-12 scroll-fade-up" x-intersect="$el.classList.add('intersect-active')">Mulai Kelola Tagihan Secara Profesional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Review 1 -->
                <div class="p-6 bg-[var(--bg-primary)] rounded-2xl border border-[var(--border-color)] text-left scroll-morph" style="transition-delay: 100ms;" x-intersect="$el.classList.add('intersect-active')">
                    <div class="flex text-amber-400 mb-3 text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <p class="text-[var(--text-secondary)] text-sm mb-4 leading-relaxed font-medium">"Fitur notifikasi Telegram sangat membantu. Dulu sering kebobolan auto-renewal Spotify walau sudah jarang dipakai. Desain UI aplikasinya juga sangat berkelas seperti m-banking."</p>
                    <p class="text-[var(--text-primary)] font-bold text-sm">— Dimas R.</p>
                </div>
                <!-- Review 2 -->
                <div class="p-6 bg-[var(--bg-primary)] rounded-2xl border border-[var(--border-color)] text-left scroll-morph" style="transition-delay: 200ms;" x-intersect="$el.classList.add('intersect-active')">
                    <div class="flex text-amber-400 mb-3 text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    </div>
                    <p class="text-[var(--text-secondary)] text-sm mb-4 leading-relaxed font-medium">"Mengelola tagihan kos dan Netflix keluarga jadi gampang banget. Fitur Split Bill sangat membantu mencatat siapa saja yang nunggak."</p>
                    <p class="text-[var(--text-primary)] font-bold text-sm">— Anita K.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ ACCORDION --}}
    <section id="faq" class="py-24 bg-[var(--bg-primary)]">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-black text-center text-[var(--text-primary)] mb-12 scroll-fade-up" x-intersect="$el.classList.add('intersect-active')">Pertanyaan Umum</h2>
            
            <div class="space-y-4" x-data="{ active: null }">
                <!-- FAQ 1 -->
                <div class="border border-[var(--border-color)] bg-[var(--bg-secondary)] rounded-xl overflow-hidden scroll-fade-up" x-intersect="$el.classList.add('intersect-active')">
                    <button @click="active = active === 1 ? null : 1" class="w-full text-left px-6 py-4 font-bold text-[var(--text-primary)] flex justify-between items-center focus:outline-none transition-colors hover:bg-[var(--bg-elevated)]">
                        Apakah Tatagih gratis digunakan?
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': active === 1}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 1" x-collapse>
                        <div class="px-6 pb-5 text-[var(--text-secondary)] text-sm leading-relaxed font-medium">
                            Ya, Tatagih 100% gratis untuk mencatat subscription dan mendapatkan notifikasi Telegram. Tidak ada batasan jumlah langganan yang bisa Anda catat.
                        </div>
                    </div>
                </div>
                <!-- FAQ 2 -->
                <div class="border border-[var(--border-color)] bg-[var(--bg-secondary)] rounded-xl overflow-hidden scroll-fade-up" style="transition-delay: 100ms;" x-intersect="$el.classList.add('intersect-active')">
                    <button @click="active = active === 2 ? null : 2" class="w-full text-left px-6 py-4 font-bold text-[var(--text-primary)] flex justify-between items-center focus:outline-none transition-colors hover:bg-[var(--bg-elevated)]">
                        Bagaimana cara bot Telegram bekerja?
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': active === 2}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 2" x-collapse>
                        <div class="px-6 pb-5 text-[var(--text-secondary)] text-sm leading-relaxed font-medium">
                            Setelah mendaftar, Anda bisa masuk ke menu "Integrasi Telegram" dan mengirim pesan ke bot kami untuk menautkan akun. Bot akan otomatis mengirimkan pesan pengingat sesuai jadwal tagihan Anda.
                        </div>
                    </div>
                </div>
                <!-- FAQ 3 -->
                <div class="border border-[var(--border-color)] bg-[var(--bg-secondary)] rounded-xl overflow-hidden scroll-fade-up" style="transition-delay: 200ms;" x-intersect="$el.classList.add('intersect-active')">
                    <button @click="active = active === 3 ? null : 3" class="w-full text-left px-6 py-4 font-bold text-[var(--text-primary)] flex justify-between items-center focus:outline-none transition-colors hover:bg-[var(--bg-elevated)]">
                        Apakah aman dari kebocoran data kartu kredit?
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': active === 3}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="active === 3" x-collapse>
                        <div class="px-6 pb-5 text-[var(--text-secondary)] text-sm leading-relaxed font-medium">
                            Sangat aman. Tatagih **tidak meminta atau menyimpan nomor kartu kredit** Anda. Aplikasi ini hanya bertindak sebagai pencatat cerdas (ledger) dan pengingat jadwal saja.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FOOTER --}}
    <footer class="py-24 border-t border-[var(--border-color)] bg-[var(--bg-secondary)] text-center relative overflow-hidden">
        <div class="max-w-2xl mx-auto px-6 relative z-10 scroll-fade-up" x-intersect="$el.classList.add('intersect-active')">
            <h2 class="text-4xl md:text-5xl font-black text-[var(--text-primary)] mb-6">Siap Mengelola Keuangan?</h2>
            <p class="text-[var(--text-secondary)] mb-10 text-lg font-medium">Bergabunglah bersama ribuan pengguna lainnya dan stop membuang uang untuk langganan yang tidak terpakai.</p>
            <a href="{{ route('register') }}" class="btn-finance text-lg px-10 py-4 rounded-xl inline-block shadow-lg">Daftar Sekarang — Gratis</a>
        </div>
        <div class="mt-20 pt-8 border-t border-[var(--border-color)] text-sm font-bold text-[var(--text-muted)] relative z-10">
            &copy; {{ date('Y') }} Tatagih SaaS. All rights reserved.
        </div>
    </footer>

</body>
</html>
