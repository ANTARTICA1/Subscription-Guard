<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())
            ->active()
            ->with('category')
            ->get();

        // Generate calendar events for current month
        $now = Carbon::now();
        $events = [];

        foreach ($subscriptions as $sub) {
            $day = $sub->payment_date;

            if ($sub->billing_cycle === 'monthly') {
                $lastDay = $now->copy()->endOfMonth()->day;
                $payDay = min($day, $lastDay);
                $events[] = [
                    'id' => $sub->id,
                    'title' => $sub->name,
                    'date' => $now->copy()->day($payDay)->format('Y-m-d'),
                    'amount' => $sub->formatted_amount,
                    'color' => $sub->category->color ?? '#6366f1',
                    'icon' => $sub->category->icon ?? '📦',
                    'auto_renew' => $sub->auto_renew,
                ];
            } elseif ($sub->billing_cycle === 'yearly') {
                $yearlyDate = Carbon::createFromDate($now->year, 1, 1)->addDays($day - 1);
                if ($yearlyDate->month === $now->month) {
                    $events[] = [
                        'id' => $sub->id,
                        'title' => $sub->name,
                        'date' => $yearlyDate->format('Y-m-d'),
                        'amount' => $sub->formatted_amount,
                        'color' => $sub->category->color ?? '#6366f1',
                        'icon' => $sub->category->icon ?? '📦',
                        'auto_renew' => $sub->auto_renew,
                    ];
                }
            } elseif ($sub->billing_cycle === 'weekly') {
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();
                $current = $startOfMonth->copy();
                while ($current <= $endOfMonth) {
                    if ($current->dayOfWeek === ($day % 7)) {
                        $events[] = [
                            'id' => $sub->id,
                            'title' => $sub->name,
                            'date' => $current->format('Y-m-d'),
                            'amount' => $sub->formatted_amount,
                            'color' => $sub->category->color ?? '#6366f1',
                            'icon' => $sub->category->icon ?? '📦',
                            'auto_renew' => $sub->auto_renew,
                        ];
                    }
                    $current->addDay();
                }
            }
        }

        return view('calendar.index', compact('events', 'subscriptions'));
    }
}
