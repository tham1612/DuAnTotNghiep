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

        Route::put('/tasks/{id}/updateFolow', [TaskController::class, 'updateFolow'])->name('tasks.updateFolow');

        Route::post('/tasks/addMember', [TaskController::class, 'addMemberTask'])
            ->name('tasks.addMemberTask');

        Route::post('/tasks/deleteTaskMember', [TaskController::class, 'deleteTaskMember'])
            ->name('tasks.deleteTaskMember');

        Route::get('/tasks/getFormChekList/{id}', [TaskController::class, 'getFormChekList'])
            ->name('tasks.getFormChekList');

        Route::get('/tasks/getFormAttach/{id}', [TaskController::class, 'getFormAttach'])
            ->name('tasks.getFormAttach');

        Route::get('/tasks/getFormAddMember/{id}', [TaskController::class, 'getFormAddMember'])
            ->name('tasks.getFormAddMember');

        //  checklist
        Route::post('/tasks/checklist/create', [ChecklistController::class, 'create'])
            ->name('checklist.create');

        Route::put('/tasks/{checklist}/checklist', [ChecklistController::class, 'update'])
            ->name('checklist.update');

        Route::post('/tasks/checklist/checklistItem/create', [ChecklistController::class, 'createChecklistItem'])
            ->name('checklist.createChecklistItem');

        Route::put('/tasks/checklist/checklistItem/{id}/update', [ChecklistController::class, 'updateChecklistItem'])
            ->name('checklist.updateChecklistItem');

        Route::post('/checklistItem/addMemberChecklist', [ChecklistController::class, 'addMemberChecklist'])
            ->name('checklist.addMemberChecklist');

        Route::post('/checklistItem/deleteMemberChecklist', [ChecklistController::class, 'deleteMemberChecklist'])
            ->name('checklist.deleteMemberChecklist');

        Route::get('/tasks/checklist/getProgress', [ChecklistController::class, 'getProgress'])
            ->name('checklist.getProgress');

        Route::post('/tasks/checklist/checklistItem/{id}/delete', [ChecklistController::class, 'deleteChecklistItem'])
            ->name('checklist.deleteChecklistItem');

        Route::get('/tasks/checklist/checklistItem/{id}/getFormDate', [ChecklistController::class, 'getFormDateChecklistItem'])
            ->name('checklist.getFormDateChecklistItem');

        Route::post('/tasks/{checklist}/deleteChecklist', [ChecklistController::class, 'deleteChecklist'])
            ->name('checklist.deleteChecklist');

        Route::get('/tasks/checklist/checklistItem/getFormAddMember/{id}', [ChecklistController::class, 'getFormAddMember'])
            ->name('tasks.getFormAddMember');

        Route::get('/tasks/{id}/getFormDateTask', [TaskController::class, 'getFormDateTask']);

        //       task tag
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

        //        comment
        Route::post('/tasks/comments/create', [\App\Http\Controllers\CommentController::class, 'store'])
            ->name('comments.create');

        Route::put('/tasks/comments/{id}/update', [\App\Http\Controllers\CommentController::class, 'update'])
            ->name('comments.update');

        Route::post('/tasks/comments/{id}/destroy', [\App\Http\Controllers\CommentController::class, 'destroy'])
            ->name('comments.destroy');
    });
