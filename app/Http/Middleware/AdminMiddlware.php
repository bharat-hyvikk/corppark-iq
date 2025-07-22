<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddlware
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
        if (Auth::user()->status == "Inactive" && !Auth::user()->isAdmin) {
            Auth::logout();
            return redirect()->route('sign-in')->withErrors(['message' => 'Your account is inactive.']);
        }
        // Check if the user is an admin (user_type = 0)
        if (auth()->user()->user_type == 0) {
            Auth::logout();
            return redirect()->route('sign-in')->withErrors(['message' => 'You do not have admin access.']);
        }
        if (!auth()->user()->isAdmin && (
            request()->is('buildings*') ||
            in_array(request()->route()->getName(), ['users.profile', 'admin.update', 'users-management'])
        )) {
            Auth::logout();
            return redirect()->route('sign-in')->withErrors(['message' => 'You do not have access.']);
        }


        // if route name is user.manage and user type is 3
        if (auth()->user()->user_type == 3 && request()->route()->getName() == 'users.manage') {
            Auth::logout();
            return redirect()->route('sign-in')->withErrors(['message' => 'You do not have user access.']);
        }
        return $next($request);
    }
}
