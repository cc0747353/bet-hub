<?php

namespace App\Http\Middleware;

use App\Models\Analytic;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;

class Analytics
{
    public function handle(Request $request, Closure $next): mixed
    {
        $input = $request->all();
        $uri = str_replace($request->root(), '', $request->url()) ?: '/';
        $userId = User::whereEmail($input['email'])->value('id');
        if (! $userId) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $agent = new Agent();
        if (! $agent->isRobot()) {
            $agent->setUserAgent($request->headers->get('user-agent'));
            $agent->setHttpHeaders($request->headers);

            $items = implode($agent->languages());
            $lang = substr($items, 0, 2);
            $ip = Location::get($request->ip());
            $ipExists = Analytic::where('ip', $request->ip())->exists();
            if ($ipExists) {
                return $next($request);
            }
            $country = $ip ? $ip->countryName : '';
            Analytic::create([
                'user_id'         => $userId,
                'uri'              => $uri,
                'source'           => $request->headers->get('referer'),
                'country'          => $country,
                'browser'          => $agent->browser() ?? null,
                'device'           => $agent->deviceType(),
                'operating_system' => $agent->platform(),
                'ip'               => $request->ip(),
                'language'         => $lang,
                'meta'             => json_encode(Location::get($request->ip())),
            ]);

            return $next($request);
        }
        return $next($request);
    }
}
