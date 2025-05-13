<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $role Role to verify (comma separated for multiple roles)
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        Log::info('VerifyRole Middleware: Attempting role check');
        
        if (!Auth::check()) {
            Log::info('VerifyRole Middleware: User not authenticated');
            return redirect()->route('login');
        }
        
        Log::info('VerifyRole Middleware: User authenticated, role: ' . Auth::user()->role);
        
        // If no role is required, just check if user is authenticated
        if (is_null($role)) {
            return $next($request);
        }
        
        // Handle multiple roles (comma separated)
        $roles = explode(',', $role);
        
        if (in_array(Auth::user()->role, $roles)) {
            Log::info('VerifyRole Middleware: Access granted for role: ' . Auth::user()->role);
            return $next($request);
        }
        
        Log::info('VerifyRole Middleware: Access denied for role: ' . Auth::user()->role . ', Required: ' . $role);
        
        // Redirect to appropriate dashboard based on user's role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }if (Auth::user()->role === 'teacher') {
            return redirect()->route('dashboard.teacher');
        }
        if (Auth::user()->role === 'school') {
            return redirect()->route('school.dashboard');
        }
        
        // Default fallback
        return abort(403, 'This action is unauthorized.');
    }
}