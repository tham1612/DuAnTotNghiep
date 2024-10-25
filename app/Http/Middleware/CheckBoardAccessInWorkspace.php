<?php

namespace App\Http\Middleware;

use App\Enums\AccessEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Board;
use App\Models\Workspace;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckBoardAccessInWorkspace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (Auth::check()) {
            $user = Auth::user();

            // Lấy ID của bảng từ request
            $id = $request->route('id'); // Lấy id từ route
            Log::info('Board ID: ' . $id);

            if ($id) {
                // Tìm bảng hiện tại
                $currentBoard = Board::find($id);
                Log::info('Current Board: ' . json_encode($currentBoard));

                if ($currentBoard) {
                    // Kiểm tra xem người dùng có phải là thành viên của workspace chứa bảng này không
                    $isMemberOfWorkspace = $user->workspaces()->where('workspaces.id', $currentBoard->workspace_id)->exists();

                    // Kiểm tra xem bảng có phải là public không
                    $isBoardPublic = AccessEnum::isPublic($currentBoard->access);
                    Log::info('Is Board Public: ' . ($isBoardPublic ? 'true' : 'false'));

                    // Kiểm tra xem người dùng có phải là thành viên của bảng không
                    $isMemberOfBoard = $user->Board()->where('boards.id', $id)->exists();
                    Log::info('Is Member Of Board: ' . ($isMemberOfBoard ? 'true' : 'false'));

                    // Kiểm tra vai trò của người dùng nếu họ là thành viên của bảng
                    $userRole = $user->Board()->where('boards.id', $id)->first()?->pivot->authorize ?? 'No role found';
                    Log::info('User Role: ' . $userRole);

                    // Nếu người dùng có vai trò Viewer, thiết lập chế độ chỉ xem
                    if ($userRole === 'Viewer') {
                        session(['view_only' => true]);
                        Log::info('View Only Mode set for Viewer role.');
                        return $next($request);
                    }

                    // Nếu người dùng có vai trò Member hoặc Owner, xóa session view_only và cho phép quyền chỉnh sửa
                    if (in_array($userRole, ['Member', 'Owner'])) {
                        session()->forget('view_only');
                        Log::info('User has full access as ' . $userRole);
                        return $next($request);
                    }

                    // Nếu bảng là public và người dùng là thành viên của workspace nhưng không phải là thành viên của bảng
                    if ($isBoardPublic && $isMemberOfWorkspace && !$isMemberOfBoard) {
                        session(['view_only' => true]);
                        Log::info('View Only Mode set for non-board member in public board.');
                        return $next($request);
                    }

                    // Nếu người dùng không phải là thành viên của bảng và bảng không phải là public
                    if (!$isMemberOfBoard && !$isBoardPublic) {
                        return back()->with('error', 'Bạn không có quyền truy cập bảng này.');
                    }

                    // Nếu người dùng là thành viên của bảng với vai trò Viewer (điều kiện bổ sung cho chắc chắn)
                    if ($isMemberOfBoard && $userRole === \App\Enums\AuthorizeEnum::Viewer) {
                        session(['view_only' => true]);
                        Log::info('View Only Mode re-confirmed for Viewer role.');
                        return $next($request);
                    }

                    // Nếu người dùng là thành viên của bảng và có quyền chỉnh sửa
                    if ($isMemberOfBoard && $userRole !== \App\Enums\AuthorizeEnum::Viewer) {
                        session()->forget('view_only');
                        Log::info('User has full access to the board.');
                        return $next($request);
                    }
                }
            }
        }

        // Nếu không có quyền truy cập, tiếp tục xử lý request
        return $next($request);
    }
}
