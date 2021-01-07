@extends('admin.layouts.master')


@section('content_body')

<div class="row">
    <!-- Customers -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box top-left">
            <span class="info-box-icon bg-success elevation-1"><i class="nav-icon fas fa-users"></i></span>

            <div class="info-box-content">
            <a href="{{route('customer.index')}}"><span class="info-box-text">Customers</span></a>
            <span class="info-box-number">
                {{count($customers)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- Products -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box top-top">
            <span class="info-box-icon bg-warning elevation-1"><i class="nav-icon fa fa-truck"></i></span>

            <div class="info-box-content">
            <a href="{{route('product.index')}}"><span class="info-box-text">Products</span></a>
            <span class="info-box-number">
                {{count($products)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- Staff -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box top-right">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

            <div class="info-box-content">
            <a href="{{route('staff')}}"><span class="info-box-text">Staff</span></a>
            <span class="info-box-number">
                {{count($staff)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>

<div class="row">
    <!-- Riders -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bottom-left">
            <span class="info-box-icon bg-success elevation-1"><i class="fa fa-motorcycle" aria-hidden="true"></i></span>

            <div class="info-box-content">
            <a href="{{route('rider')}}"><span class="info-box-text">Riders</span></a>
            <span class="info-box-number">
                {{count($riders)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- Regular Orders -->
    <!-- <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bottom-bottom">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-box"></i></span>

            <div class="info-box-content">
            <a href="#"><span class="info-box-text">Regular Orders</span></a>
            <span class="info-box-number">
                0
            </span>
            </div>
        </div>
    </div> -->

    <!-- Staff -->
    <!-- <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bottom-right">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

            <div class="info-box-content">
            <a href="#"><span class="info-box-text">Staff</span></a>
            <span class="info-box-number">
                0
            </span>
            </div>
        </div>
    </div> -->
</div>

<a href="{{route('plug_n_play')}}" class="red">.</a>

<!-- <div class="info-box p-5" style="display:block;">
    <h4>ORDERS OVER TIME</h4>
    <br>
    <area-chart id="chart-id" :data="chartData"></area-chart>
</div> -->

<script>
    $(document).ready(function(){
        
    });
</script>
@endsection('content_body')