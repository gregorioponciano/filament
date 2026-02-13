<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBan extends Model
{
        protected $fillable = [
        'user_id',
        'banned_by',
        'banned_until',
        'reason',
        'active',
    ];
     protected $casts = [
        'banned_until' => 'datetime',
        'active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    public function isActive(): bool
    {
        if (! $this->active) {
            return false;
        }

        if (is_null($this->banned_until)) {
            return true; // permanente
        }

        return Carbon::now()->lt($this->banned_until);
    }
}
