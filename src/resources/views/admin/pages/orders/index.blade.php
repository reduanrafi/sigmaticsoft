@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title">Orders</h4>
                    <a href="{{ route('orders.create') }}"
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
                                    Customer name
                                </th>
                                <th>
                                    Phone
                                </th>
                                <th>
                                    Total
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $key =>$order)
                            <tr>
                                <td>{{ ++$key }}</td>

                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>{{ $order->total_amount }}</td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('orders.edit', $order->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-0 p-1"><i
                                                class="mdi mdi-table-edit"></i></a>
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           class="btn btn-sm btn-outline-warning rounded-0 p-1"><i
                                                class="mdi mdi-table-tennis"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-danger">Please Add orders First</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
