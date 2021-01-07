@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fas fa-sign-in-alt"></i> Stock In</h1>
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
        <!-- <h3 class="card-title">StockIns</h3> -->
        <div class="card-tools">
          <button class="btn btn-success" id="add_stockIn" data-toggle="modal" data-target="#addStockInModal">
            <i class="fas fa-plus"></i> Add New StockIn</button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_stockIns')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Product</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Quantity</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Transaction Date</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Created By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Modified By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($stockIns) > 0)
                @foreach($stockIns as $stockIn)
                  <tr role="row" class="odd">
                    <td class="{{'product_id'.$stockIn->id}}">{{$stockIn->product ? $stockIn->product->category->name . ' - ' . $stockIn->product->brand->name . ' - ' . $stockIn->product->article : NULL}}</td>
                    <td class="{{'quantity'.$stockIn->id}}">{{$stockIn->quantity}}</td>
                    <td class="{{'transaction_date'.$stockIn->id}}">{{return_date($stockIn->created_at)}}</td>
                    <td class="{{'created_by'.$stockIn->id}}">{{return_user_name($stockIn->created_by)}}</td>
                    <td class="{{'modified_by'.$stockIn->id}}">{{return_user_name($stockIn->modified_by)}}</td>
                    <td>
                      <!-- Detail -->
                      <a href="#" class="detailButton" data-id="{{$stockIn->id}}">
                        <i class="fas fa-eye green ml-1"></i>
                      </a>
                      <!-- Edit -->
                      <a href="#" class="editButton" data-id="{{$stockIn->id}}" data-object="{{$stockIn}}">
                        <i class="fas fa-edit blue ml-1"></i>
                      </a>
                      <!-- Delete -->
                      <a href="#" class="deleteButton" data-id="{{$stockIn->id}}" data-object="{{$stockIn}}">
                        <i class="fas fa-trash red ml-1"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="6"><h6 align="center">No stockIn(s) found</h6></td></tr>
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
        @if(count($stockIns) > 0)
        {{$stockIns->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addStockInModal" tabindex="-1" role="dialog" aria-labelledby="addStockInModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStockInModalLabel">Add New Stock In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('stock_in.store')}}" enctype="multipart/form-data">
        @include('admin.stockIn.stockIn_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editStockInModal" tabindex="-1" role="dialog" aria-labelledby="editStockInModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStockInModalLabel">Edit Stock In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('stock_in.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.stockIn.stockIn_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteStockInModal" tabindex="-1" role="dialog" aria-labelledby="deleteStockInModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteStockInModalLabel">Delete Stock In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('stock_in.destroy', 1)}}">
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

  // create
  $('#add_stockIn').on('click', function(){
    // fetch_all_stores();
    // fetch_all_brands();
  });

  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    var stockIn = $(this).data('object');
    $('#hidden').val(id);

    $('#editForm #product_id option[value="'+ stockIn.product_id +'"]').prop('selected', true);
    $('#editForm #quantity').val(stockIn.quantity);
    $('#editForm #transaction_date').val(stockIn.transaction_date);
    
    $('#editStockInModal').modal('show');
  });

  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('stock_in.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);

    $('#deleteStockInModalLabel').text('Delete Stock In?');
    $('#deleteStockInModal').modal('show');
  });

});
</script>
@endsection('content_body')