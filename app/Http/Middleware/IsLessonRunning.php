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
        if (Lesson::IsLessonNotFinishedYet($request->lesson_id))
            return $next($request);
        else {
            if ($request->ajax()) {
                return  response()->json(["error" => 1, "message" => "غير مسموح له بالدخول للدرس"], 403);
            }
            return redirect("lesson")->with(["errors" => ["غير مسموح له بالدخول للدرس"]]);
        }
        return $next($request);
    }
}
