@extends('layouts.app')
@section('title', 'TATA Chatbot')

@section('content')
<style>
    .chat-studio-wrapper {
        height: calc(100vh - 170px);
        min-height: 580px;
    }
    @media (max-width: 768px) {
        .chat-studio-wrapper {
            height: calc(100vh - 150px);
            min-height: 520px;
        }
    }

    .chat-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .chat-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .chat-scroll::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.2);
        border-radius: 9999px;
    }
    .chat-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.4);
    }

    .user-bubble {
        background-color: #059669;
        color: #ffffff !important;
    }
    .user-bubble .bubble-text {
        color: #ffffff !important;
    }
    .user-bubble .bubble-meta {
        color: rgba(209, 250, 229, 0.9) !important;
    }
    .user-bubble .bubble-check {
        color: #a7f3d0 !important;
    }

    [data-theme="light"] .user-bubble {
        background-color: #d1fae5 !important;
        color: #064e3b !important;
        border: 1px solid #a7f3d0 !important;
    }
    [data-theme="light"] .user-bubble .bubble-text {
        color: #064e3b !important;
    }
    [data-theme="light"] .user-bubble .bubble-meta {
        color: #047857 !important;
    }
    [data-theme="light"] .user-bubble .bubble-check {
        color: #059669 !important;
    }

    .chat-content strong {
        font-weight: 700;
        color: inherit;
    }
    .chat-content code {
        padding: 0.15rem 0.35rem;
        border-radius: 0.375rem;
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        font-size: 0.85em;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }
    .chat-content ul, .chat-content ol {
        margin: 0.25rem 0;
        padding-left: 1.25rem;
    }
    .chat-content li {
        margin: 0.2rem 0;
    }
</style>

