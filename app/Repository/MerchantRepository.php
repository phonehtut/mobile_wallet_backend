<?php

namespace App\Repository;

use App\Http\Requests\MerchantSubmitRequest;
use App\Models\Merchant;

class MerchantRepository implements MerchantRepositoryInterface
{
    public function create(array $data, MerchantSubmitRequest $request): Merchant
    {
        $merchant = Merchant::create([
            'user_id' => $data['user_id'],
            'shop_name' => $data['shop_name'],
            'shop_url' => $data['shop_url'] ?? null,
            'shop_logo' => $data['shop_logo'] ?? null,
            'category' => $data['category'],
            'address' => $data['address'],
        ]);

        return $merchant;
    }
}
