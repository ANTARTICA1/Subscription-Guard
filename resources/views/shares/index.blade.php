@extends('layouts.app')
@section('title', 'Patungan Subscriptions')
@section('heading', 'Sistem Patungan Canggih')
@section('subheading', 'Bagi biaya subscription dengan teman. Pantau status pembayaran, kirim reminder, dan validasi bukti transfer secara real-time.')

@section('content')
<div class="max-w-6xl space-y-8" x-data="shareFormComponent()">
    
    
    <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-2xl p-6 shadow-sm mb-8">
            <h3 class="text-xl font-bold text-[var(--text-primary)] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Anggota ke Langganan Anda
            </h3>
            
            <p class="text-sm text-[var(--text-muted)] mb-6 border-l-4 border-[var(--accent-primary)] pl-3 bg-[var(--accent-primary)]/5 py-2 rounded-r-lg">
                <strong>Catatan:</strong> Form ini akan <u>menambahkan teman</u> ke tagihan langganan yang sudah Anda miliki. Jika Anda ingin membuat grup/tagihan yang sepenuhnya terpisah untuk orang lain, silakan <a href="{{ route('subscriptions.index') }}" class="text-[var(--accent-primary)] font-bold hover:underline">Buat Langganan Baru</a> terlebih dahulu.
            </p>

        <form method="POST" action="{{ route('shares.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[var(--text-secondary)] mb-2">Pilih Subscription</label>
                    <select name="subscription_id" x-model="subId" @change="updateAmount()" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-[var(--text-primary)] focus:ring-2 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-all" required>
                        <option value="">Pilih Subscription...</option>
                        @foreach($mySubscriptions as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }} ({{ $sub->formatted_amount }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[var(--text-secondary)] mb-2">Pilih Teman</label>
                    <select name="friend_user_id" class="w-full bg-[var(--bg-primary)] border border-[var(--border-color)] rounded-xl px-4 py-3 text-[var(--text-primary)] focus:ring-2 focus:ring-[var(--accent-primary)] focus:border-[var(--accent-primary)] transition-all" required>
                        <option value="">Pilih Teman...</option>
                        @foreach($friends as $f)
                        <option value="{{ $f->id }}">{{ $f->name }} ({{ $f->user_tag }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            
            <div x-show="subId !== ''" class="p-5 rounded-xl border border-[var(--border-color)] bg-[var(--bg-elevated)] mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-[var(--text-primary)] mb-1 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        Kalkulasi Pembagian Otomatis
                    </p>
                    <p class="text-xs text-[var(--text-muted)]">
                        Total <span x-text="existingCount + 2" class="text-[var(--text-primary)] font-bold"></span> Orang (Ketua + Anggota). Tagihan akan dibagi rata.
                    </p>
                </div>
                
                <div class="text-right">
                    <p class="text-xs text-[var(--text-muted)] mb-1">Perkiraan Biaya per Orang</p>
                    <p class="text-2xl font-black text-[var(--accent-primary)]">Rp<span x-text="new Intl.NumberFormat('id-ID').format(subAmount)">0</span></p>
                </div>

                <input type="hidden" name="split_amount" x-model="subAmount">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-[var(--accent-primary)] hover:bg-[var(--accent-secondary)] text-white font-bold py-3 px-8 rounded-xl transition-all">
                    Undang ke Patungan
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-[var(--text-primary)] flex items-center gap-2 border-b border-[var(--border-color)] pb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                Grup yang Anda Kelola (Ketua)
            </h3>

            <div class="space-y-5">
                @forelse($mySharedSubscriptions as $sub)
                <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-xl overflow-hidden shadow-sm" x-data="{ showQrModal: false }">
                    
                    <div class="p-5 border-b border-[var(--border-color)] bg-[var(--bg-elevated)] flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-light)] flex items-center justify-center text-xl shadow-sm">
                                {{ $sub->category->icon ?? '' }}
                                @empty($sub->category->icon)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                @endempty
                            </div>
                            <div>
                                <h4 class="font-bold text-[var(--text-primary)]">{{ $sub->name }}</h4>
                                <p class="text-xs text-[var(--text-muted)] mt-1">
                                    {{ $sub->formatted_amount }}/{{ $sub->billing_cycle }} • Rp{{ number_format($sub->amount / ($sub->shares->count() + 1), 0, ',', '.') }}/orang
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('shares.toggle-public', $sub->id) }}">
                                @csrf
                                <button type="submit" class="p-2 rounded-lg border border-[var(--border-color)] transition-colors {{ $sub->is_public ? 'bg-[var(--accent-primary)]/10 text-[var(--accent-primary)] border-[var(--accent-primary)]/30' : 'bg-[var(--bg-primary)] text-[var(--text-secondary)] hover:text-[var(--text-primary)]' }}" title="{{ $sub->is_public ? 'Jadikan Privat' : 'Jadikan Publik (Cari Teman)' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </button>
                            </form>
                            <button @click="showQrModal = true" class="p-2 rounded-lg bg-[var(--bg-primary)] text-[var(--text-secondary)] border border-[var(--border-color)] hover:text-[var(--text-primary)] transition-colors" title="Tampilkan QR Join">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </button>
                        </div>
                    </div>

                    
                    <div class="p-4 space-y-3">
                        <h5 class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2">Daftar Anggota Grup</h5>
                        
                        <div class="flex items-center justify-between p-3 rounded-xl bg-amber-500/5 border border-amber-500/20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-600 font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[var(--text-primary)]">{{ auth()->user()->name }} <span class="text-xs font-normal text-[var(--text-muted)]">(Anda)</span></p>
                                    <p class="text-xs text-[var(--text-muted)]">Ketua Grup • Menanggung Rp{{ number_format($sub->amount / ($sub->shares->count() + 1), 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 rounded text-[10px] font-bold bg-amber-500/10 text-amber-600 border border-amber-500/30 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    KETUA
                                </span>
                            </div>
                        </div>

                        @foreach($sub->shares as $share)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[var(--bg-primary)] border border-[var(--border-color)]" x-data="{ showBukti: false }">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-light)] flex items-center justify-center text-[var(--text-primary)] font-bold">
                                    {{ substr($share->friend_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[var(--text-primary)]">{{ $share->friend_name }}</p>
                                    <p class="text-xs text-[var(--text-muted)]">{{ $share->formatted_split_amount }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                @if($share->payment_status === 'paid')
                                    <span class="px-2 py-1 rounded text-[10px] font-bold bg-[var(--accent-primary)]/10 text-[var(--accent-primary)] border border-[var(--accent-primary)]/30">
                                        LUNAS
                                    </span>
                                    <button @click="showBukti = true" class="px-2 py-1 rounded text-[10px] font-bold bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] hover:bg-[var(--bg-secondary)] flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        Bukti
                                    </button>
                                @elseif($share->payment_proof_path)
                                    <span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-500/10 text-blue-500 border border-blue-500/30">
                                        MENUNGGU VALIDASI
                                    </span>
                                    <button @click="showBukti = true" class="px-2 py-1 rounded text-[10px] font-bold bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] hover:bg-[var(--bg-secondary)] flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        Bukti
                                    </button>
                                    <form method="POST" action="{{ route('shares.mark-paid', $share->id) }}" class="ml-1">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 rounded text-[10px] font-bold bg-green-500 text-white hover:bg-green-600 transition-colors flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            Terima
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('shares.reject-proof', $share->id) }}" class="ml-1" onsubmit="return confirm('Tolak bukti bayar ini? Gambar akan dihapus dan status dikembalikan ke Menunggu Pembayaran.')">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 rounded text-[10px] font-bold bg-red-500 text-white hover:bg-red-600 transition-colors flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            Tolak
                                        </button>
                                    </form>
                                @else
                                    <span class="px-2 py-1 rounded text-[10px] font-bold bg-amber-500/10 text-amber-500 border border-amber-500/30">
                                        BELUM BAYAR
                                    </span>
                                @endif

                                <form method="POST" action="{{ route('shares.destroy', $share->id) }}" onsubmit="return confirm('Keluarkan anggota ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-400 hover:bg-red-400/10 rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>

                            
                            <div x-show="showBukti" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" @click.away="showBukti = false">
                                <div class="bg-[var(--bg-secondary)] p-6 rounded-2xl max-w-sm w-full border border-[var(--border-color)] text-center relative shadow-xl">
                                    <h4 class="text-lg font-bold text-[var(--text-primary)] mb-4">Bukti Transfer</h4>
                                    
                                    <div class="bg-[var(--bg-primary)] p-2 rounded-xl mb-6 shadow-sm border border-[var(--border-color)] text-center">
                                        @if($share->payment_proof_path)
                                            <img src="{{ Storage::url($share->payment_proof_path) }}" alt="Bukti Transfer" class="w-full rounded-lg object-contain max-h-64 mb-3">
                                        @else
                                            <div class="py-8 text-[var(--text-muted)] flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                <p class="text-xs">Tidak ada gambar bukti</p>
                                            </div>
                                        @endif
                                        <p class="text-xs font-bold text-[var(--text-secondary)] mb-1">Transfer ke:</p>
                                        <p class="font-bold text-sm mb-3 text-[var(--text-primary)]">Ketua {{ $sub->user->name ?? 'Anda' }}</p>
                                        
                                        <p class="text-xs font-bold text-[var(--text-secondary)] mb-1">Nominal:</p>
                                        <p class="font-black text-2xl text-[var(--text-primary)]">{{ $share->formatted_split_amount }}</p>
                                    </div>
                                    <button @click="showBukti = false" class="w-full bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] font-bold py-3 rounded-xl hover:bg-[var(--bg-primary)] transition-colors">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($sub->shares->count() === 0)
                            <p class="text-sm text-center text-[var(--text-muted)] py-4">Belum ada anggota yang bergabung.</p>
                        @endif
                    </div>

                    
                    <div x-show="showQrModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" @click.away="showQrModal = false">
                        <div class="bg-[var(--bg-secondary)] p-8 rounded-2xl max-w-sm w-full border border-[var(--border-color)] text-center shadow-xl">
                            <div class="w-16 h-16 mx-auto bg-[var(--bg-elevated)] border border-[var(--border-color)] text-[var(--text-primary)] rounded-xl flex items-center justify-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </div>
                            <h4 class="text-xl font-bold text-[var(--text-primary)] mb-2">Invite Link Grup</h4>
                            <p class="text-sm text-[var(--text-muted)] mb-6">Suruh temanmu scan QR ini untuk join ke tagihan <strong>{{ $sub->name }}</strong>.</p>
                            
                            <div class="p-4 bg-white rounded-xl inline-block mb-6 shadow-sm border border-slate-200">
                                <img src="{{ $sub->qr_code_url }}" alt="QR Code Join Grup" class="w-48 h-48 mx-auto rounded-lg">
                            </div>
                            
                            <button @click="showQrModal = false" class="w-full bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] font-bold py-3 rounded-xl hover:bg-[var(--bg-primary)] transition-colors">Tutup</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 border border-dashed border-[var(--border-color)] rounded-xl text-center bg-[var(--bg-secondary)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-[var(--text-muted)] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    <p class="text-[var(--text-muted)] text-sm">Anda belum membuat grup patungan apapun.</p>
                </div>
                @endforelse
            </div>
        </div>

        
        <div class="space-y-6">
            <h3 class="text-lg font-bold text-[var(--text-primary)] flex items-center gap-2 border-b border-[var(--border-color)] pb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--text-secondary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" /></svg>
                Patungan Anda (Anggota)
            </h3>

            <div class="space-y-4">
                @forelse($sharedWithMe as $share)
                <div class="bg-[var(--bg-secondary)] border border-[var(--border-color)] rounded-xl p-5 shadow-sm relative overflow-hidden" x-data="{ showUpload: false }">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-light)] flex items-center justify-center text-xl shadow-sm">
                                {{ $share->subscription->category->icon ?? '' }}
                                @empty($share->subscription->category->icon)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                @endempty
                            </div>
                            <div>
                                <h4 class="font-bold text-[var(--text-primary)]">{{ $share->subscription->name }}</h4>
                                <p class="text-xs text-[var(--text-muted)] mt-1">Ketua: {{ $share->owner->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-[var(--text-primary)]">{{ $share->formatted_split_amount }}</p>
                            @if($share->payment_status === 'paid')
                                <span class="px-2 py-1 rounded text-[10px] font-bold bg-[var(--accent-primary)]/10 text-[var(--accent-primary)] border border-[var(--accent-primary)]/30">SUDAH LUNAS</span>
                            @elseif($share->payment_proof_path)
                                <span class="px-2 py-1 rounded text-[10px] font-bold bg-blue-500/10 text-blue-500 border border-blue-500/30">MENUNGGU VALIDASI</span>
                            @else
                                <span class="px-2 py-1 rounded text-[10px] font-bold bg-amber-500/10 text-amber-500 border border-amber-500/30">BELUM BAYAR</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-[var(--border-color)]">
                        <p class="text-xs font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-3">Daftar Anggota Grup ({{ $share->subscription->shares->count() + 1 }} Orang)</p>
                        <div class="space-y-2">
                            
                            <div class="flex items-center justify-between p-2 rounded-lg bg-amber-500/5 border border-amber-500/20">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-amber-500/10 text-amber-600 flex items-center justify-center text-xs font-bold">
                                        {{ substr($share->owner->name, 0, 1) }}
                                    </div>
                                    <p class="text-sm font-bold text-[var(--text-primary)]">{{ $share->owner->name }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-amber-500/10 text-amber-600 border border-amber-500/30 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                    KETUA
                                </span>
                            </div>
                            
                            
                            @foreach($share->subscription->shares as $memberShare)
                            <div class="flex items-center justify-between p-2 rounded-lg bg-[var(--bg-primary)] border border-[var(--border-color)]">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[var(--bg-elevated)] border border-[var(--border-light)] flex items-center justify-center text-xs font-bold text-[var(--text-primary)]">
                                        {{ substr($memberShare->friend_name, 0, 1) }}
                                    </div>
                                    <p class="text-sm font-bold text-[var(--text-primary)]">
                                        {{ $memberShare->friend_name }} 
                                        @if($memberShare->friend_user_id === auth()->id())
                                            <span class="text-xs font-normal text-[var(--text-muted)]">(Anda)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @if($share->payment_status !== 'paid')
                    <div class="pt-4 border-t border-[var(--border-color)] flex gap-2">
                        <form method="POST" action="{{ route('shares.destroy', $share->id) }}" onsubmit="return confirm('Anda yakin ingin menolak dan keluar dari grup patungan ini?')" class="flex-none">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white border border-red-500/30 font-bold py-2 px-3 rounded-lg text-sm transition-colors flex items-center justify-center h-full" title="Tolak Patungan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </form>
                        <button @click="showUpload = true" class="flex-1 bg-[var(--bg-elevated)] text-[var(--text-primary)] hover:bg-[var(--bg-primary)] border border-[var(--border-color)] font-bold py-2 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            Upload Bukti Transfer
                        </button>
                    </div>
                    @endif

                    
                    <div x-show="showUpload" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" @click.away="showUpload = false">
                        <div class="bg-[var(--bg-secondary)] p-8 rounded-2xl max-w-sm w-full border border-[var(--border-color)] text-center shadow-xl">
                            <h4 class="text-xl font-bold text-[var(--text-primary)] mb-2">Upload Bukti TF</h4>
                            <p class="text-sm text-[var(--text-muted)] mb-6">Silakan transfer <strong>{{ $share->formatted_split_amount }}</strong> ke rekening Ketua, lalu upload buktinya ke sini.</p>
                            
                            <form method="POST" action="{{ route('shares.upload-proof', $share->id) }}" enctype="multipart/form-data">
                                @csrf
                                
                                <label for="proof_{{ $share->id }}" class="block border-2 border-dashed border-[var(--border-color)] rounded-xl p-8 mb-6 hover:border-[var(--accent-primary)] hover:bg-[var(--bg-elevated)] transition-colors cursor-pointer group bg-[var(--bg-primary)]">
                                    <div class="w-12 h-12 mx-auto rounded-lg bg-[var(--bg-elevated)] border border-[var(--border-light)] flex items-center justify-center mb-3 group-hover:bg-[var(--accent-primary)]/10 group-hover:text-[var(--accent-primary)] group-hover:border-[var(--accent-primary)]/30 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--text-muted)] group-hover:text-[var(--accent-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    </div>
                                    <p class="text-sm font-bold text-[var(--text-secondary)] group-hover:text-[var(--text-primary)]">Pilih File Screenshot</p>
                                    <p class="text-[10px] text-[var(--text-muted)] mt-1">JPG, PNG (Max. 2MB)</p>
                                    <input type="file" id="proof_{{ $share->id }}" name="proof" class="hidden" accept="image/jpeg, image/png, image/jpg" required>
                                </label>
                                
                                <div class="flex gap-3">
                                    <button type="button" @click="showUpload = false" class="flex-1 bg-[var(--bg-elevated)] text-[var(--text-primary)] border border-[var(--border-color)] font-bold py-3 rounded-xl hover:bg-[var(--bg-primary)] transition-colors">Batal</button>
                                    
                                    <button type="submit" class="flex-1 bg-[var(--accent-primary)] text-white font-bold py-3 rounded-xl hover:bg-[var(--accent-secondary)] transition-colors">Kirim Bukti</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 border border-dashed border-[var(--border-color)] rounded-xl text-center bg-[var(--bg-secondary)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-[var(--text-muted)] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" /></svg>
                    <p class="text-[var(--text-muted)] text-sm">Anda belum tergabung di grup patungan apapun.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function shareFormComponent() {
    return {
        subId: '',
        subs: @json($mySubscriptions),
        subAmount: 0,
        totalAmount: 0,
        existingCount: 0,
        memberType: 'friend',
        updateAmount() {
            const found = this.subs.find(s => s.id == this.subId);
            if (found) {
                this.totalAmount = Number(found.amount);
                this.existingCount = (found.shares ? found.shares.length : 0);
                const totalPeople = this.existingCount + 2; // Ketua + current members + 1 new member
                this.subAmount = Math.round(this.totalAmount / totalPeople);
            } else {
                this.totalAmount = 0;
                this.existingCount = 0;
                this.subAmount = 0;
            }
        }
    };
}
</script>
@endsection
