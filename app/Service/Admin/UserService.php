<?php

namespace App\Service\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function index(): LengthAwarePaginator
    {
        $users = User::orderByDesc('created_at')->where('role', User::ROLE_USER);
        if ($status = request()->status) {
            $users->where('status', $status);
        }
        if ($key = request()->key) {
            $users->where(function ($users) use ($key) {
                $users->where('user_name', 'like', '%' . $key . '%')
                    ->orWhere('email', 'like', '%' . $key . '%');
            });
        }
        return $users->paginate(config('length.limit_page_admin'));
    }

    public function updateStatus(int $id): bool
    {
        try {
            $user = User::where('id', $id)->firstOrFail();
            return $user->update([
                'status' => $user->status == User::ACTIVATED 
                ? User::BLOCKED : User::ACTIVATED
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $user = User::findOrFail($id);
            return $user->delete();
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }
}
