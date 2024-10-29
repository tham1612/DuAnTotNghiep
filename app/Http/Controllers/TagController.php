<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TaskTag;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->all();
        $tag = Tag::query()->create($data);

        if (isset($data['task_id']) && !empty($data['task_id'])) {
            TaskTag::query()->insert([
                'task_id' => $data['task_id'],
                'tag_id' => $tag->id,
            ]);
        }

        return response()->json([
            'data' => $data,
            'success' => true
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
        } else {
            TaskTag::query()->insert([
                'task_id' => $task_id,
                'tag_id' => $tag_id,
            ]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
