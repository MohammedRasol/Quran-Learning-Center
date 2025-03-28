<?php

namespace App\Http\Middleware;

use App\Models\Lesson;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsStudentInLesson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Lesson::IsStudentInLesson($request))
            return $next($request);
        else {
            if ($request->ajax()) {
                return  response()->json(["error" => 1, "message" => "غير مسموح له بالدخول للدرس"], 403);
            }
            return redirect("lesson")->with(["errors" => ["غير مسموح له بالدخول للدرس"]]);
        }
    }
}
