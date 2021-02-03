@extends('admin.layouts.master')

@section('content_header')

@endsection


@section('content_body')
    <!-- markup to be injected -->
    <!-- search form -->
    <h2 class="text-center display-3">Marketing Plan</h2>
    <div class="row" data-select2-id="12">
        <div class="col-md-10 offset-md-1" data-select2-id="11">
            <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                <!-- date -->
                <div class="col-10">
                    <div class="form-group">
                        <label>Search by Date:</label>
                        <input type="date" class="form-control date_to" name="date_to">
                    </div>
                </div>
                <!-- search button -->
                <div class="col-2">
                    <div class="form-group">
                        <label>&nbsp</label>
                        <button type="button" class="btn btn-block btn-primary form-control fetch_expenses" disabled="disabled"><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <hr>
    
    <!-- today -->
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="text-center" style="font-weight: normal;">Today's Marketing Plan ({{return_date_pdf(return_todays_date())}})</h2>
            <div class="row">
                <!-- customers to visit -->
                <div class="col-md-6">
                    <h5>Customers to Visit: {{count($customers)}}</h5>
                    <table class="table table-striped table-bordered col-md-12">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Contact</th>
                                <th>Shop</th>
                                <th>Market</th>
                                <th>Area</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->name ? $customer->name : ''}}</td>
                                    <td>{{$customer->contact_number ? $customer->contact_number : ''}}</td>
                                    <td>{{$customer->shop_name ? $customer->shop_name : ''}}</td>
                                    <td>{{$customer->market ? $customer->market->name : ''}}</td>
                                    <td>{{($customer->market && $customer->market->area) ? $customer->market->area->name : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- orders to dispatch -->
                <div class="col-md-6">
                    <h5>Orders to Dispatch: {{count($orders)}}</h5>
                    <table class="table table-striped table-bordered col-md-12">
                        <thead>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Shop</th>
                            <th>Market</th>
                            <th>Area</th>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->customer ? $order->customer->name : ''}}</td>
                                    <td>{{$order->customer ? $order->customer->contact_number : ''}}</td>
                                    <td>{{$order->customer ? $order->customer->shop_name : ''}}</td>
                                    <td>{{$order->customer->market ? $order->customer->market->name : ''}}</td>
                                    <td>{{($order->customer->market && $order->customer->market->area) ? $order->customer->market->area->name : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ledger view -->
    <div class="modal fade" id="detailLedgerModal" tabindex="-1" role="dialog" aria-labelledby="detailLedgerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title" id="detailLedgerModalLabel">Ledger</h5>
                <!-- generate excel -->
                <div class="text-right">
                    <button type="button" class="btn btn-success generate_expenses_excel">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-condensed table-sm">
                <thead>
                    <!-- outstanding balance row -->
                    <tr class="table-info">
                    <td></td>
                    <td class="text-bold">Total</td>
                    <td class="detail_total"></td>
                    </tr>
                    <!-- headers -->
                    <tr>
                    <th>Transaction Date</th>
                    <th>Amount</th>
                    <th>Details</th>
                    </tr>
                </thead>
                <tbody class="ledger_wrapper">
                    <tr>
                        <td>12.12.12</td>
                        <td>444</td>
                        <td>jaksd aksj hakjsdaskj akjsd jkashd</td>
                    </tr>
                </tbody>
                </table>
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
        });
    </script>
@endsection('content_body')