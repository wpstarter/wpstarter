<?php

namespace App\Http\Controllers;

use WpStarter\Http\Request;

class ShortcodeController extends Controller
{

    function index(){
        return ws_view('shortcode');
    }
    function post(Request $request){
        $this->validate($request,['your_name'=>'required']);

        return ws_redirect()->back()->withInput();
    }
}