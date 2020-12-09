@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Unit</h1>
</div>
<!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Admin</a></li>
      <li class="breadcrumb-item active">Unit</li>
  </ol>
</div>
<!-- /.col -->
</div>

@endsection


@section('content_body')
<!-- Index view -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <!-- <h3 class="">Units</h3> -->
                    <button class="btn btn-success" id="add_program" data-toggle="modal" data-target="#addUnitModal">
                        <i class="fas fa-plus"></i> Add New Unit
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Name</th>
                                <th tabindex="0" rowspan="1" colspan="1" >Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(count($units) > 0)
                            @foreach($units as $unit)
                            <tr role="row" class="odd">
                                <td class="{{'name'.$unit->id}}">{{$unit->name}}</td>
                                <td>
                                    <!-- Edit -->
                                    <a href="#" class="editButton" data-id="{{$unit->id}}">
                                        <i class="fas fa-edit blue ml-1"></i>
                                    </a>
                                    |
                                    <!-- Delete -->
                                    <a href="#" class="deleteButton" data-id="{{$unit->id}}">
                                        <i class="fas fa-trash red ml-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4"><h6 align="center">No unit(s) found</h6></td>
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
             @if(count($units) > 0)
             {{$units->links()}}
             @endif
         </div>
     </div>
 </div>
</div>

<!-- Create view -->
<div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addUnitModalLabel">Add New Unit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="{{route('unit.store')}}">
            @include('admin.unit.unit_master')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="createButton">Create</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editUnitModal" tabindex="-1" role="dialog" aria-labelledby="editUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="editForm" method="POST" action="{{route('unit.update', 1)}}">
            <!-- hidden input -->
            @method('PUT')
            <input id="hidden" type="hidden" name="hidden">
            @include('admin.unit.unit_master')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="createButton">Update</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteUnitModal" tabindex="-1" role="dialog" aria-labelledby="deleteUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteUnitModalLabel">Delete Unit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('unit.destroy', 1)}}">
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
         //*** datatables ***//
         $('#example1').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false,
            "searching":false });

        // edit
        $('.editButton').on('click', function(){
            var id = $(this).data('id');
            $('#editForm').attr('action', "{{route('unit.update', 1)}}");
            $('#hidden').val(id);
            // alert($('#hidden').val());
            
            $('#editForm #name').val($('.name' + id).html());
            $('#editForm #placeholder').val($('.placeholder' + id).html());
            $('#editForm #slug').val($('.slug' + id).html());

            $('#editUnitModal').modal('show');
        });

        // delete
        $('.deleteButton').on('click', function(){
            var id = $(this).data('id');
            $('#deleteForm').attr('action', "{{route('unit.update', 1)}}");
            $('#deleteForm .hidden').val(id);
            
            $('#deleteUnitModalLabel').text('Delete Unit: ' + $('.name' + id).html() + "?");
            $('#deleteUnitModal').modal('show');
        });
    });
</script>
@endsection('content_body')