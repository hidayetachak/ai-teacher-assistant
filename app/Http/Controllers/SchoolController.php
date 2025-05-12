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
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller{
 



    public function index()
    {
        $school = auth()->user();
    
        $teacherIds = User::where('role', 'teacher')
            ->where('school_id', $school->id)
            ->pluck('id')
            ->push($school->id);
    
        // Aggregate content counts
        $resourceCount = Usage::whereIn('user_id', $teacherIds)->where('type', 'resource')->count();
        $lessonsCount = Usage::whereIn('user_id', $teacherIds)->where('type', 'lesson_plan')->count();
        $quizzesCount = Usage::whereIn('user_id', $teacherIds)->where('type', 'quiz')->count();
        $assignmentCount = Usage::whereIn('user_id', $teacherIds)->where('type', 'assignment')->count();
    
        // Percent changes
        $resourcePercentChange = $this->calculateWeeklyChangeForGroup($teacherIds, 'resource');
        $lessonsPercentChange = $this->calculateWeeklyChangeForGroup($teacherIds, 'lesson_plan');
        $quizzesPercentChange = $this->calculateWeeklyChangeForGroup($teacherIds, 'quiz');
        $assignmentsPercentChange = $this->calculateWeeklyChangeForGroup($teacherIds, 'assignment');
    
        // Subscription status (can be extended per-school basis)
        $subscriptionStatus = $school->credits;
    
        // Charts and recent activity
        $monthlyData = $this->getMonthlyContentDataForGroup($teacherIds);
        $contentDistribution = $this->getContentDistributionForGroup($teacherIds);
        $recentActivities = $this->getRecentActivitiesForGroup($teacherIds, 5);
    
        return view('school.dashboard', compact(
            'resourceCount',
            'lessonsCount',
            'quizzesCount',
            'assignmentCount',
            'resourcePercentChange',
            'lessonsPercentChange',
            'quizzesPercentChange',
            'assignmentsPercentChange',
            'subscriptionStatus',
            'monthlyData',
            'contentDistribution',
            'recentActivities'
        ));
    }
    

        public function createTeacher()
        {
            return view('school.teachers.create');
        }

        public function storeTeacher(Request $request)
        {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'teacher',
                'school_id' => auth()->id(),
            ]);

            return redirect()->route('school.dashboard')->with('success', 'Teacher created.');
        }
        public function listTeachers()
        {
            $schoolId = auth()->id();
            $teachers = User::where('role', 'teacher')->where('school_id', $schoolId)->get();

            return view('school.teachers.index', compact('teachers'));
        }
        public function editTeacher(User $teacher)
        {
            $this->authorizeTeacher($teacher);
            return view('school.teachers.edit', compact('teacher'));
        }

        public function updateTeacher(Request $request, User $teacher)
        {
            $this->authorizeTeacher($teacher);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $teacher->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $teacher->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] ? Hash::make($data['password']) : $teacher->password,
            ]);

            return redirect()->route('school.teachers.index')->with('success', 'Teacher updated.');
        }

        public function deleteTeacher(User $teacher)
        {
            $this->authorizeTeacher($teacher);
            $teacher->delete();

            return redirect()->route('school.teachers.index')->with('success', 'Teacher deleted.');
        }

        protected function authorizeTeacher(User $teacher)
        {
            if ($teacher->school_id !== auth()->id() || $teacher->role !== 'teacher') {
                abort(403, 'Unauthorized action.');
            }
        }
        private function calculateWeeklyChangeForGroup($userIds, $contentType)
{
    $now = Carbon::now();
    $lastWeekStart = $now->copy()->subWeek()->startOfWeek();
    $lastWeekEnd = $now->copy()->subWeek()->endOfWeek();
    $thisWeekStart = $now->copy()->startOfWeek();

    $thisWeekCount = Usage::whereIn('user_id', $userIds)
        ->where('type', $contentType)
        ->whereBetween('created_at', [$thisWeekStart, $now])
        ->count();

    $lastWeekCount = Usage::whereIn('user_id', $userIds)
        ->where('type', $contentType)
        ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
        ->count();

    if ($lastWeekCount > 0) {
        return round((($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100);
    } elseif ($thisWeekCount > 0) {
        return 100;
    } else {
        return 0;
    }
}
private function getMonthlyContentDataForGroup($userIds)
{
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $currentYear = Carbon::now()->year;

    $lessonData = [];
    $quizData = [];
    $resourceData = [];
    $assignmentData = [];

    foreach (range(1, 12) as $month) {
        $start = Carbon::create($currentYear, $month, 1)->startOfMonth();
        $end = Carbon::create($currentYear, $month, 1)->endOfMonth();

        $lessonData[] = Usage::whereIn('user_id', $userIds)
            ->where('type', 'lesson_plan')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $quizData[] = Usage::whereIn('user_id', $userIds)
            ->where('type', 'quiz')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $resourceData[] = Usage::whereIn('user_id', $userIds)
            ->where('type', 'resource')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $assignmentData[] = Usage::whereIn('user_id', $userIds)
            ->where('type', 'assignment')
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }

    return [
        'months' => $months,
        'lessonData' => $lessonData,
        'quizData' => $quizData,
        'resourceData' => $resourceData,
        'assignmentData' => $assignmentData,
    ];
}

private function getContentDistributionForGroup($userIds)
{
    return [
        'lessonCount' => Usage::whereIn('user_id', $userIds)->where('type', 'lesson_plan')->count(),
        'quizCount' => Usage::whereIn('user_id', $userIds)->where('type', 'quiz')->count(),
        'assignmentCount' => Usage::whereIn('user_id', $userIds)->where('type', 'assignment')->count(),
        'notesCount' => Usage::whereIn('user_id', $userIds)->where('type', 'notes')->count(),
        'resourceCount' => Usage::whereIn('user_id', $userIds)->where('type', 'resource')->count(),
    ];
}

private function getRecentActivitiesForGroup($userIds, $limit = 5)
{
    $recentActivities = DB::table('usage')
        ->join('content', 'usage.content_id', '=', 'content.id')
        ->select('content.id', 'content.topic', 'content.data', 'content.type', 'content.created_at')
        ->whereIn('usage.user_id', $userIds)
        ->orderBy('content.created_at', 'desc')
        ->limit($limit)
        ->get();

    return $recentActivities->map(function ($activity) {
        return [
            'id' => $activity->id,
            'title' => $activity->topic ?? 'Untitled Content',
            'type' => ucfirst(str_replace('_', ' ', $activity->type)),
            'date' => Carbon::parse($activity->created_at)->format('M d, Y'),
        ];
    })->toArray();
}



}