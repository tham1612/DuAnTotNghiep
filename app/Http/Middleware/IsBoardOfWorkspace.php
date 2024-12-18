<?php

namespace App\Http\Middleware;

use App\Models\Board;
use App\Models\WorkspaceMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsBoardOfWorkspace
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $wspId = WorkspaceMember::query()->where('user_id', Auth::id())->pluck('workspace_id')->all();
        $boardId = $request->route('id') ?? $request->board_id ?? null;

        $activeBoard = Board::query()
            ->whereIn('workspace_id', $wspId)
            ->where('id', $boardId)
            ->exists();
//dd($activeBoard,$wspId,$request->route('id'));
        if ($activeBoard) {
            return $next($request);
        }
        return redirect('/home');
    }
}
