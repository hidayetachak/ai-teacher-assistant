<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Models\Content;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class ResourceController extends Controller{
    public function index()
{
    $user = auth()->user();

    if ($user->role === 'school') {
        $childUserIds = User::where('role', 'teacher')
        ->where('school_id', $user->id)
        ->pluck('id')
        ->push($user->id);
        $resource = Content::whereIn('user_id', $childUserIds)
            ->where('type', 'resource')
            ->get(['id', 'topic',  'data', 'created_at']);

        return view('school.teachers.resource.index', compact('resource'));
    } else {
        $resource = Content::where('user_id', $user->id)
            ->where('type', 'resource')
            ->get(['id', 'topic', 'data', 'created_at']);

        return view('teacher.resource.index', compact('resource'));
    }
}

    public function create()
    { 
        $user = auth()->user();
        if ($user->role === 'school') {
    
            return view('school.teachers.resource.resource');
        } else {
        
            return view('teacher.resource.resource');
        }
      
    }
}