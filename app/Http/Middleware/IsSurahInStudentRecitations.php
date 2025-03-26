<?php

namespace App\Http\Middleware;

use App\Models\StudentLessonRecitation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSurahInStudentRecitations
{

    public function handle(Request $request, Closure $next): Response
    {
        if (StudentLessonRecitation::IsSurahInStudentRecitations($request))
            return $next($request);
        else {
            if ($request->ajax()) {
                return  response()->json(["error" => 1, "message" => "غير مسموح له بالدخول للدرس"], 403);
            }
            return redirect()->back();
        }
    }
}
