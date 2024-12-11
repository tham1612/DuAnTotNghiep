<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\CheckListItemMember;
use App\Models\Follow_member;
use App\Models\Tag;
use App\Models\Task;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Spatie\Activitylog\Models\Activity;

class ChecklistController extends Controller
{
    public function create(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkList = CheckList::create($data);

        $followMember = Follow_member::where('task_id', $checkList->task->id)
            ->where('follow', 1)
            ->get();
        foreach ($followMember as $member) {
            if ($member->user->id != Auth::id()) {
                event(new EventNotification("Nhiệm vụ " . $checkList->task->text . " đã thêm checklist ". $checkList->name.". Xem chi tiết! ", 'success', $member->user->id));
            }
        }
        activity('Thêm check list')
        ->performedOn($checkList)
        ->causedBy(Auth::user())
        ->withProperties([
            'check_list_name' => $checkList->name,
            'task_id' => $checkList->task_id,
            'catalog_id' => $checkList->task->catalog_id,
            'board_id' => $checkList->task->catalog->board_id,
            'workspace_id' => $checkList->task->catalog->board->workspace_id,
        ])
        ->tap(function (Activity $activity) use ($checkList) {
            $activity->checklist_id = $checkList->id;
            $activity->task_id = $checkList->task_id;
            $activity->catalog_id = $checkList->task->catalog_id;
            $activity->board_id = $checkList->task->catalog->board_id;
            $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
        })
        ->log('Checklist "' . $checkList->name . '" đã được thêm "' . $checkList->task->text . '"');
        return response()->json([
            'success' => "them thao tác thành công",
            'msg' => true,
            'checkList' => $checkList,
            'checkListId' => $checkList->id,
            'name' => $checkList->name,


        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkList = CheckList::query()->findOrFail($id);
        $data = $request->only(['name', 'task_id','progress']);
        $checkList->update($data);
        activity('Cập nhập check list')
        ->performedOn($checkList)
        ->causedBy(Auth::user())
        ->withProperties([
            'checklist_name' => $checkList->name,
            'task_id' => $checkList->task_id,
            'catalog_id' => $checkList->task->catalog_id,
            'board_id' => $checkList->task->catalog->board_id,
            'workspace_id' => $checkList->task->catalog->board->workspace_id,
        ])
        ->tap(function (Activity $activity) use ($checkList) {
            $activity->checklist_id = $checkList->id;
            $activity->task_id = $checkList->task_id;
            $activity->catalog_id = $checkList->task->catalog_id;
            $activity->board_id = $checkList->task->catalog->board_id;
            $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
        })
        ->log('Checklist "' . $checkList->name . '" đã được cập nhập  "' . $checkList->task->text . '"');
        return response()->json([
            'success' => "update checkList thành công",
            'msg' => true
        ]);
    }


    public function updateChecklistItem(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkListItem = CheckListItem::query()->findOrFail($request->id);
        $data = $request->only(['reminder_date', 'end_date', 'start_date', 'is_complete']);
        $checkListItem->update($data);
        $checkList = $checkListItem->checkList;
        $task = $checkList->task;
        activity('cập nhập  checklist item')
        ->performedOn($checkListItem)
        ->causedBy(Auth::user())
        ->withProperties([
            'checklist_item_id' => $checkListItem->id,
            'checklist_name' => $checkList->name,
            'catalog_id' => $checkList->task->catalog_id,
            'task_id' => $task->id,
            'workspace_id' => $checkList->task->catalog->board->workspace_id,
            'board_id' => $task->catalog->board_id ?? null,  // Kiểm tra sự tồn tại của board_id
        ])
        ->tap(function (Activity $activity) use ($checkList, $task) {
            $activity->checklist_id = $checkList->id;
            $activity->task_id = $task->id;
            $activity->catalog_id = $checkList->task->catalog_id;
            $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
            $activity->board_id = $task->catalog->board_id ?? null;
        })
        ->log('Checklist Item "' . $checkListItem->text . '" đã được cập nhập  Checklist "' . $checkList->name . '" thuộc Task "' . $task->text . '"');
        return response()->json([
            'success' => "update checkListItem thành công",
            'msg' => true
        ]);
    }

    public function addMemberChecklist(Request $request)
    {
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkListItemMember=CheckListItemMember::create($data);
        $checkList = $checkListItemMember->checkList;
        $task = $checkList->task;
//        dd($checkListItemMember);
activity('add member checklist item')
->performedOn($checkListItemMember)
->causedBy(Auth::user())
->withProperties([
    'checklist_item_id' => $checkListItemMember->id,
    'checklist_name' => $checkList->name,
    'catalog_id' => $checkList->task->catalog_id,
    'task_id' => $task->id,
    'workspace_id' => $checkList->task->catalog->board->workspace_id,
    'board_id' => $task->catalog->board_id ?? null,  // Kiểm tra sự tồn tại của board_id
])
->tap(function (Activity $activity) use ($checkList, $task) {
    $activity->checklist_id = $checkList->id;
    $activity->task_id = $task->id;
    $activity->catalog_id = $checkList->task->catalog_id;
    $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
    $activity->board_id = $task->catalog->board_id ?? null;
})
->log('Checklist Item "' . $checkListItemMember->text . '" đã được xóa khỏi Checklist "' . $checkList->name . '" thuộc Task "' . $task->text . '"');
        return response()->json([
            'success' => "them CheckListItemMember thành công",
            'msg' => true,
            'checkListItemMember'=>$checkListItemMember
        ]);
    }

    public function deleteMemberChecklist(Request $request)
    {
//        if (session('view_only', false)) {
//            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
//        }
//        session()->forget('view_only');
        $checklistItem = CheckListItemMember::where('check_list_item_id', $request->check_list_item_id)
            ->where('user_id', $request->user_id)
            ->first();
        $checklistItem->delete();
        $checkList = $checklistItem->checkList;
        $task = $checkList->task;
        activity('xóa member checklist item')
            ->performedOn($checklistItem)
            ->causedBy(Auth::user())
            ->withProperties([
                'checklist_item_id' => $checklistItem->id,
                'checklist_name' => $checkList->name,
                'catalog_id' => $checkList->task->catalog_id,
                'task_id' => $task->id,
                'workspace_id' => $checkList->task->catalog->board->workspace_id,
                'board_id' => $task->catalog->board_id ?? null,  // Kiểm tra sự tồn tại của board_id
            ])
            ->tap(function (Activity $activity) use ($checkList, $task) {
                $activity->checklist_id = $checkList->id;
                $activity->task_id = $task->id;
                $activity->catalog_id = $checkList->task->catalog_id;
                $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
                $activity->board_id = $task->catalog->board_id ?? null;
            })
            ->log('Checklist Item "' . $checklistItem->text . '" đã được xóa khỏi Checklist "' . $checkList->name . '" thuộc Task "' . $task->text . '"');
        return response()->json([
            'success' => "xoas CheckListItemMember thành công",
            'msg' => true
        ]);
    }

    public function getFormDateChecklistItem( $checkListItemId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checklistItem = CheckListItem::findOrFail($checkListItemId);
//        dd( $checklistItem);

        $htmlForm = View::make('dropdowns.dateCheckList', [
            'checklistItem' => $checklistItem
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

    public function deleteChecklist(Request $request)

    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkList = CheckList::with(['checkListItems.checkListItemMembers'])
            ->where('id', $request->id)
            ->first();
        if ($checkList) {
            foreach ($checkList->checkListItems as $checkListItem) {
                foreach ($checkListItem->checkListItemMembers as $checkListMember) {
                    $checkListMember->delete();
                }
                $checkListItem->delete();
            }

            $checkList->delete();
            activity('xóa check list')
            ->performedOn($checkList)
            ->causedBy(Auth::user())
            ->withProperties([
                'checklist_name' => $checkList->name,
                'task_id' => $checkList->task_id,
                'catalog_id' => $checkList->task->catalog_id,
                'board_id' => $checkList->task->catalog->board_id,
                'workspace_id' => $checkList->task->catalog->board->workspace_id,
            ])
            ->tap(function (Activity $activity) use ($checkList) {
                $activity->checklist_id = $checkList->id;
                $activity->task_id = $checkList->task_id;
                $activity->catalog_id = $checkList->task->catalog_id;
                $activity->board_id = $checkList->task->catalog->board_id;
                $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
            });
            return response()->json([
                'success' => "Xóa CheckList thành công",
                'msg' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => "CheckList không tồn tại"
            ], 404);
        }
    }

//    checklist item
    public function createChecklistItem(Request $request)
    {

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $data = $request->except(['_token', '_method']);
        $checkListItem = CheckListItem::create($data);
        $checkList = $checkListItem->checkList;
        $task = $checkList->task;
        activity('thêm checklist item')
                ->performedOn($checkListItem)
                ->causedBy(Auth::user())
                ->withProperties([
                    'checklist_item_id' => $checkListItem->id,
                    'checklist_name' => $checkList->name,
                    'catalog_id' => $checkList->task->catalog_id,
                    'task_id' => $task->id,
                    'workspace_id' => $checkList->task->catalog->board->workspace_id,
                    'board_id' => $task->catalog->board_id ?? null,  // Kiểm tra sự tồn tại của board_id
                ])
                ->tap(function (Activity $activity) use ($checkList, $task) {
                    $activity->checklist_id = $checkList->id;
                    $activity->task_id = $task->id;
                    $activity->catalog_id = $checkList->task->catalog_id;
                    $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
                    $activity->board_id = $task->catalog->board_id ?? null;
                })
                ->log('Checklist Item "' . $checkListItem->text . '" đã được thêm vào Checklist "' . $checkList->name . '" thuộc Task "' . $task->text . '"');

        $followMember = Follow_member::where('task_id', $checkListItem->checkList->task->id)
            ->where('follow', 1)
            ->get();
        foreach ($followMember as $member) {
            if ($member->user->id != Auth::id()) {
                event(new EventNotification("Nhiệm vụ " . $checkListItem->checkList->task->text . " đã thêm checklist " . $checkListItem->name . ". Xem chi tiết! ", 'success', $member->user->id));
            }
        }
        return response()->json([
            'success' => "them ChecklistItem thành công",
            'msg' => true,
            'checkListItem' => $checkListItem,
            'check_list_id' => $checkListItem->check_list_id,
            'id' => $checkListItem->id,
            'is_complete' => $checkListItem->is_complete,
            'start_date' => $checkListItem->start_date,
            'end_date' => $checkListItem->end_date,
            'reminder_date' => $checkListItem->reminder_date,
            'task_id' => CheckList::with('checkListItems')
                ->where('id', $checkListItem->check_list_id)->value('task_id'),
        ]);
    }
    public function deleteChecklistItem(Request $request)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checkListItem = CheckListItem::with(['checkListItemMembers'])
            ->where('id', $request->id)
            ->first();
        if ($checkListItem) {
            $checkList = $checkListItem->checkList;
            $task = $checkList->task;
            activity('xóa checklist item')
                ->performedOn($checkListItem)
                ->causedBy(Auth::user())
                ->withProperties([
                    'checklist_item_id' => $checkListItem->id,
                    'checklist_name' => $checkList->name,
                    'catalog_id' => $checkList->task->catalog_id,
                    'task_id' => $task->id,
                    'workspace_id' => $checkList->task->catalog->board->workspace_id,
                    'board_id' => $task->catalog->board_id ?? null,  // Kiểm tra sự tồn tại của board_id
                ])
                ->tap(function (Activity $activity) use ($checkList, $task) {
                    $activity->checklist_id = $checkList->id;
                    $activity->task_id = $task->id;
                    $activity->catalog_id = $checkList->task->catalog_id;
                    $activity->workspace_id = $checkList->task->catalog->board->workspace_id;
                    $activity->board_id = $task->catalog->board_id ?? null;
                })
                ->log('Checklist Item "' . $checkListItem->text . '" đã được xóa khỏi Checklist "' . $checkList->name . '" thuộc Task "' . $task->text . '"');
            foreach ($checkListItem->checkListItemMembers as $checkListMember) {
                $checkListMember->delete();
            }

            $checkListItem->delete();

            return response()->json([
                'success' => "Xóa checkListItem thành công",
                'msg' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => "checkListItem không tồn tại"
            ], 404);
        }
    }


//    call giao diện
    public function getFormCheckList($taskId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        if (!$taskId) {
            return response()->json(['error' => 'Task ID is missing'], 400);
        }

        $htmlForm = View::make('dropdowns.checklist', ['taskId' => $taskId])->render();

        // Trả về HTML cho frontend
        return response()->json(['html' => $htmlForm]);
    }


    public function getFormDate($checkListItemId)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $checklistItem = CheckListItem::findOrFail($checkListItemId);
//        dd( $checklistItem);

        $htmlForm = View::make('dropdowns.dateCheckList', [
            'checklistItem' => $checklistItem
        ])->render();

        return response()->json(['html' => $htmlForm]);
    }

}
