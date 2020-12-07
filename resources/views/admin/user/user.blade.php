@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    @if($user_type == 'staff')
    <h1 class="m-0 text-dark">Staff</h1>
    @elseif($user_type == 'rider')
    <h1 class="m-0 text-dark">Riders</h1>
    @else
    <h1 class="m-0 text-dark">Customers</h1>
    @endif
    
</div>
<!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Admin</a></li>
      <li class="breadcrumb-item"><a href="#">Users</a></li>
      @if($user_type == 'staff')
      <li class="breadcrumb-item active">Staff</li>
      @elseif($user_type == 'rider')
      <li class="breadcrumb-item active">Riders</li>
      @else
      <li class="breadcrumb-item active">Customers</li>
      @endif  
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
              <!-- <h3 class="card-title">Items</h3> -->
              <div class="card-tools">
                @if($user_type == 'staff')
                    @can('isSuperAdmin')
                        <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addUserModal">
                            <i class="fas fa-plus"></i> Add New Staff
                        </button>
                    @endcan
                @elseif($user_type == 'rider')
                    <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-plus"></i> Add New Rider
                    </button>
                @else
                    <button class="btn btn-success" id="add_item" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-plus"></i> Add New Customer
                    </button>
                 @endif
             </div>
             <!-- search bar -->
             <form action="{{route('search_users')}}" class="form-wrapper">
                <div class="row">
                    <!-- search bar -->
                    <div class="topnav col-md-4">
                        <input name="query" class="form-control" id="search_content" type="text" placeholder="Search..">
                        @if($user_type == 'staff')
                            <input name="user_type" type="hidden" value="staff">
                        @elseif($user_type == 'rider')
                            <input name="user_type" type="hidden" value="rider">
                        @else
                            <input name="user_type" type="hidden" value="customer">
                        @endif
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
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Profile picture: activate to sort column ascending">Profile Picture</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Full Name: activate to sort column ascending">Full Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Phone</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                            @if($user_type == 'customer')
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Zone: activate to sort column ascending">Zone</th>
                            @endif
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Email Address: activate to sort column ascending">Email Address</th>
                            @if($user_type == 'customer')
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Baskets: activate to sort column ascending">Baskets</th>
                            @endif
                            @if($user_type == 'staff')
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Baskets: activate to sort column ascending">Role</th>
                            @endif
                            @if($user_type == 'rider')
                            <th class="sorting" tabindex="1" aria-controls="example1" rowspan="1" colspan="1" aria-label="Baskets: activate to sort column ascending">Zones</th>
                            @endif
                            <th class="sorting" tabindex="1" aria-controls="example1" rowspan="1" colspan="1" aria-label="Registration Date: activate to sort column ascending">Registration Date</th>
                            <th class="sorting" tabindex="1" aria-controls="example1" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(count($users) > 0)
                        @foreach($users as $user)
                        <tr role="row" class="odd">
                            <!-- picture -->
                            @if($user->profile_picture == null)
                            <td class="{{'profile_picture'.$user->id}}"><img width="50" src="{{asset('img/logo.png')}}"/></td>
                            @else
                            <td class="{{'profile_picture'.$user->id}}"><img width="50" src="{{asset($user->profile_picture)}}"/></td>
                            @endif

                            <!-- name -->
                            <td class="{{'name'.$user->id}}">{{$user->name}}</td>

                            <!-- phone -->
                            @if($user->phone == null)
                            <td class="{{'phone'.$user->id}}">---</td>
                            @else
                            <td class="{{'phone'.$user->id}}">{{$user->phone}}</td>
                            @endif

                            <!-- address -->
                            @if($user->address == null)
                            <td class="{{'address'.$user->id}}">---</td>
                            @else
                            <td class="{{'address'.$user->id}}">{{$user->address}}</td>
                            @endif

                            <!-- zone_id -->
                            @if($user_type == 'customer')
                            <td class="{{'zone'.$user->id}}" data-id="{{$user->zone ? $user->zone->id : 0}}">
                                {{$user->zone ? $user->zone->name : 0}}
                            </td>
                            @endif

                            <!-- email -->
                            @if($user->email == null)
                            <td class="{{'email'.$user->id}}">---</td>
                            @else
                            <td class="{{'email'.$user->id}}">{{$user->email}}</td>
                            @endif

                            <!-- customer's baskets -->
                            @if($user_type == 'customer')
                            <td class="{{'customer'.$user->id}}">
                                <a href="#">{{count($user->baskets)}}</a>
                            </td>
                            @endif

                            <!-- staff's type -->
                            @if($user_type == 'staff')
                            <td class="{{'type'.$user->id}}">{{$user->type}}</td>
                            @endif

                            <!-- riders' zones -->
                            @if($user_type == 'rider')
                            <td class="{{'type'.$user->id}}">
                                @foreach($user->user_zones as $user_zone)
                                {{$user_zone->zone->name}}
                                @if (!$loop->last)
                                ,
                                @endif
                                @endforeach
                            </td>
                            @endif

                            @if($user->created_at == null)
                            <td class="{{'created_at'.$user->id}}">---</td>
                            @else
                            <td class="{{'created_at'.$user->id}}">{{return_date($user->created_at)}}</td>
                            @endif

                            <td>
                                <!-- View Profile -->
                                <a href="#" class="viewProfileButton" data-id="{{$user->id}}" data-type="{{$user_type}}" data-route="{{route('user.show',$user->id)}}">
                                    <i class="fas fa-user green ml-1"></i>
                                </a>
                                @if($user_type == 'staff')
                                    @if($user->id == Auth::user()->id || Gate::check('isSuperAdmin'))
                                        |
                                        <!-- Edit -->
                                        <a href="#" class="editButton" data-id="{{$user->id}}" data-type="{{$user_type}}">
                                            <i class="fas fa-edit blue ml-1"></i>
                                        </a>
                                        |
                                        <!-- Delete -->
                                        <a href="#" class="deleteButton" data-id="{{$user->id}}" data-type="{{$user_type}}">
                                            <i class="fas fa-trash red ml-1"></i>
                                        </a>
                                    @endif
                                @else
                                        |
                                        <!-- Edit -->
                                        <a href="#" class="editButton" data-id="{{$user->id}}" data-type="{{$user_type}}">
                                            <i class="fas fa-edit blue ml-1"></i>
                                        </a>
                                        @can('isSuperAdmin')
                                            |
                                            <!-- Delete -->
                                            <a href="#" class="deleteButton" data-id="{{$user->id}}" data-type="{{$user_type}}">
                                                <i class="fas fa-trash red ml-1"></i>
                                            </a>
                                        @endcan
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="9"><h6 align="center">No record(s) found</h6></td></tr>
                        @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         @if(count($users) > 0)
         {{$users->appends(request()->except('page'))->links()}}
         @endif
     </div>
 </div>
