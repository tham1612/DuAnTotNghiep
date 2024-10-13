<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const PATH_UPLOAD_IMAGE = 'users';
    public function chat(Request $request,?string $roomId = null, ?string $receiverId = null)
    {
        // Nhận giá trị từ input 'search'
    $search = $request->input('search');

    // Truy vấn users với điều kiện 'name' LIKE nếu có từ khóa tìm kiếm, ngược lại lấy tất cả
    $users = User::query()
        ->select('id', 'name', 'image')
        ->when(!empty($search), function ($query) use ($search) {
            // Thêm điều kiện where nếu có từ khóa tìm kiếm
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->get();
        if ($receiverId) {
            $userss = User::query()->select('id', 'name', 'image', 'email')->where('id', $receiverId)->first();
            $messages = Message::select('message', 'sender_id', 'receiver_id')
            ->where('receiver_id', $receiverId)
            ->where('sender_id', auth()->id())  // Lọc theo ID của người dùng hiện tại
            ->orderBy('created_at', 'asc')
            ->get();
            return view('chat.index', compact('users', 'userss', 'roomId', 'receiverId','messages'));
        }
        return view('chat.index', compact('users', 'roomId', 'receiverId'));
    }
    public function edit(string $id)
    {
        $user = User::query()->findOrFail($id);
        return view('users.profile', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id)
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
