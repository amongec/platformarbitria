<?php

use App\Http\Middleware\EnsureUserIsSuscribed;
//use App\Http\Middleware\Lang;
//use App\Http\Middleware\Localization;
//use App\Http\Middleware\SetLang;
use App\Http\Middleware\PostMiddleware;
use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\CookieConsent\CookieConsentMiddleware;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
           then: function(){   
            Route::middleware('web', 'auth')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));
            }
    )
    ->withMiddleware(function (Middleware $middleware) {
       // $middleware->appendToGroup('SetLang', Setlang::class);
        
        $middleware->alias([
            //'admin' => \App\Http\Middleware\Admin::class,
            //'can' => \Illuminate\Auth\Middleware\Autorize::class,
            //'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'cookie-consent' => \Spatie\CookieConsent\CookieConsentMiddleware::class,
            //'cookies' => \Spatie\CookieConsent\CookieConsentMiddleware::class,
            //'session' => \App\Session\Middleware\StartSession::class,
            'subscribed' => EnsureUserIsSuscribed::class,
           // 'localization' => \App\Http\Middleware\Localization::class,
          //  'lang'=> Lang::class,
          //  'setLocale' => setLocale::class,
            'role'=> \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'=> \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'=> \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
           // 'net' => \App\Http\Middleware\NetMiddleware::class,
           'post' => \App\Http\Middleware\PostMiddleware::class,
          //  'Calendar' => MaddHatter\LaravelFullcalendar\Facades\Calendar::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
