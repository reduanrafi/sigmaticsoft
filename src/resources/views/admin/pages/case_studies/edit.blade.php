@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Edit Case Study: {{ $caseStudy->title }}</h4>
                        <a href="{{ route('case-study.index') }}"
                            class="btn btn-outline-success btn-sm rounded d-flex align-items-center"><i
                                class="mdi mdi-eye mr-1"></i> View All</a>
                    </div>
                    <div class="col-md-offset-2">
                        @if (Session::has('success'))
                            @include('admin.layouts.message.success')
                        @elseif(Session::has('error'))
                            @include('admin.layouts.message.error')
                        @endif
                    </div>
                    
                    <form action="{{ route('case-study.update', $caseStudy->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- TAB 1: GENERAL INFO -->
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light"><strong>General Information</strong></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title', $caseStudy->title) }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Slug</label>
                                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $caseStudy->slug) }}" placeholder="Auto-generated if empty">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Subtitle / Lead Paragraph</label>
                                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $caseStudy->subtitle) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Tag</label>
                                        <input type="text" name="tag" class="form-control" value="{{ old('tag', $caseStudy->tag) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Icon Class (FontAwesome)</label>
                                        <input type="text" name="icon_class" class="form-control" value="{{ old('icon_class', $caseStudy->icon_class) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Excerpt (Card Short Summary)</label>
                                        <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $caseStudy->excerpt) }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select name="is_active" class="form-control">
                                            <option value="1" {{ $caseStudy->is_active == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $caseStudy->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Featured (Show on Homepage)</label>
                                        <select name="is_featured" class="form-control">
                                            <option value="0" {{ $caseStudy->is_featured == 0 ? 'selected' : '' }}>Standard</option>
                                            <option value="1" {{ $caseStudy->is_featured == 1 ? 'selected' : '' }}>Featured</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: SPECIFICATIONS & SIDEBAR -->
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light"><strong>Project Details & Capabilities (Sidebar)</strong></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Category</label>
                                        <input type="text" name="category" class="form-control" value="{{ old('category', $caseStudy->category) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Timeline</label>
                                        <input type="text" name="timeline" class="form-control" value="{{ old('timeline', $caseStudy->timeline) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Stack</label>
                                        <input type="text" name="stack" class="form-control" value="{{ old('stack', $caseStudy->stack) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <input type="text" name="status" class="form-control" value="{{ old('status', $caseStudy->status) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Capability 1</label>
                                        <input type="text" name="capability_1" class="form-control" value="{{ old('capability_1', $caseStudy->capability_1) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Capability 2</label>
                                        <input type="text" name="capability_2" class="form-control" value="{{ old('capability_2', $caseStudy->capability_2) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Capability 3</label>
                                        <input type="text" name="capability_3" class="form-control" value="{{ old('capability_3', $caseStudy->capability_3) }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Capability 4</label>
                                        <input type="text" name="capability_4" class="form-control" value="{{ old('capability_4', $caseStudy->capability_4) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: THE CASE STUDY STORY -->
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light"><strong>Case Study Case Story (Content Elements)</strong></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>1. Client Context</label>
                                    <textarea name="client_context" rows="4" class="form-control">{{ old('client_context', $caseStudy->client_context) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>2. Existing Environment</label>
                                    <textarea name="existing_environment" rows="4" class="form-control">{{ old('existing_environment', $caseStudy->existing_environment) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>3. Business Problem</label>
                                    <textarea name="business_problem" rows="4" class="form-control">{{ old('business_problem', $caseStudy->business_problem) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>4. The Solution</label>
                                    <textarea name="solution" rows="4" class="form-control">{{ old('solution', $caseStudy->solution) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>5. Implementation Details</label>
                                    <textarea name="implementation" rows="4" class="form-control">{{ old('implementation', $caseStudy->implementation) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>6. Operational Outcome</label>
                                    <textarea name="outcome" rows="4" class="form-control">{{ old('outcome', $caseStudy->outcome) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>7. Lessons Learned</label>
                                    <textarea name="lessons_learned" rows="4" class="form-control">{{ old('lessons_learned', $caseStudy->lessons_learned) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: SYSTEM ARCHITECTURE FLOWCHART -->
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light"><strong>System Architecture Flowchart Nodes (3-Step Diagram)</strong></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 border-right">
                                        <h5 class="mb-3 text-primary">Node 1 (Source / Start)</h5>
                                        <div class="form-group">
                                            <label>Node 1 Title</label>
                                            <input type="text" name="node1_title" class="form-control" value="{{ old('node1_title', $caseStudy->node1_title) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Node 1 Description</label>
                                            <input type="text" name="node1_desc" class="form-control" value="{{ old('node1_desc', $caseStudy->node1_desc) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 border-right">
                                        <h5 class="mb-3 text-primary">Node 2 (Process / Middle)</h5>
                                        <div class="form-group">
                                            <label>Node 2 Title</label>
                                            <input type="text" name="node2_title" class="form-control" value="{{ old('node2_title', $caseStudy->node2_title) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Node 2 Description</label>
                                            <input type="text" name="node2_desc" class="form-control" value="{{ old('node2_desc', $caseStudy->node2_desc) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="mb-3 text-primary">Node 3 (Destination / End)</h5>
                                        <div class="form-group">
                                            <label>Node 3 Title</label>
                                            <input type="text" name="node3_title" class="form-control" value="{{ old('node3_title', $caseStudy->node3_title) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Node 3 Description</label>
                                            <input type="text" name="node3_desc" class="form-control" value="{{ old('node3_desc', $caseStudy->node3_desc) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: CALL TO ACTION (CTA) -->
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light"><strong>Call To Action (CTA) Block</strong></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>CTA Title</label>
                                        <input type="text" name="cta_title" class="form-control" value="{{ old('cta_title', $caseStudy->cta_title) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>CTA Button Text</label>
                                        <input type="text" name="cta_button_text" class="form-control" value="{{ old('cta_button_text', $caseStudy->cta_button_text) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>CTA Description</label>
                                        <textarea name="cta_description" rows="3" class="form-control">{{ old('cta_description', $caseStudy->cta_description) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>CTA Link (URL / Route Path)</label>
                                        <input type="text" name="cta_link" class="form-control" value="{{ old('cta_link', $caseStudy->cta_link) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success btn-lg px-5">Update Case Study</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
