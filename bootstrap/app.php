<?php

use App\Http\Middleware\IsLessonRunning;
use App\Http\Middleware\IsStudentHaveRecitation;
use App\Http\Middleware\IsStudentInLesson;
use App\Http\Middleware\IsSurahInStudentRecitations;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "IsLessonRunning" => IsLessonRunning::class,
            "IsStudentInLesson" => IsStudentInLesson::class,
            "IsSurahInStudentRecitations" => IsSurahInStudentRecitations::class,
            "IsStudentHaveRecitation" => IsStudentHaveRecitation::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
