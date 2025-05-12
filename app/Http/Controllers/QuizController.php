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
class QuizController extends Controller{
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'school') {
            $childUserIds = User::where('role', 'teacher')
            ->where('school_id', $user->id)
            ->pluck('id')
            ->push($user->id);
            $quizzes = Content::whereIn('user_id', $childUserIds)
            ->where('type', 'quiz')
            ->get(['id', 'topic', 'grade_level', 'num_questions', 'question_type', 'tags', 'data', 'created_at']);
    
            return view('school.teachers.quiz.index', compact('quizzes'));
        } else {
            $quizzes = Content::where('user_id', auth()->id())
            ->where('type', 'quiz')
            ->get(['id', 'topic', 'grade_level', 'num_questions', 'question_type', 'tags', 'data', 'created_at']);
    
                return view('teacher.quiz.index', compact('quizzes'));
        }
    }
    public function create()
    { 
        $user = auth()->user();
        if ($user->role === 'school') {
    
            return view('school.teachers.quiz.quiz-creator');
        } else {
        
            return view('teacher.quiz.quiz-creator');
        }
      
    }
   
}