<div x-data="tataChat()" x-init="initChat()" class="chat-studio-wrapper flex flex-col w-full max-w-7xl mx-auto">

    <div class="flex-1 flex bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl overflow-hidden shadow-sm relative min-h-0">

        <aside :class="{
                    'translate-x-0': showMobileSidebar,
                    '-translate-x-full lg:translate-x-0': !showMobileSidebar,
                    'lg:w-64 xl:w-72 lg:opacity-100': !historyCollapsed,
                    'lg:w-0 lg:p-0 lg:border-0 lg:opacity-0 lg:pointer-events-none': historyCollapsed
                }"
               class="fixed inset-y-0 left-0 z-40 w-72 lg:static lg:z-0 flex-shrink-0 flex flex-col bg-[var(--bg-card)] border-r border-[var(--border-color)] transition-all duration-300 shadow-xl lg:shadow-none overflow-hidden">

            <div class="p-3.5 border-b border-[var(--border-color)] flex items-center justify-between min-w-[250px] bg-[var(--bg-card)]">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[var(--text-muted)] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <div>
                        <span class="text-xs font-bold text-[var(--text-primary)] tracking-tight block">Riwayat Obrolan</span>
                        <span class="text-[10px] text-[var(--text-muted)] block">{{ count($sessions) }} sesi tersimpan</span>
                    </div>
                </div>

                <div class="flex items-center gap-1">
                    <button @click="createNewSession()"
                            class="p-1.5 rounded-lg text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-elevated)] transition-colors cursor-pointer"
                            title="Percakapan Baru">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>


                    <button @click="showMobileSidebar = false"
                            class="lg:hidden p-1.5 text-[var(--text-muted)] hover:text-[var(--text-primary)] rounded-lg cursor-pointer">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-3 min-w-[250px]">
                <button @click="createNewSession()"
                        class="btn-primary w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-semibold cursor-pointer">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Percakapan Baru</span>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-2 space-y-1 py-1 chat-scroll min-w-[250px]">
                @forelse($sessions as $sess)
                    <div class="group flex items-center justify-between px-2.5 py-2 rounded-xl text-xs transition-colors cursor-pointer {{ $activeSession && $activeSession->id === $sess->id ? 'bg-[var(--bg-elevated)] text-[var(--text-primary)] font-semibold border border-[var(--border-color)]' : 'text-[var(--text-secondary)] hover:bg-[var(--bg-secondary)] hover:text-[var(--text-primary)] border border-transparent' }}">
                        <a href="{{ route('assistant.chat', ['session_id' => $sess->id]) }}" class="flex-1 truncate flex items-center gap-2 cursor-pointer min-w-0">
                            <svg class="w-3.5 h-3.5 flex-shrink-0 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span class="truncate">{{ $sess->title }}</span>
                        </a>

                        <button @click.prevent.stop="deleteSession({{ $sess->id }})"
                                class="opacity-0 group-hover:opacity-100 p-1 text-[var(--text-muted)] hover:text-red-500 rounded transition-opacity cursor-pointer flex-shrink-0"
                                title="Hapus Percakapan">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <div class="py-8 px-4 flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('images/empty.png') }}" alt="Belum ada riwayat" class="w-14 h-14 object-contain opacity-60 mb-2">
                        <p class="text-xs font-semibold text-[var(--text-secondary)]">Belum ada obrolan</p>
                        <p class="text-[11px] text-[var(--text-muted)] mt-0.5">Mulai percakapan baru dengan TATA AI</p>
                    </div>
                @endforelse
            </div>

            <div class="p-3 border-t border-[var(--border-color)] text-[11px] text-[var(--text-muted)] flex items-center justify-between min-w-[250px] bg-[var(--bg-secondary)]/30">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ $quickStats['total_active'] }} Aktif
                </span>
                <span class="font-bold text-[var(--text-primary)]">Rp {{ number_format($quickStats['monthly_expense'], 0, ',', '.') }}/bln</span>
            </div>
        </aside>

        <div x-show="showMobileSidebar"
             @click="showMobileSidebar = false"
             x-cloak
             class="fixed inset-0 bg-black/60 z-30 lg:hidden backdrop-blur-xs"></div>

        <section class="flex-1 flex flex-col min-w-0 bg-[var(--bg-card)] relative overflow-hidden">

            <header class="h-14 px-4 border-b border-[var(--border-color)] flex items-center justify-between gap-3 bg-[var(--bg-card)] flex-shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <button @click="toggleSidebar()"
                            class="p-2 -ml-1 text-[var(--text-secondary)] hover:text-[var(--text-primary)] rounded-lg border border-[var(--border-color)] hover:border-emerald-500/40 bg-[var(--bg-secondary)] transition-colors cursor-pointer"
                            :title="historyCollapsed ? 'Buka Riwayat' : 'Tutup Riwayat'">
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': historyCollapsed }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-bold text-[var(--text-primary)] tracking-tight truncate">TATA AI</h2>
                        </div>
                        <p class="text-[11px] text-[var(--text-muted)] truncate hidden sm:block">Analisis pengeluaran dan optimasi portofolio langganan Anda</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button @click="clearCurrentChat()"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border border-[var(--border-color)] text-xs text-[var(--text-muted)] hover:text-red-500 hover:border-red-500/30 transition-colors cursor-pointer"
                            title="Bersihkan Isi Percakapan">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Bersihkan</span>
                    </button>
                </div>
            </header>

            <div id="chatMessagesContainer" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 min-h-0 chat-scroll">

                <template x-if="messages.length === 0">
                    <div class="h-full flex flex-col items-center justify-center text-center max-w-xl mx-auto py-6">
                        <div class="w-16 h-16 rounded-2xl bg-[var(--bg-elevated)] border border-[var(--border-color)] p-2.5 flex items-center justify-center mb-4 shadow-sm">
                            <img src="{{ asset('images/bot.png') }}" alt="TATA AI" class="w-full h-full object-contain">
                        </div>

                        <h3 class="text-lg font-bold text-[var(--text-primary)]">Halo, {{ auth()->user()->name }}!</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-1.5 max-w-md leading-relaxed">
                            Saya TATA, asisten cerdas portofolio langganan Anda. Ajukan pertanyaan apa saja tentang pengeluaran, tagihan terdekat, atau cara menghemat biaya.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mt-6 w-full text-left">
                            <button @click="sendPrompt('Berapa total tagihan langgananku bulan ini?')"
                                    class="group p-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-secondary)] hover:border-[var(--text-muted)] hover:-translate-y-0.5 hover:shadow-sm transition-all duration-200 text-xs cursor-pointer flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <svg class="w-4 h-4 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <span class="font-semibold text-[var(--text-primary)] block truncate">Total Tagihan</span>
                                        <p class="text-[11px] text-[var(--text-muted)] truncate">Berapa total tagihan bulan ini?</p>
                                    </div>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] opacity-0 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <button @click="sendPrompt('Langganan apa yang memakan biaya paling besar?')"
                                    class="group p-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-secondary)] hover:border-[var(--text-muted)] hover:-translate-y-0.5 hover:shadow-sm transition-all duration-200 text-xs cursor-pointer flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <svg class="w-4 h-4 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    <div class="min-w-0">
                                        <span class="font-semibold text-[var(--text-primary)] block truncate">Layanan Terbesar</span>
                                        <p class="text-[11px] text-[var(--text-muted)] truncate">Cek layanan yang paling boros</p>
                                    </div>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] opacity-0 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <button @click="sendPrompt('Berikan rekomendasi konkret untuk menghemat biaya langganan saya')"
                                    class="group p-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-secondary)] hover:border-[var(--text-muted)] hover:-translate-y-0.5 hover:shadow-sm transition-all duration-200 text-xs cursor-pointer flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <svg class="w-4 h-4 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <span class="font-semibold text-[var(--text-primary)] block truncate">Tips Hemat Biaya</span>
                                        <p class="text-[11px] text-[var(--text-muted)] truncate">Rekomendasi optimasi langganan</p>
                                    </div>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] opacity-0 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <button @click="sendPrompt('Bagaimana cara menggunakan fitur Split Bill untuk patungan langganan?')"
                                    class="group p-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-secondary)] hover:border-[var(--text-muted)] hover:-translate-y-0.5 hover:shadow-sm transition-all duration-200 text-xs cursor-pointer flex items-center justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <svg class="w-4 h-4 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <div class="min-w-0">
                                        <span class="font-semibold text-[var(--text-primary)] block truncate">Panduan Split Bill</span>
                                        <p class="text-[11px] text-[var(--text-muted)] truncate">Berbagi biaya patungan bersama teman</p>
                                    </div>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[var(--text-muted)] group-hover:text-[var(--text-primary)] opacity-0 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <template x-for="(msg, index) in messages" :key="index">
                    <div class="w-full flex flex-col space-y-1">

                        <template x-if="msg.role === 'user'">
                            <div class="flex justify-end my-1">
                                <div class="user-bubble px-4 py-2.5 rounded-2xl rounded-tr-xs text-xs leading-relaxed max-w-xl sm:max-w-2xl break-words shadow-xs select-text relative group">
                                    <div class="inline bubble-text" x-text="msg.content"></div>
                                    <span class="inline-flex items-center gap-1.5 bubble-meta text-[10px] float-right ml-3 mt-1.5 align-bottom select-none">
                                        <span x-text="formatTime(msg.created_at) || 'Baru saja'"></span>
                                        <svg class="w-3 h-3 bubble-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7m-14 4l4 4L19 7" />
                                        </svg>
                                        <button @click.stop="deleteSingleMessage(msg.id, index)"
                                                class="opacity-0 group-hover:opacity-100 p-0.5 hover:text-red-500 transition-opacity cursor-pointer ml-0.5"
                                                title="Hapus Pesan">
                                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </template>

                        <template x-if="msg.role === 'assistant'">
                            <div class="flex justify-start my-1">
                                <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] px-4 py-3 rounded-2xl rounded-tl-xs text-xs text-[var(--text-primary)] leading-relaxed max-w-xl sm:max-w-2xl shadow-xs relative group select-text">

                                    <div class="chat-content text-xs leading-relaxed space-y-1.5" x-html="renderMarkdown(msg.content)"></div>

                                    <div class="flex items-center justify-between gap-2 mt-2 select-none border-t border-[var(--border-color)]/60 pt-1.5">
                                        <div class="flex items-center gap-1.5">
                                            <template x-if="!msg.is_offline_fallback">
                                                <span class="inline-flex items-center text-[10px] text-[var(--text-muted)] font-medium">
                                                    Gemini
                                                </span>
                                            </template>
                                            <template x-if="msg.is_offline_fallback">
                                                <span class="inline-flex items-center text-[10px] text-[var(--text-muted)] font-medium">
                                                    Offline
                                                </span>
                                            </template>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <button @click="copyText(msg.content, $event)"
                                                    class="opacity-0 group-hover:opacity-100 p-0.5 text-[var(--text-muted)] hover:text-emerald-500 rounded transition-opacity cursor-pointer"
                                                    title="Salin Pesan">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                            <button @click.stop="deleteSingleMessage(msg.id, index)"
                                                    class="opacity-0 group-hover:opacity-100 p-0.5 text-[var(--text-muted)] hover:text-red-500 rounded transition-opacity cursor-pointer"
                                                    title="Hapus Pesan">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <span class="text-[10px] text-[var(--text-muted)]" x-text="formatTime(msg.created_at) || 'Baru saja'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <div x-show="isTyping" x-cloak class="flex justify-start my-1">
                    <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] px-4 py-2.5 rounded-2xl rounded-tl-xs flex items-center gap-2.5">
                        <span class="text-xs text-[var(--text-muted)]">TATA sedang menganalisis data Anda</span>
                        <div class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-bounce" style="animation-delay: 0ms"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-bounce" style="animation-delay: 150ms"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-bounce" style="animation-delay: 300ms"></span>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="p-3 sm:p-4 border-t border-[var(--border-color)] bg-[var(--bg-card)] flex-shrink-0">
                <form @submit.prevent="sendMessage()" class="relative flex items-center gap-2.5">
                    <div class="flex-1 relative">
                        <textarea x-ref="messageInput"
                                  x-model="inputMessage"
                                  @keydown="handleKeydown($event)"
                                  @input="autoGrow($event.target)"
                                  rows="1"
                                  placeholder="Ketik pertanyaan seputar langganan atau pengeluaran Anda..."
                                  class="w-full h-10 min-h-[40px] box-border py-2.5 px-3.5 text-xs rounded-xl bg-[var(--bg-secondary)] border border-[var(--border-color)] focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-[var(--text-primary)] placeholder-[var(--text-muted)] resize-none outline-none transition-all max-h-28 chat-scroll block leading-tight"></textarea>
                    </div>

                    <button type="submit"
                            :disabled="!inputMessage.trim() || isTyping"
                            class="h-10 w-10 rounded-xl bg-emerald-600 hover:bg-emerald-700 disabled:opacity-40 disabled:cursor-not-allowed text-white flex items-center justify-center transition-colors flex-shrink-0 cursor-pointer shadow-sm">
                        <svg x-show="!isTyping" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                        <svg x-show="isTyping" x-cloak class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
            </footer>
        </section>
    </div>
