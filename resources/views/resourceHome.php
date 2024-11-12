<?php
$board = session('board');

$userId = \Illuminate\Support\Facades\Auth::id();

$template_boards = \App\Models\TemplateBoard::query()->with(['templateCatalogs'])->get();

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
    ->where('workspace_members.is_active', 1)
    ->where('board_members.user_id', \Illuminate\Support\Facades\Auth::id())
    ->where('board_members.is_star', 1)
    ->get();

$userId = \Illuminate\Support\Facades\Auth::id();
$currentWorkspace = \App\Models\WorkspaceMember::where('user_id', $userId)->where('is_active', 1)->first();


