<?php

namespace App\Http\Controllers;

use App\Services\FinancialAssistantService;
use Illuminate\Support\Facades\Auth;

class FinancialAssistantController extends Controller
{
    public function index(FinancialAssistantService $service)
    {
        $analysis = $service->analyze(Auth::user());

        return view('assistant.index', compact('analysis'));
    }
}