</div>

<script>
function tataChat() {
    return {
        showMobileSidebar: false,
        historyCollapsed: false,
        isTyping: false,
        inputMessage: '',
        activeSessionId: {{ $activeSession ? $activeSession->id : 'null' }},
        messages: @json($initialMessages ?? []),

        initChat() {
            this.$nextTick(() => {
                this.scrollToBottom();
                if (this.$refs.messageInput) {
                    this.$refs.messageInput.focus();
                }
            });
        },

        toggleSidebar() {
            if (window.innerWidth >= 1024) {
                this.historyCollapsed = !this.historyCollapsed;
            } else {
                this.showMobileSidebar = !this.showMobileSidebar;
            }
        },

        handleKeydown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                this.sendMessage();
            }
        },

        autoGrow(el) {
            el.style.height = '40px';
            if (el.scrollHeight > 40) {
                el.style.height = Math.min(el.scrollHeight, 120) + 'px';
            }
        },

        scrollToBottom() {
            const container = document.getElementById('chatMessagesContainer');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        sendPrompt(promptText) {
            this.inputMessage = promptText;
            this.sendMessage();
        },

        async sendMessage() {
            const text = this.inputMessage.trim();
            if (!text || this.isTyping) return;

            const now = new Date();
            const timeString = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

            this.messages.push({
                id: null,
                role: 'user',
                content: text,
                created_at: timeString,
            });

            this.inputMessage = '';
            if (this.$refs.messageInput) {
                this.$refs.messageInput.style.height = '40px';
            }

            this.isTyping = true;
            this.$nextTick(() => this.scrollToBottom());

            try {
                const response = await fetch("{{ route('assistant.chat.send') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: text,
                        session_id: this.activeSessionId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.messages.push({
                        id: data.message.id,
                        role: 'assistant',
                        content: data.message.content,
                        is_offline_fallback: data.message.is_offline_fallback,
                        created_at: data.message.created_at,
                    });

                    if (data.session_id) {
                        this.activeSessionId = data.session_id;
                    }
                } else {
                    this.messages.push({
                        id: null,
                        role: 'assistant',
                        content: 'Maaf, terjadi kendala saat memproses jawaban. Silakan coba lagi sebentar lagi.',
                        is_offline_fallback: true,
                        created_at: timeString,
                    });
                }
            } catch (err) {
                console.error(err);
                this.messages.push({
                    id: null,
                    role: 'assistant',
                    content: 'Koneksi terputus. Pastikan perangkat Anda terhubung ke internet dan coba lagi.',
                    is_offline_fallback: true,
                    created_at: timeString,
                });
            } finally {
                this.isTyping = false;
                this.$nextTick(() => {
                    this.scrollToBottom();
                    if (this.$refs.messageInput) {
                        this.$refs.messageInput.focus();
                    }
                });
            }
        },

        async deleteSingleMessage(msgId, index) {
            if (!confirm('Apakah Anda yakin ingin menghapus pesan ini?')) return;

            this.messages.splice(index, 1);

            if (msgId) {
                try {
                    await fetch(`/assistant/chat/message/${msgId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                } catch (e) {
                    console.error('Gagal menghapus pesan:', e);
                }
            }
        },

        async createNewSession() {
            try {
                const response = await fetch("{{ route('assistant.chat.new') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const data = await response.json();
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    window.location.reload();
                }
            } catch (e) {
                window.location.href = "{{ route('assistant.chat') }}";
            }
        },

        async deleteSession(sessionId) {
            if (!confirm('Apakah Anda yakin ingin menghapus sesi percakapan ini?')) return;

            try {
                const response = await fetch(`/assistant/chat/session/${sessionId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                window.location.href = "{{ route('assistant.chat') }}";
            } catch (e) {
                console.error(e);
            }
        },

        async clearCurrentChat() {
            if (!this.activeSessionId) return;
            if (!confirm('Hapus semua pesan dalam percakapan saat ini?')) return;

            try {
                const response = await fetch(`/assistant/chat/session/${this.activeSessionId}/clear`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                this.messages = [];
            } catch (e) {
                console.error(e);
            }
        },

        copyText(text, event) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = event.currentTarget;
                const originalHtml = btn.innerHTML;
                btn.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 1500);
            });
        },

        renderMarkdown(text) {
            if (!text) return '';

            let html = text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            html = html.replace(/`([^`]+)`/g, '<code>$1</code>');

            const lines = html.split('\n');
            let formattedLines = [];

            for (let line of lines) {
                let trimmed = line.trim();
                if (trimmed.startsWith('- ') || trimmed.startsWith('* ')) {
                    let content = trimmed.substring(2);
                    formattedLines.push(`<li class="list-disc marker:text-emerald-500">${content}</li>`);
                } else if (/^\d+\.\s/.test(trimmed)) {
                    let content = trimmed.replace(/^\d+\.\s/, '');
                    formattedLines.push(`<li class="list-decimal marker:text-emerald-500">${content}</li>`);
                } else if (trimmed === '') {
                    formattedLines.push('<div class="h-1.5"></div>');
                } else {
                    formattedLines.push(`<p>${line}</p>`);
                }
            }

            return formattedLines.join('');
        },

        formatTime(isoStringOrTime) {
            if (!isoStringOrTime) return '';
            if (typeof isoStringOrTime === 'string' && /^\d{1,2}:\d{2}$/.test(isoStringOrTime)) {
                return isoStringOrTime;
            }
            try {
                const d = new Date(isoStringOrTime);
                if (isNaN(d.getTime())) return isoStringOrTime;
                return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
            } catch (e) {
                return isoStringOrTime;
            }
        }
    }
}
</script>
@endsection
