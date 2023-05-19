<?php

namespace Tests;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \WpStarter\Foundation\Application
     */
    public function createApplication()
    {
        return \WordpressStarter::make()->app();
    }
}
