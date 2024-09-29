<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Activitylog\Models\Activity;
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
        $task = Task::query()->create($data);

        activity('người dùng tạo task mới')
        ->causedBy(Auth::user()) // người thực hiện hành động
        ->perFormedOn($task) // Đối tượng bị tác động
        ->withProperties(['name' => $task->text,'user_name' => Auth::user()->name])// thuộc tính thêm
        ->log('Người dùng đã tạo thêm 1 task mới ');
        return back()->with('success', 'Thêm mới Task thành công');
    }
    public function show()
    {
        // $activities = Activity::all();
        // return
    }

    public function update($id, Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // Lấy thông tin Task trước khi cập nhật để so sánh
        $task = Task::find($id);
        $oldData = $task->toArray(); // Lưu lại dữ liệu cũ

        // Cập nhật Task
        $task->update($data);

        // Ghi lại log khi cập nhật Task
        activity('người dùng đã cập nhập task')
            ->causedBy(Auth::user()) // Người thực hiện hành động
            ->performedOn($task) // Task bị cập nhật
            ->withProperties(['old_data' => $oldData, 'new_data' => $data]) // Lưu dữ liệu trước và sau khi cập nhật
            ->log('Người dùng đã cập nhật Task'); // Mô tả hành động

        return redirect()->back()->with('success', 'Task đã được cập nhật thành công');
    }
}
