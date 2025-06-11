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
        // Register global middleware if needed
        // $middleware->web(append: [
        //     \App\Http\Middleware\TrustProxies::class,
        // ]);

        // Register route middleware
        $middleware->alias([
            'checkrole' => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->alias([
            // Pastikan baris ini benar
            'role' => \App\Http\Middleware\CheckRole::class, // Ini harus menunjuk ke kelas middleware Anda
        ]);
    
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();