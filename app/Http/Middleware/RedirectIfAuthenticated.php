<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                if ($guard === 'organizer') {
                    return redirect()->route('organizer.events.index');
                }
                if ($guard === 'visitor') {
                    return redirect()->route('visitor.events.index');
                }
                return redirect('/');
            }
        }

        return $next($request);
    }
}