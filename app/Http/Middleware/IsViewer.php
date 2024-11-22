<?php

namespace App\Http\Middleware;

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
        $workspaceChecked = Session::get('workspaceChecked'); // Lấy từ session
        if ($workspaceChecked && $workspaceChecked->authorize === "Viewer") {
            return redirect()->back()->with([
                'msg' => 'Bạn không có quyền chỉnh sửa workspace.',
                'action' => 'danger',
            ]);
        }

        return $next($request); // Tiếp tục xử lý yêu cầu
    }

}
