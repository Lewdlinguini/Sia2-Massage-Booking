<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $oneWeekAgo = Carbon::now()->subWeek();

        $activeUsers = User::where('last_login_at', '>=', $oneWeekAgo)->count();
        $inactiveUsers = User::where(function ($query) use ($oneWeekAgo) {
            $query->whereNull('last_login_at')
                  ->orWhere('last_login_at', '<', $oneWeekAgo);
        })->count();

        return view('admin.dashboard', compact('activeUsers', 'inactiveUsers'));
    }
}
