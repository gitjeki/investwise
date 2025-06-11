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
        // !! TAMBAHKAN ALIAS ANDA DI SINI !!
        $middleware->alias([
            'checkrole' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Anda juga bisa menambahkan middleware ke grup tertentu di sini, jika perlu
        // Contoh:
        // $middleware->web(append: [
        //     MyCustomWebMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
