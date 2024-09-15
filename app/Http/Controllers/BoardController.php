<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'board.';
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('b.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except(['image','link_invite']);
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/b/{$uuid}/{$token}");
        try {
            DB::beginTransaction();
            $board = Board::query()->create($data);
            DB::table('board_members')->insert([
                'user_id' => auth()->id(),
                'board_id' => $board->id,
                'authorize' => 1,
                'invite' => now(),
            ]);
            DB::commit();
            return redirect()->route('homes.home');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with('error', 'Error: ' . $exception->getMessage());
        }


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
