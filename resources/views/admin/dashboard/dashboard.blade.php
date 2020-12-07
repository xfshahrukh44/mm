@extends('admin.layouts.app')


@section('content_body')

<div class="row">
    <!-- Custom Baskets -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box top-left">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-basket"></i></span>

            <div class="info-box-content">
            <a href="#"><span class="info-box-text">Custom Baskets</span></a>
            <span class="info-box-number">
                {{count($all_baskets) - count($faaizy_baskets)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- Quick Orders -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box top-top">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bolt"></i></span>

            <div class="info-box-content">
            <a href="{{route('quick_order')}}"><span class="info-box-text">Quick Orders</span></a>
            <span class="info-box-number">
                {{count($quick_orders)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- customers -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box top-right">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-friends"></i></span>

            <div class="info-box-content">
            <a href="{{route('customer')}}"><span class="info-box-text">Customers</span></a>
            <span class="info-box-number">
                {{count($customers)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>

<div class="row">
    <!-- Faaizy Baskets -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bottom-left">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-basket"></i></span>

            <div class="info-box-content">
            <a href="#"><span class="info-box-text">Faaizy Baskets</span></a>
            <span class="info-box-number">
                {{count($faaizy_baskets)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- Regular Orders -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bottom-bottom">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-box"></i></span>

            <div class="info-box-content">
            <a href="{{route('order')}}"><span class="info-box-text">Regular Orders</span></a>
            <span class="info-box-number">
                {{count($orders)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <!-- Staff -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box bottom-right">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

            <div class="info-box-content">
            <a href="{{route('staff')}}"><span class="info-box-text">Staff</span></a>
            <span class="info-box-number">
                {{count($staffs)}}
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>

<!-- <div class="info-box p-5" style="display:block;">
    <h4>ORDERS OVER TIME</h4>
    <br>
    <area-chart id="chart-id" :data="chartData"></area-chart>
</div> -->


<hr>
<h3>This week</h3>
<!-- Current week stats -->
<div class="row">

    <!-- Frequently bought items -->
    <div class="col-md-4">
        <div class="card collapsed-card top-left">
            <div class="card-header">
            <h3 class="card-title">
                <i class="nav-icon fas fa-cubes nav-icon"></i>
                Frequently bought items
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Brand</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($frequently_bought_items_this_week as $item)
                        <tr>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['brand']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Brands in demand -->
    <div class="col-md-4">
        <div class="card collapsed-card top-top">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-bold" aria-hidden="true"></i>
                Brands in demand
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($brands_in_demand_this_week as $brand)
                        <tr>
                            <td>{{$brand['name']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- Most active customers -->
    <div class="col-md-4">
        <div class="card collapsed-card top-right">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-friends"></i>
                Most active customers
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Orders this week</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($most_active_users_this_week as $user)
                        <tr>
                            <td>{{$user['id']}}</td>
                            <td>{{$user['name']}}</td>
                            <td>{{$user['orders']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Frequently visited stores-->
    <div class="col-md-4">
        <div class="card collapsed-card bottom-left">
            <div class="card-header">
            <h3 class="card-title">
                <i class="nav-icon fa fa-shopping-bag" aria-hidden="true"></i>
                Frequently visited stores
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Store ID</th>
                    <th>Name</th>
                    <th>Items bought</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($frequently_visited_stores_this_week as $store)
                        <tr>
                            <td>{{$store['id']}}</td>
                            <td>{{$store['name']}}</td>
                            <td>{{$store['items']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Most active zones -->
    <div class="col-md-4">
        <div class="card collapsed-card bottom-bottom">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                Most active zones
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Orders this week</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($most_active_zones_this_week as $zone)
                        <tr>
                            <td>{{$zone->name}}</td>
                            <td>{{$zone->total}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Most active riders -->
    <div class="col-md-4">
        <div class="card collapsed-card bottom-right">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-motorcycle" aria-hidden="true"></i>
                Most active riders
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Rider ID</th>
                    <th>Name</th>
                    <th>Orders Delivered</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($most_active_riders_this_week as $rider)
                        <tr>
                            <td>{{$rider['id']}}</td>
                            <td>{{$rider['name']}}</td>
                            <td>{{$rider['orders']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</div>
<hr>


<h3>This month</h3>
<!-- Current month stats -->
<div class="row">

    <!-- Frequently bought items -->
    <div class="col-md-4">
        <div class="card collapsed-card top-left">
            <div class="card-header">
            <h3 class="card-title">
                <i class="nav-icon fas fa-cubes nav-icon"></i>
                Frequently bought items
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Brand</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($frequently_bought_items as $item)
                        <tr>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['brand']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Brands in demand -->
    <div class="col-md-4">
        <div class="card collapsed-card top-top">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-bold" aria-hidden="true"></i>
                Brands in demand
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($brands_in_demand as $brand)
                        <tr>
                            <td>{{$brand['name']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- Most active customers -->
    <div class="col-md-4">
        <div class="card collapsed-card top-right">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-friends"></i>
                Most active customers
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Orders this month</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($most_active_users as $user)
                        <tr>
                            <td>{{$user['id']}}</td>
                            <td>{{$user['name']}}</td>
                            <td>{{$user['orders']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Frequently visited stores-->
    <div class="col-md-4">
        <div class="card collapsed-card bottom-left">
            <div class="card-header">
            <h3 class="card-title">
                <i class="nav-icon fa fa-shopping-bag" aria-hidden="true"></i>
                Frequently visited stores
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Store ID</th>
                    <th>Name</th>
                    <th>Items bought</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($frequently_visited_stores as $store)
                        <tr>
                            <td>{{$store['id']}}</td>
                            <td>{{$store['name']}}</td>
                            <td>{{$store['items']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Most active zones -->
    <div class="col-md-4">
        <div class="card collapsed-card bottom-bottom">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                Most active zones
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Orders this month</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($most_active_zones as $zone)
                        <tr>
                            <td>{{$zone->name}}</td>
                            <td>{{$zone->total}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <!-- Most active riders -->
    <div class="col-md-4">
        <div class="card collapsed-card bottom-right">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-motorcycle" aria-hidden="true"></i>
                Most active riders
            </h3>
            <div class="card-tools mt-2">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Rider ID</th>
                    <th>Name</th>
                    <th>Orders Delivered</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($most_active_riders as $rider)
                        <tr>
                            <td>{{$rider['id']}}</td>
                            <td>{{$rider['name']}}</td>
                            <td>{{$rider['orders']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</div>
<hr>

<script>
    $(document).ready(function(){
        // edit
        $('.editButton').on('click', function(){
            var id = $(this).data('id');

            $('#editForm').attr('action', "{{route('item.update', 1)}}");
            $('#hidden').val(id);
            // alert($('.predefined_sizes' + id).html());
            
            $('#editForm #name').val($('.name' + id).html());
            if($('.has_measurement' + id).text() == 1)
            {
                $('#editForm #has_measurement').prop("checked", true);
            }
            else
            {
                $('#editForm #has_measurement').prop("checked", false);
            }
            $('#editForm #unit_id').val($('.unit' + id).attr('value'));
            $('#editForm #predefined_size').val($('.predefined_size' + id).html());

            $('#editItemModal').modal('show');
        });

        // delete
        $('.deleteButton').on('click', function(){
            var id = $(this).data('id');
            $('#deleteForm').attr('action', "{{route('item.destroy', 1)}}");
            $('#deleteForm .hidden').val(id);
            
            $('#deleteItemModalLabel').text('Delete Item: ' + $('.name' + id).html() + "?");
            $('#deleteItemModal').modal('show');
        });
    });
</script>
@endsection('content_body')