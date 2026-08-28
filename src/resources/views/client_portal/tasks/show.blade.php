@extends('layouts.portal_client')

@section('content')
<div class="row">
    <!-- Task Details Card -->
    <div class="col-md-4 mb-4">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title font-weight-bold mb-0">Task Specifications</h4>
                    <a href="{{ route('client.projects.show', $task->project_id) }}" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>

                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Task Code</small>
                        <span class="font-weight-bold text-dark"><code>{{ $task->task_code }}</code></span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Title</small>
                        <span class="font-weight-bold text-dark fs-14">{{ $task->title }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Project Name</small>
                        <a href="{{ route('client.projects.show', $task->project_id) }}" class="font-weight-bold text-info">{{ $task->project->name }}</a>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Type</small>
                        <span class="badge badge-outline-dark text-capitalize">{{ $task->type }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Priority</small>
                        <span class="badge badge-{{ $task->priority === 'critical' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'secondary') }} text-capitalize">{{ $task->priority }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Current Status</small>
                        <span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'secondary') }} text-capitalize">{{ str_replace('_', ' ', $task->status) }}</span>
                    </li>
                    <li class="list-group-item py-3">
                        <small class="text-muted d-block">Due Date</small>
                        <span class="text-dark font-weight-bold">{{ $task->due_date ? $task->due_date->format('d M, Y') : 'N/A' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Description & Conversation Feed -->
    <div class="col-md-8">
        <!-- Description -->
        <div class="card rounded mb-4">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-3">Task Details</h4>
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
                            <div class="p-2 border rounded d-flex justify-content-between align-items-center bg-light">
                                <span class="text-dark text-truncate mr-2" style="font-size: 12px; max-width: 180px;" title="{{ $attach->file_name }}">{{ $attach->file_name }}</span>
                                <a href="{{ route('attachments.download', $attach->id) }}" class="btn btn-sm btn-outline-primary p-1 px-2" title="Download"><i class="mdi mdi-download"></i></a>
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

        <!-- Discussion Feed -->
        <div class="card rounded">
            <div class="card-body">
                <h4 class="card-title font-weight-bold mb-4">Conversation Feed</h4>
                
                <div class="comment-feed mb-4" style="max-height: 400px; overflow-y: auto; padding-right: 10px;">
                    @forelse($task->comments as $comment)
                        <div class="p-3 border rounded mb-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong class="text-dark">{{ $comment->user->name }}</strong>
                                    @if($comment->user->isClient())
                                        <span class="badge badge-info ml-1">Client Contact</span>
                                    @else
                                        <span class="badge badge-primary ml-1">Sigmatic Team</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="text-dark mb-2" style="white-space: pre-line;">{{ $comment->body }}</p>

                            <!-- Comment Attachments -->
                            @if($comment->attachments->count() > 0)
                                <div class="border-top pt-2 mt-2">
                                    <div class="d-flex flex-wrap">
                                        @foreach($comment->attachments as $cAttach)
                                            <div class="mr-2 mb-2 p-1 px-2 border rounded bg-white d-flex align-items-center">
                                                <small class="text-dark text-truncate mr-2" style="max-width: 150px;">{{ $cAttach->file_name }}</small>
                                                <a href="{{ route('attachments.download', $cAttach->id) }}" class="text-success mr-2" title="Download"><i class="mdi mdi-download"></i></a>
                                                @if($cAttach->uploaded_by === auth()->id())
                                                    <form action="{{ route('attachments.destroy', $cAttach->id) }}" method="POST" onsubmit="return confirm('Delete comment attachment?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="border-0 bg-transparent text-danger p-0"><i class="mdi mdi-close"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No comments posted yet. Leave a question or feedback below.</p>
                    @endforelse
                </div>

                <!-- Add Public Comment Form -->
                <h5 class="font-weight-bold mb-3 text-primary">Add a Comment</h5>
                <form action="{{ route('client.tasks.comments.store', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" class="form-control" rows="3" required placeholder="Ask a question or leave comments on progress..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="c_attachments">Upload Attachments (Optional, Max 5MB)</label>
                        <input type="file" name="attachments[]" id="c_attachments" class="form-control-file" multiple>
                    </div>
                    <button type="submit" class="btn btn-gradient-blue text-white w-100"><i class="mdi mdi-send"></i> Submit Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
