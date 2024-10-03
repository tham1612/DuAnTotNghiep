<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogRequest;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->except(['image','position']);
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $maxPosition = \App\Models\Catalog::where('board_id', $request->board_id)
            ->max('position');
        $data['position']=$maxPosition +1;
        Catalog::query()->create($data);
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
        //
    }
}
