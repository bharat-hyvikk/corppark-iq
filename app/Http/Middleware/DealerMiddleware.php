<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DealerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('sign-in');
        }
        // Check if the user is a dealer (user_type = 1)
        if (auth()->user()->user_type != 0) {
            return redirect()->route('sign-in')->withErrors(['message' => 'You do not have dealer access.']);
        }
        return $next($request);
    }
}
