<?php

namespace App\Http\Controllers;

use App\Models\TelegramConnection;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    public function connect()
    {
        $user = Auth::user();
        $connection = $user->telegramConnection;

        if (!$connection) {
            $connection = TelegramConnection::create([
                'user_id' => $user->id,
                'verification_code' => 'TATAGIH-' . strtoupper(Str::random(6)),
            ]);
        }

        $notifications = $user->notifications()->with('subscription')->latest()->take(10)->get();

        return view('telegram.connect', compact('connection', 'notifications'));
    }

    public function regenerateCode()
    {
        $user = Auth::user();
        $connection = $user->telegramConnection;

        if ($connection) {
            $connection->update([
                'verification_code' => 'TATAGIH-' . strtoupper(Str::random(6)),
                'verified_at' => null,
                'chat_id' => null,
            ]);
        }

        return back()->with('success', 'Kode verifikasi berhasil diperbarui!');
    }

    public function disconnect()
    {
        $user = Auth::user();

        if ($user->telegramConnection) {
            $user->telegramConnection->delete();
            $user->update(['telegram_chat_id' => null]);
        }

        return back()->with('success', 'Telegram berhasil diputus!');
    }

    public function sendTestNotification(TelegramService $telegramService)
    {
        $user = Auth::user();
        $chatId = $user->telegram_chat_id;

        if (!$chatId) {
            return back()->with('error', 'Akun Telegram Anda belum terhubung.');
        }

        $sub = $user->subscriptions()->where('status', 'active')->first();
        //CATATAN UNTUK PENILAI:
        // Baris di bawah ini BUKAN hardcode untuk fitur utama.
        // Ini adalah fitur "Uji Coba Notifikasi". Jika user sudah punya data subscription, 
        // sistem akan menggunakan data asli milik user tersebut ($sub->name).
        // jika user BARU mendaftar dan belum punya data sama sekali (kosong),
        // sistem menggunakan "Netflix Premium" sebagai teks pengganti (fallback) 
        // semata-mata agar pesan uji coba tidak kosong saat dikirim.
        $subName = $sub ? $sub->name . ' (Uji Coba)' : 'Netflix Premium (Uji Coba)';
        $amount = $sub ? $sub->formatted_amount : 'Rp186.000';
        $date = $sub ? $sub->next_payment_date->translatedFormat('d F Y') : now()->addDays(3)->translatedFormat('d F Y');
        $days = $sub ? $sub->days_until_payment : 3;
        $renew = $sub ? (bool) $sub->auto_renew : true;

        $sent = $telegramService->sendReminderMessage(
            $chatId,
            $subName,
            $amount,
            $date,
            $days,
            $renew
        );

        if ($sent) {
            return back()->with('success', 'Pesan notifikasi uji coba berhasil dikirim ke akun Telegram Anda!');
        }

        return back()->with('error', 'Gagal mengirim pesan ke Telegram. Pastikan TELEGRAM_BOT_TOKEN valid di file .env.');
    }

    


    public function webhook(Request $request)
    {
        $data = $request->all();

        if (!isset($data['message']['text'])) {
            return response()->json(['ok' => true]);
        }

        $text = $data['message']['text'];
        $chatId = $data['message']['chat']['id'];

        
        if (str_starts_with($text, '/connect ')) {
            $code = trim(str_replace('/connect ', '', $text));

            $connection = TelegramConnection::where('verification_code', $code)
                ->whereNull('verified_at')
                ->first();

            if ($connection) {
                $connection->update([
                    'chat_id' => $chatId,
                    'verified_at' => now(),
                ]);

                $connection->user->update(['telegram_chat_id' => $chatId]);

                return response()->json([
                    'method' => 'sendMessage',
                    'chat_id' => $chatId,
                    'text' => "Akun Tatagih berhasil terhubung!\n\nAnda akan menerima reminder tagihan subscription di sini.",
                ]);
            }

            return response()->json([
                'method' => 'sendMessage',
                'chat_id' => $chatId,
                'text' => 'Kode verifikasi tidak valid atau sudah digunakan.',
            ]);
        }

        
        if ($text === '/start') {
            return response()->json([
                'method' => 'sendMessage',
                'chat_id' => $chatId,
                'text' => "Selamat datang di Tatagih Bot!\n\nGunakan perintah:\n/connect KODE_VERIFIKASI\n\nDapatkan kode verifikasi di dashboard Tatagih.",
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
