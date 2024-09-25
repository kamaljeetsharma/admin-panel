<?php

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\ValidUser;
use App\Http\Middleware\LanguageMiddleware;
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

            'IsUserValid'=>ValidUser::class,
              'guest' =>RedirectIfAuthenticated::class,
                'setLocale' =>\App\Http\Middleware\LanguageMiddleware::class, 
        
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
