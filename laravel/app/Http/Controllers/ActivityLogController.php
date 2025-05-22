<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Example data (replace this with real log data later)
        $logs = [
            ['time' => now()->subMinutes(10)->toDateTimeString(), 'activity' => 'Logged in'],
            ['time' => now()->subMinutes(5)->toDateTimeString(), 'activity' => 'Visited dashboard'],
        ];

        return view('activity-log', compact('logs'));
    }
}