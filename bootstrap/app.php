<?php

use App\Http\Middleware\AdminAll;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\AdvertiserAll;
use App\Http\Middleware\AdvertiserAuth;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\SuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'prevent-back' => PreventBackHistory::class,
            'admin-auth' => AdminAuth::class,
            'admin-all' => AdminAll::class,
            'super-admin' => SuperAdmin::class,
            'advertiser-auth' => AdvertiserAuth::class,
            'advertiser-all' => AdvertiserAll::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
