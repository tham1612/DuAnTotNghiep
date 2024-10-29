<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\CheckList;
use App\Models\TaskAttachment;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request)
    {
         if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $taskComment=TaskComment::create($data);
         $userOwnerID=BoardMember::where('board_id',$taskComment->task->catalog->board->id)
             ->where('user_id','Owner')
             ->value('user_id');
        $replyUser = $taskComment->parent_id
            ? TaskComment::where('id', $taskComment->parent_id)->first()
            : null;
         $auth=Auth::id() ;

        return response()->json([
            'success' => "them taskComment thành công",
            'msg' => true,
            'comment'=> $taskComment,
            'userId'=>$taskComment->user->id,
            'replyUser' => $replyUser ? $replyUser->user->name : null,
            'userName'=>$taskComment->user->name,
             'userOwnerID'=>$userOwnerID,
            'auth'=>$auth

        ]);
    }
    public function update(Request $request,string $id)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $taskComment=TaskComment::query()->findOrFail($id);
        $taskComment->update($data);
        $userOwnerID=BoardMember::where('board_id',$taskComment->task->catalog->board->id)
            ->where('user_id','Owner')
            ->value('user_id');
        $replyUser = $taskComment->parent_id
            ? TaskComment::where('id', $taskComment->parent_id)->first()
            : null;
        $auth=Auth::id() ;

        return response()->json([
            'success' => "update taskComment thành công",
            'msg' => true,
            'comment'=> $taskComment,
            'userId'=>$taskComment->user->id,
            'replyUser' => $replyUser ? $replyUser->user->name : null,
            'userName'=>$taskComment->user->name,
            'userOwnerID'=>$userOwnerID,
            'auth'=>$auth

        ]);
    }
    public function destroy(Request $request , string $id)
    {
        $comment = TaskComment::where('id', $request->id)->first();
            $comment->delete();
        return response()->json([
            'success' => "Xóa cmt thành công",
            'msg' => true
        ]);
    }
}
