<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const PATH_UPLOAD_IMAGE = 'users';
    public function chat(Request $request, ?string $roomId = null, ?string $receiverId = null)
    {
        $userIds = User::pluck('id')->toArray();
        foreach ($userIds as $id) {
            // Kiểm tra xem ID đã tồn tại trong bất kỳ members_hash nào chưa
            $exists = DB::table('room_chat')->where('members_hash', 'LIKE', "%{$id}%")->exists();

            // Nếu ID chưa tồn tại trong members_hash
            if (!$exists) {
                // Tạo combinations cho ID hiện tại với các ID còn lại
                $remainingIds = array_diff($userIds, [$id]);

                foreach ($remainingIds as $otherId) {
                    // Tạo members_hash có định dạng "id,otherId" (nhỏ -> lớn để tránh trùng lặp ngược)
                    $membersHash = implode(',', [$id, $otherId]);

                    // Kiểm tra lại để tránh thêm trùng members_hash
                    $alreadyExists = DB::table('room_chat')->where('members_hash', $membersHash)->exists();

                    if (!$alreadyExists) {
                        // Tạo mới bản ghi trong bảng room_chat
                        DB::table('room_chat')->insert([
                            'members_hash' => $membersHash,
                        ]);
                    }
                }
            }
        }

        if ($request->input('query')) {
            $query = $request->input('query'); // Nhận tham số từ request
            $users = [];

            if ($query) {
                // Truy vấn cơ sở dữ liệu và loại trừ người dùng hiện tại
                $users = User::where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'LIKE', "%{$query}%")
                                 ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->where('id', '!=', auth()->id())
                ->get();
            }
            return response()->json($users); // Trả về dữ liệu dưới dạng JSON
        } else {
            $currentUserId = auth()->id(); // Lấy ID của người dùng hiện tại

            $users = DB::table('users')



                ->get();


            $rooms = DB::table('room_chat')
                ->select('id', 'name', 'members_hash')
                ->get()->toArray();
            // dd(explode(',', $rooms[0]->members_hash));
            if ($receiverId) {
                // Truy vấn đến bảng users để lấy bản ghi với id == receiverId
                $userss = DB::table('users')->where('id', $receiverId)->first();
                return view('chat.index', compact('users', 'roomId', 'receiverId', 'rooms', 'userss'));
            }
            return view('chat.index', compact('users', 'roomId', 'receiverId', 'rooms'));
        }
    }

    public function check(string $id = null)
    {
        if (is_null($id)) {
            Log::info('No User ID received');
            return response()->json(['message' => 'No User ID provided'], 400);
        }

        Log::info('User ID received: ' . $id);

        // Lấy ID người dùng hiện tại
        $currentUserId = auth()->id();

        // Lấy tất cả các room chat
        $rooms = DB::table('room_chat')->get(); // Lấy tất cả các room từ bảng room_chat

        // Tìm room phù hợp
        foreach ($rooms as $room) {
            $membersArray = explode(',', $room->members_hash);

            // Kiểm tra xem cả hai ID có trong members_hash không
            if (in_array($currentUserId, $membersArray) && in_array($id, $membersArray)) {
                // Nếu có, trả về route chat
                return redirect()->route('chat', ['roomId' => $room->id, 'receiverId' => $id]);
            }
        }

        // Nếu không tìm thấy room nào, tạo room mới
        $membersArray = [$currentUserId, $id];
        sort($membersArray); // Sắp xếp ID từ nhỏ đến lớn
        $membersHash = implode(',', $membersArray); // Chuyển mảng thành chuỗi

        // Tạo bản ghi mới trong bảng room_chat
        $newRoomId = DB::table('room_chat')->insertGetId([
            'members_hash' => $membersHash,
            'name' => null
        ]);

        // Trả về route chat với roomId là id mới tạo
        return redirect()->route('chat', ['roomId' => $newRoomId, 'receiverId' => $id]);
    }


    public function updateStatus(Request $request)
    {
        $userId = auth()->id(); // Lấy ID của người dùng hiện tại
        $status = $request->input('status'); // Lấy trạng thái từ yêu cầu

        // Cập nhật trực tiếp bằng Query Builder
        DB::table('users')->where('id', $userId)->update(['status' => $status]);

        return response()->json(['success' => true]);
    }
    // UserController.php
    public function checkStatus($id)
    {
        $user = User::find($id);
        return response()->json(['status' => $user->status]);
    }
    public function getLatestMessage($currentUserId, $otherUserId) {
        $latestMessage = DB::table('messages')
            ->where(function($query) use ($currentUserId, $otherUserId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $otherUserId);
            })
            ->orWhere(function($query) use ($currentUserId, $otherUserId) {
                $query->where('sender_id', $otherUserId)
                      ->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'desc') // sắp xếp theo thời gian tạo, mới nhất trước
            ->limit(1) // giới hạn 1 kết quả
            ->first(); // lấy bản ghi đầu tiên

        return response()->json($latestMessage);
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
