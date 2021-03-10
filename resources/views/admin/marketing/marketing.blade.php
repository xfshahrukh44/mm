@extends('admin.layouts.master')

@section('content_header')
    <style>
    .collapsible {
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 8px;
    width: 100%;
    border: none;
    box-shadow: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    }

    .active, .collapsible:hover {
    background-color: #555;
    }

    .cntnt {
    padding: 0 18px;
    display: none;
    overflow: hidden;
    background-color: #f1f1f1;
    }
    </style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection


@section('content_body')
    <!-- markup to be injected -->
    <!-- search form -->
    <h2 class="text-center display-3">Marketing Plan <small style="font-weight:50!important;">({{return_date_pdf($date)}})</small></h2>
    <form action="{{route('search_marketing')}}" method="get">
        @csrf
        <div class="row" data-select2-id="12">
            <div class="col-md-10 offset-md-1" data-select2-id="11">
                <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                    <!-- date -->
                    <div class="col-10">
                        <div class="form-group">
                            <label>Search by Date:</label>
                            <input type="date" class="form-control date" name="date">
                        </div>
                    </div>
                    <!-- search button -->
                    <div class="col-2">
                        <div class="form-group">
                            <label>&nbsp</label>
                            <button type="submit" class="btn btn-block btn-primary form-control fetch_marketings" disabled="disabled"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
    
    <hr>
    
    <!-- Assign Tasks -->
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="text-center" style="font-weight: normal;">
                Assign Tasks
                <button class="btn btn-success add_custom">
                    <i class="fas fa-plus"></i>
                </button>
            </h2>
            <div class="row">
                <!-- customers_to_visit -->
                <button type="button" class="collapsible">
                    <h5>Customers to Visit: {{count($customers)}}</h5>
                </button>
                <div class="col-md-12 cntnt customers_to_visit" style="overflow-x:auto;">
                    <!-- <h5>Customers to Visit: {{count($customers)}}</h5> -->
                    <table class="table table-striped table-bordered col-md-12 table-sm">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                                <th>Designated Rider</th>
                                <th>Assign Rider</th>
                            </tr>
                        </thead>
                        <tbody class="tb_ctv">
                            @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        {{$customer->name ? $customer->name : ''}}
                                        <input class="customer_id2" type="hidden" value="{{$customer->id}}"></input>
                                        <input class="date" type="hidden" value="{{$ymd}}"}}></input>
                                    </td>
                                    <td>{{$customer->contact_number ? $customer->contact_number : ''}}</td>
                                    <td>{{$customer->shop_name ? $customer->shop_name : ''}}</td>
                                    <td>{{$customer->market ? $customer->market->name : ''}}</td>
                                    <td>{{($customer->market && $customer->market->area) ? $customer->market->area->name : ''}}</td>
                                    <td class="designated_rider">{{return_marketing_rider_for_customer($customer->id, $ymd)}}</td>
                                    <td>
                                        <div class="form-group">
                                            <select name="riders[]" class="form-control rider_selections">
                                                <option value="">Select rider</option>
                                                @foreach($riders as $rider)
                                                    <option value="{{$rider->id}}">{{$rider->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- payments_to_receive -->
                <button type="button" class="collapsible">
                    <h5>Payments to Receive: {{count($receivings)}}</h5>
                </button>
                <div class="col-md-12 cntnt payments_to_receive" style="overflow-x:auto;">
                    <table class="table table-striped table-bordered col-md-12 table-sm">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                                <th>Invoice ID</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Designated Rider</th>
                                <th>Assign Rider</th>
                            </tr>
                        </thead>
                        <tbody class="tb_ptr">
                            @foreach($receivings as $receiving)
                                <tr>
                                    <td>
                                        {{$receiving->customer ? $receiving->customer->name : ''}}
                                        <input class="receiving_id2" type="hidden" value="{{$receiving->id}}"></input>
                                        <input class="date" type="hidden" value="{{$ymd}}"></input>
                                    </td>
                                    <td>{{$receiving->customer ? $receiving->customer->contact_number : ''}}</td>
                                    <td>{{$receiving->customer ? $receiving->customer->shop_name : ''}}</td>
                                    <td>{{($receiving->customer && $receiving->customer->market) ? $receiving->customer->market->name : ''}}</td>
                                    <td>{{($receiving->customer && $receiving->customer->market && $receiving->customer->market->area) ? $receiving->customer->market->area->name : ''}}</td>
                                    <td>{{$receiving->invoice ? $receiving->invoice->id : ''}}</td>
                                    <td>Rs. {{$receiving->invoice ? number_format($receiving->invoice->total) : ''}}</td>
                                    <td>Rs. {{$receiving->invoice ? number_format($receiving->invoice->amount_pay) : ''}}</td>
                                    <td>Rs. {{$receiving->invoice ? number_format($receiving->invoice->total - $receiving->invoice->amount_pay) : ''}}</td>
                                    <td class="designated_rider">{{return_marketing_rider_for_receiving($receiving->id, $ymd)}}</td>
                                    <td>
                                        <div class="form-group">
                                            <select name="riders[]" class="form-control rider_selections">
                                                <option value="">Select rider</option>
                                                @foreach($riders as $rider)
                                                    <option value="{{$rider->id}}">{{$rider->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- orders_to_dispatch -->
                <button type="button" class="collapsible">
                    <h5>Orders to Dispatch: {{count($invoices)}}</h5>
                </button>
                <div class="col-md-12 cntnt orders_to_dispatch" style="overflow-x:auto;">
                    <table class="table table-striped table-bordered col-md-12 table-sm">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                                <th>Invoice ID</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Designated Rider</th>
                                <th>Assign Rider</th>
                            </tr>
                        </thead>
                        <tbody class="tb_otd">
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>
                                        {{$invoice->customer ? $invoice->customer->name : ''}}
                                        <input class="invoice_id2" type="hidden" value="{{$invoice->id}}"></input>
                                        <input class="date" type="hidden" value="{{$ymd}}"></input>
                                    </td>
                                    <td>{{$invoice->customer ? $invoice->customer->contact_number : ''}}</td>
                                    <td>{{$invoice->customer ? $invoice->customer->shop_name : ''}}</td>
                                    <td>{{($invoice->customer && $invoice->customer->market) ? $invoice->customer->market->name : ''}}</td>
                                    <td>{{($invoice->customer && $invoice->customer->market && $invoice->customer->market->area) ? $invoice->customer->market->area->name : ''}}</td>
                                    <td>{{$invoice->id}}</td>
                                    <td>Rs. {{$invoice->total ? number_format($invoice->total) : ''}}</td>
                                    <td>Rs. {{$invoice->amount_pay ? number_format($invoice->amount_pay) : ''}}</td>
                                    <td>Rs. {{($invoice->total && $invoice->amount_pay) ? number_format($invoice->total - $invoice->amount_pay) : ''}}</td>
                                    <td class="designated_rider">{{return_marketing_rider_for_invoice($invoice->id, $ymd)}}</td>
                                    <td>
                                        <div class="form-group">
                                            <select name="riders[]" class="form-control rider_selections">
                                                <option value="">Select rider</option>
                                                @foreach($riders as $rider)
                                                    <option value="{{$rider->id}}">{{$rider->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <br>
    <br>
    
    <!-- Track Tasks -->
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="text-center" style="font-weight: normal;">
                Track Tasks
            </h2>
            <div class="row">
                <!-- customers_to_visit -->
                <button type="button" class="collapsible">
                    <h5>Customers to Visit: {{count($customer_marketings)}}</h5>
                </button>
                <div class="col-md-12 cntnt customers_to_visit" style="overflow-x:auto;">
                    <!-- <h5>Customers to Visit: {{count($customers)}}</h5> -->
                    <table class="table table-striped table-bordered col-md-12 table-sm">
                    <thead>
                            <tr>
                                <th>Rider Name</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer_marketings as $customer_marketing)
                                <tr>
                                    <td>{{return_user_name($customer_marketing->user_id)}}</td>
                                    <td>{{$customer_marketing->customer ? $customer_marketing->customer->name : ''}}</td>
                                    <td>{{$customer_marketing->customer && $customer_marketing->customer->contact_number ? $customer_marketing->customer->contact_number : ''}}</td>
                                    <td>{{$customer_marketing->customer && $customer_marketing->customer->shop_name ? $customer_marketing->customer->shop_name : ''}}</td>
                                    <td>{{$customer_marketing->customer && $customer_marketing->customer->market ? $customer_marketing->customer->market->name : ''}}</td>
                                    <td>{{($customer_marketing->customer && $customer_marketing->customer->market && $customer_marketing->customer->market->area) ? $customer_marketing->customer->market->area->name : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- payments_to_receive -->
                <button type="button" class="collapsible">
                    <h5>Payments to Receive: {{count($receiving_marketings)}}</h5>
                </button>
                <div class="col-md-12 cntnt payments_to_receive" style="overflow-x:auto;">
                    <table class="table table-striped table-bordered col-md-12 table-sm">
                    <thead>
                            <tr>
                                <th>Rider Name</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                                <th>Invoice ID</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($receiving_marketings as $receiving_marketing)
                                <tr>
                                    <td>{{return_user_name($customer_marketing->user_id)}}</td>
                                    <td>{{$receiving_marketing->receiving->customer ? $receiving_marketing->receiving->customer->name : ''}}</td>
                                    <td>{{$receiving_marketing->receiving->customer ? $receiving_marketing->receiving->customer->contact_number : ''}}</td>
                                    <td>{{$receiving_marketing->receiving->customer ? $receiving_marketing->receiving->customer->shop_name : ''}}</td>
                                    <td>{{($receiving_marketing->receiving->customer && $receiving_marketing->receiving->customer->market) ? $receiving_marketing->receiving->customer->market->name : ''}}</td>
                                    <td>{{($receiving_marketing->receiving->customer && $receiving_marketing->receiving->customer->market && $receiving_marketing->receiving->customer->market->area) ? $receiving_marketing->receiving->customer->market->area->name : ''}}</td>
                                    <td>{{$receiving_marketing->receiving->invoice ? $receiving_marketing->receiving->invoice->id : ''}}</td>
                                    <td>Rs. {{$receiving_marketing->receiving->invoice ? number_format($receiving_marketing->receiving->invoice->total) : ''}}</td>
                                    <td>Rs. {{$receiving_marketing->receiving->invoice ? number_format($receiving_marketing->receiving->invoice->amount_pay) : ''}}</td>
                                    <td>Rs. {{$receiving_marketing->receiving->invoice ? number_format($receiving_marketing->receiving->invoice->total - $receiving_marketing->receiving->invoice->amount_pay) : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- orders_to_dispatch -->
                <button type="button" class="collapsible">
                    <h5>Orders to Dispatch: {{count($invoice_marketings)}}</h5>
                </button>
                <div class="col-md-12 cntnt orders_to_dispatch" style="overflow-x:auto;">
                    <table class="table table-striped table-bordered col-md-12 table-sm">
                    <thead>
                            <tr>
                                <th>Rider Name</th>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                                <th>Invoice ID</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice_marketings as $invoice_marketing)
                                <tr>
                                    <td>{{return_user_name($customer_marketing->user_id)}}</td>
                                    <td>{{$invoice_marketing->invoice->customer ? $invoice_marketing->invoice->customer->name : ''}}</td>
                                    <td>{{$invoice_marketing->invoice->customer ? $invoice_marketing->invoice->customer->contact_number : ''}}</td>
                                    <td>{{$invoice_marketing->invoice->customer ? $invoice_marketing->invoice->customer->shop_name : ''}}</td>
                                    <td>{{($invoice_marketing->invoice->customer && $invoice_marketing->invoice->customer->market) ? $invoice_marketing->invoice->customer->market->name : ''}}</td>
                                    <td>{{($invoice_marketing->invoice->customer && $invoice_marketing->invoice->customer->market && $invoice_marketing->invoice->customer->market->area) ? $invoice_marketing->invoice->customer->market->area->name : ''}}</td>
                                    <td>{{$invoice_marketing->invoice->id}}</td>
                                    <td>Rs. {{$invoice_marketing->invoice->total ? number_format($invoice_marketing->invoice->total) : ''}}</td>
                                    <td>Rs. {{$invoice_marketing->invoice->amount_pay ? number_format($invoice_marketing->invoice->amount_pay) : ''}}</td>
                                    <td>Rs. {{($invoice_marketing->invoice->total && $invoice_marketing->invoice->amount_pay) ? number_format($invoice_marketing->invoice->total - $invoice_marketing->invoice->amount_pay) : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Marketing view -->
    <div class="modal fade" id="customMarketingModal" tabindex="-1" role="dialog" aria-labelledby="customMarketingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header row">
                    <h5 class="modal-title" id="customMarketingModalLabel">Add custom marketing task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body col-md-12 p-2" style="overflow-x:auto;">
                    <!-- type -->
                    <div class="form-group col-md-12">
                        <select class="form-control type">
                            <option value="">Select type</option>
                            <option value="ctv">Customers to Visit</option>
                            <option value="ptr">Payments to Receive</option>
                            <option value="otd">Orders to Dispatch</option>
                        </select>
                    </div>
                    <!-- customer_id -->
                    <div class="form-group col-md-12 customer_wrapper" hidden>
                        <select class="form-control customer_id" style="width: 100%;">
                            <option value="">Select customer</option>
                            @foreach($customers_all as $customer)
                                <option value="{{$customer->id}}">{{customer_shop_name($customer->id)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- receiving_id -->
                    <div class="form-group col-md-12 receiving_wrapper" hidden>
                        <select class="form-control receiving_id" style="width: 100%;">
                            <option value="">Select receipt</option>
                            @foreach($receivings_all as $receiving)
                                <option value="{{$receiving->id}}">{{$receiving->id . ' - Rs. ' . number_format($receiving->amount) . ' - ' . customer_shop_name($receiving->customer->id) . ' - ' . return_date_wo_time($receiving->payment_date)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- invoice_id -->
                    <div class="form-group col-md-12 invoice_wrapper" hidden>
                        <select class="form-control invoice_id" style="width: 100%;">
                            <option value="">Select invoice</option>
                            @foreach($invoices_all as $invoice)
                                <option value="{{$invoice->id}}">{{$invoice->id . ' - Total(Rs. ' . number_format($invoice->total) . ')' . (($invoice->customer) ? ' - ' . customer_shop_name($invoice->customer->id) : '')}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- rider_id -->
                    <div class="form-group col-md-12 rider_wrapper" hidden>
                        <select class="form-control rider_id" style="width: 100%;">
                            <option value="">Select rider</option>
                            @foreach($riders as $rider)
                                <option value="{{$rider->id}}">{{$rider->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary button_save_custom_marketing">Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- dummy form -->
    <form id="dummy_form" action="{{route('generate_expenses_excel')}}" method="POST" target="_blank" hidden>
        @csrf
    </form>


    <script>
        $(document).ready(function(){
            // persistent active sidebar
            var element = $('li a[href*="'+ window.location.pathname +'"]');
            element.parent().addClass('menu-open');

            // get url params
            $.urlParam = function(name){
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results==null) {
                    return null;
                }
                return decodeURI(results[1]) || 0;
            }
            if($.urlParam('date')){
                $('.date').val($.urlParam('date',));
            }
            else{
                d = new Date();
                date = d.getDate();
                month = d.getMonth()+1;
                year = d.getFullYear();
                $('.date').val(year+'-'+((month < 10) ? ('0' + month) : month)+'-'+((date < 10) ? ('0' + date) : date));
            }

            // global vars
            var customer = "";
            var receiving = "";
            var invoice = "";

            // create marketing
            function create_marketing(data, route){
                $.ajax({
                    url: route,
                    type: 'GET',
                    data: data,
                    dataType: 'JSON',
                    async: false,
                    success: function (data) {
                        // 
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
            // fetch receiving
            function fetch_receiving(id){
                // fetch receiving
                $.ajax({
                    url: "<?php echo(route('receiving.show', 1)); ?>",
                    type: 'GET',
                    async: false,
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        receiving = data.receiving;
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
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        invoice = data.invoice;
                    }
                });
            }

            // on date change
            $('.date').on('change', function(){
                if($(this).val()){
                    $('.fetch_marketings').removeAttr('disabled');
                }
                else{
                    $('.fetch_marketings').prop('disabled', true);
                }
            })

            // customers_to_visit
            $('.customers_to_visit').on('change', '.rider_selections', function(){
                var tr = $(this).parent().parent().parent();
                var customer_id = tr.find('.customer_id2');
                var date = tr.find('.date');
                var designated_rider = tr.find('.designated_rider')
                customer_id = customer_id.val();
                date = date.val();
                var rider_id = $(this).val();
                if(rider_id){
                    $.ajax({
                        url: "<?php echo(route('assign_marketing_rider_for_customer')); ?>",
                        type: 'GET',
                        async: false,
                        data: {
                            customer_id: customer_id,
                            rider_id: rider_id,
                            date: date
                        },
                        success: function (data) {
                            designated_rider.text(data);
                        }
                    });
                }
            })

            // payments_to_receive
            $('.payments_to_receive').on('change', '.rider_selections', function(){
                var tr = $(this).parent().parent().parent();
                var receiving_id = tr.find('.receiving_id2');
                var date = tr.find('.date');
                var designated_rider = tr.find('.designated_rider')
                receiving_id = receiving_id.val();
                date = date.val();
                var rider_id = $(this).val();
                if(rider_id){
                    $.ajax({
                        url: "<?php echo(route('assign_marketing_rider_for_receiving')); ?>",
                        type: 'GET',
                        async: false,
                        data: {
                            receiving_id: receiving_id,
                            rider_id: rider_id,
                            date: date
                        },
                        success: function (data) {
                            designated_rider.text(data);
                        }
                    });
                }
            })

            // orders_to_dispatch
            $('.orders_to_dispatch').on('change', '.rider_selections', function(){
                var tr = $(this).parent().parent().parent();
                var invoice_id = tr.find('.invoice_id2');
                var date = tr.find('.date');
                var designated_rider = tr.find('.designated_rider')
                invoice_id = invoice_id.val();
                date = date.val();
                var rider_id = $(this).val();
                if(rider_id){
                    $.ajax({
                        url: "<?php echo(route('assign_marketing_rider_for_invoice')); ?>",
                        type: 'GET',
                        async: false,
                        data: {
                            invoice_id: invoice_id,
                            rider_id: rider_id,
                            date: date
                        },
                        success: function (data) {
                            designated_rider.text(data);
                        }
                    });
                }
            })

            // on add_custom click
            $('.add_custom').on('click', function(){
                // hide fields
                $('.customer_wrapper').attr('hidden', 'hidden');
                $('.receiving_wrapper').attr('hidden', 'hidden');
                $('.invoice_wrapper').attr('hidden', 'hidden');
                $('.rider_wrapper').attr('hidden', 'hidden');

                $('#customMarketingModal').modal('show');
            });

            // on type change
            $('.type').on('change', function(){
                // customers to visit
                if($(this).val() == 'ctv'){
                    // unhide fields
                    $('.customer_wrapper').removeAttr('hidden');
                    $('.rider_wrapper').removeAttr('hidden');
                    $('.customer_id').select2();
                    $('.rider_id').select2();
                    // hide fields
                    $('.receiving_wrapper').attr('hidden', 'hidden');
                    $('.invoice_wrapper').attr('hidden', 'hidden');
                }
                // payments to receive
                if($(this).val() == 'ptr'){
                    // unhide fields
                    $('.receiving_wrapper').removeAttr('hidden');
                    $('.rider_wrapper').removeAttr('hidden');
                    $('.receiving_id').select2();
                    $('.rider_id').select2();
                    // hide fields
                    $('.customer_wrapper').attr('hidden', 'hidden');
                    $('.invoice_wrapper').attr('hidden', 'hidden');
                }
                // orders to dispatch
                if($(this).val() == 'otd'){
                    // unhide fields
                    $('.invoice_wrapper').removeAttr('hidden');
                    $('.rider_wrapper').removeAttr('hidden');
                    $('.invoice_id').select2();
                    $('.rider_id').select2();
                    // hide fields
                    $('.customer_wrapper').attr('hidden', 'hidden');
                    $('.receiving_wrapper').attr('hidden', 'hidden');
                }
            });

            // on button_save_custom_marketing click
            $('.button_save_custom_marketing').on('click', function(){
                var type = $('.type').val();
                var date = $('.date').val();
                rider_id = $('.rider_id').val();

                // customers to visit
                if(type == 'ctv'){
                    id = $('.customer_id').val();

                    data = {
                        customer_id: id,
                        rider_id: rider_id,
                        date: date
                    };

                    create_marketing(data, "{{route('assign_marketing_rider_for_customer')}}");
                    // fetch_customer(id);

                    // var customer_td = '<td>'+(customer.name ? customer.name : '')+'<input class="customer_id2" type="hidden" value="'+customer.id+'"></input><input class="date" type="hidden" value="{{$ymd}}"}}></input></td>';
                    // var contact_td = '<td>'+(customer.contact_number ? customer.contact_number : '')+'</td>';
                    // var shop_td = '<td>'+(customer.shop_name ? customer.shop_name : '')+'</td>';
                    // var market_td = '<td>'+(customer.market ? customer.market.name : '')+'</td>';
                    // var area_td = '<td>'+((customer.market && customer.market.area) ? customer.market.area.name : '')+'</td>';
                    // var designated_rider_td = '<td class="designated_rider">{{return_marketing_rider_for_customer('+customer.id+', $ymd)}}</td>';
                    // var assign_rider_td = '<td><div class="form-group"><select name="riders[]" class="form-control rider_selections"><option value="">Select rider</option>@foreach($riders as $rider)<option value="{{$rider->id}}">{{$rider->name}}</option>@endforeach</select></div></td>';
                    
                    // var fieldHTML = customer_td + contact_td + shop_td + market_td + area_td + designated_rider_td + assign_rider_td;
                    // $('.tb_ctv').append('<tr>' + fieldHTML + '</tr>');
                }
                // payments to receive
                if(type == 'ptr'){
                    id = $('.receiving_id').val();

                    data = {
                        receiving_id: id,
                        rider_id: rider_id,
                        date: date
                    };

                    create_marketing(data, "{{route('assign_marketing_rider_for_receiving')}}");

                    // fetch_receiving(id);

                    // var receiving_td = '<td>'+(receiving.customer ? receiving.customer.name : '')+'<input class="receiving_id2" type="hidden" value="'+receiving.id+'"></input><input class="date" type="hidden" value="{{$ymd}}"></input></td>';
                    // var contact_td = '<td>'+(receiving.customer ? receiving.customer.contact_number : '')+'</td>';
                    // var shop_td = '<td>'+(receiving.customer ? receiving.customer.shop_name : '')+'</td>';
                    // var market_td = '<td>'+((receiving.customer && receiving.customer.market) ? receiving.customer.market.name : '')+'</td>';
                    // var area_td = '<td>'+((receiving.customer && receiving.customer.market && receiving.customer.market.area) ? receiving.customer.market.area.name : '')+'</td>';
                    // var invoice_td = '<td>'+(receiving.invoice ? receiving.invoice.id : '')+'</td>';
                    // var invoice_total_td = '<td>Rs. '+(receiving.invoice ? receiving.invoice.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '')+'</td>';
                    // var invoice_amount_pay_td = '<td>Rs. '+(receiving.invoice ? receiving.invoice.amount_pay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '')+'</td>';
                    // var invoice_due_td = '<td>Rs. '+(receiving.invoice ? (receiving.invoice.total - receiving.invoice.amount_pay).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '')+'</td>';
                    // var designated_rider_td = '<td class="designated_rider">{{return_marketing_rider_for_receiving('+receiving.id+', $ymd)}}</td>';
                    // var assign_rider_td = '<td><div class="form-group"><select name="riders[]" class="form-control rider_selections"><option value="">Select rider</option>@foreach($riders as $rider)<option value="{{$rider->id}}">{{$rider->name}}</option>@endforeach</select></div></td>';

                    // var fieldHTML = receiving_td + contact_td + shop_td + market_td + area_td + invoice_td + invoice_total_td + invoice_amount_pay_td + invoice_due_td + designated_rider_td + assign_rider_td;
                    // $('.tb_ptr').append('<tr>' + fieldHTML + '</tr>');                    

                }
                // orders to dispatch
                if(type == 'otd'){
                    id = $('.invoice_id').val();
                    
                    data = {
                        invoice_id: id,
                        rider_id: rider_id,
                        date: date
                    };

                    create_marketing(data, "{{route('assign_marketing_rider_for_invoice')}}");

                    // var customer_td = '<td>'+(invoice.customer ? invoice.customer.name : '')+'<input class="invoice_id2" type="hidden" value="'+(invoice.id)+'"></input><input class="date" type="hidden" value="{{$ymd}}"></input></td>';
                    // var contact_td = '<td>'+(invoice.customer ? invoice.customer.contact_number : '')+'</td>';
                    // var shop_td = '<td>'+(invoice.customer ? invoice.customer.shop_name : '')+'</td>';
                    // var market_td = '<td>'+((invoice.customer && invoice.customer.market) ? invoice.customer.market.name : '')+'</td>';
                    // var area_td = '<td>'+((invoice.customer && invoice.customer.market && invoice.customer.market.area) ? invoice.customer.market.area.name : '')+'</td>';
                    // var invoice_td = '<td>'+(invoice.id)+'</td>';
                    // var invoice_total_td = '<td>Rs. '+(invoice.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))+'</td>';
                    // var invoice_amount_pay_td = '<td>Rs. '+(invoice.amount_pay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))+'</td>';
                    // var invoice_due_td = '<td>Rs. '+((invoice.total - invoice.amount_pay).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))+'</td>';
                    // var designated_rider_td = '<td class="designated_rider">{{return_marketing_rider_for_invoice('+invoice.id+', $ymd)}}</td>';
                    // var assign_rider_td = '<td><div class="form-group"><select name="riders[]" class="form-control rider_selections"><option value="">Select rider</option>@foreach($riders as $rider)<option value="{{$rider->id}}">{{$rider->name}}</option>@endforeach</select></div></td>';

                    // var fieldHTML = customer_td + contact_td + shop_td + market_td + area_td + invoice_td + invoice_total_td + invoice_amount_pay_td + invoice_due_td + designated_rider_td + assign_rider_td;
                    // $('.tb_otd').append('<tr>' + fieldHTML + '</tr>');
                }

                $('#customMarketingModal').modal('hide');

                window.location.href = window.location.href;
            });
        });
    </script>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
            content.style.display = "none";
            } else {
            content.style.display = "block";
            }
        });
        }
    </script>
@endsection('content_body')