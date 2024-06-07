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
use Carbon\Carbon;

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

            $token = self::createToken($user->id);

            $mailData = [
                'title' => 'Regit blog',
                'email' => $data['email'],
                'token_verify_email' => $token->token_verify_email,
            ];
            Mail::send(new VerifyTokenMail($mailData));
            DB::commit();
            self::updateTokenStatus($token);
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function createToken(int $userId): Token
    {
        $listToken = Token::where('user_id', $userId);
        do {
            $tokenVerify = random_int(100000, 999999);
        } while (in_array($tokenVerify, $listToken->pluck('token_verify_email')->toArray()));
        return Token::create([
            'token_verify_email' => $tokenVerify,
            'user_id' => $userId,
            'status' => Token::EFFECT,
        ]);
    }

    public function isTokenExpired(Token $token): bool
    {
        self::updateTokenStatus($token);
        return $token->status === Token::EXPIRE;
    }

    public function updateTokenStatus(Token $token): void
    {
        $now = Carbon::now();
        $tokenCreatedTime = Carbon::parse($token->created_at);
        if ($tokenCreatedTime->diffInMinutes($now) >= 1) {
            $token->status = Token::EXPIRE;
            $token->save();
        }
    }

    public function token(string $token): bool
    {
        try {
            $tokenRow = Token::where('token_verify_email', $token)->firstOrFail();
            if (self::isTokenExpired($tokenRow)) {
                return false;
            }
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
            $newPassword = Str::random(6);
            $user->update(['password' => Hash::make($newPassword)]);
            $dataSendMail = ['password' => $newPassword];
            Mail::to($user->email)->send(new SendNewPassword($dataSendMail));
            DB::commit();
            return [
                'status' => true,
                'message' => __('auth.retrieve_password_success'),
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status' => false,
                'message' => __('auth.retrieve_password_error'),
            ];
        }
    }

    public function resendToken(string $email): bool
    {
        try {
            $user = User::where('email', $email)->where('status', User::INACTIVATED)->firstOrFail();
            $token = Token::where('user_id', $user->id)
                ->where('status', Token::EXPIRE)
                ->firstOrFail();
            $newToken = self::createToken($user->id);
            $mailData = [
                'title' => 'Regit blog',
                'email' => $email,
                'token_verify_email' => $newToken->token_verify_email,
            ];
            Mail::send(new VerifyTokenMail($mailData));
            self::updateTokenStatus($token);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
