<?php

namespace App\Service\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function updatePassword(object $data): int|array
    {
        try {
            $user = Auth::user();
            if (Hash::check($data->password, $user->password)) {
                return [
                    'notify' => false,
                    'message' => __('auth.notify_password_duplicate'),
                ];
            }
            
            if (Hash::check($data->password_current, $user->password)) {
                $user->update([
                    'password' => Hash::make($data->password)
                ]);

                return ['notify' => true];
            }

            return [
                'notify' => false,
                'message' => __('auth.error_password_current'),
            ];

        } catch (Exception $e) {
            return [
                'notify' => false,
                'message' => __('auth.error_password_change'),
            ];
        }
    }
}
