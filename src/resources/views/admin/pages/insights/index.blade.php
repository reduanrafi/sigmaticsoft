@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">insights</h4>
                        <a href="{{ route('insight.create') }}"
                            class="btn btn-outline-success btn-sm rounded d-flex align-items-center"><i
                                class="mdi mdi-plus mr-1"></i>
                            Create</a>
                    </div>
                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        SL
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        email
                                    </th>

                                    <th class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insights as $key => $insight)
                                    <tr>
                                        <td>
                                            {{ ++$key }}
                                        </td>
                                        <td>
                                            {!! $insight->title !!}
                                        </td>

                                        <td>
                                            {{ $insight->excerpt }}
                                        </td>


                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('insight.edit', $insight->id) }}"
                                                    class="btn btn-sm btn-outline-primary rounded-0 p-1"><i
                                                        class="mdi mdi-table-edit"></i></a>
                                                <form action="{{ route('insight.destroy', $insight->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-0 p-1 ml-2"><i
                                                            class="mdi mdi-delete"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
{{--                                {{ $insights->links() }}--}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
