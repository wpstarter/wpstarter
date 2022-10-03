<?php

namespace App\Providers;

use WpStarter\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        global $wp_actions;
        //dd($wp_actions);
        //die;
    }
}
