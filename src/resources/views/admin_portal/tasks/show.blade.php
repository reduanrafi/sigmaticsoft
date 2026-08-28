@extends('layouts.portal_admin')

@section('content')
<div class="row">
    <!-- Task Meta & Actions -->
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Task Metadata</h4>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Task Code</small>
                        <span class="font-weight-bold text-dark fs-15"><code>{{ $task->task_code }}</code></span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Title</small>
                        <span class="font-weight-bold text-dark fs-14">{{ $task->title }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Project Name</small>
                        <a href="{{ route('projects.show', $task->project_id) }}" class="font-weight-bold text-info">{{ $task->project->name }}</a>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Type</small>
                        <span class="badge badge-outline-dark text-capitalize">{{ $task->type }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Priority</small>
                        <span class="badge badge-{{ $task->priority === 'critical' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'secondary') }}">{{ ucfirst($task->priority) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Current Status</small>
                        <span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Client Visibility</small>
                        <span class="badge badge-{{ $task->client_visible ? 'success' : 'warning' }}">
                            {{ $task->client_visible ? 'Visible to Client' : 'Staff Only (Hidden)' }}
                        </span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Assignee</small>
                        <span class="font-weight-bold text-dark">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Due Date</small>
                        <span class="text-dark font-weight-bold">{{ $task->due_date ? $task->due_date->format('d M, Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Time Metrics</small>
                        <span class="text-dark">Est: {{ $task->estimated_hours ?? '0' }} hrs / Act: {{ $task->actual_hours ?? '0' }} hrs</span>
                    </li>
                    @if($task->completed_at)
                        <li class="list-group-item py-3">
                            <small class="text-muted d-block">Completed Date</small>
                            <span class="text-success font-weight-bold">{{ $task->completed_at->format('d M, Y h:i A') }}</span>
                        </li>
                    @endif
                </ul>

                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-gradient-primary text-white w-100 mb-2"><i class="mdi mdi-table-edit"></i> Edit Task Details</a>
                
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="mdi mdi-delete"></i> Delete Task</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Task Description, Attachments & Comments -->
    <div class="col-md-8">
        <!-- Description -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Task Description</h4>
                <div class="text-dark p-3 bg-light rounded" style="min-height: 100px;">
                    {!! $task->description ?? '<span class="text-muted">No description provided for this task.</span>' !!}
                </div>
            </div>
        </div>

        <!-- Task Attachments -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h5 class="font-weight-bold mb-3"><i class="mdi mdi-paperclip"></i> Task Attachments</h5>
                <div class="row">
                    @forelse($task->attachments as $attach)
                        <div class="col-sm-6 mb-3">
                            <div class="p-3 border rounded d-flex justify-content-between align-items-center bg-light">
                                <div>
                                    <strong class="d-block text-dark text-truncate" style="max-width: 180px;" title="{{ $attach->file_name }}">{{ $attach->file_name }}</strong>
                                    <small class="text-muted">{{ round($attach->file_size / 1024, 2) }} KB | Uploaded by {{ $attach->uploader->name ?? 'System' }}</small>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('attachments.download', $attach->id) }}" class="btn btn-sm btn-outline-success p-1 px-2 mr-1" title="Download"><i class="mdi mdi-download"></i></a>
                                    <form action="{{ route('attachments.destroy', $attach->id) }}" method="POST" onsubmit="return confirm('Delete this attachment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Delete"><i class="mdi mdi-delete"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted mb-0">No attachments uploaded directly on this task.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Comments & Conversations -->
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-4">Conversation Feed</h4>
                
                <div class="comment-feed mb-4" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                    @forelse($task->comments as $comment)
                        <div class="p-3 border rounded mb-3 {{ $comment->visibility === 'internal' ? 'bg-warning-light border-warning' : 'bg-light' }}" style="{{ $comment->visibility === 'internal' ? 'background: #FFFBEB;' : '' }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong class="text-dark">{{ $comment->user->name }}</strong>
                                    @if($comment->user->isClient())
                                        <span class="badge badge-info ml-1">Client Contact</span>
                                    @else
                                        <span class="badge badge-primary ml-1">Staff</span>
                                    @endif

                                    @if($comment->visibility === 'internal')
                                        <span class="badge badge-warning ml-1"><i class="mdi mdi-eye-off"></i> Internal Note (Staff Only)</span>
                                    @else
                                        <span class="badge badge-success ml-1"><i class="mdi mdi-eye"></i> Public</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="text-dark mb-2" style="white-space: pre-line;">{{ $comment->body }}</p>

                            <!-- Comment Attachments -->
                            @if($comment->attachments->count() > 0)
                                <div class="border-top pt-2 mt-2">
                                    <small class="text-muted d-block mb-1">Attached Files:</small>
                                    <div class="d-flex flex-wrap">
                                        @foreach($comment->attachments as $cAttach)
                                            <div class="mr-2 mb-2 p-1 px-2 border rounded bg-white d-flex align-items-center">
                                                <small class="text-dark text-truncate mr-2" style="max-width: 150px;">{{ $cAttach->file_name }}</small>
                                                <a href="{{ route('attachments.download', $cAttach->id) }}" class="text-success mr-2" title="Download"><i class="mdi mdi-download"></i></a>
                                                <form action="{{ route('attachments.destroy', $cAttach->id) }}" method="POST" onsubmit="return confirm('Delete comment attachment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent text-danger p-0"><i class="mdi mdi-close"></i></button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No comments posted yet. Start the conversation below.</p>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                <h5 class="font-weight-bold mb-3 text-primary">Post a Comment</h5>
                <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" class="form-control" rows="3" required placeholder="Write your message here..."></textarea>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6 form-group">
                            <label for="visibility">Comment Visibility</label>
                            <select name="visibility" id="visibility" class="form-control" required>
                                <option value="public">Public (Visible to Client)</option>
                                <option value="internal">Internal Note (Staff Only)</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="c_attachments">Upload Attachments</label>
                            <input type="file" name="attachments[]" id="c_attachments" class="form-control-file" multiple>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary text-white w-100"><i class="mdi mdi-comment-check"></i> Post Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
