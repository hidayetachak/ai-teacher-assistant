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

class DashboardController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = auth()->user();
        
        $resourceCount = Usage::where('user_id', $user->id)
        ->where('type', 'resource')
        ->count();
        // Count lessons created by the user
        $lessonsCount = Usage::where('user_id', $user->id)
            ->where('type', 'lesson_plan')
            ->count();
            
        // Count quizzes created by the user
        $quizzesCount = Usage::where('user_id', $user->id)
            ->where('type', 'quiz')
            ->count();
            
        // Count assignments created by the user (assuming 'assignment' type exists)
        $assignmentCount = Usage::where('user_id', $user->id)
            ->where('type', 'assignment')
            ->count();
            
        // Calculate weekly percentage changes
        $resourcePercentChange = $this->calculateWeeklyChange($user->id, 'resource');
        $lessonsPercentChange = $this->calculateWeeklyChange($user->id, 'lesson_plan');
        $quizzesPercentChange = $this->calculateWeeklyChange($user->id, 'quiz');
        $assignmentsPercentChange = $this->calculateWeeklyChange($user->id, 'assignment');
        
        // Get user subscription status
        $subscriptionStatus = $user->subscription_status ?? 'Free';
        
        // Get monthly content creation data for chart
        $monthlyData = $this->getMonthlyContentData($user->id);
        
        // Get content distribution data
        $contentDistribution = $this->getContentDistribution($user->id);
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($user->id, 5);
        
        return view('teacher.dashboard', compact(
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
    
    /**
     * Calculate weekly percentage change for content type
     */
    private function calculateWeeklyChange($userId, $contentType)
    {
        $now = Carbon::now();
        $lastWeekStart = Carbon::now()->subWeeks(1)->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeeks(1)->endOfWeek();
        $thisWeekStart = Carbon::now()->startOfWeek();
        
        // Count content created this week
        $thisWeekCount = Usage::where('user_id', $userId)
            ->where('type', $contentType)
            ->whereBetween('created_at', [$thisWeekStart, $now])
            ->count();
            
        // Count content created last week
        $lastWeekCount = Usage::where('user_id', $userId)
            ->where('type', $contentType)
            ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->count();
            
        // Calculate percentage change
        if ($lastWeekCount > 0) {
            $percentChange = (($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100;
            return round($percentChange);
        } elseif ($thisWeekCount > 0) {
            return 100; // If there was nothing last week but something this week, it's a 100% increase
        } else {
            return 0; // No change if both weeks have zero
        }
    }
    
    /**
     * Get monthly content data for the activity chart
     */
    private function getMonthlyContentData($userId)
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $currentYear = Carbon::now()->year;
        
        $resourceData = [];
        $assignmentData = [];
        $lessonData = [];
        $quizData = [];
        
        // For each month, get the count of lessons and quizzes
        foreach (range(0, 11) as $month) {
            $startDate = Carbon::createFromDate($currentYear, $month + 1, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($currentYear, $month + 1, 1)->endOfMonth();
            
            $resourceCount = Usage::where('user_id', $userId)
                ->where('type', 'resource')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            // Get lesson count for this month
            $lessonCount = Usage::where('user_id', $userId)
                ->where('type', 'lesson_plan')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            // Get quiz count for this month
            $quizCount = Usage::where('user_id', $userId)
                ->where('type', 'quiz')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                $assignmentCount = Usage::where('user_id', $userId)
                ->where('type', 'assignment') 
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            
            $resourceData[$month] = $resourceCount;
            $lessonData[$month] = $lessonCount;
            $quizData[$month] = $quizCount;
            $assignmentData[$month] = $assignmentCount;
        }
        
      
        
        return [
            'months' => $months,
            'resourceData' => array_values($resourceData),
            'lessonData' => array_values($lessonData),
            'quizData' => array_values($quizData),
            'assignmentData' => array_values($assignmentData),
        ];
    }
    
    /**
     * Get content distribution data for the pie chart
     */
    private function getContentDistribution($userId)
    {
        $lessonCount = Usage::where('user_id', $userId)
            ->where('type', 'lesson_plan')
            ->count();
            
        $quizCount = Usage::where('user_id', $userId)
            ->where('type', 'quiz')
            ->count();
            
        $assignmentCount = Usage::where('user_id', $userId)
            ->where('type', 'assignment')
            ->count();
            
        $resourceCount = Usage::where('user_id', $userId)
            ->where('type', 'resource')
            ->count();
            
       
        
        return [
            'lessonCount' => $lessonCount,
            'quizCount' => $quizCount,
            'assignmentCount' => $assignmentCount,
            'resourceCount' => $resourceCount
        ];
    }
    
    /**
     * Get recent activities
     */
    private function getRecentActivities($userId, $limit = 5)
    {
        // Get recent content with joined usage data
        $recentActivities = DB::table('usage')
            ->join('content', 'usage.content_id', '=', 'content.id')
            ->select(
                'content.id',
                'content.topic',
                'content.data',
                'content.type',
                'content.created_at',
            )
            ->where('usage.user_id', $userId)
            ->orderBy('content.created_at', 'desc')
            ->limit($limit)
            ->get();
            
        // Format the data for display
        $formattedActivities = [];
        
        foreach ($recentActivities as $activity) {
            $data = json_decode($activity->data, true);
            $title = $activity->topic ?? 'Untitled Content';
            
            $formattedActivities[] = [
                'id' => $activity->id,
                'title' => $title,
                'type' => ucfirst(str_replace('_', ' ', $activity->type)),
                'date' => Carbon::parse($activity->created_at)->format('M d, Y'),
             
            ];
        }
        
        
        
        return $formattedActivities;
    }
}