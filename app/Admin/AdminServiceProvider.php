<?php
namespace App\Admin;
use WpStarter\Support\ServiceProvider;
use WpStarter\Wordpress\Admin\Facades\Route;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            \WpStarter\Wordpress\Admin\Contracts\Kernel::class,
            \App\Admin\Kernel::class,
        );
    }

    function boot(){
        Route::middleware('admin')->group(__DIR__.'/routes/admin.php');
        $this->loadViewsFrom(__DIR__.'/resources/views','admin');
    }
}