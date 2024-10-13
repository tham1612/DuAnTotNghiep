<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('vouchers', function () {
    return true; // Kênh công khai nên luôn trả về true
});

// Route này kiểm tra nếu người dùng hiện tại có cùng userId với người được chỉ định, 
//      thì họ sẽ được phép lắng nghe kênh này.
Broadcast::channel('tasks.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('chat.{roomId}', function (User $user, $roomId) {

    // Select * from rooms where user_id = $user->id and id = $roomId;
    // if ($user->canJoinRoom($roomId)) {
    //     return ['id' => $user->id, 'name' => $user->name];
    // }

    return ['id' => $user->id, 'name' => $user->name];
});