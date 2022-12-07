<?php

namespace App\Providers;

use App\View\Shortcodes\SampleShortcode;
use WpStarter\Support\ServiceProvider;
use WpStarter\Wordpress\Facades\L10n;
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
    }
}
