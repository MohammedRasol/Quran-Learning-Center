<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ShaikhController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin');
})->middleware("auth")->name("dashboard");

Route::resource("shaikh", ShaikhController::class)->middleware("auth");
Route::resource("student", StudentController::class)->middleware("auth");
Route::resource("group", GroupController::class)->middleware("auth");

Route::prefix('class-room')->middleware("auth")->group(function () {
    Route::get('/list', [ClassroomController::class, 'tableShow']);
    Route::resource('/', ClassroomController::class); // Note the '/' instead of 'shaikhs'
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// require __DIR__ . '/auth.php';
