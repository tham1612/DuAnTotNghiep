<?php

namespace App\Http\Middleware;

use App\Models\Board;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActiveBoard
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $boardId = $request->route('id');
        $activeBoard = Board::query()
            ->where('id', $boardId)->first();

        if ($activeBoard) {
            return $next($request);
        }
        return redirect('/boardError');

    }
}
