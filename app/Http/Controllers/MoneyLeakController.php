<?php

namespace App\Http\Controllers;

use App\Services\MoneyLeakDetectorService;
use Illuminate\Support\Facades\Auth;

class MoneyLeakController extends Controller
{
    public function index(MoneyLeakDetectorService $detector)
    {
        $result = $detector->detect(Auth::user());

        return view('leaks.index', compact('result'));
    }

    public function scan(MoneyLeakDetectorService $detector)
    {
        $result = $detector->detect(Auth::user());

        return response()->json($result);
    }
}
