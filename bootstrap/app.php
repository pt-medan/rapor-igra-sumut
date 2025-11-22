<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'guru.verified' => \App\Http\Middleware\GuruVerified::class,
        ]);

        // Add global middleware untuk check guru validation
        $middleware->append(\App\Http\Middleware\EnsureGuruIsValidated::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
