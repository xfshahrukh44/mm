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
                    <!-- <h3 class="">Orders</h3> -->
                    <button class="btn btn-success testbtn" id="add_program" data-route="{{route('order.store')}}"">
                        <i class="fas fa-plus"></i> Add New Order
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Order ID: activate to sort column ascending"><i  class="fa fa-arrow-up arrow_up_down"></i><i class="fa fa-arrow-down arrow_up_down"></i>Order ID</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Date</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Customer Name: activate to sort column ascending">Customer Name</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Phone</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending">Total</th>
                              <th class="sorting " tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status <i class="fa fa-arrow-up arrow_up_down"></i><i class="fa fa-arrow-down arrow_up_down"></i></th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending">Rider</th>
                                @can('isSuperAdmin')
                                    <th class="sorting">Created By</th> 
                                    <th class="sorting">Modified By</th> 
                                @endcan
                              <!-- <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">Items</th> -->
                              <th tabindex="0" rowspan="1" colspan="1">Actions</th>
                          </tr>
                        </thead>

                        <tbody>
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                    <tr role="row" class="odd">
                                        <td class="{{'order_id'.$order->id}}">{{$order->id}}</td>
                                        <td class="{{'total'.$order->id}}">{{$order->created_at ? return_date($order->created_at) : NULL}}</td>
                                        <td class="{{'customer_id'.$order->id}}" data-id="{{$order->customer_id}}" data-object="{{$order->customer ? $order->customer : NULL}}">
                                            <a href="#" class="viewProfileButton" data-id="{{$order->customer_id}}" data-type="{{$order->customer ? $order->customer->type : NULL}}" data-route="{{$order->customer ? route('customer.show',$order->customer->id) : '#'}}">
                                                {{$order->customer ? $order->customer->name : NULL}}
                                            </a>
                                        </td>
                                        <td class="{{'contact_number'.$order->id}}">{{$order->customer ? $order->customer->contact_number : NULL}}</td>
                                        <td class="{{'address'.$order->id}}">{{$order->customer->shop_name . ' - ' . $order->customer->market->name . ' - ' . $order->customer->market->area->name}}</td>
                                        <td class="{{'total'.$order->id}}">{{$order->order_total}} pkr</td>
                                        <td class="{{'status'.$order->id}} text-center">

                                            @if ($order->status == "pending")
                                                <span class="badge badge-pill badge-warning" style="font-size: 0.9rem; color: white;">Pending</span>
                                                <!-- <i class="fa fa-circle text-warning"></i>
                                                {{$order->status}} -->
                                            @else
                                                <span class="badge badge-pill badge-success" style="font-size: 0.9rem; color: white;">Completed</span>
                                                <!-- <i class="fa fa-circle text-success"></i> -->
                                                <!-- {{$order->status}} -->
                                            @endif

                                            <!--  {{$order->status}} -->
                                        </td>
                                        <td class="{{'rider'.$order->id}}">{{return_user_name($order->rider_id)}}</td>
                                        @can('isSuperAdmin')
                                            <td>{{return_user_name($order->created_by)}}</td>
                                            <td>{{return_user_name($order->modified_by)}}</td>
                                        @endcan
                                        <td>
                                            <!-- Detail -->
                                            <a href="#" class="detailButton" data-id="{{$order->id}}" data-type="{{$order->id}}" data-order="{{$order}}">
                                                <i class="fas fa-shopping-basket blue ml-1"></i>
                                            </a>
                                            <!-- Edit -->

                                                <a href="#" class="editButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
                                                    <i class="fas fa-edit blue ml-1"></i>
                                                </a>
                                            @can('isSuperAdmin')
                                                <!-- Delete -->
                                                <a href="#" class="deleteButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
                                                    <i class="fas fa-trash red ml-1"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=11><h6 align="center">No order(s) found</h6></td>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrderModalLabel">Add New order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="col-md-12" method="POST" action="{{route('order.store')}}">
                @method('POST')
                
                <div class="upper_section row">
                    <!-- customer_id -->
                    <div class="col-md-12 p-3 ">
                        <div class="form-group">
                            <label for=""><i class="nav-icon fas fa-users"></i> Customer</label>
                            <select name="customer_id" required class="form-control customer_id" style="width: 100%;">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- total -->
                    <div class="col-md-4 p-3">
                        <div class="form-group">
                            <label>Current Amount</label>
                            <input id="total" type="number" name="total" class="total form-control" min=0 readonly style="background-color: white; border:none;" value=0>
                        </div>
                    </div>

                    <!-- previous_amount -->
                    <div class="col-md-4 p-3">
                        <div class="form-group">
                            <label>Previous Amount</label>
                            <input id="previous_amount" type="number" name="previous_amount" class="previous_amount form-control" min=0 readonly style="background-color: white; border:none;" value=0>
                        </div>
                    </div>

                    <!-- final_amount -->
                    <div class="col-md-4 p-3">
                        <div class="form-group">
                            <label>Final Amount</label>
                            <input id="final_amount" type="number" name="final_amount" class="final_amount form-control" min=0 readonly style="background-color: white; border:none;" value=0>
                        </div>
                    </div>
                    
                </div>

                <hr>
                @include('admin.order.order_master')

                <!-- buttons -->
                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-primary" id="createButton">Update</button> -->
                    <div class="btn-group">
                        <button name="pending_status" type="submit" class="btn btn-success save_as_pending"><i class="fas fa-clock mr-2 mt-1"></i>Save as pending</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <button name="completed_status" type="submit" class="dropdown-item save_as_completed" href="#"><i class="fas fa-check-double mr-2"></i>Save as completed</button>
                        </div>
                    </div>
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
            <form id="editForm" method="POST" action="{{route('order.update', 1)}}">
                <!-- hidden input -->
                @method('PUT')
                <input id="hidden" type="hidden" name="hidden" class="hidden">
                <input class="order_type" type="hidden" name="order_type">

                <!-- customer_id -->
                <div class="col-md-4 p-3 ">
                    <div class="form-group">
                        <label for="">Customer:</label>
                        <select name="user_id" required class="form-control customer_id">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- order_date -->
                <div class="col-md-4 p-3 ">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input name="order_date" class="form-control order_date" id="order_date" type="date">
                    </div>
                </div>
                @include('admin.order.order_master')

                <!-- order_total -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <label class="mr-5 pr-5">Total</label>
                            <input id="edit_order_total" type="number" name="order_total" class=" col-md-3 form-control mb-3" style="float: right;positon:relative;right:8%;" min=0>
                        </div>
                    </div>
                </div>

                <!-- rider_charges -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <label class="mr-5 pr-5">Rider Charges</label>
                            <input id="edit_rider_charges" type="number" name="rider_charges" class=" col-md-3 form-control mb-3" style="float: right;positon:relative;right:8%;" min=0>
                        </div>
                    </div>
                </div>

                <!-- rider_id -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 form-group" align="right">
                            <label class="mr-5 pr-5">Rider</label>
                            <!-- <input id="rider_charges" type="number" name="rider_charges" class=" col-md-3 form-control mb-3" style="float: right;positon:relative;right:8%;" min=0> -->
                            <select class=" col-md-3 form-control mb-3 rider_id_wrapper" name="rider_id" id="edit_rider_id" style="float: right;positon:relative;right:8%;">
                                <option value="">--Select Rider--</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-primary" id="createButton">Update</button> -->
                    <div class="btn-group">
                        <button name="pending_status" type="submit" class="btn btn-success">Save as pending</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <button name="completed_status" type="submit" class="dropdown-item" href="#">Save as completed</button>
                        </div>
                    </div>
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
            <div class="modal-header">
                <h5 class="modal-title" id="detailOrderModalLabel">Order details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                </table>
                <div class="col-md-12">
                    <!-- MASTER INFO -->
                    <!-- Order id -->
                    <br>
                    <a href="#" class="addItem float-right " data-id="">
                        <i class="fas fa-plus-circle blue ml-1"></i> Add Item
                    </a>
                    <br>
                    <br>
                    <div class="row">
                        <!-- CHILD INFO -->
                        <table id="itemTable" class="table table-bordered table-hover dtr-inline" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">Product</th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Brand</th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Category</th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Quantity</th>
                                    <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Unit</th>
                                </tr>
                            </thead>

                            <tbody id="table_row_wrapper">
                                <tr role="row" class="odd">
                                    <td class="">Item name</td>
                                    <td class="">Brand</td>
                                    <td class="">Category</td>
                                    <td class="">Quantity</td>
                                    <td class="">Unit</td>
                                </tr>
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
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
            <div class="card-body">
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
    // on ready functions
    $('.customer_id').select2();
    fetch_product_labels();

    // GLLOBAL VARS
    var product_labels = "";
    var product = "";
    var customer = "";
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
    var priceDiv = '<div class="form-group col-md-4"><input type="number" class="form-control prices" name="prices[]" required min=0></div>';
    var quantityDiv = '<div class="form-group col-md-3"><input type="number" class="form-control quantities" name="quantities[]" required min=0 value=0></div>';
    // var addChildDiv = '<div class="form-group col-md-0 add_button" style="display: table; vertical-align: middle;"><a class="btn btn-primary"><i class="fas fa-plus" style="color:white;"></i></a></div>';
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
            }
        });
    }

    // count order total
    function get_order_total(){
        var quantities = $('.quantities');
        var prices = $('.prices');
        // console.log(quantities, prices)
        var total = 0;
        for(var i = 0; i < prices.length; i++){
            total += ($('.prices')[i].value * $('.quantities')[i].value);
        }
        $('#total').val(total);
        // final_amount
        $('#final_amount').val(parseInt($('#total').val()) + parseInt($('#previous_amount').val()));
    }

    // ONCHANGE FUNCTIONS
    $('#addOrderModal').on('change', '.quantities', function(){
        get_order_total();
    });
    // on customer change
    $('.customer_id').on('change', function(){
        var user_id = $(this).val();
        fetch_customer(user_id);
        console.log(customer.name);
        $('#previous_amount').val(customer.outstanding_balance);
    })

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
                $(this).val(ui.item.label);
                $(this).siblings('input').val(ui.item.value);
                $(this).parent().parent().next().find('input').val(ui.item.price);

                fetch_product(ui.item.value);
                console.log(product);



                // var item_id = ui.item.value;
                // var category_input = $(this).closest('.row').find('.category_search');
                // var hidden_category_input = $(this).closest('.row').find('.hidden_category_search');
                // var brand_input = $(this).closest('.row').find('.brand_search');
                // var hidden_brand_input = $(this).closest('.row').find('.hidden_brand_search');
                // var unit_input = $(this).closest('.row').find('.unit_search');
                // var hidden_unit_input = $(this).closest('.row').find('.hidden_unit_search');

                // category
                // $.ajax({
                //     url: 'static',
                //     type: 'GET',
                //     data: {id: item_id},
                //     dataType: 'JSON',
                //     success: function (data) {
                //         category_input.val(data.name);
                //         hidden_category_input.val(data.id);
                //     },
                //     error: function(){
                //         category_input.val("");
                //         hidden_category_input.val("");
                //         // initAutocomplete(".category_search", data.new_categories);
                //     }
                // });

                // brand
                // $.ajax({
                //     url: 'static',
                //     type: 'GET',
                //     data: {id: item_id},
                //     dataType: 'JSON',
                //     success: function (data) {
                //         initAutocomplete(brand_input, wrapper, data);
                //     },
                //     error: function(){
                //         brand_input.val("");
                //         hidden_brand_input.val("");
                //         initAutocomplete(brand_input, wrapper, []);
                //     }
                // });

                // unit
                // $.ajax({
                //     url: 'static',
                //     type: 'GET',
                //     data: {id: item_id},
                //     dataType: 'JSON',
                //     success: function (data) {
                //         if(data.length == 1){
                //             unit_input.val(data[0].label);
                //             hidden_unit_input.val(data[0].value);
                //             unit_input.prop("readonly", true);
                //         }
                //         else{
                //             initAutocomplete(unit_input, wrapper, data);
                //             unit_input.prop("readonly", false);
                //         }
                //     },
                //     error: function(){
                //         unit_input.val("");
                //         hidden_unit_input.val("");
                //         initAutocomplete(unit_input, wrapper, []);
                //     }
                // });

                return false;
            },
        });
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
        if(current_order_id == 0){
            var order_id = $(this).data('id');
            var url = $(this).data('route');
        }
        else{
            var order_id = current_order_id;
            var url = 'static';
        }
        // var order_id = $(this).data('id');
        $('.hidden').val(order_id);

        // fetch data for children
        $.ajax({
            url: url,
            type: 'GET',
            data: {order_id: order_id},
            dataType: 'JSON',
            success: function (data) {
                var fetch_items_url = 'static';

                // empty wrapper
                $('.field_wrapper').html('');
                // loop over retrieved items
                for(var i = 0; i < data.items.length; i++)
                {
                    var productDiv = '<div class="col-md-2"><div class="ui-widget"><input class="form-control item_search" name="items[]" value="'+data.items[i].item.name+'"><input class="hidden_item_search" type="hidden" name="hidden_item_ids[]" value="'+data.items[i].item.id+'"></div></div>';
                    var brandDiv = '<div class="col-md-2"><div class="ui-widget"><input class="form-control brand_search" name="brands[]" value="'+data.items[i].brand+'"><input class="hidden_brand_search" type="hidden" name="hidden_brand_ids[]" value="'+data.items[i].brand_id+'"></div></div>';
                    var categoryDiv = '<div class="col-md-2"><div class="ui-widget"><input class="form-control category_search" name="categories[]" value="'+data.items[i].category+'"><input class="hidden_category_search" type="hidden" name="hidden_category_ids[]" value="'+data.items[i].category_id+'"></div></div>';
                    var storeDiv = '<div class="col-md-2"><div class="ui-widget"><input class="form-control store_search" name="stores[]" value="'+data.items[i].store+'"><input class="hidden_store_search" type="hidden" name="hidden_store_ids[]" value="'+data.items[i].store_id+'"></div></div>';
                    var quantityDiv = '<div class="form-group col-md-1"><input type="number" class="form-control" name="quantities[]" required min=0 value="'+data.items[i].quantity+'"></div>';

                    var unitDiv = '<div class="col-md-1"><div class="ui-widget"><input class="form-control unit_search" name="units[]" value="'+data.items[i].new_unit+'"><input class="hidden_unit_search" type="hidden" name="hidden_unit_ids[]" value="'+data.items[i].new_unit_id+'"></div></div>';


                    var fieldHTML = startDiv + productDiv + brandDiv + categoryDiv + storeDiv + quantityDiv + unitDiv + addChildDiv + removeChildDiv + endDiv;
                    
                    $('.field_wrapper').prepend(fieldHTML);
                }
                
                // fetch items
                // item
                initAutocompleteItems(".item_search", '#editOrderModal .ui-widget', data.new_items);
                // brand
                // initAutocomplete(".brand_search", '#editOrderModal .ui-widget', data.new_brands);
                // category
                // initAutocomplete(".category_search", '#editOrderModal .ui-widget', data.new_categories);
                // store
                initAutocomplete(".store_search", '#editOrderModal .ui-widget', data.new_stores);

                $('#editOrderModal').modal('show');
                current_order_id = 0;
            }
        });

        // 3 fields
        $.ajax({
            url: 'static',
            type: 'GET',
            data: {id: order_id},
            dataType: 'JSON',
            success: function (data) {
                $('#edit_order_total').val(data.order_total);
                $('#edit_rider_charges').val(data.rider_charges);
                $('.customer_id option[value="'+ data.user_id +'"]').prop('selected', true);
                $('.customer_id').change();
                $('#edit_rider_id option[value="'+ data.rider_id +'"]').prop('selected', true);
                $('.order_date').val(data.order_date);
            }
        });
    });

    //Add Items
    $('#detailOrderModal').on("click", ".addItem", function(){
    // $('.addItem').on('click', function(){
        $('#detailOrderModal').modal('hide');
        $('a[data-id="'+ current_order_id +'"]')[1].click();
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
        
        // fetch_order_products


        // fetch data
        $.ajax({
            url: `<?php echo(route('order.show', 1)); ?>`,
            type: 'GET',
            data: {order_id: order_id},
            dataType: 'JSON',
            success: function (data) {
                // empty wrapper
                $('#table_row_wrapper').html('');

                console.log(data.order);
                // loop over retrieved items
                for(var i = 0; i < data.order.order_products.length; i++)
                {
                    $('#table_row_wrapper').append('<tr role="row" class="odd"><td class="">'+data.order.order_products[i].product.article+'</td><td class="">'+data.order.order_products[i].product.brand.name+'</td><td class="">'+data.order.order_products[i].product.category.name+'</td><td class="">'+data.order.order_products[i].quantity+'</td><td class="">'+data.order.order_products[i].product.unit.name+'</td></tr>');
                }

                $('#order_id').text(data.order.id);
                $('#customer_name').text(data.order.customer.name);
                $('#contact_number').text(data.order.customer.contact_number);
                $('#address').text(data.order.customer.shop_name + ' - Shop # ' + data.order.customer.shop_number + ' - Floor # ' + data.order.customer.floor + ' - ' + data.order.customer.market.name + ' - ' + data.order.customer.market.area.name);
                $('#detailTotal').text(data.order.total);
                $('#status').text(data.order.status);
                // if(data.order.status != 'completed'){
                //     $('.addItem').show();
                // }
                // else{
                //     $('.addItem').hide();
                // }
                
                // re init select2
                // $('.js-example-basic-single').select2({
                //     width: 'resolve'
                // });
                // $('select').selectpicker();
            }
        });

        $('#detailOrderModal').modal('show');

        // append in table_row_wrapper empty first
        // $('#table_row_wrapper').child('td').remove();

    });

    // create*
    $('#add_program').on('click', function(){
        var url = $(this).data('route');

        // empty wrapper
        $('.field_wrapper').html('');
        
        // append in wrapper
        $('#addOrderModal .field_wrapper').prepend(fieldHTML);

        initAutocompleteItems(".product_search", "#addOrderModal .ui-widget", product_labels);

        $('#addOrderModal').modal('show');
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
        var url = $(this).data('route');

        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).prepend(fieldHTML); //Add field html

            $.ajax({
                url: 'static',
                type: 'GET',
                data: {order_id: '1'},
                dataType: 'JSON',
                success: function (data) {
                    // fetch items
                    // item
                    initAutocompleteItems(".item_search", '#editOrderModal .ui-widget', data.new_items);
                    // brand
                    // initAutocomplete(".brand_search", '#editOrderModal .ui-widget', data.new_brands);
                    // category
                    // initAutocomplete(".category_search", '#editOrderModal .ui-widget', data.new_categories);
                    // store
                    initAutocomplete(".store_search", '#editOrderModal .ui-widget', data.new_stores);
                }
            }); 
        }
    });
    
    //Once remove button is clicked*
    $('.modal').on("click", ".remove_button", function(e){
        e.preventDefault();
        if(x > minField){
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
            get_order_total();
        }
    });
    
  });

</script>
@endsection('content_body')