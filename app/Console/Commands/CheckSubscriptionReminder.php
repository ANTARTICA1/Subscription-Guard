<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\Notification;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSubscriptionReminder extends Command
{
    protected $signature = 'subscriptions:check-reminders';
    protected $description = 'Check and send subscription payment reminders';

    public function handle(TelegramService $telegramService): int
    {
        $this->info('Checking subscription reminders...');

        $subscriptions = Subscription::with(['user.telegramConnection', 'user'])
            ->active()
            ->get();

        $sent = 0;

        foreach ($subscriptions as $subscription) {
            $daysUntil = $subscription->days_until_payment;
            $type = null;

            if ($daysUntil === 7) $type = 'H-7';
            elseif ($daysUntil === 3) $type = 'H-3';
            elseif ($daysUntil === 1) $type = 'H-1';
            elseif ($daysUntil === 0) $type = 'due_date';

            if (!$type) continue;

            // Check if already notified today for this type
            $alreadySent = Notification::where('subscription_id', $subscription->id)
                ->where('type', $type)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadySent) continue;

            $user = $subscription->user;
            $nextDate = $subscription->next_payment_date->translatedFormat('d F Y');

            $message = "🔔 Tatagih Reminder\n\n"
                . "{$subscription->name} akan melakukan pembayaran {$daysUntil} hari lagi.\n\n"
                . "Nominal: {$subscription->formatted_amount}\n"
                . "Tanggal: {$nextDate}\n"
                . "Status: " . ($subscription->auto_renew ? 'Auto Renewal Aktif' : 'Manual');

            if ($subscription->auto_renew) {
                $message .= "\n\n⚠️ Subscription ini akan diperpanjang otomatis. Pastikan layanan masih digunakan.";
            }

            // Send Telegram notification
            $status = 'pending';
            $telegramConnection = $user->telegramConnection;
            if ($telegramConnection && $telegramConnection->isVerified() && $user->telegram_chat_id) {
                $success = $telegramService->sendReminderMessage(
                    $user->telegram_chat_id,
                    $subscription->name,
                    $subscription->formatted_amount,
                    $nextDate,
                    $daysUntil,
                    $subscription->auto_renew
                );
                $status = $success ? 'sent' : 'failed';
            }

            // Save notification log
            Notification::create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
                'type' => $type,
                'message' => $message,
                'sent_at' => $status === 'sent' ? now() : null,
                'status' => $status,
            ]);

            $sent++;
            $this->line("  → Sent {$type} reminder for {$subscription->name} to {$user->name}");
        }

        $this->info("Done! {$sent} reminders processed.");

        return Command::SUCCESS;
    }
}
