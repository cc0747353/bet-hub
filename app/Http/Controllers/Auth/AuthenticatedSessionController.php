<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\ValidateSecretRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(Auth::check()) {
            Redirect::to(getDashboardURL());
        } 
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        if (getLogInUser()->google2fa_secret) {
            $request->session()->put('2fa:user:id', getLogInUser()->id);
            Auth::logout();

           return $this->getValidateToken();
        }
        
        return redirect()->intended(getDashboardURL());
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function getValidateToken()
    {
        if (session('2fa:user:id')) {

            return redirect(route('user.2fa.validate.otp'));
        }

        return redirect('login');
    }

    /**
     * @param ValidateSecretRequest $request
     * @return RedirectResponse
     */
    public function postValidateToken(ValidateSecretRequest $request)
    {
        $userId = $request->session()->pull('2fa:user:id');
        $key    = $userId . ':' . $request->totp;
        
        Cache::add($key, true, 4);
        
        Auth::loginUsingId($userId);

        return redirect()->intended(getDashboardURL());
    }

    /**
     * @return Application|Factory|View
     */
    public function twoAuthValidate()
    {
        return view('2fa_security.validate');
    }
}
