<?php

namespace App\Http\Controllers;

use WpStarter\Http\Request;

class WelcomeController extends Controller
{
    function index(){
        $page=get_page_by_path('welcome-page2');
        if(!$page){
            wp_insert_post([
                'post_type'=>'page',
                'post_name'=>'welcome-page2',
                'post_title'=>'Wordpress Starter Shortcode sample',
                'post_content'=>'[welcome-shortcode]',
            ]);
        }
        return ws_view('welcome.index');
    }
    function page(Request $request){
        $path=$request->path();
        $path=trim($path,'/');
        $page=get_page_by_path($path);
        if(!$page){
            wp_insert_post(['post_type'=>'page','post_name'=>$path,'post_title'=>'Wordpress Starter Page Inside wordpress']);
        }
        return content_view('welcome.content');
    }
    function shortcode(){
        return shortcode_view('welcome.shortcode',[],[])->add('section1',function(){
            return 'welcome to section 1';
        });
    }
    function post(Request $request){
        $this->validate($request,['your_name'=>'required']);

        return ws_redirect()->back()->withInput();
    }
}