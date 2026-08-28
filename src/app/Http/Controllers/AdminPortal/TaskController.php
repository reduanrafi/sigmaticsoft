<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskComment;
use App\Models\ActivityLog;
use App\Models\Attachment;
use App\Notifications\PortalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['project.client', 'assignee']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('task_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->input('project_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->input('assigned_to'));
        }

        $tasks = $query->orderBy('sort_order')->orderBy('id', 'desc')->paginate(15);

        $projects = Project::all();
        $staff = User::where('role', 'admin')->get();

        return view('admin_portal.tasks.index', compact('tasks', 'projects', 'staff'));
    }

    public function board(Request $request)
    {
        $projects = Project::all();
        $projectId = $request->input('project_id');

        $query = Task::with(['project.client', 'assignee']);
        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $tasks = $query->orderBy('sort_order')->get();

        // Group tasks by status
        $statuses = [
            'backlog' => [],
            'accepted' => [],
            'in_progress' => [],
            'review' => [],
            'client_review' => [],
            'completed' => []
        ];

        foreach ($tasks as $task) {
            if (array_key_exists($task->status, $statuses)) {
                $statuses[$task->status][] = $task;
            } else {
                $statuses['backlog'][] = $task;
            }
        }

        return view('admin_portal.tasks.board', compact('statuses', 'projects', 'projectId'));
    }

    public function create(Request $request)
    {
        $projects = Project::all();
        $staff = User::where('role', 'admin')->get();
        $selectedProjectId = $request->input('project_id');

        return view('admin_portal.tasks.create', compact('projects', 'staff', 'selectedProjectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:bug,feature,improvement,maintenance,support,other',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:backlog,accepted,in_progress,review,client_review,completed,rejected,cancelled',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'client_visible' => 'required|boolean',
            'attachments.*' => 'nullable|file|max:5120', // Max 5MB
        ]);

        // Auto-generate task code
        $lastTask = Task::withTrashed()->orderBy('id', 'desc')->first();
        $nextId = $lastTask ? $lastTask->id + 1 : 1;
        $validated['task_code'] = 'TSK-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $validated['created_by'] = auth()->id();
        if ($validated['status'] === 'completed') {
            $validated['completed_at'] = now();
        }

        $task = Task::create($validated);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $this->uploadAttachment($file, $task, auth()->id());
                } catch (\Exception $e) {
                    return back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        ActivityLog::log('task_created', "Admin created task: {$task->title} ({$task->task_code})", $task);

        // Notify assigned staff
        if ($task->assigned_to && $task->assigned_to !== auth()->id()) {
            $assignee = User::find($task->assigned_to);
            if ($assignee) {
                $assignee->notify(new PortalNotification(
                    'Task Assigned',
                    "You have been assigned to task: {$task->title}",
                    route('tasks.show', $task->id),
                    'task_assigned'
                ));
            }
        }

        // Notify client if visible and client_review/in_progress etc.
        if ($task->client_visible) {
            $clientUsers = $task->project->client->users;
            foreach ($clientUsers as $cUser) {
                $cUser->notify(new PortalNotification(
                    'New Task Created',
                    "A new task has been created for your project: {$task->title}",
                    route('client.tasks.show', $task->id),
                    'task_created'
                ));
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load(['project.client', 'assignee', 'creator', 'comments.user.client', 'attachments.uploader']);
        $staff = User::where('role', 'admin')->get();
        return view('admin_portal.tasks.show', compact('task', 'staff'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $staff = User::where('role', 'admin')->get();
        return view('admin_portal.tasks.edit', compact('task', 'projects', 'staff'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:bug,feature,improvement,maintenance,support,other',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:backlog,accepted,in_progress,review,client_review,completed,rejected,cancelled',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => 'nullable|numeric|min:0',
            'client_visible' => 'required|boolean',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $oldStatus = $task->status;
        $oldAssignee = $task->assigned_to;

        if ($validated['status'] === 'completed' && $oldStatus !== 'completed') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $this->uploadAttachment($file, $task, auth()->id());
                } catch (\Exception $e) {
                    return back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        // Log status change
        if ($oldStatus !== $task->status) {
            ActivityLog::log('task_status_changed', "Admin changed status of Task #{$task->task_code} from " . ucfirst(str_replace('_', ' ', $oldStatus)) . " to " . ucfirst(str_replace('_', ' ', $task->status)), $task);

            // Notify client if visible status change
            if ($task->client_visible) {
                $clientUsers = $task->project->client->users;
                foreach ($clientUsers as $cUser) {
                    $cUser->notify(new PortalNotification(
                        'Task Status Updated',
                        "Task \"{$task->title}\" status updated to: " . ucfirst(str_replace('_', ' ', $task->status)),
                        route('client.tasks.show', $task->id),
                        'task_status_changed'
                    ));
                }
            }
        } else {
            ActivityLog::log('task_updated', "Admin updated task: {$task->title} ({$task->task_code})", $task);
        }

        // Notify assignee if changed
        if ($task->assigned_to && $task->assigned_to !== $oldAssignee && $task->assigned_to !== auth()->id()) {
            $assignee = User::find($task->assigned_to);
            if ($assignee) {
                $assignee->notify(new PortalNotification(
                    'Task Assigned',
                    "You have been assigned to task: {$task->title}",
                    route('tasks.show', $task->id),
                    'task_assigned'
                ));
            }
        }

        return redirect()->route('tasks.show', $task->id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:backlog,accepted,in_progress,review,client_review,completed',
        ]);

        $task = Task::find($validated['task_id']);
        $oldStatus = $task->status;

        $updateData = ['status' => $validated['status']];
        if ($validated['status'] === 'completed' && $oldStatus !== 'completed') {
            $updateData['completed_at'] = now();
        } elseif ($validated['status'] !== 'completed') {
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);

        ActivityLog::log('task_status_changed', "Admin moved Task #{$task->task_code} from " . ucfirst(str_replace('_', ' ', $oldStatus)) . " to " . ucfirst(str_replace('_', ' ', $task->status)), $task);

        // Notify client if visible status change
        if ($task->client_visible) {
            $clientUsers = $task->project->client->users;
            foreach ($clientUsers as $cUser) {
                $cUser->notify(new PortalNotification(
                    'Task Status Updated',
                    "Task \"{$task->title}\" status updated to: " . ucfirst(str_replace('_', ' ', $task->status)),
                    route('client.tasks.show', $task->id),
                    'task_status_changed'
                ));
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Task status updated.');
    }

    public function addComment(Request $request, Task $task)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'visibility' => 'required|in:public,internal',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $comment = TaskComment::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'visibility' => $validated['visibility'],
        ]);

        // Upload attachments for comments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $this->uploadAttachment($file, $comment, auth()->id());
                } catch (\Exception $e) {
                    return back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        ActivityLog::log('task_comment_added', "Admin added a " . $validated['visibility'] . " comment to Task #{$task->task_code}", $task);

        // Notify client if comment is public
        if ($validated['visibility'] === 'public' && $task->client_visible) {
            $clientUsers = $task->project->client->users;
            foreach ($clientUsers as $cUser) {
                $cUser->notify(new PortalNotification(
                    'New Comment on Task',
                    "Admin commented on task: \"{$task->title}\"",
                    route('client.tasks.show', $task->id),
                    'comment_added'
                ));
            }
        }

        return back()->with('success', 'Comment added successfully.');
    }

    public function destroy(Task $task)
    {
        ActivityLog::log('task_deleted', "Admin deleted task: {$task->title} ({$task->task_code})", $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    private function uploadAttachment($file, $attachable, $uploaderId)
    {
        $fileName = $file->getClientOriginalName();
        $safeName = time() . '_' . Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

        $forbiddenExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps', 'phar', 'sh', 'exe', 'bat', 'js'];
        if (in_array(strtolower($file->getClientOriginalExtension()), $forbiddenExtensions)) {
            throw new \Exception('Executable files are not allowed.');
        }

        $filePath = $file->storeAs('attachments', $safeName);

        return Attachment::create([
            'attachable_id' => $attachable->id,
            'attachable_type' => get_class($attachable),
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => $uploaderId,
        ]);
    }
}
