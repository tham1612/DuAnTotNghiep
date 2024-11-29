<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Models\CheckList;
use App\Models\Follow_member;
use App\Models\TaskAttachment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class AttachmentController extends Controller
{
    const PATH_UPLOAD = 'task_attachments';

    public function store(Request $request)
    {
        if ($request->hasFile('file_name')) {
            $addedFiles = []; // Mảng lưu các tệp đã thêm thành công

            foreach ($request->file('file_name') as $index => $file) {
                if ($uploadedFilePath = Storage::put(self::PATH_UPLOAD, $file)) {
                    $fileNameWithExtension = $request->input('name')[$index];
                    $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
                    $attachment = TaskAttachment::create([
                        'task_id' => $request->task_id,
                        'file_name' => $uploadedFilePath,
                        'name' => $fileName
                    ]);

                    // Lưu thông tin tệp vào mảng $addedFiles
                    $attachments[] = [
                        'id' => $attachment->id,
                        'task_id' => $attachment->task_id,
                        'file_name' => $attachment->file_name,
                        'name' => $attachment->name
                    ];

                    $followMember = Follow_member::where('task_id', $attachment->task_id)
                        ->where('follow', 1)
                        ->get();
                    foreach ($followMember as $member) {
                        if ($member->user->id != Auth::id()) {
                            event(new EventNotification("Nhiệm vụ " . $attachment->task->text . " đã thêm file " . $attachment->name. ". Xem chi tiết! ", 'success', $member->user->id));
                        }
                    }

//                    session(['msg' => 'Hệ thống đã tải tệp thành công!']);
//                    session(['action' => 'success']);
                } else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'Upload file không thành công'
                    ], 500);
                }
            }


            return response()->json([
                'success' => true,
                'msg' =>'Hệ thống đã tải tệp thành công!',
                'action' => 'success',
                'attachments' => json_decode(json_encode($attachments))
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Không có tệp nào được tải lên'
        ], 400);


    }
    public function update(Request $request, string $id)
    {
        $taskAttachment = TaskAttachment::query()->findOrFail($id);
        $data=$request->only(['name']);
        $taskAttachment->update($data);
        return response()->json([
            'success' => "update taskAttachment thành công",
            'msg' => true
        ]);
    }
    public function destroy( string $id)
    {
        $attachment = TaskAttachment::find($id);
        if ($attachment) {
            if ($attachment->file_name && Storage::exists($attachment->file_name)) {
                Storage::delete($attachment->file_name);
            }
            $attachment->delete();
            return response()->json([
                'success' => true,
                'msg' => 'Tệp đã được xóa thành công'
            ]);
        }
        return response()->json([
            'success' => false,
            'msg' => 'Tệp không tồn tại'
        ], 404);
    }

//    call giao diện
    public function getFormAttach($taskId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        if (!$taskId) {
            return response()->json(['error' => 'Task ID is missing'], 400);
        }

        $htmlForm = View::make('dropdowns.attach', ['taskId' => $taskId])->render();

        // Trả về HTML cho frontend
        return response()->json(['html' => $htmlForm]);
    }
}
