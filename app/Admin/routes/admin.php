<?php

use WpStarter\Wordpress\Admin\Facades\Route;

Route::add('ws-admin-sample',\App\Admin\Controllers\SampleAdminController::class)->position(2)
->group(function (){
    Route::add('ws-admin-sample-child-1',\App\Admin\Controllers\SampleAdminController::class);
});
/**
 *
 * Another way to register child menu without register parent, useful to add sub menu to existing page
 *
Route::parent('ws-admin-sample')->middleware(\App\Admin\Middleware\SampleMiddleware::class)->group(function(){
    Route::add('ws-admin-sample-child-2',\App\Admin\Controllers\SampleAdminController::class);
    Route::add('ws-admin-sample-child-3',\App\Admin\Controllers\SampleAdminController::class);
    Route::add('ws-admin-sample-child-4',\App\Admin\Controllers\SampleAdminController::class);
});
 */
