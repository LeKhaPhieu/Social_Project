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

    public function edit(): View
    {
        return view('auth.change_password_form');
    }

    public function update(ChangePasswordRequest $request): RedirectResponse
    {
        $data = $request->all();
        $result = $this->userService->update($data);

        if ($result['status']) {
            return redirect()->route('home')->with('success', __('auth.success_password_change'));
        }

        return redirect()->route('passwords.edit')->with('error', $result['message']);
    }
}
