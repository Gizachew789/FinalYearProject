<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Custom logic to check if user is an admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');  // Redirect to homepage if not admin
        }

        return $next($request);
    }
}
