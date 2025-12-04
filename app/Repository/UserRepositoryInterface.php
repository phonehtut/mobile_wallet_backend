<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function login(array $data, Request $request): bool;

    public function register(array $data, Request $request): User;

    public function searchWithPhone($phone): User | null;

    public function searchWithId($email): User | null;
}
