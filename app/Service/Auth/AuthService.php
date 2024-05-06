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

            $listToken = Token::where('user_id', $user->id);
            do {
                $tokenVerify = random_int(100000, 999999);
            } while (in_array($tokenVerify, $listToken->pluck('token_verify_email')->toArray()));

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
        try {
            $tokenRow = Token::where('token_verify_email', $token)->firstOrFail();
            $user = User::findOrFail($tokenRow->user_id);

            if ($user->status === User::INACTIVATED) {
                $user->update(['status' => User::ACTIVATED]);
            }
            return true;

        } catch (Exception $e) {

            return false;
        }
    }

    public function login(array $data): array|bool
    {
        $remember = isset($data['remember']);

        $fieldLogin = filter_var($data['email_or_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $data = [
            $fieldLogin => $data['email_or_username'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($data, $remember)) {

            $userStatus = Auth::user()->status;

            if ($userStatus == User::INACTIVATED) {
                Auth::logout();
                return [
                    'status' => false,
                    'message' => __('auth.user_inactivated'),
                ];
            }
            if ($userStatus == User::BLOCKED) {
                Auth::logout();
                return [
                    'status' => false,
                    'message' => __('auth.user_blocked'),
                ];
            }
            if ($userStatus == User::ACTIVATED) {
                return ['status' => true];
            }
        }
        return [
            'status' => false,
            'message' => __('auth.notify_login_error'),
        ];
    }

    public function forgotPassword(array $data): array
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $data['email'])
                ->where('status', User::ACTIVATED)
                ->firstOrFail();

            $tokenReset = Token::where('user_id', $user->id)
                ->whereNotNull('token_reset_password')
                ->firstOrFail();
            if ($tokenReset) {
                $tokenReset->delete();
            }

            $listToken = Token::where('user_id', $user->id);
            do {
                $tokenReset = random_int(100000, 999999);
            } while (in_array($tokenReset, $listToken->pluck('token_reset_password')->toArray()));

            Token::create([
                'token_reset_password' => $tokenReset,
                'user_id' => $user->id,
            ]);

            $data = [
                'email' => $data['email'],
                'token_reset_password' => $tokenReset,
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
            $tokenPassword = Token::where('token_reset_password', $token)->firstOrFail();
            $user = User::where('id', $tokenPassword->user_id)->firstOrFail();
            $newPassword = Str::random(6);
            $user->update(['password' => Hash::make($newPassword)]);
            $dataSendMail = ['password' => $newPassword];
            Mail::to($user->email)->send(new SendNewPassword($dataSendMail));

            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}
