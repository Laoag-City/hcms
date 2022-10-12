<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log as ActivityLog;

class LogController extends Controller
{
    public function __invoke(Request $request)
    {
        $logs = ActivityLog::latest()->paginate(150);

        return view('logs', [
            'title' => 'Activity Logs',
            'logs' => $logs
        ]);
    }
}
