<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\ClientRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $client = auth()->user()->client;

        if (!$client) {
            abort(403, 'Your account is not associated with a client profile. Please contact Sigmatic Soft support.');
        }

        $clientId = $client->id;

        // Projects
        $projects = Project::where('client_id', $clientId)->get();
        $projectIds = $projects->pluck('id')->toArray();
        
        $activeProjectsCount = $projects->whereIn('status', ['active', 'planning', 'on_hold'])->count();

        // Requests
        $openRequestsCount = ClientRequest::where('client_id', $clientId)
            ->whereIn('status', ['submitted', 'under_review', 'accepted'])
            ->count();

        // Tasks (client_visible = true)
        $tasksQuery = Task::whereIn('project_id', $projectIds)->where('client_visible', true);
        
        $tasksInProgressCount = (clone $tasksQuery)->where('status', 'in_progress')->count();
        $completedTasksCount = (clone $tasksQuery)->where('status', 'completed')->count();

        // Recent activity relevant to client's projects
        $recentActivity = ActivityLog::where(function ($q) use ($projectIds, $clientId) {
            $q->where(function ($sq) use ($projectIds) {
                $sq->where('loggable_type', Task::class)
                   ->whereIn('loggable_id', function ($tQuery) use ($projectIds) {
                       $tQuery->select('id')->from('tasks')->whereIn('project_id', $projectIds);
                   });
            })->orWhere(function ($sq) use ($projectIds) {
                $sq->where('loggable_type', Project::class)
                   ->whereIn('loggable_id', $projectIds);
            })->orWhere(function ($sq) use ($clientId) {
                $sq->where('loggable_type', ClientRequest::class)
                   ->whereIn('loggable_id', function ($rQuery) use ($clientId) {
                       $rQuery->select('id')->from('client_requests')->where('client_id', $clientId);
                   });
            });
        })
        ->with('user')
        ->latest()
        ->take(10)
        ->get();

        return view('client_portal.dashboard', compact(
            'client',
            'projects',
            'activeProjectsCount',
            'openRequestsCount',
            'tasksInProgressCount',
            'completedTasksCount',
            'recentActivity'
        ));
    }
}
