<?php

namespace App\Service\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function update(array $data): int|array
    {
        $user = Auth::user();

        if (Hash::check($data['password_current'], $user->password)) {
            $user->update([
                'password' => Hash::make($data['password'])
            ]);

            return ['status' => true];
        }

        return [
            'status' => false,
            'message' => __('auth.error_password_current'),
        ];
    }
}
