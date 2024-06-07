<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Admin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        $users = $this->userService->index();
        return view('admin.user.index')->with([
            'users' => $users,
            'posts' => $users,
        ]);
    }

    public function updateStatus(Request $request, int $userId): RedirectResponse
    {
        $newStatus = $request->input('status');
        $result = $this->userService->updateStatus($userId, $newStatus);
        if ($result) {
            return redirect()->back()->with('success', __('admin.approved_user_success'));
        }
        return redirect()->back()->with('error', __('admin.approved_user_error'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $result = $this->userService->destroy($id);
        if ($result) {
            return redirect()->back()->with('success', __('admin.delete_user_success'));
        }
        return redirect()->back()->with('error', __('admin.delete_user_error'));
    }
}
