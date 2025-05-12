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
use App\Models\Package;
use Illuminate\Support\Facades\Hash;

class SubscriptionController extends Controller{
 



    public function index()
    {
        $packages = Package::where('is_active', true)
        ->orderBy('price', 'asc')
        ->get();

        return view('school.subscription', compact('packages'));
    }
        



}