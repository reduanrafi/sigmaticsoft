@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Case Studies</h4>
                        <a href="{{ route('case-study.create') }}"
                            class="btn btn-outline-success btn-sm rounded d-flex align-items-center"><i
                                class="mdi mdi-plus mr-1"></i> Create New</a>
                    </div>
                    <div class="col-md-offset-2 mt-2">
                        @if (Session::has('success'))
                            @include('admin.layouts.message.success')
                        @elseif(Session::has('error'))
                            @include('admin.layouts.message.error')
                        @endif
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 5%">SL</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Featured</th>
                                    <th class="text-center" style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($caseStudies as $key => $cs)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td><strong>{{ $cs->title }}</strong><br><small class="text-muted">Slug: {{ $cs->slug }}</small></td>
                                        <td>{{ $cs->category ?? $cs->tag }}</td>
                                        <td class="text-center">
                                            @if($cs->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($cs->is_featured)
                                                <span class="badge badge-info">Featured</span>
                                            @else
                                                <span class="badge badge-secondary">Standard</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('case-study.edit', $cs->id) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-0 p-1" title="Edit"><i
                                                        class="mdi mdi-table-edit"></i></a>
                                                <form action="{{ route('case-study.destroy', $cs->id) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure you want to delete this case study?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-0 p-1 ml-2" title="Delete"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
