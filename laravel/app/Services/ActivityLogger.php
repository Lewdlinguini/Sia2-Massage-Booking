<?php
namespace App\Services;

class ActivityLogger
{
    public static function log($userId, $message)
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;

        // Logs path for this specific user
        $logPath = storage_path("logs/activity_user_{$userId}.log");

        if (!file_exists(dirname($logPath))) {
            mkdir(dirname($logPath), 0755, true);
        }

        file_put_contents($logPath, $logMessage, FILE_APPEND);
    }
}
