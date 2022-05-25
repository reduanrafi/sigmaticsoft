@extends('admin.layouts.master')
@section('content')

<section class="content-header">
    <h1>
        Sigmaticsoft ecommerce
    </h1>
    {{--<ol class="breadcrumb">--}}
    {{--<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>--}}
    {{--<li class="active">Here</li>--}}
    {{--</ol>--}}
</section>
<!-- Main content -->

<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3> 1</h3>

                    <p>Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>


        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3> 1</h3>

                    <p>Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

</section>

<!-- /.content -->

@endsection()
@section('extra-script')
<script>
    function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function () {
                $(".success").fadeOut();
            }, 1000);
        }
</script>
@endsection
