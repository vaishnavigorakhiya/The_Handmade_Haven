<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Not logged in at all — send to home with modal
            return redirect()->route('home')
                ->with('open_login_modal', true)
                ->with('error', '🔒 Please login to continue.');
        }

        if (!Auth::user()->isAdmin()) {
            // Logged in but not admin — send to their dashboard
            return redirect()->route('user.dashboard')
                ->with('error', '🚫 Access denied. Admin only.');
        }

        return $next($request);
    }
}
