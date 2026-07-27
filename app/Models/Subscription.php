<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'amount',
        'currency',
        'billing_cycle',
        'payment_date',
        'start_date',
        'end_date',
        'auto_renew',
        'reminder_days',
        'status',
        'logo',
        'invite_code',
        'is_public',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            if (empty($subscription->invite_code)) {
                $subscription->invite_code = 'GRP-' . strtoupper(Str::random(6));
            }
        });
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'auto_renew' => 'boolean',
            'is_public' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
            'payment_date' => 'integer',
            'reminder_days' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function paymentHistories(): HasMany
    {
        return $this->hasMany(PaymentHistory::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(SubscriptionShare::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function getNextPaymentDateAttribute(): Carbon
    {
        $now = Carbon::now();
        $day = $this->payment_date;

        if ($this->billing_cycle === 'yearly') {
            $next = Carbon::createFromDate($now->year, 1, 1)->addDays($day - 1);
            if ($next->isPast()) {
                $next = $next->addYear();
            }
            return $next;
        }

        if ($this->billing_cycle === 'monthly') {
            $lastDay = $now->copy()->endOfMonth()->day;
            $payDay = min($day, $lastDay);
            $next = $now->copy()->day($payDay);
            if ($next->isPast()) {
                $next = $next->addMonth();
                $lastDay = $next->copy()->endOfMonth()->day;
                $next->day(min($day, $lastDay));
            }
            return $next;
        }

        if ($this->billing_cycle === 'weekly') {
            $next = $now->copy()->next($day % 7);
            return $next;
        }

        return $now->copy()->addDay();
    }

    public function getDaysUntilPaymentAttribute(): int
    {
        return Carbon::now()->startOfDay()->diffInDays($this->next_payment_date, false);
    }

    public function getMonthlyAmountAttribute(): float
    {
        return match ($this->billing_cycle) {
            'daily' => $this->amount * 30,
            'weekly' => $this->amount * 4,
            'monthly' => $this->amount,
            'yearly' => $this->amount / 12,
            default => $this->amount,
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp' . number_format($this->amount, 0, ',', '.');
    }

    public function getJoinUrlAttribute(): string
    {
        return route('shares.join', ['code' => $this->invite_code ?? 'GRP-DEMO']);
    }

    public function getQrCodeUrlAttribute(): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($this->join_url);
    }
}
