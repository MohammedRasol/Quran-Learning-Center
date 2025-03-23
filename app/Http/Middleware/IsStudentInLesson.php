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

        $student = Lesson::where("user_id", Auth::user()->id)
            ->where("id", $request->lesson_id)
            ->with(['classrooms.students']) // Eager load the relationship
            ->firstOrFail() // Get the lesson model instance
            ->classrooms
            ->pluck('students')
            ->flatten()
            ->firstWhere('id', $request->student_id);

        if ($student != null)
            return $next($request);
        else {
            return redirect()->back();
        }
    }
}
