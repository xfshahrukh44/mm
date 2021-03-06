@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fa fa-clipboard"></i> Orders</h1>
</div>
<!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Admin</a></li>
      <li class="breadcrumb-item"><a href="#">Orders</a></li>
      <li class="breadcrumb-item active">Order</li>
  </ol>
</div>
<!-- /.col -->
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content_body')
<!-- Index view -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                <!-- generate excel -->
                    <form action="{{route('generate_orders_excel')}}" target="_blank" method="post">
                        @csrf
                        @can('can_excel_orders')
                            <button type="submit" class="btn btn-success generate_ledgers_excel">
                                <i class="fas fa-file-excel"></i>
                            </button>
                        @endcan
                        <input type="hidden" name="excel_query" class="excel_query" value="">
                        <input type="hidden" name="excel_date" class="excel_date" value="">
                        @can('can_add_orders')
                            <button class="btn btn-success" type="button" id="add_program" data-route="{{route('order.store')}}">
                                <i class="fas fa-plus"></i>
                            </button>
                        @endcan
                    </form>
                </div>
                <!-- search bar -->
                <form action="{{route('search_orders')}}" class="form-wrapper">
                    <div class="row">
                        <!-- search bar -->
                        <div class="topnav col-md-4">
                            <input name="query" class="form-control query" id="search_content" type="text" placeholder="Search..">
                        </div>
                        <!-- dispatch_date -->
                        <div class="topnav col-md-4">
                            <input name="dispatch_date" class="form-control dispatch_date2" id="search_content" type="date" placeholder="Dispatch Date">
                        </div>
                        <!-- search button-->
                        <button type="submit" class="btn btn-primary col-md-0 justify-content-start" id="search_button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-md-12" style="overflow-x:auto;">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Order ID: activate to sort column ascending"><i  class="fa fa-arrow-up arrow_up_down"></i><i class="fa fa-arrow-down arrow_up_down"></i>Order ID</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Date Punched</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Dispatch Date</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Customer Name: activate to sort column ascending">Customer Name</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Phone</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending">Total</th>
                              <th class="sorting " tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status <i class="fa fa-arrow-up arrow_up_down"></i><i class="fa fa-arrow-down arrow_up_down"></i></th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending">Rider</th>
                                @can('isSuperAdmin')
                                    <th class="sorting">Punched By</th>
                                    <th class="sorting">Modified By</th>
                                @endcan
                              <th tabindex="0" rowspan="1" colspan="1">Actions</th>
                          </tr>
                        </thead>

                        <tbody>
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                    <tr role="row" class="odd">
                                        <td class="{{'order_id'.$order->id}}">{{$order->id}}</td>
                                        <td class="{{'created_at'.$order->id}}">{{$order->created_at ? return_date($order->created_at) : NULL}}</td>
                                        <td class="{{'dispatch_date'.$order->id}}">{{$order->dispatch_date ? return_date_wo_time($order->dispatch_date) : NULL}}</td>
                                        <td class="{{'customer_id'.$order->id}}" data-id="{{$order->customer_id}}" data-object="{{$order->customer ? $order->customer : NULL}}">
                                            <a href="#" class="viewProfileButton" data-id="{{$order->customer_id}}" data-type="{{$order->customer ? $order->customer->type : NULL}}" data-route="{{$order->customer ? route('customer.show',$order->customer->id) : '#'}}">
                                                {{$order->customer ? $order->customer->name : NULL}}
                                            </a>
                                        </td>
                                        <td class="{{'contact_number'.$order->id}}">{{$order->customer ? $order->customer->contact_number : NULL}}</td>
                                        <td class="{{'address'.$order->id}}">{{$order->customer ? ($order->customer->shop_name . ' - ' . ($order->customer->market ? $order->customer->market->name : NULL) . ' - ' . ($order->customer->market && $order->customer->market->area ? $order->customer->market->area->name : NULL)) : NULL}}</td>
                                        <td class="{{'total'.$order->id}}">RS.{{number_format($order->total)}}</td>
                                        <td class="{{'status'.$order->id}} text-center">
                                            @if($order->status == "pending")
                                                <span class="badge badge-pill bg-orange" style="font-size: 0.9rem; color: white!important;">Pending</span>
                                            @elseif($order->status == "incomplete")
                                                <span class="badge badge-pill bg-yellow" style="font-size: 0.9rem; color: white!important;">Incomplete</span>
                                            @elseif($order->status == "ready_to_dispatch")
                                                <span class="badge badge-pill bg-lime" style="font-size: 0.9rem; color: white!important;">Ready to Dispatch</span>
                                            @else
                                                <span class="badge badge-pill badge-success" style="font-size: 0.9rem; color: white;">Completed</span>
                                            @endif
                                        </td>
                                        <td class="{{'rider'.$order->id}}">{{return_user_name($order->rider_id)}}</td>
                                        @can('isSuperAdmin')
                                            <td>
                                                {{return_user_name($order->created_by)}}
                                                @if($order->is_from_webpage == 1)
                                                    <span class="badge badge-pill bg-green float-center" style="font-size: 0.6rem; color: white!important;">Online</span>
                                                @endif
                                            </td>
                                            <td>{{return_user_name($order->modified_by)}}</td>
                                        @endcan
                                        <td>
                                            <!-- Detail -->
                                            @can('can_view_orders')
                                                <a href="#" class="detailButton" data-id="{{$order->id}}" data-type="{{$order->id}}" data-image="{{asset('img/order_images') . '/' . $order->image}}">
                                                    <i class="fas fa-shopping-basket blue ml-1"></i>
                                                </a>
                                            @endcan
                                            <!-- Edit -->
                                            @can('can_edit_orders')
                                                @if($order->invoiced_from != 1)
                                                    <a href="#" class="editButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
                                                        <i class="fas fa-edit blue ml-1"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                            <!-- Delete -->
                                            @can('can_delete_orders')
                                                <a href="#" class="deleteButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
                                                    <i class="fas fa-trash red ml-1"></i>
                                                </a>
                                            @endcan
                                            <!-- Generate Invoice -->
                                            @can('can_invoice_orders')
                                                @if($order->status != 'completed' && $order->status != NULL)
                                                    <a href="#" class="invoiceButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
                                                        <i class="fas fa-file-invoice-dollar"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=12><h6 align="center">No order(s) found</h6></td>
                                </tr>
                            @endif
                        </tbody>

                        <tfoot>
                        </tfoot>

                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                @if(count($orders) > 0)
                {{$orders->appends(request()->except('page'))->links()}}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create view -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrderModalLabel">Add New order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="col-md-12" method="POST" action="{{route('order.store')}}" enctype="multipart/form-data">
                @method('POST')
                @include('admin.order.order_master')

                <!-- buttons -->
                <div class="modal-footer">
                    <button name="pending_status" type="submit" class="btn btn-primary" id="createButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="{{route('order.update', 1)}}" enctype="multipart/form-data">
                <!-- hidden input -->
                @method('PUT')
                <input type="hidden" class="hidden" name="hidden">
                @include('admin.order.order_master')
                <!-- buttons -->
                <div class="modal-footer">
                    <button name="completed_status" type="submit" class="btn btn-primary" id="createButton">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Invoice view -->
