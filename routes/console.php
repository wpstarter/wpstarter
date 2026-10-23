<?php

use WpStarter\Foundation\Inspiring;
use WpStarter\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
