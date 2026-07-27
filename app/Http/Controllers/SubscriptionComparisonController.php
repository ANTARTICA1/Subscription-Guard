<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionComparisonService;
use App\Services\SubscriptionTemplateService;
use Illuminate\Support\Facades\Auth;

class SubscriptionComparisonController extends Controller
{
    public function index(SubscriptionComparisonService $comparisonService, SubscriptionTemplateService $templateService)
    {
        $rawComparisons = $comparisonService->getComparisons();
        $comparisons = [];

        foreach ($rawComparisons as $group) {
            $items = $group['items'];
            $bestValueScore = -1;
            $bestValueIndex = -1;
            
            $cheapestPrice = PHP_INT_MAX;
            $cheapestIndex = -1;

            foreach ($items as $index => $item) {
                if ($item['value_score'] > $bestValueScore) {
                    $bestValueScore = $item['value_score'];
                    $bestValueIndex = $index;
                }
                if ($item['price_value'] < $cheapestPrice) {
                    $cheapestPrice = $item['price_value'];
                    $cheapestIndex = $index;
                }
            }

            foreach ($items as $index => &$item) {
                $item['is_best_value'] = ($index === $bestValueIndex);
                $item['is_cheapest'] = ($index === $cheapestIndex);
            }

            $group['items'] = $items;
            $comparisons[] = $group;
        }

        $mySubscriptions = Auth::user()->activeSubscriptions;
        $templates = $templateService->getTemplates();

        return view('comparisons.index', compact('comparisons', 'mySubscriptions', 'templates'));
    }
}
