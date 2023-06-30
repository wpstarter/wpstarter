<?php

namespace App\Providers;

use WpStarter\Wordpress\Setting\SettingServiceProvider as BaseProvider;

class SettingServiceProvider extends BaseProvider
{

    protected function getOptionKey()
    {
        return 'ws_settings';
    }
}