<div class="modal fade" id="invoiceOrderModal" tabindex="-1" role="dialog" aria-labelledby="invoiceOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceOrderModalLabel">Generate Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="invoiceForm" method="POST" action="{{route('invoice.store')}}" enctype="multipart/form-data">

                @include('admin.order.order_master')
                <!-- buttons -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="createButton">Generate Invoice</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">Delete Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" method="POST" action="{{route('order.destroy', 1)}}">
                <!-- hidden input -->
                @method('DELETE')
                @csrf
                <input class="hidden" type="hidden" name="hidden">
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger" id="deleteButton">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="detailOrderModal" tabindex="-1" role="dialog" aria-labelledby="detailOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{route('plug_n_play')}}" method="GET">
                @method('GET')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailOrderModalLabel">Order details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-x:auto;">
                    <a href="{{asset('img/logo.png')}}" target="_blank" class="order_image_wrapper">
                        <img class="image" src="{{asset('img/logo.png')}}" width="150">
                    </a>
                    <br>
                    <br>
                    <table class=" table-bordered table-striped p-2" style="width:100%; border: 1px solid black;height: 20px;">
                        <tr role="row">
                            <th>Order id:</th>
                            <td><h6 id="order_id"></td>
                        </tr>
                        <tr>
                            <th>Customer name:</th>
                            <td><h6 id="customer_name"></h6></td>
                        </tr>
                        <tr>
                            <th>Contact:</th>
                            <td><h6 id="contact_number"></h6></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><h6 id="address"></h6></td>
                        </tr>
                        <tr>
                            <th>Total Amount:</th>
                            <td><h6 id="detailTotal"></h6></td>
                        </tr>
                        <tr>
                            <th>Order Status:</th>
                            <td><h6 id="status"></h6></td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td><p id="description"></p></td>
                        </tr>
                    </table>
                    <div class="col-md-12">
                        <!-- MASTER INFO -->
                        <!-- Order id -->
                        <br>
                        <!-- <a href="#" class="addItem float-right " data-id="">
                            <i class="fas fa-plus-circle blue ml-1"></i> Add Item
                        </a> -->
                        <div class="row" style="overflow-x:auto;">
                            <!-- CHILD INFO -->
                            <table id="itemTable" class="table table-bordered table-hover dtr-inline" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Invoice Item?</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Category</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Brand</th>
                                        <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">Product</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Quantity</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Price</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Unit</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Available?</th>
                                    </tr>
                                </thead>

                                <tbody id="table_row_wrapper">
                                    <tr role="row" class="odd">
                                        <!-- <td>yes/no</td>
                                        <td class="">'+order.order_products[i].product.category.name+'</td>
                                        <td class="">'+order.order_products[i].product.brand.name+'</td>
                                        <td class="">'+order.order_products[i].product.article+'</td>
                                        <td class="">'+order.order_products[i].quantity+'</td>
                                        <td class="">'+order.order_products[i].price+'</td>
                                        <td class="">'+order.order_products[i].product.unit.name+'</td>
                                        <td><input type="checkbox"></td> -->
                                    </tr>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn bg-lime button_rtd_detail" type="button" style="color:white!important;" hidden>Ready</button>
                    <button class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Profile view -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <img class="profile" src="{{asset('img/logo.png')}}" width="150" style="position: relative; left:33%;">
                <hr style="color:gray;">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <tr role="row" class="odd">
                            <td class="">Full Name</td>
                            <td class="fullname"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Phone</td>
                            <td class="phone"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Address</td>
                            <td class="address"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Email Address</td>
                            <td class="emailAddress"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Registration Date</td>
                            <td class="registrationDate"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function(){
    
    // get url params
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null) {
            return null;
        }
        return decodeURI(results[1]) || 0;
    }
    // console.log($.urlParam('query'));
    
    $('.query').val($.urlParam('query') ? $.urlParam('query') : '');
    $('.excel_query').val($.urlParam('query') ? $.urlParam('query') : '');
    $('.dispatch_date2').val($.urlParam('dispatch_date') ? $.urlParam('dispatch_date') : '');
    $('.excel_date').val($.urlParam('dispatch_date') ? $.urlParam('dispatch_date') : '');
    
    // persistent active sidebar
    var element = $('li a[href*="'+ window.location.pathname +'"]');
    element.parent().parent().parent().addClass('menu-open');
    element.addClass('active');

    // on ready functions
    $('.customer_id').select2();
    $('.rider_id').select2();
    fetch_product_labels();

    // GLLOBAL VARS
    var product_labels = "";
    var product = "";
    var customer = "";
    var order = "";
    var current_order_id = 0;
    var special_discount = 0;

    // adding items dynamically*
    var x = 1; //Initial field counter is 1
    var maxField = 40; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var minField = 1; //Input fields decrement limitation
    var removeButton = $('.remove_button'); //Remove button selector
    var wrapper = $('.field_wrapper'); //Input field wrappervar x = 1; //Initial field counter is 1

    // div strings
    var startDiv = '<div class="row">';
    var productDiv = '<div class="col-md-4"><div class="ui-widget"><input class="form-control product_search" name="products[]"><input class="hidden_product_search" type="hidden" name="hidden_product_ids[]"></div></div>';
    var priceDiv = '<div class="form-group col-md-4"><input type="number" class="form-control prices" name="prices[]" required min=0 step="0.01"></div>';
    var quantityDiv = '<div class="form-group col-md-3"><input type="number" class="form-control quantities" name="quantities[]" required value=0 step="0.01"></div>';
    var removeChildDiv = '<div class="form-group col-md-0 ml-1 remove_button mt-1" style="display: table; vertical-align: middle;"><a class="btn btn-primary"><i class="fas fa-minus" style="color:white;"></i></a></div>';
    var endDiv = '</div>';
    var fieldHTML = startDiv + productDiv + priceDiv + quantityDiv + removeChildDiv + endDiv;

    // fetch product labels
    function fetch_product_labels(){
        // fetch products
        $.ajax({
            url: "<?php echo(route('fetch_product_labels')); ?>",
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                product_labels = data;
            }
        });
    }

    // fetch product
    function fetch_product(id){
        // fetch product
        $.ajax({
            url: "<?php echo(route('product.show', 1)); ?>",
            type: 'GET',
            async: false,
            data: {id: id},
            dataType: 'JSON',
            success: function (data) {
                product = data.product;
            }
        });
    }

    // fetch order
    function fetch_order(id){
        // fetch order
        $.ajax({
            url: "<?php echo(route('order.show', 1)); ?>",
            type: 'GET',
            async: false,
            data: {order_id: id},
            dataType: 'JSON',
            success: function (data) {
                order = data.order;
            }
        });
    }

    // fetch customer
    function fetch_customer(id){
        // fetch customer
        $.ajax({
            url: "<?php echo(route('customer.show', 1)); ?>",
            type: 'GET',
            async: false,
            data: {id: id},
            dataType: 'JSON',
            success: function (data) {
                customer = data.customer;
                // if customer is distributor, rider id is not required, else required
                (customer.type == 'distributor') ? rider_not_required() : rider_required();
            }
        });
    }

    // count order total
    function get_order_total(form){
        var quantities = $(form + ' .quantities');
        var prices = $(form + ' .prices');
        if(form == "#invoiceOrderModal"){
            var discount = $(form + ' .discount').val();
        }
        else{
            var discount = 0;
        }
        var total = 0;
        for(var i = 0; i < prices.length; i++){
            total += ($(form + ' .prices')[i].value * $(form + ' .quantities')[i].value);
        }
        $(form + ' .total').val(total);
        // final_amount
        $(form + ' .final_amount').val(parseInt($(form + ' .total').val()) + parseInt($(form + ' .previous_amount').val()));
        $(form + ' .balance_due').val(parseInt($(form + ' .final_amount').val()) - parseInt($(form + ' .amount_pay').val()) - discount);
    }

    // fetch_by_customer_and_product
    function fetch_by_customer_and_product(){
        $.ajax({
            url: "<?php echo(route('fetch_by_customer_and_product')); ?>",
            type: 'GET',
            async: false,
            data: {
                customer_id: customer.id,
                product_id: product.id
            },
            dataType: 'JSON',
            success: function (data) {
                if(data.success == true){
                    special_discount = data.special_discount.amount;
                }
                else{
                    special_discount = 0;
                }
            }
        });
    }

    function ready_to_dispatch(order_id){
        // fetch order
        $.ajax({
            url: "<?php echo(route('ready_to_dispatch')); ?>",
            type: 'GET',
            async: false,
            data: {order_id: order_id},
            dataType: 'JSON',
            success: function (data) {
                // 
            }
        });
    }

    // ONCHANGE FUNCTIONS
    $('#addOrderModal').on('change', '.quantities', function(){
        get_order_total('#addOrderModal');
    });
    $('#addOrderModal').on('change', '.prices', function(){
        get_order_total('#addOrderModal');
    });
    $('#editOrderModal').on('change', '.quantities', function(){
        get_order_total('#editOrderModal');
    });
    $('#editOrderModal').on('change', '.prices', function(){
        get_order_total('#editOrderModal');
    });
    $('#invoiceOrderModal').on('change', '.quantities', function(){
        get_order_total('#invoiceOrderModal');
    });
    $('#invoiceOrderModal').on('change', '.prices', function(){
        get_order_total('#invoiceOrderModal');
    });
    $('#invoiceOrderModal').on('change', '.discount', function(){
        get_order_total('#invoiceOrderModal');
    });
    $('#invoiceOrderModal').on('change', '.amount_pay', function(){
        get_order_total('#invoiceOrderModal');
    });
    // on customer change
    $('.customer_id').on('change', function(){
        var user_id = $(this).val();
        fetch_customer(user_id);
        $('.previous_amount').val(customer ? customer.outstanding_balance : '');
        get_order_total('#editOrderModal');
        get_order_total('#addOrderModal');
        get_order_total('#invoiceOrderModal');
    });
    // on payment change on invoice
    $('#invoiceOrderModal .payment').on('change', function(){
        if($(this).val() == 'credit'){
            $('#invoiceOrderModal .amount_pay').val(0);
            $('#invoiceOrderModal .amount_pay').prop('readonly', true);
            $('#invoiceOrderModal .amount_pay').change();
            return 0;
        }
        $('#invoiceOrderModal .amount_pay').prop('readonly', false);
    });
    // on amount_pay change on invoice
    $('#invoiceOrderModal .amount_pay').on('change', function(){
        $('#invoiceOrderModal .balance_due').val(parseInt($('#invoiceOrderModal .final_amount').val()) - parseInt($('#invoiceOrderModal .amount_pay').val()));
    });

    // autocomplete
    function initAutocomplete(input, wrapper, source){
        $(input).autocomplete({
            source: source,
            minLength: 0,
            appendTo: wrapper,
            select: function(event, ui) {
                $(this).val(ui.item.label);
                $(this).siblings('input').val(ui.item.value);
                return false;
            },
        });
        if(input != '#search_customers' && input != '#search_riders'){
            $(input).autocomplete("search");
        }
    }

    // autocomplete items only
    function initAutocompleteItems(input, wrapper, source){
        $(input).autocomplete({
            source: source,
            appendTo: wrapper,
            select: function(event, ui) {
                // update current product
                fetch_product(ui.item.value);

                $(this).val(ui.item.label);
                $(this).siblings('input').val(ui.item.value);

                // check for special discount
                fetch_by_customer_and_product();
                if(special_discount != 0){
                    $(this).parent().parent().next().find('input').val(special_discount);
                }
                else{
                    if(customer.type == "consumer"){
                        $(this).parent().parent().next().find('input').val(ui.item.consumer_selling_price);
                    }
                    if(customer.type == "retailer" || customer.type == "distributor"){
                        $(this).parent().parent().next().find('input').val(ui.item.retailer_selling_price);
                    }
                }

                return false;
            },
        });
    }
    
    // add required attribute from rider
    function rider_required(){
        // rider_id
        $("#invoiceOrderModal .rider_id").prop("required", true);
    }

    // remove required attribute from rider
    function rider_not_required(){
        $("#invoiceOrderModal .rider_id").prop("required", false);
    }

    // add required attribute
    $('.save_as_completed').on('click', function(){
        $("#order_total").prop("required", true);
        $("#rider_charges").prop("required", true);
        $("#rider_id").prop('required', true);
    })

    // remove required attribute
    $('.save_as_pending').on('click', function(){
        $("#order_total").prop("required", false);
        $("#rider_charges").prop("required", false);
        $("#rider_id").prop('required', false);

    })

    // edit
    $('.editButton').on('click', function(){
        fetch_order($(this).data('id'));
        $('#editOrderModal .hidden').val($(this).data('id'));
        $('#editOrderModal .description').val(order.description);

        // select customer
        $('#editOrderModal .customer_id option[value="'+ (order.customer ? order.customer_id : '') +'"]').prop('selected', true);
        $('#editOrderModal .customer_id').trigger('change.select2');
        $('#editOrderModal .customer_id').change();
        $('#editOrderModal .dispatch_date').val(order.dispatch_date);

        // remove required attribute on rider_id
        $("#editOrderModal .rider_id").prop("required", false);

        // empty wrapper
        $('.field_wrapper').html('');

        for(var i = 0; i < order.order_products.length; i++){
            if(order.order_products[i].invoiced == 0){
                var productDiv = '<div class="col-md-4"><div class="ui-widget"><input class="form-control product_search" name="products[]" value="'+ order.order_products[i].product.article +'"><input class="hidden_product_search" type="hidden" name="hidden_product_ids[]" value="'+ order.order_products[i].product.id +'"></div></div>';
                var priceDiv = '<div class="form-group col-md-4"><input type="number" class="form-control prices" name="prices[]" required min=0 step="0.01" value="'+ order.order_products[i].price +'"></div>';
                var quantityDiv = '<div class="form-group col-md-3"><input type="number" class="form-control quantities" name="quantities[]" required min=0 step="0.01" value="'+ order.order_products[i].quantity +'"></div>';
                var fieldHTML = startDiv + productDiv + priceDiv + quantityDiv + removeChildDiv + endDiv;

                $('.field_wrapper').prepend(fieldHTML);
                x++;
            }
        }

        initAutocompleteItems(".product_search", "#editOrderModal .ui-widget", product_labels);

        get_order_total('#editOrderModal');

        $('#editOrderModal').modal('show');
    });

    // invoice
    $('.invoiceButton').on('click', function(){
        fetch_order($(this).data('id'));

        // un hide fields
        $('#invoiceOrderModal .payment_wrapper').removeAttr('hidden');
        $('#invoiceOrderModal .amount_pay_wrapper').removeAttr('hidden');
        $('#invoiceOrderModal .discount_wrapper').removeAttr('hidden');
        $('#invoiceOrderModal .balance_due_wrapper').removeAttr('hidden');
        $('#invoiceOrderModal .rider_wrapper').removeAttr('hidden');
        $('#invoiceOrderModal .date_wrapper').removeAttr('hidden');

        // hide fields
        $('#invoiceOrderModal .dispatch_date_wrapper').attr('hidden', 'hidden');
        $('#invoiceOrderModal .image_wrapper').attr('hidden', 'hidden');

        // remove required attribute on 
        $("#invoiceOrderModal .dispatch_date").prop("required", false);

        // adjust bootstrap classes
        $('#invoiceOrderModal .total_wrapper').removeClass('col-md-3');
        $('#invoiceOrderModal .total_wrapper').addClass('col-md-4');
        $('#invoiceOrderModal .previous_amount_wrapper').removeClass('col-md-3');
        $('#invoiceOrderModal .previous_amount_wrapper').addClass('col-md-4');
        $('#invoiceOrderModal .final_amount_wrapper').removeClass('col-md-3');
        $('#invoiceOrderModal .final_amount_wrapper').addClass('col-md-4');

        // set order_id
        $('#invoiceOrderModal .order_id').val($(this).data('id'));
        // select customer
        $('#invoiceOrderModal .customer_id option[value="'+ order.customer_id +'"]').prop('selected', true);
        $('#invoiceOrderModal .customer_id').trigger('change.select2');
        $('#invoiceOrderModal .customer_id').change();
        // set description
        $('#invoiceOrderModal .description').val(order.description);
        // set date
        $('#invoiceOrderModal .date').val(order.dispatch_date);

        // payment credit by default
        $('#invoiceOrderModal .payment option[value="credit"]').prop('selected', true);
        $('#invoiceOrderModal .payment').change();

        // empty wrapper
        $('.field_wrapper').html('');

        for(var i = 0; i < order.order_products.length; i++){
            if(order.order_products[i].invoiced == 0){
                var style_div = (order.order_products[i].is_available == 0) ? ('style = "border-color:red;"') : '';
                var productDiv = '<div class="col-md-4"><div class="ui-widget"><input name="order_products_ids[]" type="hidden" value="'+ order.order_products[i].id +'"><input '+style_div+' class="form-control product_search" name="products[]" value="'+ ((order.order_products[i].product && order.order_products[i].product.category) ? (order.order_products[i].product.category.name) : '') + ' - ' + ((order.order_products[i].product && order.order_products[i].product.brand) ? (order.order_products[i].product.brand.name) : '') + ' - ' + ((order.order_products[i].product) ? (order.order_products[i].product.article) : '') +'"><input class="hidden_product_search" type="hidden" name="hidden_product_ids[]" value="'+ ((order.order_products[i].product) ? (order.order_products[i].product.id) : '') +'"></div></div>';
                var priceDiv = '<div class="form-group col-md-4"><input '+style_div+' type="number" class="form-control prices" name="prices[]" required min=0 step="0.01" value="'+ order.order_products[i].price +'"></div>';
                var quantityDiv = '<div class="form-group col-md-3"><input '+style_div+' type="number" class="form-control quantities" name="quantities[]" required step="0.01" value="'+ order.order_products[i].quantity +'"></div>';
                var fieldHTML = startDiv + productDiv + priceDiv + quantityDiv + removeChildDiv + endDiv;

                $('.field_wrapper').prepend(fieldHTML);
                x++;
            }
        }

        initAutocompleteItems(".product_search", "#invoiceOrderModal .ui-widget", product_labels);

        get_order_total('#invoiceOrderModal');

        $('#invoiceOrderModal').modal('show');
    });

    //Add Items
    $('#detailOrderModal').on("click", ".addItem", function(){
    // $('.addItem').on('click', function(){
        // $('#detailOrderModal').modal('hide');
        // $('a[data-id="'+ current_order_id +'"]')[1].click();
    });

    //*** delete ***//
    $('.deleteButton').on('click', function(){
        var id = $(this).data('id');
        $('#deleteForm').attr('action', "{{route('order.update', 1)}}");
        $('#deleteForm .hidden').val(id);

        $('#deleteOrderModalLabel').text('Delete Order: ' + $('.order_id' + id).html() + "?");
        $('#deleteOrderModal').modal('show');
    });

    // detail
    $('.detailButton').on('click', function(){
        var order_id = $(this).data('id');

        fetch_order(order_id);

        // empty wrapper
        $('#table_row_wrapper').html('');
        // loop over retrieved items
        for(var i = 0; i < order.order_products.length; i++)
        {
            var invoiced = 0;
            var is_available_input = (order.order_products[i].is_available == 0) ? ('<input value="'+order.order_products[i].id+'" class="is_available" type="checkbox">') : ('<input value="'+order.order_products[i].id+'" class="is_available" type="checkbox" checked>');
            order.order_products[i].invoiced == 1 ? invoiced = '<i class="fas fa-check green"></i>' : invoiced = '<i class="fas fa-times red"></i>';
            $('#table_row_wrapper').append(' <tr role="row" class="odd"><td>'+ invoiced +'</td><td class="">'+((order.order_products[i].product && order.order_products[i].product.category) ? (order.order_products[i].product.category.name) : '')+'</td><td class="">'+((order.order_products[i].product && order.order_products[i].product.brand) ? (order.order_products[i].product.brand.name) : '')+'</td><td class="">'+((order.order_products[i].product) ? (order.order_products[i].product.article) : '')+'</td><td class="">'+order.order_products[i].quantity+'</td><td class="">'+order.order_products[i].price+'</td><td class="">'+((order.order_products[i].product && order.order_products[i].product.unit) ? (order.order_products[i].product.unit.name) : '')+'</td><td>'+is_available_input+'</td></tr>');
        }

        if(order.image){
            var image_path = $(this).data('image');
            $('.image').attr('src', image_path);
            $('.order_image_wrapper').attr('href', image_path);
            // order_image_wrapper
        }
        else{
            var image_path = '{{asset("img/logo.png")}}';
            $('.image').attr('src', image_path);
            $('.order_image_wrapper').attr('href', image_path);
            // order_image_wrapper
        }

        // master details
        $('#order_id').text(order.id);
        $('#customer_name').text(order.customer ? order.customer.name : '');
        $('#contact_number').text(order.customer ? order.customer.contact_number : '');
        $('#address').text((order.customer ? order.customer.shop_name : '') + ' - Shop # ' + (order.customer ? order.customer.shop_number : '') + ' - Floor # ' + (order.customer ? order.customer.floor : '') + ((order.customer && order.customer.market && order.customer.market.area) ? (' - ' + order.customer.market.name + ' - ' + order.customer.market.area.name) : ''));
        $('#detailTotal').text(order.total);
        $('#status').text(order.status);
        $('#description').text(order.description);

        // ready to dispatch button
        if(order.status != 'ready_to_dispatch' && order.status != 'completed'){
            // show
            $('#detailOrderModal .button_rtd_detail').removeAttr('hidden');
        }
        else{
            // hide
            $('#detailOrderModal .button_rtd_detail').attr('hidden', 'hidden');
        }

        $('#detailOrderModal').modal('show');

    });

    // create*
    $('#add_program').on('click', function(){
        var url = $(this).data('route');

        // empty wrapper
        $('.field_wrapper').html('');

        // append in wrapper
        $('#addOrderModal .field_wrapper').prepend(fieldHTML);

        initAutocompleteItems(".product_search", "#addOrderModal .ui-widget", product_labels);

        // remove required attribute on rider_id
        $("#addOrderModal .rider_id").prop("required", false);

        $('#addOrderModal').modal('show');
    });

    // on button_rtd_detail click
    $('#detailOrderModal').on('click', '.button_rtd_detail', function(){
        ready_to_dispatch(order.id);
        $('#detailOrderModal .button_rtd_detail').attr('hidden', 'hidden');
    });

    // on is_available click
    $('#detailOrderModal').on('click', '.is_available', function(){
        var order_product_id = $(this).val();
        $.ajax({
            url: "<?php echo(route('toggle_is_available')); ?>",
            type: 'GET',
            async: false,
            data: {order_product_id: order_product_id},
            dataType: 'JSON',
            success: function (data) {
                $(this).prop("checked", !$(this).prop("checked"));
            }
        });

    });

    //Once add button is clicked on create*
    $('#addOrderModal').on("click", ".add_button", function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).prepend(fieldHTML); //Add field html

            // initialize autocomplete
            initAutocompleteItems(".product_search", "#addOrderModal .ui-widget", product_labels);
        }
    });

    //Once add button is clicked on edit*
    $('#editOrderModal').on("click", ".add_button", function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).prepend(fieldHTML); //Add field html

            // initialize autocomplete
            initAutocompleteItems(".product_search", "#editOrderModal .ui-widget", product_labels);
        }
    });

    //Once add button is clicked on invoice*
    $('#invoiceOrderModal').on("click", ".add_button", function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).prepend(fieldHTML); //Add field html

            // initialize autocomplete
            initAutocompleteItems(".product_search", "#invoiceOrderModal .ui-widget", product_labels);
        }
    });

    //Once remove button is clicked*
    $('.modal').on("click", ".remove_button", function(e){
        e.preventDefault();
        if(x > minField){
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
            get_order_total('#editOrderModal');
            get_order_total('#addOrderModal');
            get_order_total('#invoiceOrderModal');
            // initAutocompleteItems(".product_search", "#editOrderModal .ui-widget", product_labels);
        }
    });

  });

</script>
@endsection('content_body')
