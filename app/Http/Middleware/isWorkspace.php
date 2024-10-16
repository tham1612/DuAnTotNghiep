<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Import Auth facade
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class isWorkspace
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ( Auth::check() && !Auth::user()->hasWorkspace()) {
            if (!$request->is('/workspaces/create')) {
                return redirect('workspaces/create');
            }
        }
        return $next($request);
    }
}
