@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Customers</h1>
  </div>
  <!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-customer"><a href="#">Admin</a></li>
      <li class="breadcrumb-customer active">Customers</li>
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
                    <td class="{{'area'.$customer->id}}">{{$customer->market && $customer->market->area ? $customer->market->area->name : NULL}}</td>
                    <td class="{{'market'.$customer->id}}">{{$customer->market ? $customer->market->name : NULL}}</td>
                    <td class="{{'contact_number'.$customer->id}}">{{$customer->contact_number ? $customer->contact_number : NULL}}</td>
                    <td class="{{'business_to_date'.$customer->id}}">{{$customer->business_to_date ? $customer->business_to_date : NULL}}</td>
                    <td class="{{'outstanding_balance'.$customer->id}}">{{$customer->outstanding_balance ? $customer->outstanding_balance : NULL}}</td>
                    <td>
                      <!-- Edit -->
                      <a href="#" class="editButton" data-id="{{$customer->id}}" data-object="{{$customer}}">
                        <i class="fas fa-edit blue ml-1"></i>
                      </a>
                      |
                      <!-- Delete -->
                      <a href="#" class="deleteButton" data-id="{{$customer->id}}" data-object="{{$customer}}">
                        <i class="fas fa-trash red ml-1"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="5"><h6 align="center">No customer(s) found</h6></td></tr>
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
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
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
      <form id="editForm" method="POST" action="{{route('customer.update', 1)}}">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.customer.customer_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Update</button>
        </div>
      </form>
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
  $('#area_id').select2();
  $('#market_id').select2();
  // datatable
  // $('#example1').DataTable();
  $('#example1').dataTable({
    "bPaginate": false,
    "bLengthChange": false,
    "bFilter": true,
    "bInfo": false,
    "searching":false
  });
  // $('.js-example-basic-multiple').select2();

  // fetch markets by area id
  function fetch_specific_markets(area_id){
    $.ajax({
        url: '<?php echo("fetch_specific_markets"); ?>',
        type: 'GET',
        data: {area_id: area_id},
        dataType: 'JSON',
        success: function (data) {
          $('.market_id').html('<option value="">Select market</option>');
          for(var i = 0; i < data.length; i++){
            $('.market_id').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
          }
          $('#market_id').select2({
            dropdownParent: $('#addCustomerModal')
          });
        },
        error: function(data){
          $('.market_id').html('<option value="">Select market</option>');
          $('.market_id').select2();
        }
    });
  }
  // fetch all stores and populate
  // function fetch_all_stores(){
  //   $.ajax({
  //       url: '',
  //       type: 'GET',
  //       // data: {id: id},
  //       dataType: 'JSON',
  //       success: function (data) {
  //         $('.store_wrapper').html('');
  //         for(var i = 0; i < data.length; i++){
  //           $('.store_wrapper').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
  //         }
  //         $('.store_wrapper').select2();
  //       }
  //   });
  // }

  // fetch specific stores and select
  // function fetch_specific_stores(customer_id){
  //   // fetch stores and populate
  //   fetch_all_stores();
  //   $.ajax({
  //       url: '',
  //       type: 'GET',
  //       data: {id: customer_id},
  //       dataType: 'JSON',
  //       success: function (data) {
  //         for(var i = 0; i < data.length; i++){
  //           $('.store_wrapper option[value="'+ data[i].id +'"]').prop('selected', true);
  //         }
  //         $('.store_wrapper').select2();
  //       }
  //   });
  // }

  // create
  $('#add_customer').on('click', function(){
    // fetch_all_stores();
    // fetch_all_brands();
  });

  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    var customer = $(this).data('object');
    $('#hidden').val(id);
    console.log(customer);
    
    $('#editForm #name').val($('.name' + id).html());
    $('#editForm #contact_number').val($('.contact_number' + id).html());
    $('#editForm #area_id option[value="'+ customer.market.area.id +'"]').prop('selected', true);
    fetch_specific_markets(customer.market.area.id);
    $('#editForm #market_id option[value="'+ customer.market.id +'"]').prop('selected', true);
    $('#editForm #business_to_date').val($('.business_to_date' + id).html());
    $('#editForm #outstanding_balance').val($('.outstanding_balance' + id).html());

    

    $('#editCustomerModal').modal('show');
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

});
</script>
@endsection('content_body')