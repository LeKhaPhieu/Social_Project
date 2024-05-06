<?php

namespace App\Service\User;

use App\Models\User;
use App\Service\Other\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

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

    public function updateProfile(array $data): bool|array
    {
        try {
            $user = auth()->user();
            if (isset($data['image'])) {
                $imageAvatar = $this->imageService->uploadImage($data);
                if ($user->avatar) {
                    $this->imageService->deleteOldImage($user->avatar);
                }
            }
            $user->update([
                'user_name' => $data['user_name'],
                'phone_number' => $data['phone_number'],
                'gender' => $data['gender'],
                'avatar' => $imageAvatar ?? $user->avatar,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
