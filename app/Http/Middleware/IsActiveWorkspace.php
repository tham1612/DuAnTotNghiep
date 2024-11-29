<?php

namespace App\Http\Middleware;

use App\Models\WorkspaceMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActiveWorkspace
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeWsp = WorkspaceMember::query()
            ->where('user_id', Auth::id())
            ->where('is_active', 1)
            ->first();
        if ($activeWsp) {
            return $next($request);
        }
        return Auth::user()->hasActiveWorkspace();
    }
}
