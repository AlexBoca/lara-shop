<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{

    public function handle($request, Closure $next)
    {
        if (!session('user_login')) {
            return redirect()->back();
        }
        return $next($request);
    }
}
