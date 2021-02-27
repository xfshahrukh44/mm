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
    <h2 class="text-center display-3">Customer Schedule</h2>
    <form action="{{route('customer_schedule')}}" method="get">
        @csrf
        <div class="row" data-select2-id="12">
            <div class="col-md-10 offset-md-1" data-select2-id="11">
                <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                    <!-- Area -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Area:</label>
                            <select class="form-control area_id" name="area_id">
                                <option value="">Select area</option>
                                @foreach($areas as $area)
                                    <option value="{{$area->id}}">{{$area->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Market -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Market:</label>
                            <select class="form-control market_id" name="market_id">
                                <option value="">Select market</option>
                                <!-- append here -->
                            </select>
                        </div>
                    </div>
                    <!-- Number of Customers -->
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Number of Customers</label>
                            <input class="form-control number_of_customers" type="number" readonly min=0 value=0 style="border-color: transparent;">
                        </div>
                    </div>
                    <!-- Visiting Day -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Set Visiting Day:</label>
                            <select class="form-control visiting_day" name="visiting_day">
                                <option value="">Select Visiting day</option>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                            </select>
                        </div>
                    </div>
                    <!-- search button -->
                    <div class="col-md-1 col-sm-12">
                        <div class="form-group">
                            <label>&nbsp</label>
                            <button type="button" class="btn btn-block btn-primary form-control set_customer_schedule" disabled="disabled">Set</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- dummy form -->
    <form id="dummy_form" action="{{route('generate_expenses_excel')}}" method="POST" target="_blank" hidden>
        @csrf
    </form>

    <script>
        $(document).ready(function(){
            // persistent active sidebar
            var element = $('li a[href*="'+ window.location.pathname +'"]');
            element.parent().parent().parent().addClass('menu-open');
            element.addClass('active');

            // init select2
            // $('.area_id').select2();
            // $('.market_id').select2();
            // $('.visiting_day').select2();

            // global vars
            var total = 0;
            var wild_card = 0;
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            // fetch markets by area id
            function fetch_specific_markets(area_id){
                $.ajax({
                    url: '<?php echo(route("fetch_specific_markets")); ?>',
                    type: 'GET',
                    data: {area_id: area_id},
                    dataType: 'JSON',
                    async: false,
                    success: function (data) {
                    $('.market_id').html('<option value="">Select market</option>');
                    for(var i = 0; i < data.length; i++){
                        $('.market_id').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
                    }
                    },
                    error: function(data){
                    $('.market_id').html('<option value="">Select market</option>');
                    $('.market_id').fadeOut(200);
                    }
                });
            }

            // check if all fields are filled
            function check_fields(){
                // get all parameteres
                var area_id = $('.area_id').val();
                var market_id = $('.market_id').val();
                var visiting_day = $('.visiting_day').val();
                var number_of_customers = $('.number_of_customers').val();

                if(area_id && market_id && visiting_day && (number_of_customers > 0)){
                    $('.set_customer_schedule').removeAttr('disabled');
                }
                else{
                    $('.set_customer_schedule').prop('disabled', true);
                }
            }

            // on type change
            $('.visiting_day').on('change', function(){check_fields();});
            $('.number_of_customers').on('change', function(){check_fields();});

            //on area id change
            $('.area_id').on('change', function(){
                // check fields
                check_fields();
                var area_id = $(this).val();
                fetch_specific_markets(area_id);
            });

            $('.market_id').on('change', function(){
                // check fields
                check_fields();
                var market_id = $(this).val();
                $.ajax({
                    url: '<?php echo(route("fetch_customer_count")); ?>',
                    type: 'GET',
                    data: {market_id: market_id},
                    dataType: 'JSON',
                    async: false,
                    success: function (data) {
                        $('.number_of_customers').val(data);
                        $('.number_of_customers').change();
                    },
                    error: function(data){
                        $('.number_of_customers').val(0);
                        $('.number_of_customers').change();
                    }
                });
            });

            // on search expenses click
            $('.set_customer_schedule').on('click', function(){
                var market_id = $('.market_id').val();
                var visiting_day = $('.visiting_day').val();
                $.ajax({
                    url: '<?php echo(route("set_customer_schedule")); ?>',
                    type: 'GET',
                    data: {market_id: market_id, visiting_day: visiting_day},
                    dataType: 'JSON',
                    async: false,
                    success: function (data) {
                        // $('.area_id').select2('val', '');
                        $('.area_id option[value=""]').prop('selected', true);
                        $('.market_id option[value=""]').prop('selected', true);
                        $('.visiting_day option[value=""]').prop('selected', true);
                        $('.number_of_customers').val(0);
                        toastr["success"]("Customer schedule set successfully!", "Success");
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
        });
    </script>

@endsection('content_body')
