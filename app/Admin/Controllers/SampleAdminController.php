<?php

namespace App\Admin\Controllers;

use App\Admin\Middleware\SampleMiddleware;
use WpStarter\Http\Request;
use WpStarter\Wordpress\Admin\Facades\Notice;

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
        Notice::success('Saved');
        ws_admin_notice()->error('sample error');
        ws_admin_notice()->warning('sample warning');
        ws_admin_notice()->info('sample info');
        return ws_redirect()->back();
    }
}