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
        'paid_at',
        'due_date',
        'payment_proof_path',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'split_amount' => 'decimal:2',
            'due_date' => 'date',
            'paid_at' => 'datetime',
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

    public function getPaymentQrUrlAttribute(): string
    {
        $payload = "PATUNGAN:" . ($this->subscription->name ?? 'SUBS')
            . "|PEMILIK:" . ($this->owner->name ?? 'TATAGIH')
            . "|NOMINAL:Rp" . number_format($this->split_amount, 0, ',', '.')
            . "|MEMBER:" . $this->friend_name;

        return 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($payload);
    }

    public function getProofUrlAttribute(): ?string
    {
        if (!$this->payment_proof_path) {
            return null;
        }
        return \Illuminate\Support\Facades\Storage::url($this->payment_proof_path);
    }

    public function getWhatsappReminderUrlAttribute(): string
    {
        $subName = $this->subscription->name ?? 'Langganan';
        $amount = $this->formatted_split_amount;
        $ownerName = $this->owner->name ?? 'Ketua Patungan';
        $bankName = $this->owner->bank_name ?? 'Bank/E-Wallet';
        $accNo = $this->owner->account_number ?? '-';
        $accHolder = $this->owner->account_holder ?? $ownerName;
        $joinUrl = $this->subscription ? route('shares.join', $this->subscription->invite_code) : url('/shares');

        $text = "Halo " . $this->friend_name . ",\n\n"
            . "Pengingat patungan langganan " . $subName . " di Tatagih:\n"
            . "- Tagihan Anda: " . $amount . "\n"
            . "- Host/Ketua: " . $ownerName . "\n";

        if ($this->owner && $this->owner->account_number) {
            $text .= "- Pembayaran: " . $bankName . " - " . $accNo . " (a.n " . $accHolder . ")\n";
        }

        $text .= "\nMohon lakukan transfer dan konfirmasi bukti pembayaran melalui tautan berikut:\n" . $joinUrl;

        return 'https://api.whatsapp.com/send?text=' . urlencode($text);
    }
}
