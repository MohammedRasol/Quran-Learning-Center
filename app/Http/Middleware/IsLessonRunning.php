<?php

namespace App\Http\Middleware;

use App\Models\Lesson;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsLessonRunning
{
    public function handle(Request $request, Closure $next): Response
    {
        $lesson = Lesson::where("user_id", Auth::user()->id)->where("id", $request->id)->where("finished_at", "=", null)->first();
        if ($lesson != null)
            return $next($request);
        else {
            return redirect("/lesson");
        }
    }
}
