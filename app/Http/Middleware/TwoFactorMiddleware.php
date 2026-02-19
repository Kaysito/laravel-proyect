<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // 1. Si no está logueado, fuera.
        if (!$user) {
            return redirect('/');
        }

        // 2. Si el usuario NO tiene 2FA configurado, lo mandamos a configurarlo.
        if (is_null($user->google2fa_secret)) {
            return redirect()->route('2fa.setup');
        }

        // 3. Si ya tiene 2FA, verificamos si ya pasó la validación en esta sesión.
        if (!$request->session()->has('2fa_verified')) {
            return redirect()->route('2fa.index');
        }

        return $next($request);
    }
}