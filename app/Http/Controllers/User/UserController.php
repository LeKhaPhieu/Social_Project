<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Service\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function editChangePassword(): View
    {
        return view('auth.change_password_form');
    }

    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $data = $request->all();
        $result = $this->userService->updatePassword($data);

        if ($result['status']) {
            return redirect()->route('blogs.home')->with('success', __('auth.success_password_change'));
        }

        return redirect()->route('user.password.edit')->with('error', $result['message']);
    }
}
