<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionComparisonService;

class SubscriptionComparisonController extends Controller
{
    public function index(SubscriptionComparisonService $comparisonService)
    {
        $comparisons = $comparisonService->getComparisons();

        return view('comparisons.index', compact('comparisons'));
    }
}
