<?php

namespace App\Admin;

use WpStarter\Wordpress\Admin\Kernel as AdminKernel;

class Kernel extends AdminKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        //\Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \WpStarter\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \WpStarter\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'admin' => [
            \App\Http\Middleware\EncryptCookies::class,
            \WpStarter\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \WpStarter\Wordpress\Middleware\StartSession::class,
            \WpStarter\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],
    ];
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'cache.headers' => \WpStarter\Http\Middleware\SetCacheHeaders::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \WpStarter\Routing\Middleware\ValidateSignature::class,
        'throttle' => \WpStarter\Routing\Middleware\ThrottleRequests::class,
    ];
}