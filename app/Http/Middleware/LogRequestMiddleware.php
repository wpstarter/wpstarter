<?php

namespace App\Http\Middleware;

use App\Models\RequestLog;
use WpStarter\Http\Request;
use WpStarter\Support\Str;

class LogRequestMiddleware
{
    function handle(Request $request,\Closure $next){
        /*
        RequestLog::create([
            'ip'=>$request->getClientIp(),
            'path'=>Str::limit($request->path(),255,''),
            'method'=>$request->method(),
            'header'=>json_encode($request->headers->all(),JSON_PRETTY_PRINT),
            'body'=>json_encode($request->all(),JSON_PRETTY_PRINT),
        ]);
        */
        return $next($request);
    }
}
