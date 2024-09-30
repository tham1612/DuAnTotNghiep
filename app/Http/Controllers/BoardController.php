<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
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


        // Lấy tất cả các bảng mà người dùng là người tạo hoặc là thành viên
        $boards = Board::where(function ($query) use ($userId) {
            $query->where('created_at', $userId) // Người tạo
                ->orWhereHas('boardMembers', function ($query) use ($userId) {
                    $query->where('user_id', $userId); // Thành viên
                });
        })
            ->with(['workspace', 'boardMembers'])

            ->get()
            ->map(function ($board) use ($userId) {
                // Tính tổng số thành viên trong bảng
                $board->total_members = $board->boardMembers->count();

                // Kiểm tra xem user có đánh dấu sao cho bảng này không
                $board->is_star = $board->boardMembers->contains(function ($member) use ($userId) {
                    return $member->user_id == $userId && $member->is_star == 1;
                });

                // Kiểm tra xem user có theo dõi bảng này không (follow = 1)
                $board->follow = $board->boardMembers->contains(function ($member) use ($userId) {
                    return $member->user_id == $userId && $member->follow == 1;
                });

                return $board;
            });

        // Lọc danh sách các bảng mà user đã đánh dấu sao
        $board_star = $boards->filter(function ($board) use ($userId) {
            return $board->boardMembers->contains(function ($member) use ($userId) {
                return $member->user_id == $userId && $member->is_star == 1;
            });
        });

        // Trả về view với danh sách bảng và các bảng đã đánh dấu sao
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
    public function store(StoreBoardRequest $request)
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
    public function show(string $id)
    {
    }

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
            'catalogs.tasks.catalog:id,name',
            'catalogs.tasks' => function($query) {
                $query->orderBy('position', 'asc');
            },

            'catalogs.tasks.members'
        ]);

        $boardMembers = $board->users->unique('id');
        // Lấy danh sách catalogs
        $catalogs = $board->catalogs;
        /*
         * pluck('tasks'): Lấy tất cả các tasks từ các catalogs, nó sẽ trả về một collection mà mỗi phần tử là một danh sách các tasks.
         * flatten(): Dùng để chuyển đổi một collection lồng vào nhau thành một collection phẳng, chứa tất cả các tasks.
         * */



        $tasks = $catalogs->pluck('tasks')->flatten()->sortBy('position');

        //        $taskMembers=$tasks->pluck('members')->flatten();
        return match ($viewType) {
            'dashboard' => view('homes.dashboard_board', compact('board', 'catalogs', 'tasks')),
            'list' => view('lists.index', compact('board', 'catalogs', 'tasks')),
            'gantt' => view('ganttCharts.index', compact('board', 'catalogs', 'tasks')),
            'table' => view('tables.index', compact('board', 'catalogs', 'tasks')),
            default => view('boards.index', compact('board', 'catalogs', 'tasks')),
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
