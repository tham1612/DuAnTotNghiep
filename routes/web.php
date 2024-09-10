<?php

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

// Định nghĩa các route
Route::get('/', function () {
    return view('welcome');
});
Route::get('/homes/dashboard_show', function () {
    return view('homes.dashboard_show');
});

Route::get('/homes/dashboard_home', function () {
    return view('homes.dashboard_home');
});
Route::get('/homes/dashboard_board', function () {
    return view('homes.dashboard_board');
});

Auth::routes();

// Định nghĩa route cho home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Các route khác
Route::get('tables', function () {
    return view('tables.index');
});

Route::get('ganttChart', function () {
    return view('ganttChart.index');
});
Route::get('boards', function () {
    return view('boards.index');
});

Route::get('lists', function () {
    return view('lists.index');
});