<?php

namespace App\Http\Middleware;

use App\Models\StudentLessonRecitation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsStudentHaveRecitation
{

    public function handle(Request $request, Closure $next): Response
    {
        if (StudentLessonRecitation::IsStudentHaveRecitation($request->surah_id, $request->student_id, $request->lesson_id))
            return $next($request);
        else {
            if ($request->ajax()) {
                return  response()->json(["error" => 1, "message" => "غير مسموح له بالدخول للدرس"], 403);
            }
            return redirect()->back();
        }
    }
}
