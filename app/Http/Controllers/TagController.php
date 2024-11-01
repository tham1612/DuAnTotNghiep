<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\CheckListItem;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getListTagTaskBoard(Request $request, $taskId)
    {
        $board=Board::with('tags')->findOrFail($request->board_id);
        $task = Task::with('tags')->findOrFail($taskId);
        $tags = $board->tags->map(function ($tag) use ($task) {
            $tag->isChecked = $task->tags->pluck('id')->contains($tag->id);
            return $tag;
        });
        $htmlForm = View::make('dropdowns.tag', [
            'taskId' => $taskId,
            'tags' => $tags,
            'boardId' => $request->board_id,
            'task'=>$task
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }
    public function getFormCreateTag(Request $request, $taskId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $colors0 = session('colors');
        $colors = json_decode(json_encode($colors0));
        $task=Task::findOrFail($taskId);
        $boardID=$task->catalog->board->id;

        $htmlForm = View::make('dropdowns.createTag', [
            'taskId' => $taskId,
            'colors' => $colors,
            'boardID' => $boardID
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

    public function store(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->all();

        $tag = Tag::query()->create($data);

        if (isset($data['task_id']) && !empty($data['task_id'])) {
            $tagTask=TaskTag::query()->insert([
                'task_id' => $data['task_id'],
                'tag_id' => $tag->id,
            ]);
        }

        return response()->json([
            'data' => $data,
            'success' => true,
            'tagTaskName' => $tag->name,
            'tagTaskColor' => $tag->color_code,
            'tag_id'=>$tag->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        list($task_id, $tag_id) = explode("-", $request->data);

        $check = TaskTag::query()->where('task_id', $task_id)->where('tag_id', $tag_id)->first();
        if ($check) {
            TaskTag::query()->where('task_id', $task_id)->where('tag_id', $tag_id)->delete();
            return response()->json([

                'success' => true,
                'action' => 'removed',
                'tagTaskName' => $check->tag->name,
                'tagTaskColor' => $check->tag->color_code,
                'task_id' => $task_id,
                'tag_id'=>$tag_id
            ]);
        } else {
            $newTag = TaskTag::query()->create([
                'task_id' => $task_id,
                'tag_id' => $tag_id,
            ]);
            $tag = Tag::find($tag_id); // Lấy thông tin của tag
            return response()->json([
                'success' => true,
                'action' => 'added',
                'tagTaskName' => $tag->name,
                'tagTaskColor' => $tag->color_code,
                'task_id' => $task_id,
                'tag_id'=>$tag_id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
