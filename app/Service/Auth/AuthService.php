<?php

namespace App\Service\Auth;

use App\Mail\SendNewPassword;
use App\Mail\TokenResetPassword;
use App\Mail\VerifyTokenMail;
use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data): bool
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'user_name' => $data['user_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'phone_number' => $data['phone_number'],
                'gender' => $data['gender'],
                'role' => User::ROLE_USER,
                'status' => User::INACTIVATED,
            ]);

            $tokenVerify = rand(100000, 999999);
            Token::create([
                'token_verify_email' => $tokenVerify,
                'user_id' => $user->id,
            ]);
            $data = [
                'title' => 'Regit blog',
                'email' => $data['email'],
                'token_verify_email' => $tokenVerify,
            ];
            Mail::send(new VerifyTokenMail($data));
            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function token(string $token): bool
    {
        $tokenRow = Token::where('token_verify_email', $token)->firstOrFail();
        if (!$tokenRow) {
            return false;
        }

        $user = User::findOrFail($tokenRow->user_id);
        if (!$user) {
            return false;
        }

        if ($user->status === User::INACTIVATED) {
            $user->update(['status' => User::ACTIVATED]);
        }

        return true;
    }

    public function login(array $data): array
    {
        $remember = isset($data['remember']);

        $fieldLogin = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $data = [
            $fieldLogin => $data['email'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($data, $remember)) {
            return ['status' => true];
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return [
                'status' => false,
                'message' => __('auth.email_unregistered'),
            ];
        }

        if ($user->status === User::INACTIVATED) {
            return [
                'status' => false,
                'message' => __('auth.user_inactivated'),
            ];
        }

        if ($user->status === User::BLOCKED) {
            return [
                'status' => false,
                'message' => __('auth.user_blocked'),
            ];
        }

        if (!Hash::check($data['password'], $user->password)) {
            return [
                'status' => false,
                'message' => __('auth.password_wrong'),
            ];
        }

        if (
            Auth::attempt([
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => User::ACTIVATED,
            ])
        ) {
            return ['status' => true];
        }
    }

    public function forgotPassword(array $data): array
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $data['email'])
                ->where('status', User::ACTIVATED)
                ->first();
            if (!$user) {
                return [
                    'status' => false,
                    'message' => __('auth.user_invalid_forgot'),
                ];
            }

            $tokenReset = Token::where('user_id', $user->id)
                ->whereNotNull('token_reset_password')
                ->first();
            if ($tokenReset) {
                $tokenReset->delete();
            }

            $tokenResetPassword = rand(100000, 999999);
            Token::create([
                'token_reset_password' => $tokenResetPassword,
                'user_id' => $user->id,
            ]);

            $data = [
                'email' => $data['email'],
                'token_reset_password' => $tokenResetPassword,
            ];
            Mail::send(new TokenResetPassword($data));
            DB::commit();

            return [
                'status' => true,
                'message' => __('auth.token_forgot_success'),
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => __('auth.token_forgot_error'),
            ];
        }
    }

    public function postTokenForgot(string $token): bool
    {
        try {
            $tokenPassword = Token::where('token_reset_password', $token)->first();
            if (!$tokenPassword) {
                return false;
            }

            $user = User::where('id', $tokenPassword->user_id)->first();
            $passwordNew = Str::random(6);
            $user->update(['password' => Hash::make($passwordNew)]);
            $dataSendMail = ['password' => $passwordNew];
            Mail::to($user->email)->send(new SendNewPassword($dataSendMail));

            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}
