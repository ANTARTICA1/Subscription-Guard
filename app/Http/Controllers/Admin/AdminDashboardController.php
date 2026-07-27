<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Notification;
use App\Models\Category;
use App\Models\PaymentHistory;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::active()->count();
        $totalReminders = Notification::where('status', 'sent')->count();

        // Popular categories
        $popularCategories = Category::withCount('subscriptions')
            ->orderByDesc('subscriptions_count')
            ->take(5)
            ->get();

        // Recent users
        $recentUsers = User::latest()->take(10)->get();

        // Monthly revenue chart
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');
            $chartData[] = User::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        // Subscription status distribution
        $statusData = [
            'active' => Subscription::active()->count(),
            'cancelled' => Subscription::cancelled()->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSubscriptions',
            'activeSubscriptions',
            'totalReminders',
            'popularCategories',
            'recentUsers',
            'chartLabels',
            'chartData',
            'statusData'
        ));
    }

    public function users()
    {
        $users = User::withCount('subscriptions')->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }
}
