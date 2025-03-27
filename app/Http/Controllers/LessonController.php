<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\StudentLessonRecitation;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
    function openClassRoomLesson($id)
    {
        $lesson = Lesson::with(['classrooms.group.classroom', 'classrooms.students'])
            ->whereHas('classrooms')
            ->findOrFail($id);

        // Collect all classrooms
        $classrooms = $lesson->classrooms->flatMap(function ($classroom) {
            return $classroom->group
                ? $classroom->group->classroom
                : [$classroom];
        })->all();

        // Collect all students
        $students = collect($classrooms)
            ->pluck('students')
            ->filter()
            ->flatten()
            ->all();

        return view("lessonView.lessonData", compact("lesson", "classrooms", "students"));
    }
    function lessonStudentData($lesson_id, $student_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $student = Student::with("recitations.lesson")->where("id", $student_id)->first();
        $surahs = Surah::get();
        $studentRecitationSummary = $this->showStudentRecitationSummary($student_id, $lesson_id);
        return view("lessonView.lessonStudentData", compact("lesson", "surahs", "student", "studentRecitationSummary"));
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
    // function editLessonStudentData($lesson_id, $student_id, $surah_id)
    // {
    //     $recitations = StudentLessonRecitation::where("lesson_id", $lesson_id)->where("student_id", $student_id)->where("surah_id", $surah_id)->orderBy("from_verse")->get();
    //     $lesson=$recitations->first()->lesson;
    //     $student=$recitations->first()->student;
    //     $surah=$recitations->first()->surah;
    //     $surahs = Surah::get();
    //     return view("lessonView.lessonStudentRecitationData", compact("lesson", "surah", "student", "recitations","surahs"));
    // }
    public function showStudentRecitationSummary($student_id, $lesson_id)
    {
        // Fetch student with recitations filtered by lesson_id
        $student = Student::with(["recitations" => function ($query) use ($lesson_id) {
            $query->where("lesson_id", $lesson_id);
        }])->where("id", $student_id)->firstOrFail();

        // Calculate summation of verses per surah
        return $student->recitations
            ->groupBy("surah")
            ->map(function ($recitationsPerSurah) {
                $totalVerses = $recitationsPerSurah->sum(function ($recitation) {
                    return $recitation->to_verse - $recitation->from_verse + 1; // Total verses recited
                });
                $averageRate = $recitationsPerSurah->avg('rate');

                // Get the total verses in the surah (assuming surah relationship exists)
                $surahTotalVerses = $recitationsPerSurah->first()->surah->total_verses;

                // Calculate rate percentage based on total verses recited vs surah total
                $ratePercentage = $surahTotalVerses > 0
                    ? round(($totalVerses / $surahTotalVerses) * $averageRate * 20, 2) // Assuming rate is 0-5 scale
                    : 0;
                return [
                    'surah' => $recitationsPerSurah->first()->surah,
                    'rate' => $ratePercentage > 0 ? round($ratePercentage / 20) : 0,
                    'total_verses_recited' => $totalVerses,
                    'id' => $recitationsPerSurah->first()->id,
                ];
            })->values();
    }
    function deletRecitation(
        $lesson_id,
        $student_id,
        $surah_id
    ) {

        $recitations = StudentLessonRecitation::where("lesson_id", $lesson_id)->where("surah_id", $surah_id)->where("student_id", $student_id)->delete();
        return $recitations;
    }
}
