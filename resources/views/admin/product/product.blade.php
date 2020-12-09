@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Products</h1>
  </div>
  <!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-product"><a href="#">Admin</a></li>
      <li class="breadcrumb-product active">Products</li>
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
        <!-- <h3 class="card-title">Products</h3> -->
        <div class="card-tools">
          <button class="btn btn-success" id="add_product" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus"></i> Add New Product</button>
        </div>
        <!-- search bar -->
        <form action="{{route('search_products')}}" class="form-wrapper">
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
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Article</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Category</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Brand</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Unit</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Purchase Price</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Quantity in Hand</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Cost Value</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Selling Price</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Sales Value</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Opening Quantity</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">M.O.Q</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Product Picture</th>
                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($products) > 0)
                @foreach($products as $product)
                  <tr role="row" class="odd">
                    <td class="{{'article'.$product->id}}">{{$product->article}}</td>
                    <td class="{{'category_id'.$product->id}}">{{$product->category ? $product->category->name : NULL}}</td>
                    <td class="{{'brand_id'.$product->id}}">{{$product->brand ? $product->brand->name : NULL}}</td>
                    <td class="{{'unit_id'.$product->id}}">{{$product->unit ? $product->unit->name : NULL}}</td>
                    <td class="{{'purchase_price'.$product->id}}">{{$product->purchase_price}}</td>
                    <td class="{{'quantity_in_hand'.$product->id}}">{{$product->quantity_in_hand}}</td>
                    <td class="{{'cost_value'.$product->id}}">{{$product->cost_value}}</td>
                    <td class="{{'selling_price'.$product->id}}">{{$product->selling_price}}</td>
                    <td class="{{'sales_value'.$product->id}}">{{$product->sales_value}}</td>
                    <td class="{{'opening_quantity'.$product->id}}">{{$product->opening_quantity}}</td>
                    <td class="{{'moq'.$product->id}}">{{$product->moq}}</td>
                    <td class="{{'product_picture'.$product->id}}">{{$product->product_picture}}</td>
                    <td>
                      <!-- Detail -->
                      <a href="#" class="detailButton" data-id="{{$product->id}}" data-object="{{$product}}" data-product="{{URL::to('/') . storage_path('products') . '/' . $product->product_picture}}">
                        <i class="fas fa-eye green ml-1"></i>
                      </a>
                      |
                      <!-- Edit -->
                      <a href="#" class="editButton" data-id="{{$product->id}}" data-object="{{$product}}">
                        <i class="fas fa-edit blue ml-1"></i>
                      </a>
                      |
                      <!-- Delete -->
                      <a href="#" class="deleteButton" data-id="{{$product->id}}" data-object="{{$product}}">
                        <i class="fas fa-trash red ml-1"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr><td colspan="5"><h6 align="center">No product(s) found</h6></td></tr>
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
        @if(count($products) > 0)
        {{$products->appends(request()->except('page'))->links()}}
        @endif
      </div>
    </div>
  </div>
