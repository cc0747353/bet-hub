<?php

namespace App\Http\Middleware;

use Closure;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CheckUserStatus
 */
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     *
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (is_impersonating()) {
            return $response;
        }

        $user = getLogInUser();

        if (Auth::check() && (!$user->status || !isset($user->email_verified_at))) {
            $isActive = $user->status;
            Auth::logout();

            return redirect(route('login'))->withErrors(!$isActive ? 'Your account is not active. Please contact to administrator.' : 'Your email is not verified.');
        }

        return $response;
    }
}
