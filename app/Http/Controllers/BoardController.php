<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'board.';

    public function index()
    {
        $userId = Auth::id();

        // Lấy tất cả các bảng mà người dùng thuộc về workspace, kèm theo thông tin về việc có được đánh dấu sao không
        $boards = Board::with(['workspace', 'boardMembers'])
            ->whereHas('workspace.workspaceMembers', function ($query) use ($userId) {
                $query->where('is_active', 1)->where('user_id', $userId);
            })
            ->get()
            ->map(function ($board) use ($userId) {
                // Kiểm tra xem bảng có được đánh dấu sao không
                $board->is_star = $board->boardMembers->contains(fn($member) => $member->user_id == $userId && $member->is_star == 1);
                return $board;
            });

        // Tách danh sách bảng sao
        $board_star = $boards->filter(fn($board) => $board->is_star);

        return view('homes.dashboard', compact('boards', 'board_star'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('b.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except(['image', 'link_invite']);
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/b/{$uuid}/{$token}");
        try {
            DB::beginTransaction();
            $board = Board::query()->create($data);
            BoardMember::query()->create([
                'user_id' => auth()->id(),
                'board_id' => $board->id,
                'authorize' => 'Owner',
                'invite' => now(),
            ]);
            DB::commit();
            return redirect()->route('home');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with('error', 'Error: ' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $board = Board::query()->findOrFail($id);

        session(['board' => $board]);

        $viewType = \request('viewType', 'board');

        // https://laravel.com/docs/10.x/eloquent-relationships#lazy-eager-loading
        // https://laravel.com/docs/10.x/eloquent-relationships#nested-eager-loading
        $board->load([
            'users',
            'catalogs',
            'catalogs.tasks',
            'catalogs.tasks.members'
        ]);
        $boardMembers = $board->users->unique('id');
        // Lấy danh sách catalogs
        $catalogs = $board->catalogs;
        /*
         * pluck('tasks'): Lấy tất cả các tasks từ các catalogs, nó sẽ trả về một collection mà mỗi phần tử là một danh sách các tasks.
         * flatten(): Dùng để chuyển đổi một collection lồng vào nhau thành một collection phẳng, chứa tất cả các tasks.
         * */

        $tasks = $catalogs->pluck('tasks')->flatten();
        //        $taskMembers=$tasks->pluck('members')->flatten();

        return match ($viewType) {
            'dashboard' => view('homes.dashboard_board', compact('board')),
            'list' => view('lists.index', compact('board')),
            'gantt' => view('ganttCharts.index', compact('board', 'catalogs', 'tasks')),
            'table' => view('tables.index', compact('board', 'catalogs', 'tasks')),
            default => view('boards.index', compact('board')),
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}