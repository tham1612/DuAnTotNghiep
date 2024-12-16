<?php

use App\Models\WorkspaceMember;
use Illuminate\Support\Facades\DB;

$board = session('board');

$userId = \Illuminate\Support\Facades\Auth::id();

$template_boards = \App\Models\TemplateBoard::query()->with(['templateCatalogs'])->get();

$currentWorkspace = \App\Models\WorkspaceMember::where('user_id', $userId)->where('is_active', 1)->first();

$workspace = \App\Models\Workspace::query()
    ->whereHas('users', function ($query) use ($userId) {
        $query->where('user_id', $userId)->where('is_active', 1);
    })
    ->first();

$boardIsStars = \App\Models\Board::query()
    ->distinct()
    ->select(
        'boards.name AS board_name',
        'workspaces.name AS workspace_name',
        'boards.id AS board_id',
        'boards.image AS board_image',
    )
    ->join('workspaces', 'boards.workspace_id', '=', 'workspaces.id')
    ->join('workspace_members', 'workspace_members.workspace_id', '=', 'workspaces.id')
    ->join('board_members', 'board_members.board_id', '=', 'boards.id')
    ->where('workspaces.id', $currentWorkspace->workspace_id)
    ->where('workspace_members.is_active', 1)
    ->where('board_members.user_id', \Illuminate\Support\Facades\Auth::id())
    ->where('board_members.is_star', 1)
    ->get();
    $workspaceId = auth()->user()->current_workspace_id ?? WorkspaceMember::where('user_id', auth()->id())
    ->where('is_active', 1)
    ->value('workspace_id');
    $recentBoards = DB::table(config('activitylog.table_name') . ' as logs')
        ->join('boards', 'logs.board_id', '=', 'boards.id') // Kết nối với bảng boards
        ->join('workspaces', 'boards.workspace_id', '=', 'workspaces.id') // Kết nối với bảng boards
        ->select(
            'logs.board_id as board_id',
            'boards.name as board_name',
            'boards.image as board_image',
            'workspaces.name as workspace_name',

            DB::raw('MAX(logs.created_at) as last_activity')
        )
        ->where('boards.workspace_id', $workspaceId) // Lọc đúng workspace
        ->whereNotNull('logs.board_id') // Đảm bảo board_id không null
        ->groupBy('logs.board_id', 'boards.name') // Gom nhóm theo board_id và tên
        ->orderByDesc('last_activity') // Sắp xếp theo hoạt động gần nhất
        ->limit(5) // Lấy 5 bảng gần nhất
        ->get();