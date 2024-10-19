<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\TaskComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        TaskComment::create($data);
        return response()->json([
            'success' => "them taskComment thành công",
            'msg' => true
        ]);
    }
}
