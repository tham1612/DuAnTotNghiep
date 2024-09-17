<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Laravel\Prompts\table;


class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'workspaces.';

    public function index()
    {

    }

    public function create()
    {
        return view('workspaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $data['access'] = $data['access'] ?? 'private';
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/{$uuid}/{$token}");
        try {
            DB::beginTransaction();

            $workspace = Workspace::query()->create($data);
            Log::info('Form submitted by user: ' . auth()->id());
            DB::table('workspace_members')->insert([
                'user_id' => auth()->id(),
                'workspace_id' => $workspace->id,
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
    public
        function show(
        string $id
    ) {
        //        $model = Workspace::query()->findOrFail($id);
//         return view('workspaces.edit',compact('model'));
//        $data = $request->except('image');
//        if ($request->hasFile('image')) {
//            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
//        }
//        $data['access'] = $data['access'] ?? 'private';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
        function edit(
        string $id
    ) {
        $model = Workspace::query()->findOrFail($id);
        return view('workspaces.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public
        function update(
        Request $request,
        string $id
    ) {
        $model = Workspace::query()->findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public
        function destroy(
        string $id
    ) {
        //
    }


}
