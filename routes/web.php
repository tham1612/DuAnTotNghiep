<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use \App\Http\Controllers\BoardController;
use \App\Http\Controllers\CatalogControler;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
        Route::get('/taskflow/invite/{uuid}/{token}', [WorkspaceController::class, 'acceptInvite']);
        Route::post('/workspaces/{workspaceId}/invite', [WorkspaceController::class, 'inviteUser'])
            ->middleware('auth')->name('invite_workspace');

            Route::get('/homes/dashboard', [BoardController::class, 'index'])->name('homes.dashboard');

        Route::get('/home', function () {
            return view('homes.home');
        })->name('home');

        Route::get('/chat',function(){
            return view('chat.index');
        })->name('chat');


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
                Route::put('{id}/update', [BoardController::class, 'update'])->name('update');
            });
        Route::resource('catalogs', CatalogControler::class);
        Route::resource('tasks', \App\Http\Controllers\TaskController::class);

    });

Route::get('inboxs', function () {
    return view('Inboxs.index');
})->name('inbox');

Auth::routes();
