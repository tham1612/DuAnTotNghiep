<?php

use App\Http\Controllers\UserController;
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
Route::resource('/workspaces', \App\Http\Controllers\WorkspaceController::class)->middleware('auth');
Route::middleware(['auth','isWorkspace'])->group(function () {
    Route::get('/homes/dashboard', function () {
        return view('homes.dashboard');
    });
    Route::get('/homes/dashboard_board', function () {
        return view('homes.dashboard_board');
    });
    Route::get('/home', function () {
        return view('homes.home');
    })->name('homes.home');


    Route::get('/user/{id}', [UserController::class, 'edit'])->name('user');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('users.update');





    Route::prefix('b')
        ->as('b.')
        ->group(function () {

            Route::get('/', function () {
                return view('boards.index');
            })->name('index');

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


});


Auth::routes();
