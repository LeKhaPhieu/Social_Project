<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyTokenMail;
use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function viewRegister()
    {
        return view('auth.register');
    }

    public function viewTokenForm()
    {
        return view('auth.token_verify_form');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
            ]);

            $verificationToken = Token::create([
                'token_verify_email' => rand(100000, 999999),
                'user_id' => $user->id,
            ]);

            Mail::to($request->email)->send(new VerifyTokenMail($verificationToken->token_verify_email));

            return redirect()->route('view.token.form')->with('success', 'Successful registration, please confirm');

        } catch (Exception $e) {

            return redirect()->route('view.register')->with('success', 'error registration, please confirm');
        }
    }

    public function viewLogin()
    {
        return view('auth.login');
    }
}
