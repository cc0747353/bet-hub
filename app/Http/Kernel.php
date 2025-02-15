<?php

namespace App\Http;

use App\Http\Middleware\Analytics;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\XSS;
use App\Http\Middleware\SetLanguage;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use PragmaRX\Google2FALaravel\Middleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Middleware\RedirectIfAuthenticated;
use  Illuminate\Auth\Middleware\RequirePassword;
use  App\Http\Middleware\ValidateSignature;
use  Illuminate\Routing\Middleware\ThrottleRequests;
use  \Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use  App\Http\Middleware\EncryptCookies;
use  Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use  Illuminate\Session\Middleware\StartSession;
use  Illuminate\View\Middleware\ShareErrorsFromSession;
use  App\Http\Middleware\VerifyCsrfToken;
use  Illuminate\Routing\Middleware\SubstituteBindings;
use  App\Http\Middleware\TrustProxies;
use  Illuminate\Http\Middleware\HandleCors;
use  App\Http\Middleware\PreventRequestsDuringMaintenance;
use  Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use  App\Http\Middleware\TrimStrings;
use  Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth'             => Authenticate::class,
        'auth.basic'       => AuthenticateWithBasicAuth::class,
        'auth.session'     => AuthenticateSession::class,
        'cache.headers'    => SetCacheHeaders::class,
        'can'              => Authorize::class,
        'guest'            => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed'           => ValidateSignature::class,
        'throttle'         => ThrottleRequests::class,
        'verified'         => EnsureEmailIsVerified::class,
        'xss'              => XSS::class,
        'setLanguage'      => SetLanguage::class,
        'role'             => RoleMiddleware::class,
        'permission'       => PermissionMiddleware::class,
        '2fa'              => Middleware::class,
        'valid.user'       => CheckUserStatus::class,
        'analytics'        => Analytics::class,
    ];
}