</div>
</div>

<!-- Profile view -->
<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if($user_type == 'staff')
                <h5 class="modal-title">Staff Profile</h5>
                @elseif($user_type == 'rider')
                <h5 class="modal-title">Rider Profile</h5>
                @else
                <h5 class="modal-title">Customer Profile</h5>
                @endif
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
                        @if($user_type == 'rider')
                        <tr role="row" class="odd">
                            <td class="">Zones</td>
                            <td class="zones"></td>
                        </tr>
                        @endif
                        @if($user_type == 'customer')
                        <tr role="row" class="odd">
                            <td class="">Zone</td>
                            <td class="zone"></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create view -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                @if($user_type == 'customer')
                <h5 class="modal-title" id="addUserModalLabel">Add New Customer</h5>
                @elseif($user_type == 'rider')
                <h5 class="modal-title" id="addUserModalLabel">Add New Rider</h5>
                @else
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('user.store')}}">
                @include('admin.user.user_master')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="createButton">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            @if($user_type == 'customer')
            <h5 class="modal-title" id="editUserModalLabel">Edit Customer</h5>
            @elseif($user_type == 'rider')
            <h5 class="modal-title" id="editUserModalLabel">Edit Rider</h5>
            @else
            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
            @endif
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="editForm" method="POST" action="{{route('user.update', 1)}}">
            <!-- hidden input -->
            @method('PUT')
            <input id="hidden" type="hidden" name="hidden">
            <input class="user_type" type="hidden" name="user_type">
            @include('admin.user.user_master')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="createButton">Update</button>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            @if($user_type == 'customer')
            <h5 class="modal-title" id="deleteUserModalLabel">Delete Customer</h5>
            @elseif($user_type == 'rider')
            <h5 class="modal-title" id="deleteUserModalLabel">Delete Rider</h5>
            @else
            <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
            @endif
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="deleteForm" method="POST" action="{{route('user.destroy', 1)}}">
            <!-- hidden input -->
            @method('DELETE')
            @csrf
            <input class="hidden" type="hidden" name="hidden">
            <input class="user_type" type="hidden" name="user_type">
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
        // $('#example1').dataTable({
        //     "bPaginate": false,
        //     "bLengthChange": false,
        //     "bFilter": true,
        //     "bInfo": false,
        //     "searching":false
        // });


        //*** View Profile ***//        
        $('.viewProfileButton').on('click', function(){
            // $(".profile").attr("src","{{asset('img/logo2.png')}}");
            var id = $(this).data('id');
            var url = $(this).data('route');
            var type = $(this).data('type');
            // alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',                   
                success: function(response){
                    // alert(response['name']);
                    $('#viewUserModal').modal('show');
                    // console.log(response);fullname
                    $('.fullname').html(response['name']);
                    if(response['profile_picture'] == null){
                        $(".profile").attr("src","{{asset('img/logo.png')}}");
                    }
                    else{
                        $('.profile').attr("src",response['profile_picture']);
                    }
                    if(response['phone'] == null){
                        $('.phone').html('---');
                    }
                    else{
                        $('.phone').html(response['phone']);
                    }
                    if(response['address'] == null){
                        $('.address').html('---');
                    }
                    else{
                        $('.address').html(response['address']);
                    }
                    if(response['email'] == null){
                        $('.emailAddress').html('---');
                    }
                    else{
                        $('.emailAddress').html(response['email']);
                    }
                    if(response['created_at'] == null){
                        $('.registrationDate').html('---');
                    }
                    else{
                        $('.registrationDate').html($('.created_at' + id).html());
                    }
                    // zones
                    if(type == 'rider'){
                        if(response['user_zones'] == null){
                            $('.zones').html('---');
                        }
                        else{
                            var string = ""
                            for(var i = 0; i < response['user_zones'].length; i++){
                                string += response['user_zones'][i].zone.name;
                                if(i != response['user_zones'].length - 1)
                                {
                                    string += ", "
                                }
                            }
                        }
                        $('.zones').html(string);
                    }
                    else if (type == 'customer'){
                     if(response['zone'] == null){
                        $('.zone').html('---');
                    }
                    else{
                        $('.zone').html(response['zone'].name);
                    }

                }

            },
        });
        });

        // create
        $('#add_item').on('click', function(){
            fetch_all_zones();
        });

        //*** edit ***//
        $('.editButton').on('click', function(){
            var id = $(this).data('id');
            var user_type = $(this).data('type');

            fetch_specific_zones(id);

            $('#editForm').attr('action', "{{route('user.update', 1)}}");
            $('#hidden').val(id);
            $('.user_type').val(user_type);
            // alert($('#hidden').val());
            
            $('#editForm #name').val($('.name' + id).html());
            $('#editForm #email').val($('.email' + id).html());
            $('#editForm #phone').val($('.phone' + id).html());
            $('#editForm #address').val($('.address' + id).html());
            $('#editForm #zone_id').val($('.zone' + id).data('id'));
            $('#editForm #type').val($('.type' + id).html());
            $('#editForm #created_at').val($('.created_at' + id).html());

            $('#editUserModal').modal('show');
        });

        // delete
        $('.deleteButton').on('click', function(){
            var id = $(this).data('id');
            var user_type = $(this).data('type');
            $('#deleteForm').attr('action', "{{route('user.destroy', 1)}}");
            $('#deleteForm .hidden').val(id);
            $('.user_type').val(user_type);
            
            if(user_type == 'staff'){
                $('#deleteUserModalLabel').text('Delete User: ' + $('.name' + id).html() + "?");
            }
            else if(user_type == 'customer'){
                $('#deleteUserModalLabel').text('Delete Customer: ' + $('.name' + id).html() + "?");
            }
            else{
                $('#deleteUserModalLabel').text('Delete Rider: ' + $('.name' + id).html() + "?");
            }
            $('#deleteUserModal').modal('show');
        });
    });
</script>
@endsection('content_body')
