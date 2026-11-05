<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetDefaultLanguage
{
    public function handle($request, Closure $next)
    {
        try {
            if (auth('api')->check()) {
                $user = auth('api')->user();

                if ($user && $user->language) {
                    app()->setLocale($user->language);
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return $next($request);
    }
}
