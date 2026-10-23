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
        // \WpStarter\Http\Middleware\TrustProxiesTrustHosts::class,
        \WpStarter\Http\Middleware\TrustProxies::class,
        //\Fruitcake\Cors\HandleCors::class,
        \WpStarter\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \WpStarter\Foundation\Http\Middleware\ValidatePostSize::class,
        \WpStarter\Foundation\Http\Middleware\TrimStrings::class,
        \WpStarter\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'admin' => [
            \WpStarter\Cookie\Middleware\EncryptCookies::class,
            \WpStarter\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \WpStarter\Wordpress\Middleware\StartSession::class,
            \WpStarter\View\Middleware\ShareErrorsFromSession::class,
            \WpStarter\Foundation\Http\Middleware\VerifyCsrfToken::class,
        ],
    ];
    protected $routeMiddleware = [
        'auth' => \WpStarter\Auth\Middleware\Authenticate::class,
        'cache.headers' => \WpStarter\Http\Middleware\SetCacheHeaders::class,
        'guest' => \WpStarter\Auth\Middleware\RedirectIfAuthenticated::class,
        'signed' => \WpStarter\Routing\Middleware\ValidateSignature::class,
        'throttle' => \WpStarter\Routing\Middleware\ThrottleRequests::class,
    ];
}