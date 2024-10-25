<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\TaskComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
         if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        TaskComment::create($data);
        return response()->json([
            'success' => "them taskComment thành công",
            'msg' => true
        ]);
    }
}
