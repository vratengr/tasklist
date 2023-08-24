<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

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
Route::put('tasks/sort', [TaskController::class, 'sort'])->name('tasks.sort');
Route::resource('tasks', TaskController::class)->only(['store', 'update', 'destroy']);
Route::resource('projects', ProjectController::class)->only(['store', 'show', 'destroy']);