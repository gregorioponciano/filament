<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserBan
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isBanned()) {
            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'email' => 'Sua conta está banida. Entre em contato com o suporte.',
                ]);
        }

        return $next($request);
    }
}
