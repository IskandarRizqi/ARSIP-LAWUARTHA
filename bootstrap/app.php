<?php

use App\Http\Middleware\PetugasMiddleware;
use App\Http\Middleware\PetugasPimpinanMiddleware;
use App\Http\Middleware\PimpinanMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
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
        $middleware->alias([
            'auth' => Authenticate::class,
            'petugas' => PetugasMiddleware::class,
            'pimpinan' => PimpinanMiddleware::class,
            'petugaspimpinan' => PetugasPimpinanMiddleware::class,
            'user' => UserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
