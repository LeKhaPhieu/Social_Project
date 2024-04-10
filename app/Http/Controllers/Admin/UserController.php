<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\Admin\UserService as UserServiceAdmin;
use Illuminate\View\View;

class UserController extends Controller
{
    protected UserServiceAdmin $userServiceAdmin;

    public function __construct(UserServiceAdmin $userServiceAdmin)
    {
        $this->userServiceAdmin = $userServiceAdmin;
    }

    public function store(): View
    {
        $users = User::orderBy('created_at', 'desc')->paginate(User::LIMIT_ADMIN_PAGE);
        return view('admin.user.index')->with([
            'Users' => $users,
            'items' => $users,
        ]);
    }

    public function updateStatus(int $id) 
    {
        $result = $this->userServiceAdmin->updateStatus($id);

        if ($result) {

            return redirect()->route('users.store')->with('success', __('admin.approved_user_success'));
        }

        return redirect()->route('users.store')->with('error', __('admin.approved_user_error'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $result = $this->userServiceAdmin->destroy($user);

        if ($result) {

            return redirect()->back()->with('success', __('admin.delete_user_success'));
        }

        return redirect()->back()->with('error', __('admin.delete_user_error'));
    }
}
