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
Route::get('/index', function () {
    return view('index');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/dashboard_detail', function () {
    return view('dashboard_detail');
});
Route::get('/home2', function () {
    return view('home2');
});


// Định nghĩa route cho home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Các route khác
Route::get('tables', function () {
    return view('tables.index');
});
Route::get('catalog', function () {
    return view('catalog.index');
});
Route::get('ganttChart', function () {
    return view('ganttChart.index');
});
Route::get('boards', function () {
    return view('boards.index');
});

// Đăng ký các route cho authentication
// Auth::routes();