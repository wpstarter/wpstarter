<?php

namespace Tests;

use WpStarter\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \WpStarter\Foundation\Application
     */
    public function createApplication()
    {
        $app=\WordpressStarter::make()->app();
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}
