<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Content;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class AssignmentController extends Controller{
    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'school') {
            $childUserIds = User::where('role', 'teacher')
            ->where('school_id', $user->id)
            ->pluck('id')
            ->push($user->id);
            $assignment = Content::whereIn('user_id', $childUserIds)
            ->where('type', 'assignment')
            ->get(['id', 'topic', 'grade_level',  'num_questions', 'question_type', 'tags', 'data', 'created_at']);
    
            return view('school.teachers.assignment.index', compact('assignment'));
        } else {
            $assignment = Content::where('user_id', auth()->id())
            ->where('type', 'assignment')
            ->get(['id', 'topic', 'grade_level',  'num_questions', 'question_type', 'tags', 'data', 'created_at']);
            return view('teacher.assignment.index', compact('assignment'));
        }
    }
    public function create()
    { 
        $user = auth()->user();
        if ($user->role === 'school') {
    
            return view('school.teachers.assignment.create');
        } else {
        
            return view('teacher.assignment.create');
        }
      
    }
   
}