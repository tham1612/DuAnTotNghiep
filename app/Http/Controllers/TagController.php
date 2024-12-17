<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Events\RealtimeCreateTag;
use App\Events\RealtimeCreateTask;
use App\Models\Board;
use App\Models\Follow_member;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskTag;
use App\Notifications\BoardNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Log;

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
    public function createBoardTag(Request $request)
    {
        $data = $request->all();
        $tag = Tag::query()->create($data);
        return response()->json([
            'action' => 'success',
            'msg' => 'Tạo nhãn thành công',
            'tag' => $tag,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getListTagTaskBoard(Request $request, $taskId)
    {
        $board = Board::with('tags')->findOrFail($request->board_id);
        $task = Task::with('tags')->findOrFail($taskId);
        $tags = $board->tags->map(function ($tag) use ($task) {
            $tag->isChecked = $task->tags->pluck('id')->contains($tag->id);
            return $tag;
        });
        $htmlForm = View::make('dropdowns.tag', [
            'taskId' => $taskId,
            'tags' => $tags,
            'boardId' => $request->board_id,
            'task' => $task
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
        $task = Task::findOrFail($taskId);
        $boardID = $task->catalog->board->id;

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
            TaskTag::query()->insert([
                'task_id' => $data['task_id'],
                'tag_id' => $tag->id,
            ]);
        }
        $followMember = Follow_member::where('task_id', $data['task_id'])
            ->where('follow', 1)
            ->get();
        $task = Task::find($data['task_id']);
        Log::info('Bắt đầu phát sự kiện RealtimeCreateTag', [
            'tag_id' => $tag->id,
            'board_id' => $tag->board->id,
            'task_id' => $task->id,
        ]);

        broadcast(new RealtimeCreateTag($tag, $tag->board->id, $task->id))->toOthers();

        Log::info('Phát sự kiện thành công');
        foreach ($followMember as $member) {
            if ($member->user->id != Auth::id()) {
                event(new EventNotification("Nhiệm vụ " . $task->text . " tạo thêm nhãn mới. Xem chi tiết! ", 'success', $member->user->id));
                $name = 'Task ' . $task->text;
                $title = 'Task có thay đổi';
                $description = 'Task ' . $task->text . ' tạo thêm nhãn mới';
                $board = $tag->board;
                $member->user->notify(new BoardNotification($member->user, $board, $name, $description, $title));
            }
        }

        return response()->json([
            'data' => $data,
            'task_id' => $data['task_id'],
            'success' => true,
            'tagTaskName' => $tag->name,
            'tagTaskColor' => $tag->color_code,
            'tag_id' => $tag->id,
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
        if (isset($request->id) && !empty($request->id)) {
            $tag = Tag::query()->findOrFail($request->id);
            $tag->update($request->all());
            return response()->json([
                'msg' => 'Cập nhật thành công',
                'action' => 'success',
                'tag' => $tag
            ]);
        }
        // hiện tại còn lỗi đ chạy đc thì demo kiểu đ j
        if ($request->updateOrDeleteTag) {
            list($task_id, $tag_id) = explode("-", $request->data);

            $check = TaskTag::query()->where('task_id', $task_id)->where('tag_id', $tag_id)->first();
            if ($check) {

                $followMember = Follow_member::where('task_id', $task_id)
                    ->where('follow', 1)
                    ->get();
                $task = Task::find($task_id);
                foreach ($followMember as $member) {
                    if ($member->user->id != Auth::id()) {
                        event(new EventNotification("Nhiệm vụ " . $task->text . " đã xóa nhãn " . $check->tag->name . ". Xem chi tiết! ", 'success', $member->user->id));
                        $name = 'Task ' . $task->text;
                        $title = 'Task có thay đổi';
                        $description = 'Task ' . $task->text . ' đã xóa nhãn ' . $check->tag->name;
                        $board = $task->board;
                        $member->user->notify(new BoardNotification($member->user, $board, $name, $description, $title));
                    }
                }

                TaskTag::query()->where('task_id', $task_id)->where('tag_id', $tag_id)->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'tagTaskName' => $check->tag->name,
                    'tagTaskColor' => $check->tag->color_code,
                    'task_id' => $task_id,
                    'tag_id' => $tag_id
                ]);
            } else {
                $newTag = TaskTag::query()->create([
                    'task_id' => $task_id,
                    'tag_id' => $tag_id,
                ]);
                $tag = Tag::find($tag_id); // Lấy thông tin của tag

                $followMember = Follow_member::where('task_id', $task_id)
                    ->where('follow', 1)
                    ->get();
                $task = Task::find($task_id);
                foreach ($followMember as $member) {
                    if ($member->user->id != Auth::id()) {
                        event(new EventNotification("Nhiệm vụ " . $task->text . " đã thêm nhãn " . $tag->name . ". Xem chi tiết! ", 'success', $member->user->id));
                        $name = 'Task ' . $task->text;
                        $title = 'Task có thay đổi';
                        $description = 'Task ' . $task->text . ' đã thêm nhãn ' . $tag->name;
                        $board = $task->board;
                        $member->user->notify(new BoardNotification($member->user, $board, $name, $description, $title));
                    }
                }

                return response()->json([
                    'success' => true,
                    'action' => 'added',
                    'tagTaskName' => $tag->name,
                    'tagTaskColor' => $tag->color_code,
                    'task_id' => $task_id,
                    'tag_id' => $tag_id
                ]);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tag = Tag::query()->findOrFail($request->id);
        $tagTasks = TaskTag::query()->where('tag_id', $request->id)->get();
        //        dd($tagTasks);
        try {
            DB::beginTransaction();
            foreach ($tagTasks as $tagTask) {
                $tagTask->where('tag_id', $request->id)->delete();
            }
            $tag->delete();
            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Xóa nhãn thành công!!',
                'tag' => $tag
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }
    }
}
