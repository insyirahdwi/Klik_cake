<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class EnsureCustomerEmailIsVerified extends EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     * Admin users are always allowed through regardless of email verification status.
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $user = $request->user();

        // Allow admins to bypass email verification
        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        return parent::handle($request, $next, $redirectToRoute);
    }
}
