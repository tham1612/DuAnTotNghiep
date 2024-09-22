<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const PATH_UPLOAD_IMAGE = 'users';

    public function edit(string $id)
    {
        $user = User::query()->findOrFail($id);
        return view('users.profile', compact('user'));
    }

    public function update(UpdateUserRequest $request,string $id)
    {
        $user = User::query()->findOrFail($id);
        $validatedData = $request->except('image');

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $validatedData['image'] = Storage::put(self::PATH_UPLOAD_IMAGE, $request->image);
            $currentImage = $user->image;
            if ($currentImage && Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
        }

        $user->update($validatedData);

        return redirect()->route('user', $id)
            ->with('success', 'Thông tin người dùng đã được cập nhật');
    }
}
