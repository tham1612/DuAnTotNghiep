<?php

use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatAIController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

Route::middleware(['auth', 'isWorkspace', 'isActiveWsp'])
    ->group(function () {
        Route::view('/boardError', '/pageError/boardError');
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('chat/{roomId?}/{receiverId?}', [UserController::class, 'chat'])
            ->name('chat');

        Route::post('/messages/send', [MessageController::class, 'sendMessage']);

        Route::get('/chatAI', [ChatAIController::class, 'index'])->name('chatAI.index');

        Route::post('/chatAI', [ChatAIController::class, 'store'])->name('store');

        Route::delete('/chat/history', [ChatAIController::class, 'destroy'])->name('chat.history.destroy');

        Route::get('/chat/load-more', [ChatAIController::class, 'loadMore'])->name('chat.loadMore');

        Route::get('/user/{id}', [UserController::class, 'edit'])
            ->name('user');

        Route::put('/user/{id}', [UserController::class, 'update'])
            ->name('users.update');
    });

Route::middleware(['auth', 'isActiveWsp'])->get('inboxs', function () {
    return view('Inboxs.index');
})->name('inbox');

Route::get('/ai-chat', [ChatAIController::class, 'chat']);

Auth::routes();

Route::post('/forget-session', function () {
    session()->forget(['msg', 'action']);
})->name('forget.session');

Route::controller(LoginGoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('login-google');

    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('/check-user/{id?}', [UserController::class, 'check'])->name('check.user');
Route::post('/update-status', [UserController::class, 'updateStatus']);

Route::get('/user/status/{id}', [UserController::class, 'checkStatus']);
Route::get('/latest-message/{currentUserId}/{otherUserId}', [UserController::class, 'getLatestMessage']);
