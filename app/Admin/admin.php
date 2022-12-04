<?php

use WpStarter\Wordpress\Admin\Facades\Route;

Route::add('ws-admin-sample',\App\Admin\Controllers\SampleAdminController::class)->position(2);
