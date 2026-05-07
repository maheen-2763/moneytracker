<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequiresTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Skip if not logged in or 2FA not enabled
        if (!$user || !$user->two_factor_enabled) {
            return $next($request);
        }

        // Skip the 2FA challenge route itself
        if ($request->routeIs('2fa.challenge', '2fa.verify')) {
            return $next($request);
        }

        // Redirect to 2FA challenge if not verified
        if (!session('2fa_verified')) {
            return redirect()->route('2fa.challenge');
        }

        return $next($request);
    }
}
