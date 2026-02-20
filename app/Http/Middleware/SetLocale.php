<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 public function handle($request, Closure $next)
{
    if (session()->has('locale')) {
        app()->setLocale(session('locale'));
    } else {
        // Détecte la langue du navigateur (fr, en, es)
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        if (in_array($browserLocale, ['fr', 'en', 'es'])) {
            app()->setLocale($browserLocale);
        }
    }
    return $next($request);
}
}
