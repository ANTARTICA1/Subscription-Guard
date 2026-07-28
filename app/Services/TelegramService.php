<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $apiUrl;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token', '');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function sendMessage(string $chatId, string $message): bool
    {
        if (empty($this->botToken) || $this->botToken === 'your-telegram-bot-token-here') {
            Log::warning('Telegram bot token not configured');
            return false;
        }

        try {
            $response = Http::withOptions(['verify' => false])->post("{$this->apiUrl}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Telegram API error: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Telegram send failed: ' . $e->getMessage());
            return false;
        }
    }

    public function sendReminderMessage(string $chatId, string $subName, string $amount, string $date, int $daysLeft, bool $autoRenew): bool
    {
        $emoji = match (true) {
            $daysLeft <= 1 => '🔴',
            $daysLeft <= 3 => '🟡',
            default => '🟢',
        };

        $renewStatus = $autoRenew ? '✅ Auto Renewal Aktif' : '❌ Auto Renewal Nonaktif';

        $message = "{$emoji} <b>Tatagih Reminder</b>\n\n"
            . "<b>{$subName}</b> akan melakukan pembayaran <b>{$daysLeft} hari lagi</b>.\n\n"
            . "Nominal: <b>{$amount}</b>\n"
            . "Tanggal: <b>{$date}</b>\n"
            . "Status: {$renewStatus}";

        if ($autoRenew && $daysLeft <= 3) {
            $message .= "\n\n<i>Subscription ini akan diperpanjang otomatis. Pastikan layanan masih digunakan.</i>";
        }

        return $this->sendMessage($chatId, $message);
    }

    public function setWebhook(string $url): bool
    {
        try {
            $response = Http::withOptions(['verify' => false])->post("{$this->apiUrl}/setWebhook", [
                'url' => $url,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram webhook setup failed: ' . $e->getMessage());
            return false;
        }
    }
}
