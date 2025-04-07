<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentAbsent;
use App\Models\StudentLessonRecitation;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 2)
            $lessons = Lesson::whereHas("classrooms")->where("user_id", Auth::user()->id)->orderBy('started_at', 'desc')->cursorPaginate(15);
        else
            $lessons = Lesson::with("classrooms")->orderBy('started_at', 'desc')->cursorPaginate(15);
        return view("lessonView.tableShow", compact("lessons"));
    }
    public function create()
    {
        if (Auth::user()->role == 2)
            $shaikhs = [Auth::user()];
        else
            $shaikhs = User::where("role", 2)->get();

        $classrooms = Classroom::where("graduated", 0)->where("user_id", Auth::user()->id)->get();
        $groups = Group::where("graduated", 0)->where("user_id", Auth::user()->id)->get();
        return view("lessonView.addLesson", compact("shaikhs", "classrooms", "groups"));
    }

    public function store(Request $req)
    {
        $lesson = new Lesson();
        $lesson->topic = $req->topic;
        $lesson->user_id = $req->user_id;
        $lesson->started_at = $req->started_at;
        $lesson->finished_at = $req->finished_at;
        $lesson->save();
        $classroomIds = Classroom::whereIn('id', $req->class_room)->pluck('id')->toArray();
        $lesson->classrooms()->sync($classroomIds);

        return redirect("lesson/$lesson->id")->with('lesson');
    }

    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        if (Auth::user()->role == 2)
            $shaikhs = [Auth::user()];
        else
            $shaikhs = User::where("role", 2)->get();

        $classrooms = Classroom::where("graduated", 0)->where("user_id", Auth::user()->id)->get();
        $groups = Group::where("graduated", 0)->where("user_id", Auth::user()->id)->get();
        $lessonClassrooms = $lesson->classrooms->pluck('id')->toArray();
        return view("lessonView.showLesson", compact("shaikhs", "classrooms", "groups", "lesson", "lessonClassrooms"));
    }
    function openClassRoomLesson($lesson_id)
    {
        $lesson = Lesson::with(['classrooms.group.classroom', 'classrooms.students.recitations' => function ($query) use ($lesson_id) {
            $query->where('lesson_id', $lesson_id);
        }])->whereHas('classrooms')->findOrFail($lesson_id);

        $students = $lesson->classrooms->pluck('students')->flatten()->unique('id')->sortBy('name');;
        foreach ($students as $key => &$student) {
            $student->summary = $this->showStudentRecitationSummary($student, $lesson_id);
        }

        $isRunning = $lesson->finished_at == null ? true : false;
        $absences = $lesson->studentAbsent->pluck('student_id')->all();
        return view("lessonView.lessonData", compact("lesson", "students", "isRunning", "absences"));
    }
    function lessonStudentData($lesson_id, $student_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $student = Student::with("recitations.lesson")->where("id", $student_id)->first();
        $surahs = Surah::get();
        $studentRecitationSummary = $this->showStudentRecitationSummary($student, $lesson_id);
        return view("lessonView.lessonStudentData", compact("lesson", "surahs", "student", "studentRecitationSummary"));
    }

    function lessonStudentActivities($lesson_id, $student_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $student = Student::with("recitations.lesson")->where("id", $student_id)->first();
        $surahs = Surah::get();
        $recitations = $student->recitations->sortBy('from_verse')->groupBy('surah_id');
        $studentRecitationSummary = $this->showStudentRecitationSummary($student, $lesson_id);
        return view("lessonView.lessonStudentActivities", compact("lesson", "surahs", "student", "studentRecitationSummary", "recitations"));
    }

    function getLessonSurahInfo($surah_id, $lesson_id, $student_id)
    {
        $data = [
            'recitations' => StudentLessonRecitation::with(["student", "surah", "lesson"])
                ->where("surah_id", $surah_id)
                ->where("student_id", $student_id)
                ->where("lesson_id", $lesson_id)
                ->orderBy("from_verse")
                ->get(),
            'student' => Student::findOrFail($student_id), // Throws 404 if not found
            'surah' => Surah::findOrFail($surah_id),
            'lesson' => Lesson::findOrFail($lesson_id),
        ];
        return response()->json(["data" => $data, "status" => 200], 200);
    }


    public function showStudentRecitationSummary($student, $lesson_id, $surah_id = null)
    {
        // Start with the recitations collection
        $recitations = $student->recitations;

        // Apply lesson_id filter if provided
        if ($lesson_id !== null) {
            $recitations = $recitations->where("lesson_id", $lesson_id);
        }

        // Apply surah_id filter if provided
        if ($surah_id !== null) {
            $recitations = $recitations->where("surah_id", $surah_id);
        }

        // Calculate summation of verses per surah
        return $recitations->groupBy("surah")
            ->map(function ($recitationsPerSurah) {
                $totalVerses = $recitationsPerSurah->sum(function ($recitation) {
                    return $recitation->to_verse - $recitation->from_verse + 1; // Total verses recited
                });
                $averageRate = $recitationsPerSurah->avg('rate');

                return [
                    'surah' => $recitationsPerSurah->first()->surah,
                    'rate' => $averageRate > 0 ? round($averageRate) : 0,
                    'total_verses_recited' => $totalVerses,
                    'id' => $recitationsPerSurah->first()->id,
                    "percentage" => round($totalVerses / $recitationsPerSurah->first()->surah->total_verses * 100, 2),
                    "total_verses_in_surah" => $recitationsPerSurah->first()->surah->total_verses
                ];
            })->values();
    }
    function deletRecitation($lesson_id, $student_id, $surah_id)
    {
        $recitations = StudentLessonRecitation::where("lesson_id", $lesson_id)->where("surah_id", $surah_id)->where("student_id", $student_id)->delete();
        return $recitations;
    }
    function deletRecitationById($lesson_id, $student_id, $surah_id, $recitation_id)
    {
        $recitation = StudentLessonRecitation::where("id", $recitation_id)->where("lesson_id", $lesson_id)->where("surah_id", $surah_id)->where("student_id", $student_id)->first();

        $recitation->delete();
        $student = Student::find($student_id);

        return response()->json(["data" => $this->showStudentRecitationSummary($student, $lesson_id, $surah_id), "status" => 200], 200);
    }
    function closeLesson($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);
        $lesson->finished_at = date("Y-m-d H:i:s");
        $lesson->save();
        return response()->json(["data" => $lesson->finished_at, "status" => 200], 200);
    }
    function addDeleteStudentAbsent($lesson_id, $student_id, $absence_date, $reason = "")
    {
        try {
            if (!StudentAbsent::getStudentAbsent($lesson_id, $student_id)) {
                StudentAbsent::addStudentAbsent($lesson_id, $student_id, $absence_date, $reason);
                return response()->json(["data" => "تم تسجيل الغياب", "status" => 200], 200);
            } else {
                StudentAbsent::removeStudentAbsent($lesson_id, $student_id);
                return response()->json(["data" => "تم حذف الغياب", "status" => 202], 202);
            }
        } catch (Exception $th) {
            return response()->json(["data" => "مسجل غياب بالفعل", "status" => 400], 400);
        }
    }
    function lessonStatistics($lesson_id)
    {
        $lessonData = Lesson::with(["studentAbsent", "recitations", "classRooms" => function ($query) {
            $query->withCount('students');
        }])->where("id", $lesson_id)->first();
        $lessonData->totalStudents = $lessonData->classRooms->sum('students_count');
        return view("lessonView.lessonStatistics", compact("lessonData"));
    }
}
