<?php

namespace App\Services;

use App\Models\activity_log;
use Illuminate\Support\Facades\Config;

class ActivityLogger
{
    public static function log($userId, $action, $description)
    {
        $timezone = Config::get('app.timezone'); // Get the application's timezone
        $logEntry = new activity_log([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'created_at' => now()->setTimezone($timezone),
        ]);

        $logEntry->save();

        $logMessage = "[" . now()->setTimezone($timezone)->toDateTimeString() . "] User $userId performed action '$action' - $description \n";
        file_put_contents(storage_path('logs/user_activity.log'), $logMessage, FILE_APPEND);
        
    }
}