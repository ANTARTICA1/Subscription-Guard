<?php

namespace App\Http\Controllers;

use App\Models\TataChatMessage;
use App\Models\TataChatSession;
use App\Services\TataChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TataChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sessions = $user->tataChatSessions()->get();

        $activeSessionId = $request->query('session_id');
        $activeSession = null;

        if ($activeSessionId) {
            $activeSession = $sessions->firstWhere('id', $activeSessionId);
        }

        if (!$activeSession && $sessions->isNotEmpty()) {
            $activeSession = $sessions->first();
        }

        if (!$activeSession) {
            $activeSession = $user->tataChatSessions()->create([
                'title' => 'Percakapan Baru',
            ]);
            $sessions = $user->tataChatSessions()->get();
        }

        $messages = $activeSession->messages;

        $initialMessages = $messages->map(function ($m) {
            return [
                'id' => $m->id,
                'role' => $m->role,
                'content' => $m->content,
                'is_offline_fallback' => (bool) $m->is_offline_fallback,
                'created_at' => $m->created_at->toIso8601String(),
            ];
        })->values()->toArray();

        $quickStats = [
            'total_active' => $user->activeSubscriptions()->count(),
            'monthly_expense' => $user->monthlyExpense(),
            'yearly_expense' => $user->yearlyExpense(),
            'health_score' => $user->tata_assistant_data['health_score'] ?? null,
            'potential_savings' => $user->tata_assistant_data['potential_savings'] ?? null,
        ];

        return view('assistant.chat', compact('sessions', 'activeSession', 'messages', 'initialMessages', 'quickStats'));
    }

    public function sendMessage(Request $request, TataChatService $chatService): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'session_id' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $sessionId = $request->input('session_id');

        $session = null;
        if ($sessionId) {
            $session = $user->tataChatSessions()->find($sessionId);
        }

        if (!$session) {
            $session = $user->tataChatSessions()->create([
                'title' => 'Percakapan Baru',
            ]);
        }

        $userText = trim($request->input('message'));

        if ($session->title === 'Percakapan Baru' || empty($session->title)) {
            $cleaned = Str::limit(preg_replace('/[^\p{L}\p{N}\s]/u', '', $userText), 35, '...');
            $session->update(['title' => $cleaned ?: 'Percakapan Langganan']);
        }

        $userMessage = $session->messages()->create([
            'user_id' => $user->id,
            'role' => 'user',
            'content' => $userText,
            'is_offline_fallback' => false,
        ]);

        $previousMessages = $session->messages()
            ->where('id', '<', $userMessage->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'role' => $msg->role,
                    'content' => $msg->content,
                ];
            })
            ->toArray();

        $result = $chatService->generateResponse($user, $userText, $previousMessages);

        $assistantMessage = $session->messages()->create([
            'user_id' => $user->id,
            'role' => 'assistant',
            'content' => $result['content'],
            'is_offline_fallback' => $result['is_offline_fallback'] ?? false,
        ]);

        $session->touch();

        return response()->json([
            'success' => true,
            'session_id' => $session->id,
            'session_title' => $session->title,
            'message' => [
                'id' => $assistantMessage->id,
                'role' => 'assistant',
                'content' => $assistantMessage->content,
                'is_offline_fallback' => $assistantMessage->is_offline_fallback,
                'created_at' => $assistantMessage->created_at->toIso8601String(),
            ],
            'model_used' => $result['model_used'] ?? 'gemini',
        ]);
    }

    public function createSession(Request $request)
    {
        $user = Auth::user();
        $newSession = $user->tataChatSessions()->create([
            'title' => 'Percakapan Baru',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'session' => $newSession,
                'redirect_url' => route('assistant.chat', ['session_id' => $newSession->id]),
            ]);
        }

        return redirect()->route('assistant.chat', ['session_id' => $newSession->id]);
    }

    public function deleteSession($id)
    {
        $user = Auth::user();
        $session = $user->tataChatSessions()->findOrFail($id);
        $session->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('assistant.chat');
    }

    public function clearMessages($id)
    {
        $user = Auth::user();
        $session = $user->tataChatSessions()->findOrFail($id);
        $session->messages()->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('assistant.chat', ['session_id' => $session->id]);
    }

    public function deleteMessage($id): JsonResponse
    {
        $user = Auth::user();
        $message = TataChatMessage::where('user_id', $user->id)->findOrFail($id);
        $message->delete();

        return response()->json(['success' => true]);
    }
}
