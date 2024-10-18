<?php

use \App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use \App\Http\Controllers\BoardController;
use \App\Http\Controllers\CatalogControler;
use App\Http\Controllers\ChatAIController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleApiClientController;

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

Route::middleware(['auth', 'isWorkspace'])
    ->group(function () {
        Route::prefix('workspaces')
            ->as('workspaces.')
            ->group(function () {
                Route::resource('/', WorkspaceController::class);
                Route::get('/{id}', [WorkspaceController::class, 'index'])
                    ->name('index');
                Route::get('create', [WorkspaceController::class, 'create'])
                    ->withoutMiddleware('isWorkspace')
                    ->name('create');
                Route::post('store', [WorkspaceController::class, 'store'])
                    ->withoutMiddleware('isWorkspace')
                    ->name('store');
                Route::get('delete/{id}', [WorkspaceController::class, 'delete'])
                    ->withoutMiddleware('isWorkspace')
                    ->name('delete');
            });

        //Xử lý chỉnh sửa workspace
        Route::get('edit_workspaces', [WorkspaceController::class, 'showFormEditWorkspace'])
            ->name('showFormEditWorkspace');
        Route::post('update_workspaces', [WorkspaceController::class, 'editWorkspace'])
            ->name('editWorkspace');
        Route::post('update_ws_access', [WorkspaceController::class, 'update_ws_access'])
            ->name('update_ws_access');
        //dùng cho modal duyệt thành viên trong chỉnh sửa wsp
        Route::put('accept_member', [WorkspaceController::class, 'accept_member'])
            ->name('accept_member');
        Route::delete('refuse_member/{id}', [WorkspaceController::class, 'refuse_member'])
            ->name('refuse_member');
        //thằng này thì sử lý logic khi người dùng kick và link được mời hoặc kick vào link_Pinvite của wsp
        Route::get('/taskflow/invite/{uuid}/{token}', [WorkspaceController::class, 'acceptInvite'])
            ->withoutMiddleware('auth');

        Route::post('/workspaces/{workspaceId}/invite', [WorkspaceController::class, 'inviteUser'])
            ->middleware('auth')->name('invite_workspace');

        Route::get('/homes/dashboard/{workspaceId}', [BoardController::class, 'index'])->name('homes.dashboard');
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/chat', function () {
            return view('chat.index');
        })->name('chat');

        Route::get('/chatAI', [ChatAIController::class, 'index'])->name('chatAI.index');
        Route::post('/chatAI', [ChatAIController::class, 'store'])->name('store');
        Route::delete('/chat/history', [ChatAIController::class, 'destroy'])->name('chat.history.destroy');
        Route::get('/chat/load-more', [ChatAIController::class, 'loadMore'])->name('chat.loadMore');

        Route::get('/user/{id}', [UserController::class, 'edit'])
            ->name('user');
        Route::put('/user/{id}', [UserController::class, 'update'])
            ->name('users.update');
        Route::prefix('b')
            ->as('b.')
            ->group(function () {
                Route::get('create', [BoardController::class, 'create'])->name('create');
                Route::post('store', [BoardController::class, 'store'])->name('store');
                Route::get('{id}/edit', [BoardController::class, 'edit'])->name('edit');
                Route::post('{id}/filter', [BoardController::class, 'filter']);
                Route::put('{id}/update', [BoardController::class, 'update'])->name('update');
                Route::get('/boards/{boardId}/edit', [BoardController::class, 'edit'])->name('boards.edit');
                Route::put('{id}/updateBoardMember', [BoardController::class, 'updateBoardMember'])->name('updateBoardMember');
                Route::put('{id}/updateBoardMember2', [BoardController::class, 'updateBoardMember2'])->name('updateBoardMember2');
                Route::get('request-to-join-workspace', [BoardController::class, 'requestToJoinWorkspace'])->name('requestToJoinWorkspace');
                Route::post('invite', [BoardController::class, 'inviteUserBoard'])->name('invite_board');
                Route::post('invite-member-workspace/{userId}/{boardId}', [BoardController::class, 'inviteMemberWorkspace'])->name('inviteMemberWorkspace');
            });
        Route::get('/taskflow/invite/b/{uuid}/{token}', [BoardController::class, 'acceptInviteBoard'])
            ->withoutMiddleware('auth');
        Route::resource('catalogs', CatalogControler::class);

        Route::resource('tasks', TaskController::class);

        Route::post('/create-event', [TaskController::class, 'createEvent']);
        Route::put('/update-event/{id}', [TaskController::class, 'updateEvent'])->name('update');
//        Route::put('/update-dateTask/{id}', [TaskController::class, 'updateEvent'])->name('updateDateTask');
        Route::delete('/delete-event/{id}', [TaskController::class, 'deleteEvent'])->name('delete');
        Route::get('/redirect', [GoogleApiClientController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/callback', [GoogleApiClientController::class, 'handleGoogleCallback']);

        Route::put('/tasks/updatePosition/{id}', [TaskController::class, 'updatePosition'])->name('update.position');
        Route::put('/tasks/updateCalendar/{id}', [TaskController::class, 'updateCalendar'])->name('update.calendar');
        Route::put('/tasks/{id}/updateFolow', [TaskController::class, 'updateFolow'])->name('tasks.updateFolow');
        Route::post('/tasks/addMember', [TaskController::class, 'addMemberTask'])
            ->name('tasks.addMemberTask');
        Route::post('/tasks/deleteTaskMember', [TaskController::class, 'deleteTaskMember'])
            ->name('tasks.deleteTaskMember');

        Route::post('/tasks/checklist/create', [ChecklistController::class, 'create'])
            ->name('checklist.create');
        Route::put('/tasks/{checklist}/checklist', [ChecklistController::class, 'update'])
            ->name('checklist.update');
        Route::post('/tasks/checklist/checklistItem/create', [ChecklistController::class, 'createChecklistItem'])
            ->name('checklist.createChecklistItem');
        Route::post('/tasks/checklist/checklistItem/update', [ChecklistController::class, 'updateChecklistItem'])
            ->name('checklist.updateChecklistItem');
        Route::post('/checklistItem/addMemberChecklist', [ChecklistController::class, 'addMemberChecklist'])
            ->name('checklist.addMemberChecklist');
        Route::post('/checklistItem/deleteMemberChecklist', [ChecklistController::class, 'deleteMemberChecklist'])
            ->name('checklist.deleteMemberChecklist');
        Route::get('/tasks/checklist/getProgress', [ChecklistController::class, 'getProgress'])
            ->name('checklist.getProgress');

//       task tag
        Route::post('/tasks/tag/create', [\App\Http\Controllers\TagController::class, 'store'])
            ->name('tags.create');
        Route::post('/tasks/tag/update', [\App\Http\Controllers\TagController::class, 'update'])
            ->name('tags.update');
        Route::post('/tasks/attachments/create', [\App\Http\Controllers\AttachmentController::class, 'store'])
            ->name('attachments.create');
        Route::put('/tasks/attachments/{id}/update', [\App\Http\Controllers\AttachmentController::class, 'update'])
            ->name('attachments.update');
        Route::delete('/tasks/attachments/{id}/destroy', [\App\Http\Controllers\AttachmentController::class, 'destroy'])
            ->name('attachments.destroy');
        Route::post('/tasks/comments/create', [\App\Http\Controllers\CommentController::class, 'store'])
            ->name('comments.create');
    });


Route::get('inboxs', function () {
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
