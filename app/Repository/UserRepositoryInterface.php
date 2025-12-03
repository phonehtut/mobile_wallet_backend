<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use phpDocumentor\Reflection\Types\Boolean;

interface UserRepositoryInterface
{
    public function login($data, $request): bool;
}
