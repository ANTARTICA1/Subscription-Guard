<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'telegram_chat_id',
        'timezone',
        'role',
        'user_tag',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->user_tag)) {
                $user->user_tag = 'TAG-' . strtoupper(Str::random(6));
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function paymentHistories(): HasMany
    {
        return $this->hasMany(PaymentHistory::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function telegramConnection(): HasOne
    {
        return $this->hasOne(TelegramConnection::class);
    }

    public function friendships(): HasMany
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    public function acceptedFriends()
    {
        return User::whereIn('id', function ($query) {
            $query->select('friend_id')->from('friendships')->where('user_id', $this->id)->where('status', 'accepted')
                ->union(
                    $query->newQuery()->select('user_id')->from('friendships')->where('friend_id', $this->id)->where('status', 'accepted')
                );
        })->get();
    }

    public function subscriptionShares(): HasMany
    {
        return $this->hasMany(SubscriptionShare::class, 'owner_id');
    }

    public function sharedWithMe(): HasMany
    {
        return $this->hasMany(SubscriptionShare::class, 'friend_user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function activeSubscriptions(): HasMany
    {
        return $this->subscriptions()->where('status', 'active');
    }

    public function monthlyExpense(): float
    {
        return $this->activeSubscriptions->sum(function ($sub) {
            return match ($sub->billing_cycle) {
                'daily' => $sub->amount * 30,
                'weekly' => $sub->amount * 4,
                'monthly' => $sub->amount,
                'yearly' => $sub->amount / 12,
                default => $sub->amount,
            };
        });
    }

    public function yearlyExpense(): float
    {
        return $this->activeSubscriptions->sum(function ($sub) {
            return match ($sub->billing_cycle) {
                'daily' => $sub->amount * 365,
                'weekly' => $sub->amount * 52,
                'monthly' => $sub->amount * 12,
                'yearly' => $sub->amount,
                default => $sub->amount,
            };
        });
    }
}
