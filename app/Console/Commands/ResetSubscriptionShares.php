<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionShare;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ResetSubscriptionShares extends Command
{
    protected $signature = 'shares:reset';

    protected $description = 'Reset subscription shares status for the new billing cycle';

    public function handle()
    {
        $this->info('Checking subscription shares for reset...');

        $shares = SubscriptionShare::where('due_date', '<', Carbon::today())
            ->with('subscription')
            ->get();

        $count = 0;

        foreach ($shares as $share) {
            if ($share->subscription && $share->subscription->status === 'active') {
                if ($share->payment_proof_path) {
                    Storage::disk('public')->delete($share->payment_proof_path);
                }

                $share->update([
                    'payment_status' => 'pending',
                    'payment_proof_path' => null,
                    'due_date' => $share->subscription->next_payment_date->format('Y-m-d')
                ]);

                $count++;
            }
        }

        $this->info("Done! Reset {$count} shares for the new billing cycle.");
    }
}
