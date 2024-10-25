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
        if ($request->input('query')) {
            $query = $request->input('query'); // Nhận tham số từ request
            $users = [];
            if ($query) {
                // Truy vấn cơ sở dữ liệu
                $users = User::where('email', 'LIKE', "%{$query}%")->get();
            }

            return response()->json($users); // Trả về dữ liệu dưới dạng JSON
        } else {
            $currentUserId = auth()->id(); // Lấy ID của người dùng hiện tại

            $users = DB::table('users')
                ->join('messages', function ($join) use ($currentUserId) {
                    $join->on('users.id', '=', 'messages.sender_id')
                        ->orOn('users.id', '=', 'messages.receiver_id');
                })
                ->where(function ($query) use ($currentUserId) {
                    $query->where('messages.sender_id', $currentUserId)
                          ->orWhere('messages.receiver_id', $currentUserId);
                })
                ->select(
                    'users.*', 
                    DB::raw('(SELECT m.message FROM messages AS m 
                              WHERE (m.sender_id = users.id OR m.receiver_id = users.id) 
                              AND (m.sender_id = ' . $currentUserId . ' OR m.receiver_id = ' . $currentUserId . ') 
                              ORDER BY m.created_at DESC 
                              LIMIT 1) as latest_message'),
                    DB::raw('(SELECT m.sender_id FROM messages AS m 
                              WHERE (m.sender_id = users.id OR m.receiver_id = users.id) 
                              AND (m.sender_id = ' . $currentUserId . ' OR m.receiver_id = ' . $currentUserId . ') 
                              ORDER BY m.created_at DESC 
                              LIMIT 1) as latest_sender_id'),
                    DB::raw('(SELECT m.created_at FROM messages AS m 
                              WHERE (m.sender_id = users.id OR m.receiver_id = users.id) 
                              AND (m.sender_id = ' . $currentUserId . ' OR m.receiver_id = ' . $currentUserId . ') 
                              ORDER BY m.created_at DESC 
                              LIMIT 1) as latest_message_time')
                )
                ->distinct()
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
