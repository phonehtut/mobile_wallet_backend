<?php

namespace App\Models;

use App\Observers\MerchantObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([MerchantObserver::class])]
class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_url',
        'shop_logo',
        'category',
        'address',
        'qr_code',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
