<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogRequest;
use App\Models\Board;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class CatalogControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'catalogs.';
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCatalogRequest $request)
    {

        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');

        $data = $request->except(['image','position']);

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $maxPosition = Catalog::where('board_id', $request->board_id)
            ->max('position');
        $data['position']=$maxPosition +1;

        $catalog =  Catalog::query()->create($data);
        // lấy thông tin board
        $board = Board::findOrFail($request->board_id);
        activity('thêm mới danh sách')
        ->performedOn($catalog)
        ->causedBy(Auth::user())
        ->withProperties(['catalog_name' => $catalog->name,'board_id' => $request->board_id,'workspace_id' => $board->workspace_id])
        ->tap(function (Activity $activity) use ($board,$request,$catalog){
            $activity->board_id = $request->board_id;
            $activity->catalog_id = $catalog->id;
            $activity->workspace_id = $board->workspace_id;
        })
        ->log('danh sách đã được thêm:'.$catalog->name);
        session(['msg' => 'đã thêm ' . $data['name'] . '  thành công!']);
        session(['action' => 'success']);
        return response()->json([
            'message' => 'catalog  đã được thêm thành công',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (session('view_only', false)) {
            return back()->with('error', 'Bạn chỉ có quyền xem và không thể chỉnh sửa bảng này.');
        }
        session()->forget('view_only');
        $catalog = Catalog::find($id);

        // Ghi log khi xóa danh sách
        activity('Catalog Deleted')
            ->causedBy(Auth::user()) // Người thực hiện
            ->withProperties(['catalog_name' => $catalog->name])
            ->tap(function (Activity $activity) use ($catalog) {
                $activity->board_id = $catalog->board_id;
                $activity->catalog_id = $catalog->id;
            })
            ->log('Người dùng đã xóa danh sách khỏi bảng');

        $catalog->delete();

        return redirect()->back()->with('success', 'Danh sách đã được xóa thành công.');
    }
}
