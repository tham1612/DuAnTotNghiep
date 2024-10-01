<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $data = $request->except(['image','position']);
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $maxPosition = \App\Models\Catalog::where('board_id', $request->board_id)
            ->max('position');
        $data['position']=$maxPosition +1;
        $catalog =  Catalog::query()->create($data);
        activity('thêm mới danh sách')
        ->causedBy(Auth::user())
        ->withProperties(['catalog_name' => $catalog->name])
        ->tap(function (Activity $activity) use ($request,$catalog){
            $activity->board_id = $request->board_id;
            $activity->catalog_id = $catalog->id;
        })
        ->log('danh sách đã được thêm vào bảng ');
        return back()
            ->with('success', 'Thêm mới danh sách thành công vào bảng');


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
