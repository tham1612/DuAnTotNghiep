<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\CheckListItem;
use App\Models\Task;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        CheckList::create($data);
        return response()->json([
            'success' => "them thao tác thành công",
        ]);
    }
    public function createChecklistItem(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        CheckListItem::create($data);
        return response()->json([
            'success' => "them ChecklistItem thành công",
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $checkList = CheckList::query()->findOrFail($id);
        $data=$request->only(['name','task_id']);
        $checkList->update($data);
        return response()->json([
            'success' => "update thao tác thành công",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
