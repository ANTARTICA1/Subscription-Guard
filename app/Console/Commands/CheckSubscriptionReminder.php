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

            
            $alreadySent = Notification::where('subscription_id', $subscription->id)
                ->where('type', $type)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadySent) continue;

            $user = $subscription->user;
            $nextDate = $subscription->next_payment_date->translatedFormat('d F Y');

            $message = "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5 inline-block text-yellow-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9\" /></svg> Tatagih Reminder\n\n"
                . "{$subscription->name} akan melakukan pembayaran {$daysUntil} hari lagi.\n\n"
                . "Nominal: {$subscription->formatted_amount}\n"
                . "Tanggal: {$nextDate}\n"
                . "Status: " . ($subscription->auto_renew ? 'Auto Renewal Aktif' : 'Manual');

            if ($subscription->auto_renew) {
                $message .= "\n\n<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-5 w-5 inline-block text-yellow-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z\" /></svg> Subscription ini akan diperpanjang otomatis. Pastikan layanan masih digunakan.";
            }

            
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
