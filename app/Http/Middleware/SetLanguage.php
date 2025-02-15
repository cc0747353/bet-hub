<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLanguage
{

    /**
     * @param Request $request
     * @param Closure $next
     *
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $localeLanguage = checkLanguageSession();

        if (! isset($localeLanguage)) {
            \App::setLocale('en');
        } else {
            \App::setLocale($localeLanguage);
        }

        return $next($request);
    }
}
