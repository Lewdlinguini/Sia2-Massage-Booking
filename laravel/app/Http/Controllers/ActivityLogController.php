<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ActivityLogController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $logFile = storage_path("logs/activity_user_{$userId}.log");
        $logs = [];

        if (File::exists($logFile)) {
            $lines = File::lines($logFile)->toArray();

            foreach ($lines as $line) {
                if (preg_match('/\[(.*?)\] (.*)/', $line, $matches)) {
                    $logs[] = [
                        'time' => $matches[1],
                        'activity' => $matches[2],
                    ];
                }
            }
        }

        return view('activity-log', compact('logs'));
    }
}
