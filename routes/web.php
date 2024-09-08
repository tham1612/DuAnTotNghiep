<?php

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
    return view('index');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/dashboard_detail', function () {
    return view('dashboard_detail');
});
Route::get('/home', function () {
    return view('home');
});

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
