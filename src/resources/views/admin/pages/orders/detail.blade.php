@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12" >
            <div class="card px-2">
                <div class="card-body" id="invoice">
                    <div class="container-fluid">
                        Sigmaticsoft
                        <hr>
                    </div>
                    <div class="container-fluid d-flex justify-content-between">
                        <h3 class="text-center my-5">Invoice&nbsp;&nbsp;{{$order->order_number}}</h3>
                        <div class="col-lg-3 ps-0">
                            <p class="mt-5 mb-2"><b>{{ $order->customer_name }}</b></p>
                            <p>{{ $order->delivery_address }}</p>
                        </div>
                        <div class="col-lg-3 pe-0">
                            <p class="mt-5 mb-2 text-end"><b>Invoice to</b></p>
                            <p class="text-end">{{ $order->customer_name }}<br>  {{ $order->delivery_address }}</p>
                        </div>
                    </div>

                    <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                        <div class="table-responsive w-100">
                            <table class="table">
                                <thead>
                                <tr class="bg-dark text-white">
                                    <th>#</th>
                                    <th>Item name</th>
                                    <th class="text-end">Quantity</th>
                                    <th class="text-end">Unit cost</th>
                                    <th class="text-end">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $k=>$item)
                                <tr class="text-end">
                                    <td class="text-start">{{++$k}}</td>
                                    <td class="text-start">{{$item->product_name}}</td>
                                    <td class="text-start">{{$item->quantity}}</td>
                                    <td class="text-start">{{$item->unit_price}}</td>
                                    <td class="text-start">{{$item->total_price}}</td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 d-flex justify-content-between w-100">
                        <div class="col-lg-4 pe-0">
                                <p class="mb-0 mt-5">Invoice Date : {{$order->created_at->format('F j, Y g:i A')}}</p>
                        </div>
                       <div class="col-lg-3 pe-0 text-left">
                           <p class="text-end mb-2">Sub - Total amount: {{$order->total_amount}}</p>
                           <p class="text-end">vat   :  {{$order->vat}}</p>
                           <p class="text-end"> Discount :  {{$order->discount}}</p>
                           <h4 class="text-end mb-5">Total : {{$order->total_amount+$order->vat -$order->discount}}</h4>

                       </div>
                    </div>

                </div>
                <div class="container-fluid w-100">
                    <a   class="btn btn-primary float-right mt-4 ms-2 print:hidden" onclick="printDiv('invoice')"><i class="ti-printer me-1"></i>Print</a>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-style')

@endsection
@section('script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <!-- Summernote JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote();
        });

        function printDiv(divId) {
            const content = document.getElementById(divId).innerHTML;

            const printWindow = window.open('', '', 'height=700,width=900');
            printWindow.document.write('<html><head><title>Invoice</title>');

            // ✅ Import Bootstrap CSS
            printWindow.document.write(
                `<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">`
            );

            // Optional: custom inline styles
            printWindow.document.write('<style>body{padding:20px;}</style>');

            printWindow.document.write('</head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.focus();

            // Print and close
            setTimeout(() => {
                printWindow.print(); // user can Save as PDF
                printWindow.close();
            }, 500);

        }
    </script>
<script>

    const featureImage = document.getElementById('featured_image');
    featureImage.onchange = evt => {
        const [file] = featureImage.files
        if (file) {
        imageOutput.src = URL.createObjectURL(file)
        }
    }
</script>
@endsection
