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
=======
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{


    public function index()
    {
        $users = User::all(); // Lấy tất cả người dùng từ database
        return view('users.index', compact('users')); // Trả về view và truyền biến $users
    }

    // hiển thị trang chỉnh sửa thông tin người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID
        return view('users.edit', compact('user')); // Trả về view và truyền biến $user
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'fullName' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:7,15', // Bắt buộc phải là số và có độ dài từ 7 đến 15 chữ số
            'email' => 'required|email|max:255', // Bắt buộc phải có giá trị và phải đúng định dạng email
            'address' => 'nullable|string|max:255',
            'introduce' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'social_id' => 'nullable|string|max:255',
            'social_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cập nhật dữ liệu
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->fullName = $validatedData['fullName']; // Sửa lỗi ở đây
        $user->phone  = $validatedData['phone'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
            $user->image = $imagePath;
        }

        $user->introduce = $validatedData['introduce'];
        $user->address = $validatedData['address'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->social_id = $validatedData['social_id'];
        $user->social_name = $validatedData['social_name'];

        $user->save();


        return redirect()->route('users.edit', $id)

            ->with('success', 'Thông tin người dùng đã được cập nhật');
    }
}
