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

    protected $appends = [
        'join_url',
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
            $month = $this->start_date ? $this->start_date->month : $now->month;
            $next = Carbon::createFromDate($now->year, $month, 1);
            $lastDay = $next->copy()->endOfMonth()->day;
            $next->day(min($day, $lastDay));
            
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

    public function getCancelUrlAttribute(): ?string
    {
        $name = strtolower($this->name);
        
        $urls = [
            'netflix' => 'https://www.netflix.com/cancelplan',
            'spotify' => 'https://www.spotify.com/account/change-plan/cancel/',
            'youtube' => 'https://www.youtube.com/paid_memberships',
            'xbox' => 'https://account.microsoft.com/services',
            'game pass' => 'https://account.microsoft.com/services',
            'apple' => 'https://buy.itunes.apple.com/WebObjects/MZFinance.woa/wa/manageSubscriptions',
            'disney' => 'https://www.disneyplus.com/account/subscription',
            'amazon' => 'https://www.amazon.com/mc/pipelines/cancellation',
            'prime' => 'https://www.amazon.com/mc/pipelines/cancellation',
            'canva' => 'https://www.canva.com/settings/billing',
            'chatgpt' => 'https://chat.openai.com/account/manage',
            'openai' => 'https://chat.openai.com/account/manage',
            'adobe' => 'https://account.adobe.com/plans',
            'zoom' => 'https://zoom.us/billing',
            'playstation' => 'https://id.sonyentertainmentnetwork.com/id/management/',
            'ps plus' => 'https://id.sonyentertainmentnetwork.com/id/management/',
            'google one' => 'https://one.google.com/settings',
            'icloud' => 'https://support.apple.com/kb/HT207594',
        ];

        foreach ($urls as $keyword => $url) {
            if (str_contains($name, $keyword)) {
                return $url;
            }
        }

        return null;
    }

    public function getJoinUrlAttribute(): string
    {
        return route('shares.join', ['code' => $this->invite_code ?? 'GRP-DEMO']);
    }

    public function getQrCodeUrlAttribute(): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($this->join_url);
    }

    public function getIsPersonalAttribute(): bool
    {
        $personalKeywords = ['bpjs', 'kesehatan', 'asuransi', 'pribadi', 'personal', 'ktp', 'pinjaman', 'kredit', 'tagihan pribadi', 'obat', 'asuransi jiwa'];
        
        $name = strtolower($this->name);
        $categoryName = $this->category ? strtolower($this->category->name) : '';

        foreach ($personalKeywords as $keyword) {
            if (str_contains($name, $keyword) || str_contains($categoryName, $keyword)) {
                return true;
            }
        }
        
        return false;
    }

    public function getLogoAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $name = strtolower($this->name);
        
        $logos = [
            'netflix' => 'https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg',
            'spotify' => 'https://storage.googleapis.com/pr-newsroom-wp/1/2023/05/Spotify_Primary_Logo_RGB_Green.png',
            'disney' => 'https://upload.wikimedia.org/wikipedia/commons/3/3e/Disney%2B_logo.svg',
            'youtube' => 'https://upload.wikimedia.org/wikipedia/commons/0/09/YouTube_full-color_icon_%282017%29.svg',
            'xbox' => 'https://upload.wikimedia.org/wikipedia/commons/d/d7/Xbox_logo_%282019%29.svg',
            'game pass' => 'https://upload.wikimedia.org/wikipedia/commons/d/d7/Xbox_logo_%282019%29.svg',
            'apple' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
            'amazon' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg',
            'prime' => 'https://upload.wikimedia.org/wikipedia/commons/f/f1/Prime_Video.png',
            'canva' => 'https://upload.wikimedia.org/wikipedia/commons/0/08/Canva_icon_2021.svg',
            'chatgpt' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg',
            'openai' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg',
            'adobe' => 'https://upload.wikimedia.org/wikipedia/commons/c/cb/Adobe_Creative_Cloud_Logo.svg',
            'zoom' => 'https://upload.wikimedia.org/wikipedia/commons/9/9a/Zoom_Icon.png',
            'playstation' => 'https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_logo.svg',
            'ps plus' => 'https://upload.wikimedia.org/wikipedia/commons/0/00/PlayStation_logo.svg',
            'google' => 'https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg',
            'github' => 'https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg',
            'figma' => 'https://upload.wikimedia.org/wikipedia/commons/3/33/Figma-logo.svg',
            'coursera' => 'https://upload.wikimedia.org/wikipedia/commons/9/97/Coursera-Logo_600x600.svg',
            'indihome' => 'https://upload.wikimedia.org/wikipedia/commons/8/83/IndiHome_logo.svg',
        ];

        foreach ($logos as $keyword => $url) {
            if (str_contains($name, $keyword)) {
                return $url;
            }
        }

        return null;
    }
}
