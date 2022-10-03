<?php

namespace App\Http\Controllers;

use App\View\Components\Heading;

class WelcomeController extends Controller
{
    function index(){
        return content_view('welcome')->withPostTitle('Custom title');
    }
}