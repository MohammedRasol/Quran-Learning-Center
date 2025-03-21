<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ShaikhController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin');
})->middleware("auth")->name("dashboard");

Route::resource("shaikh", ShaikhController::class)->middleware("auth");

Route::resource("lesson", LessonController::class)->middleware("auth");

Route::prefix('student/')->middleware("auth")->group(function () {
    Route::get('/list', [StudentController::class, 'tableShow']);
    Route::resource("", StudentController::class)->parameters(['' => 'id']);
});

Route::prefix('group/')->middleware("auth")->group(function () {
    Route::get('/list', [GroupController::class, 'tableShow']);
    Route::resource("", GroupController::class)->parameters(['' => 'id']);
});

Route::prefix('class-room')->middleware('auth')->group(function () {
    Route::get('/list', [ClassroomController::class, 'tableShow']);
    Route::resource('', ClassroomController::class)->parameters(['' => 'id']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// require __DIR__ . '/auth.php';
