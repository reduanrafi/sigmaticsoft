@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-4">
                        <h4 class="card-title">Create Case Study</h4>
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
                    
                    <form action="{{ route('case-study.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- TAB 1: GENERAL INFO -->
                        <div class="card mb-4 border border-light shadow-sm">
                            <div class="card-header bg-light"><strong>General Information</strong></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" placeholder="e.g. Retail POS & Inventory Database Sync" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Slug (Optional)</label>
                                        <input type="text" name="slug" class="form-control" placeholder="e.g. retail-pos-inventory-management (auto-generated from title if blank)">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Subtitle / Lead Paragraph</label>
                                        <input type="text" name="subtitle" class="form-control" placeholder="e.g. Connecting multi-terminal outlets with warehouses.">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Tag (e.g. Integration, Modernization)</label>
                                        <input type="text" name="tag" class="form-control" placeholder="e.g. Integration">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Icon Class (FontAwesome)</label>
                                        <input type="text" name="icon_class" class="form-control" placeholder="e.g. fa-solid fa-server">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Excerpt (Card Short Summary)</label>
                                        <textarea name="excerpt" rows="3" class="form-control" placeholder="Short teaser snippet for the case studies listing page grid..."></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select name="is_active" class="form-control">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Featured (Show on Homepage)</label>
                                        <select name="is_featured" class="form-control">
                                            <option value="0" selected>Standard</option>
                                            <option value="1">Featured</option>
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
                                        <label>Category (e.g. System Integration)</label>
                                        <input type="text" name="category" class="form-control" placeholder="e.g. System Integration">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Timeline (e.g. 10 Weeks)</label>
                                        <input type="text" name="timeline" class="form-control" placeholder="e.g. 10 Weeks">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Stack (e.g. PHP / Laravel / Postgres)</label>
                                        <input type="text" name="stack" class="form-control" placeholder="e.g. PHP / Laravel / Redis">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Status (e.g. Live in Production)</label>
                                        <input type="text" name="status" class="form-control" placeholder="e.g. Live in Production">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Capability 1</label>
                                        <input type="text" name="capability_1" class="form-control" placeholder="e.g. Webhook-driven updates">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Capability 2</label>
                                        <input type="text" name="capability_2" class="form-control" placeholder="e.g. Offline-fallback queue logging">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Capability 3</label>
                                        <input type="text" name="capability_3" class="form-control" placeholder="e.g. Token-authorized API handshakes">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Capability 4</label>
                                        <input type="text" name="capability_4" class="form-control" placeholder="e.g. Central stock database logs">
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
                                    <textarea name="client_context" rows="4" class="form-control" placeholder="Describe the client profile and operations..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>2. Existing Environment</label>
                                    <textarea name="existing_environment" rows="4" class="form-control" placeholder="Describe their setup before you built the solution..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>3. Business Problem</label>
                                    <textarea name="business_problem" rows="4" class="form-control" placeholder="Describe the specific bottlenecks and pain points..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>4. The Solution</label>
                                    <textarea name="solution" rows="4" class="form-control" placeholder="Explain the systems engineering solution you engineered..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>5. Implementation Details</label>
                                    <textarea name="implementation" rows="4" class="form-control" placeholder="Detail how you programmed it, databases, parameters..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>6. Operational Outcome</label>
                                    <textarea name="outcome" rows="4" class="form-control" placeholder="Highlight key statistics and improvements..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label>7. Lessons Learned</label>
                                    <textarea name="lessons_learned" rows="4" class="form-control" placeholder="Provide major takeaways and best practices..."></textarea>
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
                                            <input type="text" name="node1_title" class="form-control" placeholder="e.g. POS Billing Terminals">
                                        </div>
                                        <div class="form-group">
                                            <label>Node 1 Description</label>
                                            <input type="text" name="node1_desc" class="form-control" placeholder="e.g. Local client scanning barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-4 border-right">
                                        <h5 class="mb-3 text-primary">Node 2 (Process / Middle)</h5>
                                        <div class="form-group">
                                            <label>Node 2 Title</label>
                                            <input type="text" name="node2_title" class="form-control" placeholder="e.g. Integration Layer">
                                        </div>
                                        <div class="form-group">
                                            <label>Node 2 Description</label>
                                            <input type="text" name="node2_desc" class="form-control" placeholder="e.g. Redis Queue & API triggers">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="mb-3 text-primary">Node 3 (Destination / End)</h5>
                                        <div class="form-group">
                                            <label>Node 3 Title</label>
                                            <input type="text" name="node3_title" class="form-control" placeholder="e.g. Central Inventory Core">
                                        </div>
                                        <div class="form-group">
                                            <label>Node 3 Description</label>
                                            <input type="text" name="node3_desc" class="form-control" placeholder="e.g. Synchronized database records">
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
                                        <input type="text" name="cta_title" class="form-control" placeholder="e.g. Need POS Integration?">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>CTA Button Text</label>
                                        <input type="text" name="cta_button_text" class="form-control" placeholder="e.g. Discuss Your Sync Goals">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>CTA Description</label>
                                        <textarea name="cta_description" rows="3" class="form-control" placeholder="e.g. Let's discuss how to connect your terminals and warehouses."></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>CTA Link (URL / Route Path)</label>
                                        <input type="text" name="cta_link" class="form-control" placeholder="e.g. /contact?subject=POS+Integration+Request">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success btn-lg px-5">Save Case Study</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
