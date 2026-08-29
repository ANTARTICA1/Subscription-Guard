<?php

namespace App\Http\Controllers;

use App\Services\FinancialAssistantService;
use App\Services\GeminiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FinancialAssistantController extends Controller
{
    public function index(FinancialAssistantService $financialService)
    {
        $user = Auth::user();
        $syncStatus = $financialService->checkSyncStatus($user);

        if (!empty($user->tata_assistant_data)) {
            $analysis = $user->tata_assistant_data;
            $analysis['total_monthly'] = $user->monthlyExpense();
            $analysis['total_yearly'] = $user->yearlyExpense();
            $isCached = true;
        } else {
            $analysis = $financialService->analyze($user);
            $isCached = false;
        }

        return view('assistant.index', compact('analysis', 'syncStatus', 'isCached'));
    }

    public function scan(GeminiAssistantService $geminiService, FinancialAssistantService $financialService): JsonResponse
    {
        $user = Auth::user();
        $result = $geminiService->analyze($user);

        if ($result['success']) {
            $data = $result['data'];
            $currentHash = $financialService->calculateSubscriptionHash($user);

            $user->update([
                'tata_assistant_data' => $data,
                'tata_assistant_scanned_at' => now(),
                'tata_assistant_hash' => $currentHash,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Analisis Tata Asisten berhasil diperbarui.',
                'data' => $data,
                'scanned_at' => now()->translatedFormat('d M Y H:i'),
                'is_synced' => true,
            ]);
        }

        $errorMessage = $result['error_message'] ?? 'Terjadi kesalahan pada layanan AI.';

        if (!empty($user->tata_assistant_data)) {
            $previousData = $user->tata_assistant_data;
            $previousData['total_monthly'] = $user->monthlyExpense();
            $previousData['total_yearly'] = $user->yearlyExpense();

            return response()->json([
                'success' => false,
                'has_previous_data' => true,
                'error_message' => $errorMessage,
                'warning' => 'Gagal memperbarui AI (' . $errorMessage . '). Menampilkan hasil analisis tersimpan sebelumnya.',
                'data' => $previousData,
            ]);
        }

        $fallbackData = $financialService->analyze($user);

        return response()->json([
            'success' => false,
            'has_previous_data' => false,
            'error_message' => $errorMessage,
            'warning' => 'Gagal menghubungi AI (' . $errorMessage . '). Menggunakan analisis dasar sistem.',
            'data' => $fallbackData,
        ]);
    }
}
