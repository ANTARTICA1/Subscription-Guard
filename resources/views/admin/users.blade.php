@extends('layouts.app')
@section('title', 'Kelola User')
@section('heading', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg> Kelola User')
@section('subheading', 'Daftar semua pengguna Tatagih')

@section('content')
<div class="card">
    <div class="overflow-x-auto">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Subscriptions</th>
                    <th>Telegram</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold text-white" style="background: var(--accent-gradient);">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold" style="color: var(--text-primary);">{{ $u->name }}</span>
                        </div>
                    </td>
                    <td style="color: var(--text-secondary);">{{ $u->email }}</td>
                    <td><span class="badge {{ $u->role === 'admin' ? 'badge-pending' : 'badge-active' }}">{{ $u->role }}</span></td>
                    <td class="font-bold" style="color: var(--text-primary);">{{ $u->subscriptions_count }}</td>
                    <td>
                        @if($u->telegram_chat_id)
                        <span class="badge badge-active">Connected</span>
                        @else
                        <span class="badge" style="background: rgba(100,116,139,0.15); color: #94a3b8;">-</span>
                        @endif
                    </td>
                    <td style="color: var(--text-muted);">{{ $u->created_at->translatedFormat('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
