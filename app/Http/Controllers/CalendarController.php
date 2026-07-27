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
                    'icon' => $sub->category->icon ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>',
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
                        'icon' => $sub->category->icon ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>',
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
                            'icon' => $sub->category->icon ?? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>',
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
