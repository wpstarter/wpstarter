<?php

use App\Http\Controllers\WelcomeController;
use WpStarter\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('welcome', [WelcomeController::class,'index'])->name('welcome');
Route::get('welcome-page', [WelcomeController::class,'page'])->name('welcome.page');
//Route::get('welcome-page2',[WelcomeController::class,'shortcode']);



