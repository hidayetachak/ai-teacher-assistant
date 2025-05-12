<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        $usageStats = Usage::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get();

        return view('admin.dashboard', compact('users', 'usageStats'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User role updated.');
    }
}