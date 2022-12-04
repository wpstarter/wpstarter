<?php

namespace App\Admin\Middleware;

use WpStarter\Support\Facades\RateLimiter;

class SampleMiddleware
{
    function handle($request,$next){
        $executed = RateLimiter::attempt(
            'sample',
            $perMinute = 5,
            function() {
                // Send message...
            }
        );

        if (! $executed) {
            return ws_response('Too many submit!');
        }
        return $next($request);
    }
}