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

        $updateData = [
            'name' => $validatedData['name'],
            'fullName' => $validatedData['fullName'],
            'phone' => $validatedData['phone'],
            'introduce' => $validatedData['introduce'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'social_id' => $validatedData['social_id'],
            'social_name' => $validatedData['social_name'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        $updateData = $request->except('image');
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }

            $updateData['image'] = Storage::put('users', $request->file('image'));
        }
        $user->update($updateData);

        return redirect()->route('user', $id)
            ->with('success', 'Thông tin người dùng đã được cập nhật');
    }
}
