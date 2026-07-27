<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionShare extends Model
{
    protected $fillable = [
        'subscription_id',
        'owner_id',
        'friend_user_id',
        'friend_name',
        'split_amount',
        'payment_status',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'split_amount' => 'decimal:2',
            'due_date' => 'date',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function friendUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_user_id');
    }

    public function getFormattedSplitAmountAttribute(): string
    {
        return 'Rp' . number_format($this->split_amount, 0, ',', '.');
    }

    /**
     * Generate dynamic QR Code URL for split payment
     */
    public function getPaymentQrUrlAttribute(): string
    {
        $payload = "PATUNGAN:" . ($this->subscription->name ?? 'SUBS')
            . "|PEMILIK:" . ($this->owner->name ?? 'TATAGIH')
            . "|NOMINAL:Rp" . number_format($this->split_amount, 0, ',', '.')
            . "|MEMBER:" . $this->friend_name;

        return 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($payload);
    }
}
