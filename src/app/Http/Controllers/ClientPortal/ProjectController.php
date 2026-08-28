<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $client = auth()->user()->client;

        if (!$client) {
            abort(403, 'Unauthorized.');
        }

        $projects = Project::where('client_id', $client->id)->latest()->get();

        return view('client_portal.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['client', 'tasks' => function ($q) {
            $q->where('client_visible', true)->orderBy('sort_order');
        }, 'tasks.assignee']);

        return view('client_portal.projects.show', compact('project'));
    }
}
