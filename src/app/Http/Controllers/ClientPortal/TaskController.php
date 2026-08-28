<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\ActivityLog;
use App\Models\Attachment;
use App\Models\User;
use App\Notifications\PortalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['project', 'assignee', 'attachments.uploader', 'comments' => function ($q) {
            $q->where('visibility', 'public')->orderBy('created_at', 'asc');
        }, 'comments.user.client', 'comments.attachments.uploader']);

        return view('client_portal.tasks.show', compact('task'));
    }

    public function addComment(Request $request, Task $task)
    {
        $this->authorize('addComment', $task);

        $validated = $request->validate([
            'body' => 'required|string',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $comment = TaskComment::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'visibility' => 'public', // Client comments are always public
        ]);

        // Upload attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $this->uploadAttachment($file, $comment, auth()->id());
                } catch (\Exception $e) {
                    return back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        ActivityLog::log('task_comment_added', "Client " . auth()->user()->name . " added a comment to Task #{$task->task_code}", $task);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new PortalNotification(
                'New Client Comment',
                "Client " . auth()->user()->name . " commented on task: \"{$task->title}\"",
                route('tasks.show', $task->id),
                'client_comment'
            ));
        }

        return back()->with('success', 'Comment added successfully.');
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
