<?php

namespace App\Providers;

use App\View\Shortcodes\SampleShortcode;
use WpStarter\Support\ServiceProvider;
use WpStarter\Wordpress\Facades\L10n;
use WpStarter\Wordpress\Facades\Livewire;
use WpStarter\Wordpress\Facades\Shortcode;

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
        L10n::loadDomain('app',ws_resource_path('lang'));
        Shortcode::add(SampleShortcode::class);
        /**
         * Add js and css for livewire
         * Adding here will add style/script globally
         * to add to specified page only please call it in controller or middleware
         */
        //Livewire::enqueue();
    }
}