</div>

 <!-- Create view -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
        @include('admin.product.product_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit view -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editForm" method="POST" action="{{route('product.update', 1)}}" enctype="multipart/form-data">
        <!-- hidden input -->
        @method('PUT')
        <input id="hidden" type="hidden" name="hidden">
        @include('admin.product.product_master')
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="createButton">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Detail view -->
<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Detail</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- tables -->
            <div class="card-body row">
              <!-- main info -->
              <div class="col-md-12" style="text-align: center;">
                <!-- product_image -->
                <img class="shop_picture" src="{{asset('img/logo.png')}}" width="200">
                <!-- article -->
                <h3 class="article"></h3>
                <hr style="color:gray;">
              </div>
              <!-- section 1 -->
              <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <tr role="row" class="odd">
                            <td class="">Category</td>
                            <td class="category_id"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Brand</td>
                            <td class="brand_id"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Unit</td>
                            <td class="unit_id"></td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <!-- section 2 -->
              <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <tr role="row" class="odd">
                            <td class="">Purchase Price</td>
                            <td class="purchase_price"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Selling Price</td>
                            <td class="selling_price"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Cost Value</td>
                            <td class="cost_value"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Sales Value</td>
                            <td class="sales_value"></td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <!-- section 3 -->
              <div class="col-md-4">
                <table class="table table-bordered table-striped">
                    <tbody id="table_row_wrapper">
                        <tr role="row" class="odd">
                            <td class="">Opening Quantity</td>
                            <td class="opening_quantity"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Quantity in Hand</td>
                            <td class="quantity_in_hand"></td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="">Minimum Ordering Quantity</td>
                            <td class="moq"></td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
              

            <div class="card-footer">
                <button class="btn btn-primary" data-dismiss="modal" style="float: right;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm" method="POST" action="{{route('product.destroy', 1)}}">
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
          // $('#market_id').select2({
          //   dropdownParent: $('#addProductModal')
          // });
        },
        error: function(data){
          $('.market_id').html('<option value="">Select market</option>');
          // $('.market_id').select2();
        }
    });
  }

  // create
  $('#add_product').on('click', function(){
    // fetch_all_stores();
    // fetch_all_brands();
  });

  // edit
  $('.editButton').on('click', function(){
    var id = $(this).data('id');
    var product = $(this).data('object');
    $('#hidden').val(id);
    
    $('#editForm #article').val(product.article);

    $('#editForm #category_id option[value="'+ product.category.id +'"]').prop('selected', true);
    $('#editForm #brand_id option[value="'+ product.brand.id +'"]').prop('selected', true);
    $('#editForm #unit_id option[value="'+ product.unit.id +'"]').prop('selected', true);

    $('#editForm #purchase_price').val(product.purchase_price);
    $('#editForm #selling_price').val(product.selling_price);
    $('#editForm #cost_value').val(product.cost_value);
    $('#editForm #sales_value').val(product.sales_value);
    
    $('#editForm #opening_quantity').val(product.opening_quantity);
    $('#editForm #quantity_in_hand').val(product.quantity_in_hand);
    $('#editForm #moq').val(product.moq);


    // $('#editForm #shop_name').val(product.shop_name);
    // $('#editForm #shop_number').val(product.shop_number);
    // $('#editForm #floor').val(product.floor);

    // $('#editForm #area_id option[value="'+ product.market.area.id +'"]').prop('selected', true);
    // fetch_specific_markets(product.market.area.id);
    // $('#editForm #market_id option[value="'+ product.market.id +'"]').prop('selected', true);

    // $('#editForm #status option[value="'+ product.status +'"]').prop('selected', true);
    // $('#editForm #visiting_days option[value="'+ product.visiting_days +'"]').prop('selected', true);
    // $('#editForm #cash_on_delivery option[value="'+ product.cash_on_delivery +'"]').prop('selected', true);

    // $('#editForm #opening_balance').val(product.opening_balance);
    // $('#editForm #business_to_date').val(product.business_to_date);
    // $('#editForm #outstanding_balance').val(product.outstanding_balance);
    // $('#editForm #special_discount').val(product.special_discount);

    // $('#editForm #payment_terms').val(product.payment_terms);

    

    $('#editProductModal').modal('show');
  });

  // detail
  $('.detailButton').on('click', function(){
    var product = $(this).data('object');
    
    $('.article').html(product.article);
    // $('.product_picture').html(product.product_picture);

    $('.category_id').html(product.category.name);
    $('.brand_id').html(product.brand.name);
    $('.unit_id').html(product.unit.name);

    $('.purchase_price').html(product.purchase_price);
    $('.selling_price').html(product.selling_price);
    $('.cost_value').html(product.cost_value);
    $('.sales_value').html(product.sales_value);

    $('.opening_quantity').html(product.opening_quantity);
    $('.quantity_in_hand').html(product.quantity_in_hand);
    $('.moq').html(product.moq);

    // $('.contact_number').html(product.contact_number);
    // $('.whatsapp_number').html(product.whatsapp_number);
    // if(product.shop_keeper_picture){
    //   var shop_path = $(this).data('shopkeeper');
    //   $('.shop_keeper_picture').attr('src', shop_path);
    // }

    // $('.shop_name').html(product.shop_name);
    // $('.shop_number').html(product.shop_number);
    // $('.floor').html(product.floor);
    // $('.area').html(product.market.area.name);
    // $('.market').html(product.market.name);
    // if(product.shop_picture){
    //   var shop_path = $(this).data('shopkeeper');
    //   $('.shop_picture').attr('src', shop_path);
    // }

    // $('.status').html(product.status);
    // $('.visiting_days').html(product.visiting_days);
    // $('.cash_on_delivery').html(product.cash_on_delivery);
    // $('.opening_balance').html(product.opening_balance);
    // $('.business_to_date').html(product.business_to_date);
    // $('.outstanding_balance').html(product.outstanding_balance);
    // $('.special_discount').html(product.special_discount);

    $('#viewProductModal').modal('show');
  });

  // delete
  $('.deleteButton').on('click', function(){
    var id = $(this).data('id');
    $('#deleteForm').attr('action', "{{route('product.destroy', 1)}}");
    $('#deleteForm .hidden').val(id);

    $('#deleteProductModalLabel').text('Delete Product: ' + $('.name' + id).html() + "?");
    $('#deleteProductModal').modal('show');
  });

  //on area id change
  $('.area_id').on('change', function(){
    var area_id = $(this).val();
    fetch_specific_markets(area_id);
  });

});
</script>
@endsection('content_body')