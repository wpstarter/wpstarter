<?php

namespace App\Admin\Controllers;

use App\Admin\Middleware\SampleMiddleware;
use WpStarter\Http\Request;

class SampleAdminController extends Controller
{
    public function __construct()
    {
        //Use middleware to limit 5 postSave perminute
        $this->middleware(SampleMiddleware::class)->only('postSave');
    }

    function getIndex(){
        return ws_view('admin::sample');
    }
    function postSave(Request $request){
        $this->validate($request,['name'=>'required']);
        $this->layout->withSuccess('Saved');
        return ws_redirect()->back();
    }
}