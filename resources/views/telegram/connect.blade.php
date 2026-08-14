@extends('layouts.app')
@section('title', 'Telegram Bot')
@section('heading', 'Telegram Bot')
@section('subheading', 'Hubungkan akun untuk notifikasi pengingat otomatis')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="card bg-[#111c2e] border border-[rgba(255,255,255,0.06)] shadow-sm">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 flex-shrink-0 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center justify-center text-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
            </div>
            <div>
                <h3 class="section-title text-[#f1f5f9] mb-1">Status Koneksi</h3>
                <p class="text-xs text-[#94a3b8]">Integrasi notifikasi real-time via Telegram</p>
            </div>
        </div>

        @if($connection && $connection->isVerified())
        <div class="item-row mb-6 border-emerald-500/30 bg-emerald-500/10 p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <span class="text-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></span>
                <div>
                    <p class="font-bold text-sm text-emerald-400">Terhubung!</p>
                    <p class="text-xs text-[#94a3b8]">Chat ID: {{ $connection->chat_id }}</p>
                    <p class="text-[11px] text-[#4b5e78]">Verified: {{ $connection->verified_at->translatedFormat('d M Y H:i') }}</p>
                </div>
            </div>
            <span class="badge badge-active">TERKONEKSI</span>
        </div>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('telegram.test-notification') }}">@csrf
                <button type="submit" class="btn-primary text-xs flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> 
                    Uji Coba Notifikasi
                </button>
            </form>
            <form method="POST" action="{{ route('telegram.disconnect') }}">@csrf @method('DELETE')
                <button type="submit" class="btn-danger text-xs hover:bg-red-500 hover:text-white" onclick="return confirm('Putuskan koneksi?')">Putuskan</button>
            </form>
        </div>
        @else
        <div class="space-y-6">
            <div class="p-5 rounded-xl bg-[#080d19] border border-[rgba(255,255,255,0.06)]">
                <h4 class="text-xs font-bold text-[#94a3b8] uppercase tracking-wider mb-4">Panduan Menghubungkan:</h4>
                <ol class="space-y-3 text-xs text-[#94a3b8]">
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white px-2.5 py-0.5 rounded-lg text-[10px] flex-shrink-0 bg-emerald-500">1</span>
                        <span>Buka Telegram dan cari Bot: <strong class="text-[#f1f5f9]">@TatagihBot</strong></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white px-2.5 py-0.5 rounded-lg text-[10px] flex-shrink-0 bg-emerald-500">2</span>
                        <span>Tekan <strong class="text-[#f1f5f9]">Start</strong> atau kirim <code class="text-cyan-400">/start</code></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="font-bold text-white px-2.5 py-0.5 rounded-lg text-[10px] flex-shrink-0 bg-emerald-500">3</span>
                        <span>Kirim perintah verifikasi:</span>
                    </li>
                </ol>
            </div>

            <div class="text-center py-6 rounded-xl bg-[#080d19] border border-[rgba(255,255,255,0.06)]">
                <p class="text-xs mb-3 font-bold text-[#4b5e78] uppercase tracking-wider">Kode Verifikasi:</p>
                <div class="inline-block px-6 py-3 rounded-xl text-xl font-mono font-extrabold tracking-widest bg-[#111c2e] border-2 border-emerald-500 text-emerald-400 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                    {{ $connection->verification_code ?? 'TATAGIH-XXXXXX' }}
                </div>
                <p class="text-[11px] mt-4 text-[#94a3b8]">
                    Perintah: <code class="px-3 py-1.5 rounded-lg font-mono font-bold bg-[#111c2e] text-emerald-400 border border-[rgba(255,255,255,0.06)]">/connect {{ $connection->verification_code ?? 'KODE' }}</code>
                </p>
            </div>

            <form method="POST" action="{{ route('telegram.regenerate') }}">@csrf
                <button type="submit" class="btn-secondary text-xs w-full justify-center flex items-center gap-2 hover:border-emerald-500 hover:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg> 
                    Generate Kode Baru
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="card bg-[#111c2e] border border-[rgba(255,255,255,0.06)] shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <h3 class="section-title text-[#f1f5f9] flex items-center gap-2 mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4b5e78]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg> 
                History Notifikasi
            </h3>
            <div class="md:hidden flex items-center gap-1 text-[10px] text-[#4b5e78] italic">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                <span>Geser tabel</span>
            </div>
        </div>
        <div class="overflow-x-auto w-full rounded-xl border border-[rgba(255,255,255,0.06)]">
            <table class="modern-table w-full min-w-[500px] whitespace-nowrap">
                <thead>
                    <tr>
                        <th>Subscription</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notif)
                    <tr class="hover:bg-[#192a42] transition-colors">
                        <td class="font-semibold text-[#f1f5f9]">{{ $notif->subscription->name ?? 'System' }}</td>
                        <td><span class="badge badge-accent">{{ $notif->type }}</span></td>
                        <td><span class="badge badge-{{ $notif->status === 'sent' ? 'active' : ($notif->status === 'pending' ? 'pending' : 'danger') }}">{{ strtoupper($notif->status) }}</span></td>
                        <td class="text-[#94a3b8] text-xs">{{ $notif->created_at->translatedFormat('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-6 text-[11px] text-[#4b5e78]">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
