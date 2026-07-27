<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscoverController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        $publicSubscriptions = Subscription::public()
            ->active()
            ->where('user_id', '!=', $user->id)
            ->with(['user', 'category', 'shares'])
            ->whereDoesntHave('shares', function ($query) use ($user) {
                $query->where('friend_user_id', $user->id);
            })
            ->latest()
            ->get();

        return view('discover.index', compact('publicSubscriptions'));
    }
}
