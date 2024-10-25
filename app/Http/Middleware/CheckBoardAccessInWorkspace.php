<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Board;
use App\Models\Workspace;
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
        $id = $request->route('id'); // Lấy boardId từ route

        // Kiểm tra xem người dùng có thuộc workspace của bảng hiện tại không
        if ($id) {
            // Tìm bảng hiện tại
            $currentBoard = Board::find($id);

            // Nếu tìm thấy bảng hiện tại
            if ($currentBoard) {
                // Kiểm tra xem người dùng có phải là thành viên của bảng này không
                $isMemberOfBoard = $user->board()->where('boards.id', $id)->exists();

                // Nếu không phải thành viên của bảng này
                if (!$isMemberOfBoard) {
                    // Giữ nguyên trang và gửi thông báo lỗi
                    return back()->with('error', 'Bạn không có quyền truy cập bảng này.');
                }
            }
        }
    }

    // Nếu có quyền truy cập, tiếp tục xử lý request
    return $next($request);
}

}

