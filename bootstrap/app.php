<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aquí registramos el alias para el middleware 2FA
        $middleware->alias([
            '2fa' => \App\Http\Middleware\TwoFactorMiddleware::class,
        ]);
    }) // <--- OJO: Aquí NO debe haber punto y coma, solo se cierra llave y paréntesis
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create(); // <--- El punto y coma va ÚNICAMENTE aquí, al final de todo.