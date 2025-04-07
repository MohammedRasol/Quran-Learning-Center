<?php

namespace App\Http\Middleware;

use App\Models\StudentLessonRecitation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class doesStudentHaveNoRecitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!StudentLessonRecitation::doesStudentHaveNoRecitation($request->student_id, $request->lesson_id))
            return $next($request);
        else {
            if ($request->ajax()) {
                return  response()->json(["error" => 1, "message" => "الطالب لديه تسميع لايمكن تسجيله غياب"], 403);
            }
            return redirect()->back();
        }
    }
}
