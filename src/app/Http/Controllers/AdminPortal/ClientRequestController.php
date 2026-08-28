<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Notifications\PortalNotification;
use Illuminate\Http\Request;

class ClientRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ClientRequest::with(['client', 'project', 'convertedTask']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $requests = $query->latest()->paginate(15);
        $clients = Client::all();

        return view('admin_portal.requests.index', compact('requests', 'clients'));
    }

    public function show(ClientRequest $clientRequest)
    {
        $clientRequest->load(['client', 'project', 'convertedTask', 'attachments.uploader']);
        $request = $clientRequest;
        return view('admin_portal.requests.show', compact('request'));
    }

    public function updateStatus(Request $request, ClientRequest $clientRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:submitted,under_review,accepted,rejected,closed',
        ]);

        $oldStatus = $clientRequest->status;
        $clientRequest->update($validated);

        ActivityLog::log('request_status_changed', "Admin changed status of Request #{$clientRequest->id} from {$oldStatus} to {$clientRequest->status}", $clientRequest);

        // Notify client users
        $clientUsers = $clientRequest->client->users;
        foreach ($clientUsers as $cUser) {
            $cUser->notify(new PortalNotification(
                'Request Status Updated',
                "Your request \"{$clientRequest->title}\" status updated to: " . ucfirst(str_replace('_', ' ', $clientRequest->status)),
                route('client.requests.show', $clientRequest->id),
                'request_status_changed'
            ));
        }

        return redirect()->route('requests.show', $clientRequest->id)->with('success', 'Request status updated successfully.');
    }

    public function convertToTask(Request $request, ClientRequest $clientRequest)
    {
        if ($clientRequest->converted_task_id) {
            return back()->with('error', 'This request has already been converted to a task.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:bug,feature,improvement,maintenance,support,other',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:backlog,accepted,in_progress',
        ]);

        // Auto-generate task code
        $lastTask = Task::withTrashed()->orderBy('id', 'desc')->first();
        $nextId = $lastTask ? $lastTask->id + 1 : 1;
        $taskCode = 'TSK-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        // Create Task
        $task = Task::create([
            'project_id' => $clientRequest->project_id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? $clientRequest->description,
            'task_code' => $taskCode,
            'type' => $validated['type'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'created_by' => auth()->id(),
            'client_visible' => true, // default converted tasks to visible
        ]);

        // Update Request
        $clientRequest->update([
            'status' => 'converted',
            'converted_task_id' => $task->id,
        ]);

        ActivityLog::log('request_converted', "Admin converted Request #{$clientRequest->id} to Task #{$task->task_code}", $clientRequest);

        // Copy attachments from request to task
        foreach ($clientRequest->attachments as $attachment) {
            $attachment->replicate()->fill([
                'attachable_id' => $task->id,
                'attachable_type' => Task::class,
            ])->save();
        }

        // Notify client
        $clientUsers = $clientRequest->client->users;
        foreach ($clientUsers as $cUser) {
            $cUser->notify(new PortalNotification(
                'Request Converted to Task',
                "Your request \"{$clientRequest->title}\" has been converted to Task: #{$task->task_code}",
                route('client.tasks.show', $task->id),
                'request_converted'
            ));
        }

        return redirect()->route('tasks.show', $task->id)->with('success', 'Request successfully converted to a Task.');
    }
}
