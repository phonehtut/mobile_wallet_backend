<?php

namespace App\Observers;

use App\Models\Merchant;

class MerchantObserver
{
    /**
     * Handle the Merchant "created" event.
     */
    public function created(Merchant $merchant): void
    {
        $qrData = encrypt(json_encode([
            'merchant_id' => $merchant->id,
            'type' => 'merchant',
            'shop_name' => $merchant->shop_name
        ]));

        $merchant->update([
            'qr_code' => $qrData,
        ]);
    }

    /**
     * Handle the Merchant "updated" event.
     */
    public function updated(Merchant $merchant): void
    {
        //
    }

    /**
     * Handle the Merchant "deleted" event.
     */
    public function deleted(Merchant $merchant): void
    {
        //
    }

    /**
     * Handle the Merchant "restored" event.
     */
    public function restored(Merchant $merchant): void
    {
        //
    }

    /**
     * Handle the Merchant "force deleted" event.
     */
    public function forceDeleted(Merchant $merchant): void
    {
        //
    }
}
