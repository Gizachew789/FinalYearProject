<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMultiple
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() || Auth::guard('patient')->check()) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
