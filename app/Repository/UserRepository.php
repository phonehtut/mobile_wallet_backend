<?php

namespace App\Repository;

use App\Models\EncryptedValue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function login(array $data, Request $request): bool
    {
        if (Auth::attempt(['phone' => $data['phone'], 'password' => $data['pin']])) {
//            $request->session()->regenerate();
            return true;
        }

        return false;
    }

    public function register(array $data, Request $request): User
    {
        // 1. Create user
        /** @var User $user */
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'balance' => 0,
            'is_merchant' => false,
        ]);

        // 2. Store NRC images in storage
        $nrcFrontPath = $request->file('nrc_front_image')->store('nrc_images', 'public');
        $nrcBackPath = $request->file('nrc_back_image')->store('nrc_images', 'public');

        // 3. Save sensitive info in encrypted_values
        EncryptedValue::updateOrInsert(
            ['user_id' => $user->id, 'key' => 'nrc_number'],
            ['value' => encrypt($data['nrc_number'])]
        );

        EncryptedValue::updateOrInsert(
            ['user_id' => $user->id, 'key' => 'nrc_front_image'],
            ['value' => encrypt($nrcFrontPath)]
        );

        EncryptedValue::updateOrInsert(
            ['user_id' => $user->id, 'key' => 'nrc_back_image'],
            ['value' => encrypt($nrcBackPath)]
        );

        EncryptedValue::updateOrInsert(
            ['user_id' => $user->id, 'key' => 'address'],
            ['value' => encrypt($data['address'])]
        );

        return $user;
    }
}
