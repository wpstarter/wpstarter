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
        $app = require WS_DIR.'/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }

    /**
     * Get the application instance.
     *
     * @return \WpStarter\Foundation\Application
     */
    public function getApplication()
    {
        $app=\WordpressStarter::make()->app();
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}
