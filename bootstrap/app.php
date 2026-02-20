<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        // AJOUTEZ CETTE LIGNE ICI POUR ACTIVER LA LANGUE
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

/*
|--------------------------------------------------------------------------
| Configuration Spécifique à Vercel
|--------------------------------------------------------------------------
| On redirige le stockage vers /tmp car le disque Vercel est en lecture seule.
*/
if (isset($_ENV['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
