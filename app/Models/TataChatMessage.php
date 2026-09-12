<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TataChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'role',
        'content',
        'is_offline_fallback',
    ];

    protected function casts(): array
    {
        return [
            'is_offline_fallback' => 'boolean',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(TataChatSession::class, 'session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
