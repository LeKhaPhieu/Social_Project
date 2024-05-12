<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->id) {
            $user = User::where('id', $request->id)->first();
            if ($user->status == User::INACTIVATED) {
                return $next($request);
            }
            return redirect()->route('home');
        }
        return redirect()->route('home');
    }
}
