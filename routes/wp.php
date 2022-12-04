<?php

use WpStarter\Wordpress\Facades\Route;

/*
|--------------------------------------------------------------------------
| Shortcode Routes
|--------------------------------------------------------------------------
|
| Here is where you can register shortcode routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('welcome-shortcode',[\App\Http\Controllers\WelcomeController::class,'shortcode']);


