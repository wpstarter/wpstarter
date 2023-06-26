<?php

namespace App\Providers;

use WpStarter\Auth\Events\Registered;
use WpStarter\Auth\Listeners\SendEmailVerificationNotification;
use WpStarter\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use WpStarter\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
