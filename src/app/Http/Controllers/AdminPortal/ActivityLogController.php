<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
        }

        $logs = $query->latest()->paginate(25);

        return view('admin_portal.activity_log', compact('logs'));
    }
}
