<?php

use App\Http\Middleware\ApiHeaders;
use App\Http\Middleware\EnsureUserIsVerified;
use App\Http\Middleware\LanguageSwitcher;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ApiHeaders::class);
        $middleware->alias([
            'localization' => LanguageSwitcher::class,
            'is_verified' => EnsureUserIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
