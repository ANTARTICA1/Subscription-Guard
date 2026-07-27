<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        $pendingRequests = Friendship::where('friend_id', $user->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        
        $acceptedFriendships = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)->orWhere('friend_id', $user->id);
        })->where('status', 'accepted')->get();

        $friendIds = $acceptedFriendships->map(fn($f) => $f->user_id === $user->id ? $f->friend_id : $f->user_id);
        $friends = User::whereIn('id', $friendIds)->get();

        return view('social.index', compact('user', 'pendingRequests', 'friends'));
    }

    public function addFriend(Request $request)
    {
        $request->validate([
            'user_tag' => 'required|string',
        ]);

        $tag = strtoupper(trim($request->user_tag));
        $friend = User::where('user_tag', $tag)->first();

        if (!$friend) {
            return back()->with('error', "User dengan Tag '{$tag}' tidak ditemukan.");
        }

        if ($friend->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menambahkan diri sendiri sebagai teman.');
        }

        $existing = Friendship::where(function ($q) use ($friend) {
            $q->where('user_id', Auth::id())->where('friend_id', $friend->id);
        })->orWhere(function ($q) use ($friend) {
            $q->where('user_id', $friend->id)->where('friend_id', Auth::id());
        })->first();

        if ($existing) {
            if ($existing->status === 'accepted') {
                return back()->with('error', "Anda sudah berteman dengan {$friend->name}.");
            }
            return back()->with('error', 'Permintaan pertemanan sudah dikirim sebelumnya.');
        }

        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $friend->id,
            'status' => 'accepted', 
        ]);

        return back()->with('success', "Berhasil menambahkan {$friend->name} ({$friend->user_tag}) sebagai teman!");
    }

    public function addFriendByTag($tag)
    {
        $tag = strtoupper(trim($tag));
        $friend = User::where('user_tag', $tag)->first();

        if (!$friend) {
            return redirect()->route('social.index')->with('error', "User dengan Tag '{$tag}' tidak ditemukan.");
        }

        if ($friend->id === Auth::id()) {
            return redirect()->route('social.index')->with('error', 'Anda tidak dapat menambahkan diri sendiri sebagai teman.');
        }

        $existing = Friendship::where(function ($q) use ($friend) {
            $q->where('user_id', Auth::id())->where('friend_id', $friend->id);
        })->orWhere(function ($q) use ($friend) {
            $q->where('user_id', $friend->id)->where('friend_id', Auth::id());
        })->first();

        if ($existing) {
            if ($existing->status === 'accepted') {
                return redirect()->route('social.index')->with('error', "Anda sudah berteman dengan {$friend->name}.");
            }
            return redirect()->route('social.index')->with('error', 'Permintaan pertemanan sudah dikirim sebelumnya.');
        }

        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $friend->id,
            'status' => 'accepted', 
        ]);

        return redirect()->route('social.index')->with('success', "Berhasil menambahkan {$friend->name} ({$friend->user_tag}) sebagai teman dari QR Code!");
    }

    public function acceptFriend($id)
    {
        $friendship = Friendship::where('id', $id)->where('friend_id', Auth::id())->firstOrFail();
        $friendship->update(['status' => 'accepted']);

        return back()->with('success', 'Permintaan pertemanan diterima!');
    }

    public function removeFriend($id)
    {
        $user = Auth::user();
        Friendship::where(function ($q) use ($user, $id) {
            $q->where('user_id', $user->id)->where('friend_id', $id);
        })->orWhere(function ($q) use ($user, $id) {
            $q->where('user_id', $id)->where('friend_id', $user->id);
        })->delete();

        return back()->with('success', 'Pertemanan berhasil dihapus.');
    }
}
