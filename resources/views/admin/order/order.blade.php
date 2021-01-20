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
                                    <th class="sorting">Punched By</th> 
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
                                        <td class="{{'address'.$order->id}}">{{$order->customer ? ($order->customer->shop_name . ' - ' . $order->customer->market->name . ' - ' . $order->customer->market->area->name) : NULL}}</td>
                                        <td class="{{'total'.$order->id}}">RS.{{$order->total}}</td>
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
                                            <a href="#" class="detailButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
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
                                            <!-- Generate Invoice -->
                                            <a href="#" class="invoiceButton" data-id="{{$order->id}}" data-type="{{$order->id}}">
                                                <i class="fas fa-file-invoice-dollar"></i>
                                            </a>
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
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrderModalLabel">Add New order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="col-md-12" method="POST" action="{{route('order.store')}}">
                @method('POST')
                @include('admin.order.order_master')

                <!-- buttons -->
                <div class="modal-footer">
                    <button name="completed_status" type="submit" class="btn btn-primary" id="createButton">Save</button>
                    <!-- <div class="btn-group">
                        <button name="pending_status" type="submit" class="btn btn-success save_as_pending"><i class="fas fa-clock mr-2 mt-1"></i>Save as pending</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <button name="completed_status" type="submit" class="dropdown-item save_as_completed" href="#"><i class="fas fa-check-double mr-2"></i>Save as completed</button>
                        </div>
                    </div> -->
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
                <input type="hidden" class="hidden" name="hidden">
                @include('admin.order.order_master')
                <!-- buttons -->
                <div class="modal-footer">
                    <button name="completed_status" type="submit" class="btn btn-primary" id="createButton">Update</button>
                    <!-- <div class="btn-group">
                        <button name="pending_status" type="submit" class="btn btn-success save_as_pending"><i class="fas fa-clock mr-2 mt-1"></i>Save as pending</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <button name="completed_status" type="submit" class="dropdown-item save_as_completed" href="#"><i class="fas fa-check-double mr-2"></i>Save as completed</button>
                        </div>
                    </div> -->
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
            <form id="invoiceForm" method="POST" action="{{route('invoice.store')}}">

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
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Invoice Item?</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Category</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Brand</th>
                                        <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">Product</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Quantity</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Price</th>
                                        <th class="sorting" tabindex="0" rowspan="1" colspan="1" >Unit</th>
                                    </tr>
                                </thead>

                                <tbody id="table_row_wrapper">
                                    <tr role="row" class="odd">
                                        <td>yes/no</td>
                                        <td class="">'+order.order_products[i].product.category.name+'</td>
                                        <td class="">'+order.order_products[i].product.brand.name+'</td>
                                        <td class="">'+order.order_products[i].product.article+'</td>
                                        <td class="">'+order.order_products[i].quantity+'</td>
                                        <td class="">'+order.order_products[i].price+'</td>
                                        <td class="">'+order.order_products[i].product.unit.name+'</td>
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
    var priceDiv = '<div class="form-group col-md-4"><input type="number" class="form-control prices" name="prices[]" required min=0></div>';
    var quantityDiv = '<div class="form-group col-md-3"><input type="number" class="form-control quantities" name="quantities[]" required min=0 value=0></div>';
    // var addChildDiv = '<div class="form-group col-md-0 add_button" style="display: table; vertical-align: middle;"><a class="btn btn-primary"><i class="fas fa-plus" style="color:white;"></i></a></div>';
    var removeChildDiv = '<div class="form-group col-md-0 ml-1 remove_button mt-1" style="display: table; vertical-align: middle;"><a class="btn btn-primary"><i class="fas fa-minus" style="color:white;"></i></a></div>';
    var endDiv = '</div>';
    var fieldHTML = startDiv + productDiv + priceDiv + quantityDiv + removeChildDiv + endDiv;
    // var invoice = '<input type="checkbox" class = "mt-2">';

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
            }
        });
    }

    // count order total
    function get_order_total(form){
        var quantities = $(form + ' .quantities');
        var prices = $(form + ' .prices');
        // console.log(quantities, prices);
        var total = 0;
        for(var i = 0; i < prices.length; i++){
            total += ($(form + ' .prices')[i].value * $(form + ' .quantities')[i].value);
        }
        $(form + ' .total').val(total);
        // final_amount
        $(form + ' .final_amount').val(parseInt($(form + ' .total').val()) + parseInt($(form + ' .previous_amount').val()));
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

    // ONCHANGE FUNCTIONS
    $('#addOrderModal').on('change', '.quantities', function(){
        get_order_total('#addOrderModal');
    });
    $('#editOrderModal').on('change', '.quantities', function(){
        get_order_total('#editOrderModal');
    });
    $('#invoiceOrderModal').on('change', '.quantities', function(){
        get_order_total('#invoiceOrderModal');
    });
    // on customer change
    $('.customer_id').on('change', function(){
        var user_id = $(this).val();
        fetch_customer(user_id);
        $('.previous_amount').val(customer.outstanding_balance);
        get_order_total('#editOrderModal');
        get_order_total('#addOrderModal');
        get_order_total('#invoiceOrderModal');
    })
    // on payment change on invoice
    $('#invoiceOrderModal .payment').on('change', function(){
        if($(this).val() == 'credit'){
            $('#invoiceOrderModal .amount_pay').val(0);
            $('#invoiceOrderModal .amount_pay').prop('readonly', true);
            $('#invoiceOrderModal .amount_pay').change();
            return 0;
        }
        $('#invoiceOrderModal .amount_pay').prop('readonly', false);
    })
    // on amount_pay change on invoice
    $('#invoiceOrderModal .amount_pay').on('change', function(){
        $('#invoiceOrderModal .balance_due').val(parseInt($('#invoiceOrderModal .final_amount').val()) - parseInt($('#invoiceOrderModal .amount_pay').val()));
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
                    if(customer.type == "retailer"){
                        $(this).parent().parent().next().find('input').val(ui.item.retailer_selling_price);
                    }
                }

                // console.log(special_discount);
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
        fetch_order($(this).data('id'));
        $('#editOrderModal .hidden').val($(this).data('id'));

        // select customer
        $('#editOrderModal .customer_id option[value="'+ order.customer_id +'"]').prop('selected', true);
        $('#editOrderModal .customer_id').trigger('change.select2'); 
        $('#editOrderModal .customer_id').change();
        // $('#editOrderModal .customer_id').attr("readonly", true);
        // $('#editOrderModal .customer_id').selectmenu();
        // $('#editOrderModal .customer_id').selectmenu('refresh', true);
        $('#editOrderModal .dispatch_date').val(order.dispatch_date);
        
        // remove required attribute on rider_id
        $("#editOrderModal .rider_id").prop("required", false);

        // empty wrapper
        $('.field_wrapper').html('');

        for(var i = 0; i < order.order_products.length; i++){
            var productDiv = '<div class="col-md-4"><div class="ui-widget"><input class="form-control product_search" name="products[]" value="'+ order.order_products[i].product.article +'"><input class="hidden_product_search" type="hidden" name="hidden_product_ids[]" value="'+ order.order_products[i].product.id +'"></div></div>';
            var priceDiv = '<div class="form-group col-md-4"><input type="number" class="form-control prices" name="prices[]" required min=0 value="'+ order.order_products[i].price +'"></div>';
            var quantityDiv = '<div class="form-group col-md-3"><input type="number" class="form-control quantities" name="quantities[]" required min=0  value="'+ order.order_products[i].quantity +'"></div>';
            var fieldHTML = startDiv + productDiv + priceDiv + quantityDiv + removeChildDiv + endDiv;

            $('.field_wrapper').prepend(fieldHTML);
            x++;
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
        $('#invoiceOrderModal .balance_due_wrapper').removeAttr('hidden');
        $('#invoiceOrderModal .rider_wrapper').removeAttr('hidden');

        // hide fields
        $('#invoiceOrderModal .dispatch_date_wrapper').attr('hidden', 'hidden');

        // remove required attribute on dispatch_date
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
        // $('.customer_id').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        $('#invoiceOrderModal .customer_id option[value="'+ order.customer_id +'"]').prop('selected', true);
        $('#invoiceOrderModal .customer_id').trigger('change.select2'); 
        $('#invoiceOrderModal .customer_id').change();
        // $('#invoiceOrderModal .customer_id').selectmenu();
        // $('#invoiceOrderModal .customer_id').selectmenu('refresh', true);

        // payment credit by default
        $('#invoiceOrderModal .payment option[value="credit"]').prop('selected', true);
        $('#invoiceOrderModal .payment').change();

        // empty wrapper
        $('.field_wrapper').html('');

        for(var i = 0; i < order.order_products.length; i++){
            if(order.order_products[i].invoiced == 0){
                var productDiv = '<div class="col-md-4"><div class="ui-widget"><input name="order_products_ids[]" type="hidden" value="'+ order.order_products[i].id +'"><input class="form-control product_search" name="products[]" value="'+ order.order_products[i].product.category.name + ' - ' + order.order_products[i].product.brand.name + ' - ' + order.order_products[i].product.article +'"><input class="hidden_product_search" type="hidden" name="hidden_product_ids[]" value="'+ order.order_products[i].product.id +'"></div></div>';
                var priceDiv = '<div class="form-group col-md-4"><input type="number" class="form-control prices" name="prices[]" required min=0 value="'+ order.order_products[i].price +'"></div>';
                var quantityDiv = '<div class="form-group col-md-3"><input type="number" class="form-control quantities" name="quantities[]" required min=0  value="'+ order.order_products[i].quantity +'"></div>';
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

        fetch_order(order_id);

        // console.log(order);

        // empty wrapper
        $('#table_row_wrapper').html('');
        // loop over retrieved items
        for(var i = 0; i < order.order_products.length; i++)
        {
            var invoiced = 0;
            order.order_products[i].invoiced == 1 ? invoiced = '<i class="fas fa-check green"></i>' : invoiced = '<i class="fas fa-times red"></i>';
            $('#table_row_wrapper').append(' <tr role="row" class="odd"><td>'+ invoiced +'</td><td class="">'+order.order_products[i].product.category.name+'</td><td class="">'+order.order_products[i].product.brand.name+'</td><td class="">'+order.order_products[i].product.article+'</td><td class="">'+order.order_products[i].quantity+'</td><td class="">'+order.order_products[i].price+'</td><td class="">'+order.order_products[i].product.unit.name+'</td></tr>');
        }

        $('#order_id').text(order.id);
        $('#customer_name').text(order.customer.name);
        $('#contact_number').text(order.customer.contact_number);
        $('#address').text(order.customer.shop_name + ' - Shop # ' + order.customer.shop_number + ' - Floor # ' + order.customer.floor + ' - ' + order.customer.market.name + ' - ' + order.customer.market.area.name);
        $('#detailTotal').text(order.total);
        $('#status').text(order.status);

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

        // remove required attribute on rider_id
        $("#addOrderModal .rider_id").prop("required", false);

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