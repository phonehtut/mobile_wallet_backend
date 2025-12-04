<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PinToken extends Model
{
    protected $fillable = [
        'user_id',
        'pin_token',
        'expires_in'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
