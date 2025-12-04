<?php

namespace App\Repository;

use App\Http\Requests\MerchantSubmitRequest;
use App\Models\Merchant;

interface MerchantRepositoryInterface
{
    public function create(array $data, MerchantSubmitRequest $request): Merchant;
}
