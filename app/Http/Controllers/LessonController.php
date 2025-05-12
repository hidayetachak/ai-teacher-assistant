<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonPlanRequest;
use App\Http\Requests\QuizRequest;
use App\Models\Content;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class LessonController extends Controller{
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'school') {
        $childUserIds = User::where('role', 'teacher')
        ->where('school_id', $user->id)
        ->pluck('id')
        ->push($user->id);
        $lessons = Content::whereIn('user_id', $childUserIds)
            ->where('type', 'lesson_plan')
            ->get(['id', 'topic', 'grade_level', 'duration', 'tags', 'data', 'created_at']);

        return view('school.teachers.lesson.index', compact('lessons'));
    } else {
        $lessons = Content::where('user_id', $user->id)
            ->where('type', 'lesson_plan')
            ->get(['id', 'topic', 'grade_level', 'duration', 'tags', 'data', 'created_at']);

        return view('teacher.lesson.index', compact('lessons'));
    }
}

    public function create()
    { 
        $user = auth()->user();
        if ($user->role === 'school') {
    
            return view('school.teachers.lesson.lesson-plan');
        } else {
        
            return view('teacher.lesson.lesson-plan');
        }
      
    }
}