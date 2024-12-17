<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class IsViewer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $workspaceChecked = \App\Models\Workspace::query()
            ->with('boards')
            ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
            ->where('workspace_members.user_id', Auth::id())
            ->where('workspace_members.is_active', 1)
            ->first();
        if ($workspaceChecked->authorize == "Viewer") {
            return redirect()->route('inbox');
        }

        return $next($request); // Tiếp tục xử lý yêu cầu
    }

}
