@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-users"></i> Customers</h1>
  </div>
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
        <!-- <h3 class="card-title">Customers</h3> -->
        <div class="card-tools">
          <button class="btn btn-success" id="add_customer" data-toggle="modal" data-target="#addCustomerModal">
            <i class="fas fa-plus"></i> Add New Customer</button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_customers')}}" class="form-wrapper">
          <div class="row">
              <!-- search bar -->
              <div class="topnav col-md-4">
                <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
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
        <div class="col-md-12">
          <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
            <thead>
              <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Type</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Area</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Market</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Pre-defined sizes: activate to sort column ascending">Contact #</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Business to Date</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Outstanding Balance</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($customers) > 0)
                @foreach($customers as $customer)
                  <tr role="row" class="odd">
                    <td class="{{'name'.$customer->id}}">{{$customer->name}}</td>
                    <td class="{{'type'.$customer->id}}">{{$customer->type}}</td>
                    <td class="{{'area'.$customer->id}}">{{$customer->market && $customer->market->area ? $customer->market->area->name : NULL}}</td>
                    <td class="{{'market'.$customer->id}}">{{$customer->market ? $customer->market->name : NULL}}</td>
                    <td class="{{'contact_number'.$customer->id}}">{{$customer->contact_number ? $customer->contact_number : NULL}}</td>
                    <td class="{{'business_to_date'.$customer->id}}">{{$customer->business_to_date ? $customer->business_to_date : NULL}}</td>
                    <td class="{{'outstanding_balance'.$customer->id}}">{{$customer->outstanding_balance ? $customer->outstanding_balance : NULL}}</td>
                    <td>
                      <!-- Detail -->
                      <a href="#" class="detailButton" data-id="{{$customer->id}}" data-object="{{$customer}}" data-shopkeeper="{{asset('storage/shopkeepers') . '/' . $customer->shop_keeper_picture}}" data-shop="{{asset('storage/shops') . '/' . $customer->shop_picture}}">
                        <i class="fas fa-eye green ml-1"></i>
                      </a>
                      <!-- Edit -->
                      <a href="#" class="editButton" data-id="{{$customer->id}}" data-object="{{$customer}}">
                        <i class="fas fa-edit blue ml-1"></i>
                      </a>
                      <!-- Delete -->
                      <a href="#" class="deleteButton" data-id="{{$customer->id}}" data-object="{{$customer}}">
                        <i class="fas fa-trash red ml-1"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="8"><h6 align="center">No customer(s) found</h6></td></tr>
              @endif
            </tbody>
            <tfoot>
              <!-- <tr>
                <th rowspan="1" colspan="1">Name</th>
                <th rowspan="1" colspan="1">Unit</th>
                <th rowspan="1" colspan="1">Pre-defined Sizes</th>
                <th rowspan="1" colspan="1">Actions</th>
              </tr> -->
            </tfoot>
          </table>
        </div>
      <!-- /.card-body -->
      <div class="card-footer">
        @if(count($customers) > 0)
        {{$customers->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('customer.store')}}" enctype="multipart/form-data">
        @include('admin.customer.customer_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('customer.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.customer.customer_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- TABS -->
            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active bci" data-toggle="tab" href="#bci">Basic Customer Information</a>
              </li> 
              <li class="nav-item" role="presentation" >
                <a class="nav-link" data-toggle="tab" href="#si">Shop Information</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" data-toggle="tab" href="#pi">Payment Information</a>
              </li>
            </ul>
            
            <!-- TAB CONTENT -->
            <div class="tab-content" id="myTabContent">
              <!-- basic customer info -->
              <div class="tab-pane fade show active" id="bci">
                <div class="card-body">
                  <div class="col-md-12">
                    <img class="shop_keeper_picture" src="{{asset('img/logo.png')}}" width="150">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Name</td>
                                <td class="name"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Contact #</td>
                                <td class="contact_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Whatsapp #</td>
                                <td class="whatsapp_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Customer Type</td>
                                <td class="type"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Shop info -->
              <div class="tab-pane fade" id="si">
                <div class="card-body">
                  <div class="col-md-12">
                    <img class="shop_picture" src="{{asset('img/logo.png')}}" width="150">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Shop Name</td>
                                <td class="shop_name"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Shop #</td>
                                <td class="shop_number"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Floor #</td>
                                <td class="floor"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Area</td>
                                <td class="area"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Market</td>
                                <td class="market"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- Payment info -->
              <div class="tab-pane fade" id="pi">
                <div class="card-body">
                  <div class="col-md-12">
                    <hr style="color:gray;">
                    <table class="table table-bordered table-striped">
                        <tbody id="table_row_wrapper">
                            <tr role="row" class="odd">
                                <td class="">Status</td>
                                <td class="status"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Visting Days</td>
                                <td class="visiting_days"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Cash on Delivery</td>
                                <td class="cash_on_delivery"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Opening Balance</td>
                                <td class="opening_balance"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Business to Date</td>
                                <td class="business_to_date"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Outstanding Balance</td>
                                <td class="outstanding_balance"></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="">Special Discount</td>
                                <td class="special_discount"></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteCustomerModalLabel">Delete Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('customer.destroy', 1)}}">
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

<script>
$(document).ready(function(){
  // $('#area_id').select2();
  // $('#market_id').select2();
  // datatable
  // $('#example1').DataTable();
  // $('#example1').dataTable({
  //   "bPaginate": false,
  //   "bLengthChange": false,
  //   "bFilter": true,
  //   "bInfo": false,
  //   "searching":false
  // });

  // global vars
  var customer = "";

  // on ready function calls
  $('.products').select2();

  // adding items dynamically*
  var x = 1; //Initial field counter is 1
  var maxField = 40; //Input fields increment limitation
  var addButton = $('.add_button'); //Add button selector
  var minField = 1; //Input fields decrement limitation
  var removeButton = $('.remove_button'); //Remove button selector
  var wrapper = $('.field_wrapper'); //Input field wrappervar x = 1; //Initial field counter is 1

  // div strings
  var startDiv = '<div class="row">';
  var productDiv = '<div class="col-md-6 form-group"><select name="products[]" class="form-control products" style="width: 100%; max-height: 20px;"><option value="">Select Product</option>@foreach($products as $product)<option value="{{$product->id}}">{{$product->article}}</option>@endforeach</select></div>';
  var amountDiv = '<div class="form-group col-md-5"><input type="number" class="form-control amounts" name="amounts[]" required min=0></div>';
  var removeChildDiv = '<div class="form-group col-md-0 remove_button ml-1" style="display: table; vertical-align: middle;"><a class="btn btn-primary"><i class="fas fa-minus" style="color:white;"></i></a></div>';
  var endDiv = '</div>';
  var fieldHTML = startDiv + productDiv + amountDiv + removeChildDiv + endDiv;

  // fetch markets by area id
  function fetch_specific_markets(area_id){
    $.ajax({
        url: '<?php echo(route("fetch_specific_markets")); ?>',
        type: 'GET',
        data: {area_id: area_id},
        dataType: 'JSON',
        success: function (data) {
          $('.market_id').html('<option value="">Select market</option>');
          for(var i = 0; i < data.length; i++){
            $('.market_id').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
            $('.market_id').fadeIn(200);
          }
          // $('#market_id').select2({
          //   dropdownParent: $('#addCustomerModal')
          // });
        },
        error: function(data){
          $('.market_id').html('<option value="">Select market</option>');
          $('.market_id').fadeOut(200);
          // $('.market_id').select2();
        }
    });
  }

  // fetch customer
  function fetch_customer(id){
    $.ajax({
        url: '<?php echo(route("customer.show", 0)); ?>',
        type: 'GET',
        data: {id: id},
        dataType: 'JSON',
        async: false,
        success: function (data) {
          customer = data.customer;
        }
    });
  }

  // create
  $('#add_customer').on('click', function(){
    // fetch_all_stores();
    // fetch_all_brands();
    // market_id
    $('.market_id').hide();
  });

  // edit
  $('.editButton').on('click', function(){
    $('.market_id').hide();
    var id = $(this).data('id');
    fetch_customer(id);
    // var customer = $(this).data('object');
    $('#hidden').val(id);
    
    $('#editForm .name').val($('.name' + id).html());
    $('#editForm .contact_number').val($('.contact_number' + id).html());
    $('#editForm .whatsapp_number').val(customer.whatsapp_number);
    $('#editForm .type').val(customer.type);

    $('#editForm .shop_name').val(customer.shop_name);
    $('#editForm .shop_number').val(customer.shop_number);
    $('#editForm .floor').val(customer.floor);

    $('#editForm .area_id option[value="'+ customer.market.area.id +'"]').prop('selected', true);
    fetch_specific_markets(customer.market.area.id);
    $('#editForm .market_id option[value="'+ customer.market.id +'"]').prop('selected', true);

    $('#editForm .status option[value="'+ customer.status +'"]').prop('selected', true);
    $('#editForm .visiting_days option[value="'+ customer.visiting_days +'"]').prop('selected', true);
    $('#editForm .cash_on_delivery option[value="'+ customer.cash_on_delivery +'"]').prop('selected', true);

    $('#editForm .opening_balance').val(customer.opening_balance);
    $('#editForm .business_to_date').val(customer.business_to_date);
    $('#editForm .outstanding_balance').val(customer.outstanding_balance);
    $('#editForm .special_discount').val(customer.special_discount);

    $('#editForm .payment_terms').val(customer.payment_terms);

    // children work
    if(customer.special_discounts.length > 0){
      $('.field_wrapper').html('');
      for(var i = 0; i < customer.special_discounts.length; i++){
        $('.field_wrapper').prepend(fieldHTML);
        $('#editCustomerModal .products:first option[value="'+ customer.special_discounts[i].product_id +'"]').prop('selected', true);
        $('#editCustomerModal .amounts:first').val(customer.special_discounts[i].amount);
        $('.products').select2();
      }
    }

    $('#editCustomerModal').modal('show');

  });

  // detail
  $('.detailButton').on('click', function(){
    $('.bci').trigger('click');

    var customer = $(this).data('object');
    
    $('.name').html(customer.name);
    $('.contact_number').html(customer.contact_number);
    $('.whatsapp_number').html(customer.whatsapp_number);
    if(customer.shop_keeper_picture){
      var shop_path = $(this).data('shopkeeper');
      $('.shop_keeper_picture').attr('src', shop_path);
    }
    $('.type').html(customer.type);

    $('.shop_name').html(customer.shop_name);
    $('.shop_number').html(customer.shop_number);
    $('.floor').html(customer.floor);
    $('.area').html(customer.market.area.name);
    $('.market').html(customer.market.name);
    if(customer.shop_picture){
      var shop_path = $(this).data('shop');
      $('.shop_picture').attr('src', shop_path);
    }

    $('.status').html(customer.status);
    $('.visiting_days').html(customer.visiting_days);
    $('.cash_on_delivery').html(customer.cash_on_delivery);
    $('.opening_balance').html(customer.opening_balance);
    $('.business_to_date').html(customer.business_to_date);
    $('.outstanding_balance').html(customer.outstanding_balance);
    $('.special_discount').html(customer.special_discount);

    $('#viewCustomerModal').modal('show');
  });

  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('customer.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);

    $('#deleteCustomerModalLabel').text('Delete Customer: ' + $('.name' + id).html() + "?");
    $('#deleteCustomerModal').modal('show');
  });

  //on area id change
  $('.area_id').on('change', function(){
    var area_id = $(this).val();
    fetch_specific_markets(area_id);
  });

  //Once add button is clicked on create*
  $('#addCustomerModal').on("click", ".add_button", function(){
      //Check maximum number of input fields
      if(x < maxField){ 
          x++; //Increment field counter
          $(wrapper).prepend(fieldHTML); //Add field html

          // initialize autocomplete
          // initAutocompleteItems(".product_search", "#addOrderModal .ui-widget", product_labels);
          $('.products').select2();
      }
  });

  //Once add button is clicked on edit*
  $('#editCustomerModal').on("click", ".add_button", function(){
      //Check maximum number of input fields
      if(x < maxField){ 
          x++; //Increment field counter
          $(wrapper).prepend(fieldHTML); //Add field html

          // initialize autocomplete
          // initAutocompleteItems(".product_search", "#editOrderModal .ui-widget", product_labels);
          $('.products').select2();
      }
  });
    
  //Once remove button is clicked*
  $('.modal').on("click", ".remove_button", function(e){
      e.preventDefault();
      if(x > minField){
          $(this).parent('div').remove(); //Remove field html
          x--; //Decrement field counter
          // get_order_total('#editOrderModal');
          // get_order_total('#addOrderModal');
          // initAutocompleteItems(".product_search", "#editOrderModal .ui-widget", product_labels);
          $('.products').select2();
      }
  });

});
</script>
@endsection('content_body')