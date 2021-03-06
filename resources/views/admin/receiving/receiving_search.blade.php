@extends('admin.layouts.master')

@section('content_header')
<style>
.modal-body {
    overflow : auto;
}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section('content_body')

    <!-- markup to be injected -->
    <!-- search form -->
    <h2 class="text-center display-3">Receipt Logs</h2>
    <form action="enhanced-results.html" data-select2-id="13">
        <div class="row" data-select2-id="12">
            <div class="col-md-10 offset-md-1" data-select2-id="11">
                <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                    <!-- User -->
                    <div class="col-md-5 col-sm-12">
                        <div class="form-group">
                            <label>User:</label>
                            
                            <select class="form-control user_id" name="user_id">
                                <option value="">Select user</option>
                                <option value="All">All</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name . ' ('.$user->type.')'}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- date_from -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Date(from):</label>
                            <input type="date" class="form-control date_from" name="date_from">
                        </div>
                    </div>
                    <!-- date_to -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Date(to):</label>
                            <input type="date" class="form-control date_to" name="date_to">
                        </div>
                    </div>
                    <!-- search button -->
                    <div class="col-md-1 col-sm-12">
                        <div class="form-group">
                            <label>&nbsp</label>
                            <button type="button" class="btn btn-block btn-primary form-control fetch_receivings" disabled="disabled"><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Ledger view -->
    <div class="modal fade" id="detailLedgerModal" tabindex="-1" role="dialog" aria-labelledby="detailLedgerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
            <div class="modal-header row">
                <h5 class="modal-title" id="detailLedgerModalLabel">Ledger</h5>
                <!-- generate excel -->
                <!-- <div class="text-right">
                    <button type="button" class="btn btn-success generate_receivings_excel">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-condensed table-sm" style="overflow-x:auto;">
                <thead>
                    <!-- outstanding balance row -->
                    <tr class="table-info">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-bold">Total</td>
                    <td class="detail_total"></td>
                    </tr>
                    <!-- headers -->
                    <tr>
                    <th>Date Punched</th>
                    <th>Collected by</th>
                    <th>Customer</th>
                    <th>Market</th>
                    <th>Area</th>
                    <th>Invoice ID</th>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>Received</th>
                    <th>Outstanding Balance</th>
                    </tr>
                </thead>
                <tbody class="ledger_wrapper">
                    <tr>
                        <td>rider 1</td>
                        <td>cus</td>
                        <td>market</td>
                        <td>area</td>
                        <td>1</td>
                        <td>2</td>
                        <td>Rs. 440</td>
                        <td><input type="checkbox"></td>
                        <td>Rs. 444,123,444</td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <!-- dummy form -->
    <form id="dummy_form" action="{{route('fetch_receivings')}}" method="POST" target="_blank" hidden>
        @csrf
    </form>

    <script>
        $(document).ready(function(){
            // persistent active sidebar
            var element = $('li a[href*="'+ window.location.pathname +'"]');
            element.parent().parent().parent().addClass('menu-open');
            element.addClass('active');

            // select2
            $('.user_id').select2();

            // global vars
            var receivings = {};
            var total = 0;
            var wild_card = 0;

            // fetch receiving
            function fetch_receivings(user_id, date_from, date_to){
                $.ajax({
                    url: "<?php echo(route('fetch_receivings')); ?>",
                    type: 'GET',
                    async: false,
                    data: {user_id: user_id, date_from: date_from, date_to: date_to},
                    dataType: 'JSON',
                    success: function (data) {
                        receivings = data.receivings;
                        total = data.total;
                    }
                });
            }

            // check if all fields are filled
            function check_fields(){
                // get all parameteres
                var user_id = $('.user_id').val();
                var date_from = $('.date_from').val();
                var date_to = $('.date_to').val();

                if(user_id && date_from && date_to){
                    $('.fetch_receivings').removeAttr('disabled');
                }
                else{
                    $('.fetch_receivings').prop('disabled', true);
                }
            }

            // on type change
            $('.user_id').on('change', function(){check_fields();})
            $('.date_from').on('change', function(){check_fields();})
            $('.date_to').on('change', function(){check_fields();})

            // on search receivings click
            $('.fetch_receivings').on('click', function(){
                // get all parameteres
                var user_id = $('.user_id').val();
                var date_from = $('.date_from').val();
                var date_to = $('.date_to').val();
                var user_name = $( ".user_id option:selected" ).text();

                // fetch filtered receivings
                fetch_receivings(user_id, date_from, date_to);

                // set ledger modal title
                $('#detailLedgerModalLabel').html('Receipt(s) collected by: '+user_name+' <small>(' + new Date(date_from).toDateString() + ' - ' + new Date(date_to).toDateString() + ')</small>');

                // empty wrapper
                $('.ledger_wrapper').html('');

                // if no entries
                if(receivings.length == 0){
                    // no entries row
                    $('.ledger_wrapper').prepend('<tr class="table-warning"><td class="text-center" colspan=10>No Receipt Logs</td></tr>');
                    // set total amount
                    $('.detail_total').html('Rs. 0');
                }
                // else
                else{
                    // append ledger entries
                    // new Date(date_from).toDateString()
                    for(var i = 0; i < receivings.length; i++){
                        var receiving_id = receivings[i].id;
                        var collected_by = (receivings[i].user ? receivings[i].user.name : '');
                        var date_punched = ((receivings[i].created_at) ? (new Date(receivings[i].created_at).toDateString()) : '');
                        var customer_name = (receivings[i].customer ? (receivings[i].customer.name + ((receivings[i].customer.shop_name) ? (' | ' + receivings[i].customer.shop_name) : '') + ((receivings[i].customer.market && receivings[i].customer.market.name) ? (' | ' + receivings[i].customer.market.name) : '') + ((receivings[i].customer.market && receivings[i].customer.market.area &&  receivings[i].customer.market.area.name) ? (' | ' + receivings[i].customer.market.area.name) : '')) : '');
                        var market = ((receivings[i].customer && receivings[i].customer.market) ? receivings[i].customer.market.name : '');
                        var area = ((receivings[i].customer && receivings[i].customer.market && receivings[i].customer.market.area) ? receivings[i].customer.market.area.name : '');
                        var invoice_id = ((receivings[i].invoice) ? receivings[i].invoice.id : '');
                        var order_id = ((receivings[i].invoice && receivings[i].invoice.order) ? receivings[i].invoice.order.id : '');
                        var amount = ((receivings[i].amount) ? receivings[i].amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '');
                        var is_received_input = (receivings[i].is_received == 0) ? ('<input value="'+receiving_id+'" class="is_received" type="checkbox">') : ('<input value="'+receiving_id+'" class="is_received" type="checkbox" checked>');
                        var outstanding_balance = ((receivings[i].customer && receivings[i].customer.outstanding_balance) ? receivings[i].customer.outstanding_balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '');
                        $('.ledger_wrapper').prepend('<tr><td>'+date_punched+'</td><td>'+collected_by+'</td><td>'+customer_name+'</td><td>'+market+'</td><td>'+area+'</td><td>'+invoice_id+'</td><td>'+order_id+'</td><td>Rs. '+amount+'</td><td>'+is_received_input+'</td><td>Rs. '+outstanding_balance+'</td></tr>');
                        // <tr><td>cus</td><td>market</td><td>area</td><td>1</td><td>2</td><td>Rs. 440</td></tr>
                    }
                    // set total amount
                    $('.detail_total').html('Rs. ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }


                $('#detailLedgerModal').modal('show');
                // new Date(client.ledgers[i].transaction_date).toDateString()
            });

            // on generate_receivings_excel click
            $('.generate_receivings_excel').on('click', function(){
                // transaction_dates
                $('.transaction_dates').each(function(){
                    $('#dummy_form').append('<input name="transaction_dates[]" value="'+$(this).text()+'"></input>')
                });
                // amounts
                $('.amounts').each(function(){
                    $('#dummy_form').append('<input name="amounts[]" value="'+$(this).text()+'"></input>')
                });
                // details
                $('.details').each(function(){
                    $('#dummy_form').append('<input name="details[]" value="'+$(this).text()+'"></input>')
                });
                // title
                $('#dummy_form').append('<input name="title" value="'+$('#detailLedgerModalLabel').text()+'"></input>')
                // total
                $('#dummy_form').append('<input name="total" value="'+$('.detail_total').text()+'"></input>')
                // submit
                $('#dummy_form').submit();
            });

            // on is_received click
            $('#detailLedgerModal').on('click', '.is_received', function(){
                // alert($(this).is(':checked'));
                // console.log($(this).val());
                var receiving_id = $(this).val();
                $.ajax({
                    url: "<?php echo(route('toggle_is_received')); ?>",
                    type: 'GET',
                    async: false,
                    data: {receiving_id: receiving_id},
                    dataType: 'JSON',
                    success: function (data) {
                        $(this).prop("checked", !$(this).prop("checked"));
                    }
                });

            });
        });
    </script>

@endsection('content_body')
