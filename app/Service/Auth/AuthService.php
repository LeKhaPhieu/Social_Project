<?php

namespace App\Service\Auth;

use App\Mail\VerifyTokenMail;
use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function register(array $data): bool
    {
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

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public function token(string $token): bool
    {
        $tokenRow = Token::where('token_verify_email', $token)->first();
        if (!$tokenRow) {
            return false; 
        }

        $user = User::find($tokenRow->user_id);
        if (!$user) {
            return false; 
        }

        if ($user->status === User::INACTIVATED) {
            $user->update(['status' => User::ACTIVATED]);
        }

        return true;
    }

    public function login(array $data) {
        return Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => User::ACTIVATED
        ]);
    }
}
