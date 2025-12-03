<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantPayment extends Model
{
    protected $fillable = [
        'user_id',
        'merchant_id',
        'amount',
        'cashback_amount',
        'payment_code'
    ];

    protected $casts = [
        'amount' => 'decimal',
        'cashback_amount' => 'decimal',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
