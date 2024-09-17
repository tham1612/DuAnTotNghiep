<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkspaceController;
use \App\Http\Controllers\BoardController;
use \App\Http\Controllers\CatalogControler;
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
});

Route::middleware(['auth', 'isWorkspace'])
    ->group(function () {
        Route::prefix('workspaces')
            ->as('workspaces.')
            ->group(function () {
                Route::resource('/', WorkspaceController::class);
                Route::get('create', [WorkspaceController::class, 'create'])
                    ->withoutMiddleware('isWorkspace')
                    ->name('create');
                Route::post('store', [WorkspaceController::class, 'store'])
                    ->withoutMiddleware('isWorkspace')
                    ->name('store');
            });



        Route::get('/homes/dashboard', function () {
            return view('homes.dashboard');
        });

        Route::get('/home', function () {
            return view('homes.home');
        })->name('homes.home');


        Route::get('/user/{id}', [UserController::class, 'edit'])
        ->name('user');
        Route::put('/user/{id}', [UserController::class, 'update'])
        ->name('users.update');
        Route::prefix('b')
            ->as('b.')
            ->group(function () {

                Route::get('create', [BoardController::class, 'create'])
                    ->name('create');
                Route::post('store', [BoardController::class, 'store'])
                    ->name('store');

                Route::get('dashboard', function () {
                    return view('homes.dashboard_board');
                })->name('dashboard');

                Route::get('board', function () {
                    return view('boards.index');
                })->name('board');

                Route::get('table', function () {
                    return view('tables.index');
                })->name('table');

                Route::get('ganttChart', function () {
                    return view('ganttCharts.index');
                })->name('ganttChart');

                Route::get('list', function () {
                    return view('lists.index');
                })->name('list');

                Route::get('inboxs', function () {
                    return view('Inboxs.index');
                })->name('inbox');

            });
        Route::resource('catalogs', CatalogControler::class);


    });


Auth::routes();
