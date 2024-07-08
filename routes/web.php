<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\userDataController;

Route::get('/', function () {
    return view('welcome');
});





// Authentication routes
Auth::routes(['verify' => true]);

// Home route with email verification middleware
Route::middleware(['auth', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home', [TaskController::class, 'store'])->name('task.store')->middleware('auth');
Route::post('tasks/{task}/mark-done', [TaskController::class, 'updateStatus']);
Route::post('tasks/{task}/mark-pending', [TaskController::class, 'updateStatus']);
Route::post('/tasks/{id}/update', [TaskController::class, 'updateStatus'])->name('task.updateStatus')->middleware('auth');
Route::delete('/delete-task/{id}', [TaskController::class, 'deleteTask'])->name('delete.task');
;


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.index');
    Route::get('/user-data',[userDataController::class, 'getAlluser'])->name('admin.userdata');
    Route::delete('/user/{id}', [userDataController::class, 'deleteUser'])->name('user.delete');
    Route::get('/tasks', [userDataController::class, 'allTask'])->name('admin.task');
});