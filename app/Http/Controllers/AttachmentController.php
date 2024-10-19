<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    const PATH_UPLOAD = 'task_attachments';

    public function store(Request $request)
    {
        if ($request->hasFile('file_name')) {
            foreach ($request->file('file_name') as $index => $file) {
                if ($uploadedFilePath = Storage::put(self::PATH_UPLOAD, $file)) {
                    $fileName = $request->input('name')[$index];
                    TaskAttachment::create([
                        'task_id' => $request->task_id,
                        'file_name' => $uploadedFilePath,
                        'name'=>$fileName
                    ]);
                    session(['msg' => 'Hệ thống đã tải tệp thành công!']);
                    session(['action' => 'success']);
                } else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'Upload file không thành công'
                    ], 500);
                }
            }
        }

        return response()->json([
            'success' => true,
            'msg' => 'Tất cả tệp đã được thêm vào thành công'
        ]);

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
}
