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
    return (int)$user->id === (int)$id;
});

// Broadcast::channel('chat', function ($user) {
//     return true;
// });

Broadcast::channel('chat.{roomId}', function (User $user, $roomId) {
    return ['id' => $user->id, 'name' => $user->name];
});


Broadcast::channel('notifications.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});
Broadcast::channel('catalogs', function () {
    return true;
});
Broadcast::channel('tasks.{boardId}', function ($user, $boardId) {
    return $user->boards()->where('id', $boardId)->exists();
});
Broadcast::channel('boards.{boardId}', function ($user, $boardId) {
//    return $user->boards()->where('id', $boardId)->exists();
    return true;
});
