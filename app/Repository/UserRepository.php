<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function login($data, $request): bool
    {
        if (Auth::attempt(['phone' => $data['phone'], 'password' => $data['pin']])) {
          $request->session()->regenerate();

          return true;
        }

        return false;
    }
}
