<?php

use App\Http\Controllers\WorkspaceController;
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

                Route::delete('delete/{id}', [WorkspaceController::class, 'delete'])
                    ->withoutMiddleware('isWorkspace')
                    ->name('delete');

            });

        //edit workspace
        Route::get('workspace/edit-workspaces', [WorkspaceController::class, 'showFormEditWorkspace'])
            ->name('showFormEditWorkspace');

        Route::post('workspace/update-workspaces', [WorkspaceController::class, 'editWorkspace'])
            ->name('editWorkspace');

        Route::post('workspace/update-ws-access', [WorkspaceController::class, 'update_ws_access'])
            ->name('update_ws_access');

        Route::put('workspace/accept-member', [WorkspaceController::class, 'accept_member'])
            ->name('accept_member');

        Route::delete('workspace/refuse-member/{id}', [WorkspaceController::class, 'refuse_member'])
            ->name('refuse_member');

        Route::get('/taskflow/invite/{uuid}/{token}', [WorkspaceController::class, 'acceptInvite'])
            ->withoutMiddleware('auth');

        Route::post('/workspaces/{workspaceId}/invite', [WorkspaceController::class, 'inviteUser'])
            ->middleware('auth')->name('invite_workspace');

        Route::get('workspace/activate-member/{id}', [WorkspaceController::class, 'activateMember'])->name('activateMember');

        Route::get('workspace/upgrade-member-ship/{id}', [WorkspaceController::class, 'upgradeMemberShip'])->name('upgradeMemberShip');

        Route::get('workspace/management-franchise/{owner_id}/{user_id}', [WorkspaceController::class, 'managementfranchise'])->name('managementfranchise');

    });
