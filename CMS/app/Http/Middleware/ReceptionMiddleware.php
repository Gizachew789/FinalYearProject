<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isReception()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Reception access required.'], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}

