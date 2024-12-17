<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Models\BoardMember;
use App\Models\Follow_member;
use App\Models\Task;
use App\Models\TaskComment;
use App\Notifications\BoardNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(
        AuthorizeWeb $authorizeWeb
    )
    {
        $this->authorizeWeb = $authorizeWeb;
    }

    public function store(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $task = Task::query()->findOrFail($request->task_id);
        $authorize = $this->authorizeWeb->authorizeComment($task->catalog->board->id);
//        dd($authorize,$task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $data = $request->except(['_token', '_method']);
        $taskComment = TaskComment::create($data);
        $userOwnerID = BoardMember::where('board_id', $taskComment->task->catalog->board->id)
            ->where('user_id', 'Owner')
            ->value('user_id');
        $replyUser = $taskComment->parent_id
            ? TaskComment::where('id', $taskComment->parent_id)->first()
            : null;
        $auth = Auth::id();

        $followMember = Follow_member::where('task_id', $taskComment->task_id)
            ->where('follow', 1)
            ->get();
        foreach ($followMember as $member) {
            if ($member->user->id != Auth::id()) {
                event(new EventNotification("Thẻ " . $taskComment->task->text . " đã thêm bình luận. Xem chi tiết! ", 'success', $member->user->id));
                $name = 'Task ' . $taskComment->task->text;
                $title = 'Task có thay đổi';
                $description = 'Task ' . $taskComment->task->text . ' đã thêm bình luận';
                $board = $taskComment->task->catalog->board;
                $member->user->notify(new BoardNotification($member->user, $board, $name, $description, $title));
            }
        }
        return response()->json([
            'action' => 'success',
            'msg' => 'them taskComment thành công',
            'comment' => $taskComment,
            'userId' => $taskComment->user->id,
            'replyUser' => $replyUser ? $replyUser->user->name : null,
            'userName' => $taskComment->user->name,
            'userOwnerID' => $userOwnerID,
            'auth' => $auth

        ]);
    }

    public function update(Request $request, string $id)
    {

        $data = $request->except(['_token', '_method']);
        $taskComment = TaskComment::query()->findOrFail($id);
        $taskComment->update($data);
        $userOwnerID = BoardMember::where('board_id', $taskComment->task->catalog->board->id)
            ->where('user_id', 'Owner')
            ->value('user_id');
        $replyUser = $taskComment->parent_id
            ? TaskComment::where('id', $taskComment->parent_id)->first()
            : null;
        $auth = Auth::id();

        return response()->json([
            'success' => "update taskComment thành công",
            'msg' => true,
            'comment' => $taskComment,
            'userId' => $taskComment->user->id,
            'replyUser' => $replyUser ? $replyUser->user->name : null,
            'userName' => $taskComment->user->name,
            'userOwnerID' => $userOwnerID,
            'auth' => $auth

        ]);
    }

    public function getAllComment($taskId)
    {
        if (!$taskId) {
            return response()->json(['error' => 'Task ID is missing'], 400);
        }

        $task = Task::with(['catalog.board.members' => function ($query) {
            $query->wherePivot('authorize', 'Owner');
        }])->findOrFail($taskId);

        $comments = TaskComment::with('user')->where('task_id', $taskId)->get();

        $userOwner = $task->catalog->board->members->first();

        $htmlForm = view('components.comment', [
            'taskId' => $taskId,
            'comments' => $comments,
            'userOwner' => $userOwner,
            'userId'=>auth()->id()
        ])->render();

        // Trả về HTML cho frontend
        return response()->json(['html' => $htmlForm]);
    }


    public function destroy(string $id)
    {

        $comment = TaskComment::query()->findOrFail($id);
        $task = Task::query()->findOrFail($comment->task_id);
        $authorize = $this->authorizeWeb->authorizeComment($task->catalog->board->id);
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        $comment->delete();
        return response()->json([
            'success' => "Xóa cmt thành công",
            'msg' => true
        ]);
    }
}
