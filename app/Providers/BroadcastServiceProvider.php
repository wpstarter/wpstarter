<?php

namespace App\Providers;

use WpStarter\Support\Facades\Broadcast;
use WpStarter\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require ws_base_path('routes/channels.php');
    }
}
