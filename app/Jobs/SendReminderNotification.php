<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendReminderNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Notification $notification
    ) {}

    public function handle(TelegramService $telegramService): void
    {
        $user = $this->notification->user;
        $chatId = $user->telegram_chat_id;

        if (!$chatId) {
            $this->notification->update(['status' => 'failed']);
            return;
        }

        $success = $telegramService->sendMessage($chatId, $this->notification->message);

        $this->notification->update([
            'status' => $success ? 'sent' : 'failed',
            'sent_at' => $success ? now() : null,
        ]);
    }
}
