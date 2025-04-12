<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ShaikhController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SurahController;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin');
})->middleware("auth")->name("dashboard");

Route::resource("shaikh", ShaikhController::class)->middleware("auth");

Route::prefix('lesson/')->middleware("auth")->group(function () {
    Route::get('show/{lesson_id}', [LessonController::class, 'openClassRoomLesson'])->name("openClassRoomLesson");
    Route::get('{lesson_id}/statistics', [LessonController::class, 'lessonStatistics'])->name("lessonStatistics");
    Route::get('{lesson_id}/student/{student_id}', [LessonController::class, 'lessonStudentData'])->name("lessonStudentData")->middleware(["IsStudentInLesson","IsLessonRunning"]);
    Route::get('{lesson_id}/student/{student_id}/activities', [LessonController::class, 'lessonStudentActivities'])->name("lessonStudentActivities")->middleware("IsStudentInLesson");
    
    // Route::get('{lesson_id}/student/{student_id}/surah/{surah_id}/edit', [LessonController::class, 'editLessonStudentData'])->name("editLessonStudentData")->middleware(["IsStudentInLesson", "IsSurahInStudentRecitations"]);
    Route::resource("", LessonController::class)->parameters(['' => 'id'])->names('lesson');
});

Route::prefix('student/')->middleware("auth")->group(function () {
    Route::get('list', [StudentController::class, 'tableShow'])->name("student.list");
    Route::get('{student}/archives', [StudentController::class, 'archives'])->name("student.archives");
    Route::get('{student}/archives/add', [StudentController::class, 'addArchives'])->name("student.addArchives");
    Route::resource("", StudentController::class)->parameters(['' => 'id'])->names('student');
});

Route::prefix('group/')->middleware("auth")->group(function () {
    Route::get('list', [GroupController::class, 'tableShow'])->name("group.list");
});
Route::resource("/group", GroupController::class)->names('group');

Route::prefix('class-room')->middleware('auth')->group(function () {
    Route::get('/list', [ClassroomController::class, 'tableShow'])->name("class-room.list");
    Route::resource('', ClassroomController::class)->parameters(['' => 'id'])->names('classroom');
});


Route::prefix('ajax/')->middleware('auth')->group(function () {
    Route::get('getSurahinfo/{surah_id}/{lesson_id}/{student_id}', [SurahController::class, "getSurahinfo"])->middleware("IsStudentInLesson");
    Route::get('getLessonSurahInfo/{surah_id}/{lesson_id}/{student_id}', [LessonController::class, "getLessonSurahInfo"])->middleware("IsStudentInLesson");
    Route::post('saveRecitations/{surah_id}/{lesson_id}/{student_id}', [SurahController::class, "saveRecitations"])->middleware(["IsStudentInLesson","IsLessonRunning"]);
    Route::delete('deletRecitation/{lesson_id}/{student_id}/{surah_id}', [LessonController::class, "deletRecitation"])->middleware(["IsSurahInStudentRecitations"]);
    Route::delete('deletRecitationById/{lesson_id}/{student_id}/{surah_id}/{recitation_id}', [LessonController::class, "deletRecitationById"])->middleware(["IsSurahInStudentRecitations"]);
    Route::put('closeLesson/{lesson_id}', [LessonController::class, "closeLesson"])->middleware(["IsShaikhInLesson"]);
    Route::post('addStudentAbsent/{lesson_id}/{student_id}', [LessonController::class, "addDeleteStudentAbsent"])->middleware(["IsShaikhInLesson","IsLessonRunning","doesStudentHaveNoRecitation"]);
    Route::get('getLessonRecitationsNotes/{lesson_id}/{student_id}', [LessonController::class, 'getLessonRecitationsNotes'])->name("getLessonRecitationsNotes")->middleware("IsStudentInLesson");
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/test', function () {
//     return Lesson::isStudentAbsent(2,2) ==null;
    
//     $student = Student::find(2);
//     $student->studentAbsent()->create(['lesson_id' => 2, "absence_date" => date("Y-m-d"), "reason" => "asdasd"]);
//     $student->save();
//     return true;
// });
