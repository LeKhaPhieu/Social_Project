<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TokenVerifyEmailRequest;
use App\Models\User;
use App\Service\Auth\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function viewRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        if ($this->authService->register($request->all())) {
            return redirect()->route('view.token.form')->with('success', __('auth.notify_register_success'));
        }

        return redirect()->route('view.register')->with('error', __('auth.notify_register_error'));
    }

    public function viewTokenForm()
    {
        return view('auth.token_verify_form');
    }

    public function token(TokenVerifyEmailRequest $request)
    {
        $token = $request->input('token_verify_email');

        if ($this->authService->token($token)) {
            return redirect()->route('view.login')->with('success', __('auth.notify_token_success'));
        }

        return redirect()->route('view.token.form')->with('error', __('auth.notify_token_error'));
    }

    public function viewLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if ($this->authService->login($request->all())) {
            if (Auth::user()->role === User::ROLE_ADMIN) {
                return view('admin.dashboard');
            }
            return redirect()->route('blogs.home');
        }

        return redirect()->route('view.login')->with('error', __('auth.notify_login_error'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('blogs.home');
    }
}
