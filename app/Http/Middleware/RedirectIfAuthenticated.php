<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use WpStarter\Http\Request;
use WpStarter\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \WpStarter\Http\Request  $request
     * @param  \Closure(\WpStarter\Http\Request): (\WpStarter\Http\Response|\WpStarter\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \WpStarter\Http\Response|\WpStarter\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return ws_redirect('/');
            }
        }

        return $next($request);
    }
}
