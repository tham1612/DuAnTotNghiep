<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index($id, Request $request)
     {

     }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $data=$request->except(['position','priority','risk','sortorder',]);
        $maxPosition = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('position');
        $data['position']=$maxPosition +1;
        $maxSortorder = \App\Models\Task::where('catalog_id', $request->catalog_id)
            ->max('sortorder');
        $data['sortorder']=$maxSortorder +1;
        $data['risk']=$data['risk'] ?? 'Medium';
        $data['priority']=$data['priority'] ?? 'Medium';
        Task::query()->create($data);
        return back()
            ->with('success', 'Thêm mới danh sách thành công vào bảng');
    }
    public function show()
    {
    }

        public function update($id, Request $request)
    {
        $data=$request->except(['_token', '_method']);

        Task::query()
            ->where('id', $id)
            ->update($data);
            return response()->json([
                'message' => 'Task đã được cập nhật thành công',
                'success' => true
            ]);

    }
}
