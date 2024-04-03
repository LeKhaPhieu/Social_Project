<?php

namespace App\Service\Admin;

use App\Models\User;
use Exception;

class UserService
{
    public function updateStatus(int $id): bool
    {
        try {
            $user = User::where('id', $id)->firstOrFail();

            if ($user->status == User::ACTIVATED) {
                $user->update(['status' => User::BLOCKED]);
            } else {
                $user->update(['status' => User::ACTIVATED]);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function destroy(User $user): bool
    {
        try {
            $user->delete();

            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}
