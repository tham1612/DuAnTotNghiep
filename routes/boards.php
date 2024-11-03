<?php

use \App\Http\Controllers\BoardController;
use \App\Http\Controllers\CatalogControler;
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

        Route::get('/homes/dashboard/{workspaceId}', [BoardController::class, 'index'])->name('homes.dashboard');

        Route::group(['middleware' => ['auth', 'check.board.access']], function () {
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

                    Route::put('accept-member', [BoardController::class, 'acceptMember'])->name('acceptMember');

                    Route::delete('refuse-member/{id}', [BoardController::class, 'refuseMember'])->name('refuseMember');

                    Route::post('invite-member-workspace/{userId}/{boardId}', [BoardController::class, 'inviteMemberWorkspace'])->name('inviteMemberWorkspace');

                    Route::get('activate-member/{id}', [BoardController::class, 'activateMember'])->name('activateMember');

                    Route::get('upgrade-member-ship/{id}', [BoardController::class, 'upgradeMemberShip'])->name('upgradeMemberShip');

                    Route::get('management-franchise/{owner_id}/{user_id}', [BoardController::class, 'managementfranchise'])->name('managementfranchise');

//                    lưu trữ + hoàn tác + xóa vĩnh viễn
                    Route::post('{id}', [BoardController::class, 'destroy'])->name('destroy');

                    Route::post('/restoreBoard/{id}', [BoardController::class, 'restoreBoard'])->name('restoreBoard');

                    Route::post('/destroyBoard/{id}', [BoardController::class, 'destroyBoard'])->name('destroyBoard');

                });
        });

        Route::get('/taskflow/invite/b/{uuid}/{token}', [BoardController::class, 'acceptInviteBoard'])
            ->withoutMiddleware('auth');

        Route::resource('catalogs', CatalogControler::class);

        // hoàn tác + xóa vĩnh viễn
        Route::post('/catalogs/destroyCatalog/{id}', [CatalogControler::class, 'destroyCatalog'])
            ->name('catalogs.destroyCatalog');

        Route::post('/catalogs/restoreCatalog/{id}', [CatalogControler::class, 'restoreCatalog'])
            ->name('catalogs.restoreCatalog');

        Route::post('/catalogs/archiverAllTasks/{id}', [CatalogControler::class, 'archiverAllTasks'])
            ->name('catalogs.archiverAllTasks');
    });
