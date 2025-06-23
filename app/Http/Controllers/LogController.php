<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function log()
    {
        $logs = Activity::all();
        return response()->json($logs);
    }
}
