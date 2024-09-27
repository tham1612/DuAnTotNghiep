<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::id();

        // Lấy tất cả các bảng mà người dùng tạo hoặc thuộc về workspace
        $boards = Board::where('created_at', $userId) // Bảng do người dùng tạo
            ->orWhereHas('workspace.workspaceMembers', function ($query) use ($userId) {
                $query->where('is_active', 1)->where('user_id', $userId); // Bảng người dùng là thành viên
            })
            ->with(['workspace', 'boardMembers'])
            ->get()
            ->map(function ($board) {
                // Tính tổng số thành viên trong bảng
                $board->total_members = $board->boardMembers->count();

                // Kiểm tra xem bảng có được đánh dấu sao không
                $board->is_star = $board->boardMembers->contains(fn($member) => $member->is_star == 1);

                // Kiểm tra follow = 1
                $board->follow = $board->boardMembers->contains(fn($member) => $member->follow == 1);

                // Đếm số thành viên theo dõi bảng
                $board->total_followers = $board->boardMembers->where('follow', 1)->count();

                return $board;
            });

        // Tách danh sách bảng sao
        $board_star = $boards->filter(fn($board) => $board->is_star);

        return view('homes.home', compact('boards', 'board_star'));
    }

}