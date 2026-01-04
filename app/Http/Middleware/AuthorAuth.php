<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if author is logged in
        if (!Auth::guard('author')->check()) {
            // Not logged in, redirect to login page
            return redirect()->route('openautherlogin'); 
        }

        // Logged in, allow request
        return $next($request);
    }
}
