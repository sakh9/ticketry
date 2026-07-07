<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check organizer guard
        if (Auth::guard('organizer')->check()) {
            $user = Auth::guard('organizer')->user();
            if ($user && $user->is_banned) {
                Auth::guard('organizer')->logout();
                return redirect()->route('login')->with('error', 'Your account has been banned. Reason: ' . ($user->ban_reason ?? 'No reason provided.'));
            }
        }

        // Check visitor guard
        if (Auth::guard('visitor')->check()) {
            $user = Auth::guard('visitor')->user();
            if ($user && $user->is_banned) {
                Auth::guard('visitor')->logout();
                return redirect()->route('login')->with('error', 'Your account has been banned. Reason: ' . ($user->ban_reason ?? 'No reason provided.'));
            }
        }

        return $next($request);
    }
}