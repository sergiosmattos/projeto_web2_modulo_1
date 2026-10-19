<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (session('user.permission') !== 'admin') {
        return redirect()->route('home_page');
        }

        return $next($request);
    }
}
