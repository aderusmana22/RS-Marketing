<?php

namespace App\Http\Controllers;

use App\Models\Idea\standardData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
