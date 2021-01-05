@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="fas fa-book nav-icon"></i> Ledgers</h1>
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
        <!-- <h3 class="card-title">Ledgers</h3> -->
        <div class="card-tools">
          <button class="btn btn-success" id="add_ledger" data-toggle="modal" data-target="#addLedgerModal">
            <i class="fas fa-plus"></i> Add New Ledger</button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_ledgers')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Customer</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Amount</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Type</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Transaction Date</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Created By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Modified By</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($ledgers) > 0)
                @foreach($ledgers as $ledger)
                  <tr role="row" class="odd">
                    <td class="{{'customer_id'.$ledger->id}}">{{$ledger->customer ? $ledger->customer->name : NULL}}</td>
                    <td class="{{'amount'.$ledger->id}}">{{$ledger->amount}}</td>
                    <td class="{{'type'.$ledger->id}}">{{$ledger->type}}</td>
                    <td class="{{'transaction_date'.$ledger->id}}">{{return_date($ledger->transaction_date)}}</td>
                    <td class="{{'created_by'.$ledger->id}}">{{return_user_name($ledger->created_by)}}</td>
                    <td class="{{'modified_by'.$ledger->id}}">{{return_user_name($ledger->modified_by)}}</td>
                    <td>
                      <!-- Detail -->
                      <a href="#" class="detailButton" data-id="{{$ledger->id}}">
                        <i class="fas fa-eye green ml-1"></i>
                      </a>
                      <!-- Edit -->
                      <a href="#" class="editButton" data-id="{{$ledger->id}}" data-object="{{$ledger}}">
                        <i class="fas fa-edit blue ml-1"></i>
                      </a>
                      <!-- Delete -->
                      <a href="#" class="deleteButton" data-id="{{$ledger->id}}" data-object="{{$ledger}}">
                        <i class="fas fa-trash red ml-1"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="7"><h6 align="center">No ledger(s) found</h6></td></tr>
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
        @if(count($ledgers) > 0)
        {{$ledgers->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addLedgerModal" tabindex="-1" role="dialog" aria-labelledby="addLedgerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLedgerModalLabel">Add New Ledger</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('ledger.store')}}" enctype="multipart/form-data">
        @include('admin.ledger.ledger_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editLedgerModal" tabindex="-1" role="dialog" aria-labelledby="editLedgerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLedgerModalLabel">Edit Ledger</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('ledger.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.ledger.ledger_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteLedgerModal" tabindex="-1" role="dialog" aria-labelledby="deleteLedgerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteLedgerModalLabel">Delete Ledger</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('ledger.destroy', 1)}}">
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
  $('#add_ledger').on('click', function(){
    // fetch_all_stores();
    // fetch_all_brands();
  });

  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    var ledger = $(this).data('object');
    $('#hidden').val(id);

    $('#editForm #customer_id option[value="'+ ledger.customer_id +'"]').prop('selected', true);
    $('#editForm #amount').val(ledger.amount);
    $('#editForm #type option[value="'+ ledger.type +'"]').prop('selected', true);
    $('#editForm #transaction_date').val(ledger.transaction_date);
    
    $('#editLedgerModal').modal('show');
  });

  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('ledger.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);

    $('#deleteLedgerModalLabel').text('Delete Ledger?');
    $('#deleteLedgerModal').modal('show');
  });

});
</script>
@endsection('content_body')