<?php

namespace App\Repository;

use App\Models\Transaction;
use App\Models\User;

interface PaymentRepositoryInterface
{
    public function transfer(array $data, User $user): Transaction;
}
