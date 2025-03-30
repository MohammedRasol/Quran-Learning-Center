<?php

namespace App\Http\Middleware;

use App\Models\Lesson;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsShaikhInLesson
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Lesson::IsShaikhInLesson(Auth::user()->id, $request->lesson_id))
            return $next($request);
        else {
            if ($request->ajax()) {
                return  response()->json(["error" => 1, "message" => "غير مسموح له بالدخول للدرس"], 403);
            }
            return redirect("lesson")->with(["errors" => ["غير مسموح له بالدخول للدرس"]]);
        }
    }
}
