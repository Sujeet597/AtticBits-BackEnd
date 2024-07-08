<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
     public function index()
    {
        // Ensure the user is an admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $activityLogs = Activity::with('causer')->latest()->paginate(10);

        return view('admin.index', compact('activityLogs'));
    }
}