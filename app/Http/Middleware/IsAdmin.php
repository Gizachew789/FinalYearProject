<?php 
// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class IsAdmin
{
    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Closure  $next
    //  * @return mixed
    //  */
    public function handle($request, Closure $next)
    {
        // Check if the authenticated user has an 'admin' role
        if (Auth::check() && Auth::user()->role === config('roles.admin')) {
            return $next($request); // Proceed if the user is an admin
        }

        // Redirect or abort if the user is not an admin
return redirect()->route('login')->with('error', 'You are not authorized to access this page.');
    }
}
