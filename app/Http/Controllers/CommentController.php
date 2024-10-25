<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\CheckList;
use App\Models\TaskAttachment;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $taskComment=TaskComment::create($data);
         $userOwnerID=BoardMember::where('board_id',$taskComment->task->catalog->board->id)
             ->where('user_id','Owner')
             ->value('user_id');
        return response()->json([
            'success' => "them taskComment thành công",
            'msg' => true,
            'comment'=> $taskComment,
            'userId'=>$taskComment->user->id,
            'userName'=>$taskComment->user->name,
             'userOwnerID'=>$userOwnerID

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
