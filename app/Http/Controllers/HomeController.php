<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use App\Enums\AuthorizeEnum;
use Illuminate\Support\Facades\DB;

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
        $boards = Board::whereHas('workspace.workspaceMembers', function ($query) use ($userId) {
            $query->where('is_active', 1)->where('user_id', $userId); // Người dùng là thành viên của workspace
        })
        ->with(['workspace', 'boardMembers']) // Tải thông tin workspace và boardMembers
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
        // dd($boards);
        $ownerBoards = $boards->filter(function ($board) use ($userId) {
            return $board->boardMembers->filter(function ($member) use ($userId) {
                return $member->user_id == $userId && $member->authorize == AuthorizeEnum::Owner;
            })->isNotEmpty(); // Kiểm tra có member nào thỏa mãn không
        });
        // dd($ownerBoards);

        $filteredBoards = $boards->filter(function ($board) use ($userId) {
            // Lấy thông tin thành viên của người dùng trong workspace
            $workspaceMember = $board->workspace->workspaceMembers->firstWhere('user_id', $userId);

            // Kiểm tra nếu người dùng là "Viewer"
            if ($workspaceMember && $workspaceMember->authorize == \App\Enums\AuthorizeEnum::Viewer) {
                // Nếu bảng là "public" hoặc người dùng là thành viên của bảng (ngay cả khi bảng là "private"), cho phép xem bảng
                return $board->access == 'public' || $board->boardMembers->contains(fn($member) => $member->user_id == $userId);
            }

            // Các quyền khác được phép xem tất cả bảng
            return true;
        });
        // Tách danh sách bảng sao
        $board_star = $filteredBoards->filter(fn($board) => $board->is_star);

        // lấy tất cả các thành viên trong ws mà người dùng đang trong ws đấy
        $workspaceMembers = WorkspaceMember::with([
            'user',
            'workspace.boards.boardMembers' => function ($query) {
                $query->whereNull('deleted_at'); // Lọc các thành viên trong bảng không bị xóa
            }
        ])
        ->whereIn('workspace_id', function ($query) use ($userId) {
            $query->select('workspace_id')
                ->from('workspace_members')
                ->where('user_id', $userId)
                ->where('is_active', 1);
        })
        ->whereNull('deleted_at') // Chỉ lấy những thành viên không bị xóa (nếu có soft delete)
        ->get();

        // Lấy tất cả các task trong các workspace mà user là thành viên
        $tasks = Task::with(['catalog.board.workspace', 'catalog.board.boardMembers', 'members'])
            ->whereIn('catalog_id', function ($query) use ($userId) {
                $query->select('catalogs.id')
                    ->from('catalogs')
                    ->join('boards', 'catalogs.board_id', '=', 'boards.id')
                    ->join('board_members', 'boards.id', '=', 'board_members.board_id')
                    ->where('board_members.user_id', $userId);
            })
            ->get()
            ->map(function ($task) {
                $task->catalog_name = $task->catalog->name;
                $task->board_name = $task->catalog->board->name;
                $task->board_id = $task->catalog->board->id;
                return $task;
            });


        // Tách các task của riêng user ra
        $userTasks = $tasks->filter(function ($task) use ($userId) {
        return $task->members->contains('id', $userId);
        });

        // Task hoàn thành
        $completedTasks = $tasks->filter(fn($task) => $task->progress == 100);

        // Task chưa hoàn thành
        $incompleteTasks = $tasks->filter(fn($task) => $task->progress < 100);

        // Task quá hạn
        $overdueTasks = $tasks->filter(function($task) {
            return $task->progress < 100 && $task->start_date && $task->end_date && Carbon::parse($task->end_date)->lt(now());
        });
        // Lọc các task của riêng user chưa hoàn thành
        $myAssignedTasks = $userTasks->filter(fn($task) => $task->progress < 100);

        // Task có ngày bắt đầu trong vòng 1 tuần
        $upcomingTasks = $tasks->filter(fn($task) => $task->start_date && Carbon::parse($task->start_date)->between(now(), now()->addWeek()))
        ->sortBy('end_date');


        // Task gần đến hạn trong vòng 1 tuần
        $tasksExpiringSoon = $tasks->filter(fn($task) => $task->end_date && Carbon::parse($task->end_date)->between(now(), now()->addWeek()))
        ->sortBy('end_date');


        // hoạt động gần đây
        $activities = Activity::with('causer')->whereIn('properties->workspace_id', $boards->pluck('workspace.id')->unique())
            ->orderBy('created_at', 'desc')
            ->get();

        $currentWorkspace = WorkspaceMember::where('user_id', $userId)
            ->where('is_active', 1)
            ->first();

        // Truyền các biến này sang view
        return view('homes.home', compact(
            'boards',
            'board_star',
            'ownerBoards',
            'activities',
            'workspaceMembers',
            'tasks',
            'completedTasks',
            'incompleteTasks',
            'overdueTasks',
            'upcomingTasks',
            'myAssignedTasks',
            'tasksExpiringSoon',
            'currentWorkspace',
        ));
    }
}
