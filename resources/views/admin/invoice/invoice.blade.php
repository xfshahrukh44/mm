@extends('admin.layouts.master')

@section('content_header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"><i class="nav-icon fa fa-clipboard"></i> Invoices</h1>
</div>
<!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Admin</a></li>
      <li class="breadcrumb-item"><a href="#">Invoices</a></li>
      <li class="breadcrumb-item active">Invoice</li>
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
                    <!-- <h3 class="">Invoices</h3> -->
                    <button class="btn btn-success testbtn" id="add_program" data-route="{{route('invoice.store')}}"">
                        <i class="fas fa-plus"></i> Add New Invoice
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Invoice ID: activate to sort column ascending"><i  class="fa fa-arrow-up arrow_up_down"></i><i class="fa fa-arrow-down arrow_up_down"></i>Invoice ID</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Invoice ID: activate to sort column ascending"><i  class="fa fa-arrow-up arrow_up_down"></i><i class="fa fa-arrow-down arrow_up_down"></i>Order ID</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Date</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Customer Name: activate to sort column ascending">Customer Name</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Phone</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                              <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Total: activate to sort column ascending">Total</th>
                                @can('isSuperAdmin')
                                    <th class="sorting">Created By</th> 
                                    <th class="sorting">Modified By</th> 
                                @endcan
                              <!-- <th class="sorting_asc" tabindex="0" rowspan="1" colspan="1">Items</th> -->
                              <th tabindex="0" rowspan="1" colspan="1">Actions</th>
                          </tr>
                        </thead>

                        <tbody>
                            @if(count($invoices) > 0)
                                @foreach($invoices as $invoice)
                                    <tr role="row" class="odd">
                                        <td class="{{'invoice_id'.$invoice->id}}">{{$invoice->id}}</td>
                                        <td class="{{'order_id'.$invoice->id}}">{{$invoice->order ? $invoice->order->id : NULL}}</td>
                                        <td class="{{'total'.$invoice->id}}">{{$invoice->created_at ? return_date($invoice->created_at) : NULL}}</td>
                                        <td class="{{'customer_id'.$invoice->id}}" data-id="{{$invoice->customer ? $invoice->customer_id : NULL}}" data-object="{{$invoice->customer ? $invoice->customer : NULL}}">
                                            <a href="#" class="viewProfileButton" data-id="{{$invoice->customer ? $invoice->customer_id : NULL}}" data-type="{{$invoice->customer ? $invoice->customer->type : NULL}}" data-route="{{$invoice->customer ? route('customer.show',$invoice->customer->id) : '#'}}">
                                                {{$invoice->customer ? $invoice->customer->name : NULL}}
                                            </a>
                                        </td>
                                        <td class="{{'contact_number'.$invoice->id}}">{{$invoice->customer && $invoice->customer->contact_number ? $invoice->customer->contact_number : NULL}}</td>
                                        <td class="{{'address'.$invoice->id}}">{{($invoice->customer && $invoice->customer->shop_name ? $invoice->customer->shop_name : NULL) . ' - ' . ($invoice->customer && $invoice->customer->market ? $invoice->customer->market->name : NULL) . ' - ' .($invoice->customer && $invoice->customer->market ? $invoice->customer->market->area->name : NULL)}}</td>
                                        <td class="{{'total'.$invoice->id}}">{{$invoice->total}} pkr</td>
                                        @can('isSuperAdmin')
                                            <td>{{return_user_name($invoice->created_by)}}</td>
                                            <td>{{return_user_name($invoice->modified_by)}}</td>
                                        @endcan
                                        <td>
                                            <!-- Detail -->
                                            <a href="#" class="detailButton" data-id="{{$invoice->id}}" data-type="{{$invoice->id}}">
                                                <i class="fas fa-shopping-basket blue ml-1"></i>
                                            </a>
                                            @can('isSuperAdmin')
                                                <!-- Delete -->
                                                <a href="#" class="deleteButton" data-id="{{$invoice->id}}" data-type="{{$invoice->id}}">
                                                    <i class="fas fa-trash red ml-1"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=11><h6 align="center">No invoice(s) found</h6></td>
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
                @if(count($invoices) > 0)
                {{$invoices->appends(request()->except('page'))->links()}}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete view -->
<div class="modal fade" id="deleteInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="deleteInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteInvoiceModalLabel">Delete Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm" method="POST" action="{{route('invoice.destroy', 1)}}">
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
<div class="modal fade" id="detailInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="detailInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{route('generate_invoice_pdf', 13)}}" method="GET" id="invoice_detail_form">
                @method('GET')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="detailInvoiceModalLabel">Invoice details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class=" table-binvoiceed table-striped p-2" style="width:100%; binvoice: 1px solid black;height: 20px;">
                        <tr role="row">
                            <th>Invoice id:</th>
                            <td><h6 id="invoice_id"></td>
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
                            <th>Amount Payment:</th>
                            <td><h6 id="amount_pay"></h6></td>
                        </tr>
                    </table>
                    <div class="col-md-12">
                        <!-- MASTER INFO -->
                        <!-- Invoice id -->
                        <br>
                        <div class="row">
                            <!-- CHILD INFO -->
                            <table id="itemTable" class="table table-bordered table-hover dtr-inline" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
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
                                        <td name="invoice_products[]" value="'+invoice.invoice_products[i].id+'" hidden></td>
                                        <td><input type="checkbox" name="invoiced_items[]"></td>
                                        <td class="">'+invoice.invoice_products[i].product.category.name+'</td>
                                        <td class="">'+invoice.invoice_products[i].product.brand.name+'</td>
                                        <td class="">'+invoice.invoice_products[i].product.article+'</td>
                                        <td class="">'+invoice.invoice_products[i].quantity+'</td>
                                        <td class="">'+invoice.invoice_products[i].price+'</td>
                                        <td class="">'+invoice.invoice_products[i].product.unit.name+'</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success generate_invoice" type="submit">Generate Invoice</button>
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
                <table class="table table-binvoiceed table-striped">
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
    var invoice = "";
    var current_invoice_id = 0;
    var special_discount = 0;
    var invoice_id = "";

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

    // fetch invoice
    function fetch_invoice(id){
        // fetch invoice
        $.ajax({
            url: "<?php echo(route('invoice.show', 1)); ?>",
            type: 'GET',
            async: false,
            data: {invoice_id: id},
            dataType: 'JSON',
            success: function (data) {
                invoice = data.invoice;
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

    //Add Items
    $('#detailInvoiceModal').on("click", ".addItem", function(){
    // $('.addItem').on('click', function(){
        $('#detailInvoiceModal').modal('hide');
        $('a[data-id="'+ current_invoice_id +'"]')[1].click();
    });

    //*** delete ***//
    $('.deleteButton').on('click', function(){
        var id = $(this).data('id');
        $('#deleteForm').attr('action', "{{route('invoice.update', 1)}}");
        $('#deleteForm .hidden').val(id);
        
        $('#deleteInvoiceModalLabel').text('Delete Invoice: ' + $('.invoice_id' + id).html() + "?");
        $('#deleteInvoiceModal').modal('show');
    });

    // detail
    $('.detailButton').on('click', function(){
        invoice_id = $(this).data('id');

        // set invoice url for pdf generation
        var temp_route = "{{route('generate_invoice_pdf', ':id')}}";
        temp_route = temp_route.replace(':id', invoice_id);
        $('#invoice_detail_form').attr('action', temp_route);

        fetch_invoice(invoice_id);

        // empty wrapper
        $('#table_row_wrapper').html('');
        // loop over retrieved items
        for(var i = 0; i < invoice.invoice_products.length; i++)
        {
            $('#table_row_wrapper').append(' <tr role="row" class="odd"><td name="invoice_products[]" value="'+invoice.invoice_products[i].id+'" hidden></td><td class="">'+invoice.invoice_products[i].product.category.name+'</td><td class="">'+invoice.invoice_products[i].product.brand.name+'</td><td class="">'+invoice.invoice_products[i].product.article+'</td><td class="">'+invoice.invoice_products[i].quantity+'</td><td class="">'+invoice.invoice_products[i].price+'</td><td class="">'+invoice.invoice_products[i].product.unit.name+'</td></tr>');
        }

        $('#invoice_id').text(invoice.id);
        $('#customer_name').text(invoice.customer.name);
        $('#contact_number').text(invoice.customer.contact_number);
        $('#address').text(invoice.customer.shop_name + ' - Shop # ' + invoice.customer.shop_number + ' - Floor # ' + invoice.customer.floor + ' - ' + invoice.customer.market.name + ' - ' + invoice.customer.market.area.name);
        $('#detailTotal').text(invoice.total);
        $('#amount_pay').text(invoice.amount_pay);

        $('#detailInvoiceModal').modal('show');

        // append in table_row_wrapper empty first
        // $('#table_row_wrapper').child('td').remove();

    });
    
  });

</script>
@endsection('content_body')