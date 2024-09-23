<?php

use App\Http\Controllers\Api\GanttController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/boards/{boardId}/tasks', [GanttController::class, 'data']);
Route::resource('task', TaskController::class);
Route::resource('link', LinkController::class);


