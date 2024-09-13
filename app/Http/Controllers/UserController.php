<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.profile', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validatedData = $request->validated();

        $user = User::findOrFail($id);

        // Cập nhật dữ liệu
        $user->name = $validatedData['name'];
        $user->fullName = $validatedData['fullName'];
        $user->phone = $validatedData['phone'];
        $user->introduce = $validatedData['introduce'];
        $user->address = $validatedData['address'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->social_name = $validatedData['social_name'];

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete( $user->image);
            }
            $user->image = Storage::put('users', $request->file('image'));
        }

        $user->save();
        

        return redirect()->route('user', $id)
            ->with('success', 'Thông tin người dùng đã được cập nhật');
    }
}
