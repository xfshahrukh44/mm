@extends('admin.layouts.master')


@section('content_body')

<div class="row">
    <!-- Customers -->
    <div class="col-sm-6 col-md-4">
        <a href="{{route('customer.index')}}">
            <div class="info-box top-left">
                <span class="info-box-icon bg-info elevation-1"><i class="nav-icon fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text text-dark">Customers | {{count($customers)}}</span>
                    <span class="info-box-number small text-dark">
                        Total Receivables: {{'Rs. ' . $total_receivables}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <!-- Vendors -->
    <div class="col-sm-6 col-md-4">
        <a href="{{route('vendor.index')}}">
            <div class="info-box top-top">
                <span class="info-box-icon bg-info elevation-1"><i class="nav-icon fas fa-users"></i></span>

                <div class="info-box-content">
                <span class="info-box-text text-dark">Vendors | {{count($vendors)}}</span>
                <span class="info-box-number small text-dark">
                    Total Payables: {{'Rs. ' . $total_payables}}
                </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- Products -->
    <div class="col-sm-6 col-md-4">
        <a href="{{route('product.index')}}">
            <div class="info-box top-right">
                <span class="info-box-icon bg-warning elevation-1"><i class="nav-icon fa fa-truck"></i></span>

                <div class="info-box-content">
                <span class="info-box-text text-dark">Products | {{count($products)}}</span>
                <span class="info-box-number small text-dark">
                    Cost value: {{'Rs. ' . $total_cost_value}} | Sales value: {{'Rs. ' . $total_sales_value}}
                </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- Staff -->
    <div class="col-sm-6 col-md-4">
        <a href="{{route('staff')}}">
            <div class="info-box bottom-left">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

                <div class="info-box-content">
                <span class="info-box-text text-dark">Staff | {{count($staff)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- Riders -->
    <div class="col-12 col-sm-6 col-md-4">
        <a href="{{route('rider')}}">
            <div class="info-box bottom-bottom">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-motorcycle" aria-hidden="true"></i></span>

                <div class="info-box-content">
                <span class="info-box-text text-dark">Riders | {{count($riders)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
</div>

<hr>

<div class="row">
    <!-- Orders -->
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{route('order.index')}}">
            <div class="info-box top-top">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clipboard" aria-hidden="true"></i></span>
                <div class="info-box-content">
                <span class="info-box-text text-dark">Orders | {{$total_orders}}</span>
                <div class="row mt-1">
                    <span class="badge badge-pill small bg-lime ml-1" style="color:black !important;">
                        Ready: {{order_count_by_status('ready_to_dispatch') . ' ('.'Rs. ' . order_total_count_by_status('ready_to_dispatch').')'}}
                    </span>
                    <span class="badge badge-pill small bg-orange ml-1" style="color:black !important;">
                        Pending: {{order_count_by_status('pending') . ' ('.'Rs. ' . order_total_count_by_status('pending').')'}}
                    </span>
                    <span class="badge badge-pill small bg-yellow ml-1" style="color:black !important;">
                        Incomplete: {{order_count_by_status('incomplete') . ' ('.'Rs. ' . order_total_count_by_status('incomplete').')'}}
                    </span>
                    <span class="badge badge-pill small bg-green ml-1" style="color:black !important;">
                        Completed: {{order_count_by_status('completed')}}
                    </span>
                </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Invoices -->
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{route('invoice.index')}}">
            <div class="info-box top-left">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar" aria-hidden="true"></i></span>
                <div class="info-box-content">
                <span class="info-box-text text-dark">Invoices | {{$total_invoices}}</span>
                </div>
            </div>
        </a>
    </div>
    <!-- Receipts -->
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{route('receiving.index')}}">
            <div class="info-box top-top">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                <span class="info-box-text text-dark">Receipts | {{$total_receivings}}</span>
                </div>
            </div>
        </a>
    </div>
    <!-- Payments -->
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{route('payment.index')}}">
            <div class="info-box top-top">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book" aria-hidden="true"></i></span>
                <div class="info-box-content">
                <span class="info-box-text text-dark">Payments | {{$total_payments}}</span>
                </div>
            </div>
        </a>
    </div>
</div>

<a href="{{route('plug_n_play')}}" class="red">.</a>

<script>
    $(document).ready(function(){
        // persistent active sidebar
        var element = $('li a[href*="dashboard"]');
        element.parent().addClass('menu-open');
    });
</script>
@endsection('content_body')