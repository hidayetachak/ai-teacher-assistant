<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Get the start and end of the current week (Monday to Sunday)
        $startOfWeek = Carbon::now()->startOfWeek()->startOfDay();
        $endOfWeek = Carbon::now()->endOfWeek()->endOfDay();

        // Total Users
        $totalUsers = User::count();

        // Active Free Trials (payment_method = 'free' and created within the week)
        $activeFreeTrials = PaymentRecord::where('payment_method', 'free')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        // Total Paid Subscriptions (payment_method = 'stripe' and created within the week)
        $totalSubscriptions = PaymentRecord::where('payment_method', 'stripe')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        // Total Revenue This Week (sum of amount for payment_method = 'stripe')
        $totalRevenue = PaymentRecord::where('payment_method', 'stripe')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        // Weekly Users Data for Chart (new users per day)
        $weeklyUsers = [];
        for ($day = 0; $day < 7; $day++) {
            $date = $startOfWeek->copy()->addDays($day);
            $count = User::whereDate('created_at', $date)->count();
            $weeklyUsers[] = $count;
        }

        // Weekly Revenue Data for Chart (revenue per day for payment_method = 'stripe')
        $weeklyRevenue = [];
        for ($day = 0; $day < 7; $day++) {
            $date = $startOfWeek->copy()->addDays($day);
            $revenue = PaymentRecord::where('payment_method', 'stripe')
                ->whereDate('created_at', $date)
                ->sum('amount');
            $weeklyRevenue[] = $revenue;
        }

        // Pass data to the view
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeFreeTrials',
            'totalSubscriptions',
            'totalRevenue',
            'weeklyUsers',
            'weeklyRevenue'
        ));
    }
}