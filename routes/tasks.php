<?php

use \App\Http\Controllers\ChecklistController;
use App\Http\Controllers\TaskController;
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


Route::middleware(['auth', 'isWorkspace'])
    ->group(function () {

        Route::resource('tasks', TaskController::class);

        Route::post('/create-event', [TaskController::class, 'createEvent']);

        Route::put('/update-event/{id}', [TaskController::class, 'updateEvent'])->name('update');

        Route::delete('/delete-event/{id}', [TaskController::class, 'deleteEvent'])->name('delete');

        Route::get('/redirect', [GoogleApiClientController::class, 'redirectToGoogle'])->name('google.redirect');

        Route::get('/callback', [GoogleApiClientController::class, 'handleGoogleCallback']);

        Route::put('/tasks/updatePosition/{id}', [TaskController::class, 'updatePosition'])->name('update.position');

        Route::get('/tasks/getModalTask/{id}', [TaskController::class, 'getModalTask']);

        Route::put('/tasks/{id}/updateFolow', [TaskController::class, 'updateFolow'])->name('tasks.updateFolow');

        Route::get('/tasks/{id}/getFormDateTask', [TaskController::class, 'getFormDateTask']);

        Route::get('/tasks/{id}/getFormDateTask', [TaskController::class, 'getFormDateTask']);

        Route::get('/tasks/getFormCheckList/{id}', [ChecklistController::class, 'getFormCheckList'])
            ->name('tasks.getFormCheckList');

//        sao chep
        Route::post('/tasks/copyTask', [TaskController::class, 'copyTask'])
            ->name('tasks.copyTask');

//        hoàn tác + xóa vĩnh viễn
        Route::post('/tasks/destroyTask/{id}', [TaskController::class, 'destroyTask'])
            ->name('tasks.destroyTask');

        Route::post('/tasks/restoreTask/{id}', [TaskController::class, 'restoreTask'])
            ->name('tasks.restoreTask');

        //  checklist
        Route::post('/tasks/checklist/create', [ChecklistController::class, 'create'])
            ->name('checklist.create');

        Route::put('/tasks/{checklist}/checklist', [ChecklistController::class, 'update'])
            ->name('checklist.update');

        Route::post('/tasks/checklist/checklistItem/create', [ChecklistController::class, 'createChecklistItem'])
            ->name('checklist.createChecklistItem');

        Route::put('/tasks/checklist/checklistItem/{id}/update', [ChecklistController::class, 'updateChecklistItem'])
            ->name('checklist.updateChecklistItem');

        Route::get('/tasks/checklist/getProgress', [ChecklistController::class, 'getProgress'])
            ->name('checklist.getProgress');

        Route::post('/tasks/checklist/checklistItem/{id}/delete', [ChecklistController::class, 'deleteChecklistItem'])
            ->name('checklist.deleteChecklistItem');

        Route::get('/tasks/checklist/checklistItem/{id}/getFormDate', [ChecklistController::class, 'getFormDate'])
            ->name('checklist.getFormDate');

        Route::post('/tasks/{checklist}/deleteChecklist', [ChecklistController::class, 'deleteChecklist'])
            ->name('checklist.deleteChecklist');


        // member
        Route::post('/tasks/addMember', [\App\Http\Controllers\MemberController::class, 'addMemberTask'])
            ->name('tasks.addMemberTask');

        Route::post('/tasks/deleteTaskMember', [\App\Http\Controllers\MemberController::class, 'deleteTaskMember'])
            ->name('tasks.deleteTaskMember');

        Route::get('/tasks/getFormAddMember/{id}', [\App\Http\Controllers\MemberController::class, 'getFormMemberTask'])
            ->name('tasks.getFormMemberTask');

        Route::post('/checklistItem/addMemberChecklist', [\App\Http\Controllers\MemberController::class, 'addMemberChecklistItem'])
            ->name('checklist.addMemberChecklistItem');

        Route::post('/checklistItem/deleteMemberChecklist', [\App\Http\Controllers\MemberController::class, 'deleteMemberChecklistItem'])
            ->name('checklist.deleteMemberChecklistItem');

        Route::get('/tasks/checklist/checklistItem/getFormAddMember/{id}', [\App\Http\Controllers\MemberController::class, 'getFormMemberChecklistItem'])
            ->name('tasks.getFormMemberChecklistItem');


        //       tag
        Route::get('/tasks/getListTagTaskBoard/{id}', [\App\Http\Controllers\TagController::class, 'getListTagTaskBoard'])
            ->name('tasks.getListTagTaskBoard');

        Route::get('/tasks/getFormCreateTag/{id}', [\App\Http\Controllers\TagController::class, 'getFormCreateTag'])
            ->name('tasks.getFormCreateTag');

        Route::post('/tasks/tag/create', [\App\Http\Controllers\TagController::class, 'store'])
            ->name('tags.create');

        Route::post('/tasks/tag/update', [\App\Http\Controllers\TagController::class, 'update'])
            ->name('tags.update');


        //        attachment
        Route::post('/tasks/attachments/create', [\App\Http\Controllers\AttachmentController::class, 'store'])
            ->name('attachments.create');

        Route::put('/tasks/attachments/{id}/update', [\App\Http\Controllers\AttachmentController::class, 'update'])
            ->name('attachments.update');

        Route::delete('/tasks/attachments/{id}/destroy', [\App\Http\Controllers\AttachmentController::class, 'destroy'])
            ->name('attachments.destroy');

        Route::get('/tasks/getFormAttach/{id}', [\App\Http\Controllers\AttachmentController::class, 'getFormAttach'])
            ->name('tasks.getFormAttach');


        //        comment
        Route::post('/tasks/comments/create', [\App\Http\Controllers\CommentController::class, 'store'])
            ->name('comments.create');

        Route::put('/tasks/comments/{id}/update', [\App\Http\Controllers\CommentController::class, 'update'])
            ->name('comments.update');

        Route::post('/tasks/comments/{id}/destroy', [\App\Http\Controllers\CommentController::class, 'destroy'])
            ->name('comments.destroy');

        Route::get('/tasks/comments/{id}/getAllComment', [\App\Http\Controllers\CommentController::class, 'getAllComment'])
            ->name('comments.getAllComment');
    });
