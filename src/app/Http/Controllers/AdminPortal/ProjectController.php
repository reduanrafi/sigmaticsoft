<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Client;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('client');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('project_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        $projects = $query->latest()->paginate(10);
        $clients = Client::all();

        return view('admin_portal.projects.index', compact('projects', 'clients'));
    }

    public function create()
    {
        $clients = Client::where('status', 'active')->get();
        return view('admin_portal.projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,critical',
            'start_date' => 'nullable|date',
            'expected_end_date' => 'nullable|date|after_or_equal:start_date',
            'actual_end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        // Auto-generate project code
        $lastProject = Project::withTrashed()->orderBy('id', 'desc')->first();
        $nextId = $lastProject ? $lastProject->id + 1 : 1;
        $validated['project_code'] = 'PRJ-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // Auto-generate slug
        $slug = Str::slug($validated['name']);
        $existingSlugCount = Project::where('slug', 'like', "{$slug}%")->count();
        $validated['slug'] = $existingSlugCount > 0 ? "{$slug}-" . ($existingSlugCount + 1) : $slug;

        $validated['created_by'] = auth()->id();

        $project = Project::create($validated);

        ActivityLog::log('project_created', "Admin created project: {$project->name} ({$project->project_code})", $project);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['client', 'tasks.assignee', 'requests', 'creator']);
        return view('admin_portal.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $clients = Client::where('status', 'active')->get();
        return view('admin_portal.projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,critical',
            'start_date' => 'nullable|date',
            'expected_end_date' => 'nullable|date|after_or_equal:start_date',
            'actual_end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        // Handle slug if name changed
        if ($project->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $existingSlugCount = Project::where('slug', 'like', "{$slug}%")->where('id', '!=', $project->id)->count();
            $validated['slug'] = $existingSlugCount > 0 ? "{$slug}-" . ($existingSlugCount + 1) : $slug;
        }

        $project->update($validated);

        ActivityLog::log('project_updated', "Admin updated project: {$project->name} ({$project->project_code})", $project);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        ActivityLog::log('project_deleted', "Admin deleted project: {$project->name} ({$project->project_code})", $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
