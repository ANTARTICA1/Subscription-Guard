<?php

namespace App\Console\Commands;

use App\Models\TelegramConnection;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class TelegramPoll extends Command
{
    protected $signature = 'telegram:poll {--once : Run once and exit}';
    protected $description = 'Poll incoming messages from Telegram bot';

    public function handle(TelegramService $telegramService): int
    {
        $this->info('Listening for Telegram messages... (Press Ctrl+C to stop)');

        $offset = 0;
        $runOnce = $this->option('once');

        do {
            $updates = $telegramService->getUpdates($offset);

            foreach ($updates as $update) {
                $offset = $update['update_id'] + 1;

                if (!isset($update['message']['text'])) {
                    continue;
                }

                $text = trim($update['message']['text']);
                $chatId = (string) $update['message']['chat']['id'];
                $senderName = $update['message']['from']['first_name'] ?? 'User';

                $this->line("Received message from {$senderName} [{$chatId}]: {$text}");

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

                        $telegramService->sendMessage($chatId, "<b>Akun Tatagih berhasil terhubung!</b>\n\nSelamat datang, {$connection->user->name}! Anda akan menerima pengingat tenggat pembayaran subscription di sini.");
                        $this->info("Akun {$connection->user->name} berhasil dihubungkan.");
                    } else {
                        $alreadyConnected = TelegramConnection::where('verification_code', $code)->whereNotNull('verified_at')->first();
                        if ($alreadyConnected) {
                            $telegramService->sendMessage($chatId, "Akun Anda sudah terhubung sebelumnya dengan kode ini.");
                        } else {
                            $telegramService->sendMessage($chatId, "Kode verifikasi <code>{$code}</code> tidak valid.");
                        }
                        $this->warn("Kode tidak cocok: {$code}");
                    }
                } elseif ($text === '/start') {
                    $telegramService->sendMessage($chatId, "<b>Selamat datang di Tatagih Bot!</b>\n\nUntuk menghubungkan akun Anda, gunakan perintah:\n<code>/connect KODE_VERIFIKASI</code>\n\nDapatkan kode verifikasi di menu Telegram dashboard Tatagih Anda.");
                }
            }

            if ($runOnce) {
                break;
            }

            sleep(2);
        } while (true);

        return Command::SUCCESS;
    }
}
