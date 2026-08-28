<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use App\Models\Project;
use App\Models\Attachment;
use App\Models\User;
use App\Models\ActivityLog;
use App\Notifications\PortalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientRequestController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $client = auth()->user()->client;
        if (!$client) {
            abort(403);
        }

        $requests = ClientRequest::where('client_id', $client->id)->latest()->paginate(10);
        return view('client_portal.requests.index', compact('requests'));
    }

    public function create()
    {
        $client = auth()->user()->client;
        if (!$client) {
            abort(403);
        }

        $projects = Project::where('client_id', $client->id)->where('status', 'active')->get();
        return view('client_portal.requests.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $client = auth()->user()->client;
        if (!$client) {
            abort(403);
        }

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:bug,feature,improvement,support',
            'priority' => 'required|in:low,medium,high,critical',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        // Authorize that the project belongs to the client
        $project = Project::findOrFail($validated['project_id']);
        if ($project->client_id !== $client->id) {
            abort(403, 'Unauthorized project selection.');
        }

        $validated['client_id'] = $client->id;
        $validated['status'] = 'submitted';

        $clientRequest = ClientRequest::create($validated);

        // Upload attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $this->uploadAttachment($file, $clientRequest, auth()->id());
                } catch (\Exception $e) {
                    return back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        ActivityLog::log('request_submitted', "Client " . auth()->user()->name . " submitted request: {$clientRequest->title}", $clientRequest);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new PortalNotification(
                'New Client Request',
                "Client " . auth()->user()->name . " submitted request: \"{$clientRequest->title}\"",
                route('requests.show', $clientRequest->id),
                'request_submitted'
            ));
        }

        return redirect()->route('client.requests.index')->with('success', 'Request submitted successfully. Our team will review it shortly.');
    }

    public function show(ClientRequest $clientRequest)
    {
        $this->authorize('view', $clientRequest);

        $clientRequest->load(['project', 'convertedTask', 'attachments.uploader']);
        $request = $clientRequest;

        return view('client_portal.requests.show', compact('request'));
    }

    public function edit(ClientRequest $clientRequest)
    {
        $this->authorize('update', $clientRequest);

        $client = auth()->user()->client;
        $projects = Project::where('client_id', $client->id)->where('status', 'active')->get();
        $request = $clientRequest;

        return view('client_portal.requests.edit', compact('request', 'projects'));
    }

    public function update(Request $request, ClientRequest $clientRequest)
    {
        $this->authorize('update', $clientRequest);

        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:bug,feature,improvement,support',
            'priority' => 'required|in:low,medium,high,critical',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        // Check project ownership
        $project = Project::findOrFail($validated['project_id']);
        if ($project->client_id !== auth()->user()->client_id) {
            abort(403);
        }

        $clientRequest->update($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $this->uploadAttachment($file, $clientRequest, auth()->id());
                } catch (\Exception $e) {
                    return back()->withErrors(['attachments' => $e->getMessage()]);
                }
            }
        }

        ActivityLog::log('request_updated', "Client updated request: {$clientRequest->title}", $clientRequest);

        return redirect()->route('client.requests.show', $clientRequest->id)->with('success', 'Request updated successfully.');
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
