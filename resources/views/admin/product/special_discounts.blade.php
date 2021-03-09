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
    <h2 class="text-center display-3">Special Discounts</h2>
    <form action="{{route('customer_schedule')}}" method="get">
        @csrf
        <div class="row" data-select2-id="12">
            <div class="col-md-10 offset-md-1" data-select2-id="11">
                <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                    <!-- Category -->
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Category:</label>
                            <select class="form-control category_id" name="category_id">
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Brand -->
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Brand:</label>
                            <select class="form-control brand_id" name="brand_id">
                                <option value="">Select brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Product -->
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Article:</label>
                            <select class="form-control product_id" name="product_id">
                                <option value="">Select article</option>
                            </select>
                        </div>
                    </div>
                    <!-- search button -->
                    <div class="col-md-1 col-sm-12">
                        <div class="form-group">
                            <label>&nbsp</label>
                            <button type="button" class="btn btn-block btn-primary form-control fetch_special_discounts" disabled="disabled">Search</button>
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

    <!-- Ledger view -->
    <div class="modal fade" id="specialDiscountModal" tabindex="-1" role="dialog" aria-labelledby="specialDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header row">
                    <h5 class="modal-title" id="specialDiscountModalLabel">Special Discounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-x:auto;">
                    <table class="table table-bordered table-striped table-condensed table-sm">
                        <thead>
                            <!-- headers -->
                            <tr>
                                <th>Customer Name</th>
                                <th>Market</th>
                                <th>Area</th>
                                <th>Price</th>
                                <th>Adjust Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="ledger_wrapper">
                            <tr class="">
                                <td hidden> <input class="special_discount_id" value="" name="special_discount_ids[]"></input> </td>
                                <td>Mr.asdasdas</td>
                                <td>abc</td>
                                <td>xyz</td>
                                <td>Rs. 44.44</td>
                                <td><input class="adjusted_prices" type="number" min=0></input></td>
                                <td><button class="btn-success set_price" type="button">Set Price</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // persistent active sidebar
            var element = $('li a[href*="'+ window.location.pathname +'"]');
            element.parent().parent().parent().addClass('menu-open');
            element.addClass('active');

            // init select2
            $('.category_id').select2();
            $('.brand_id').select2();
            $('.product_id').select2();

            // global vars
            var product= "";
            var special_discounts= "";

            // fetch_by_category_and_brand
            function fetch_by_category_and_brand(){
                var category_id = $('.category_id').val();
                var brand_id = $('.brand_id').val();
                $('.product_id').html('');

                $.ajax({
                    url: '<?php echo(route("fetch_by_category_and_brand")); ?>',
                    type: 'GET',
                    data: {category_id: category_id, brand_id: brand_id},
                    dataType: 'JSON',
                    async: false,
                    success: function (data) {
                        $('.product_id').append('<option value="">Select article</option>');
                        for(var i = 0; i < data.length; i++){
                            $('.product_id').append('<option value="'+data[i].id+'">'+data[i].article+'</option>');
                        }
                        $('.product_id').change();
                    },
                    error: function(data){
                        $('.product_id').append('<option value="">Select article</option>');
                        $('.product_id').change();
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
                        special_discounts = product.special_discounts;
                    }
                });
            }

            // check if all fields are filled
            function check_fields(){
                // get all parameteres
                var product_id = $('.product_id').val();

                if(product_id){
                    $('.fetch_special_discounts').removeAttr('disabled');
                }
                else{
                    $('.fetch_special_discounts').prop('disabled', true);
                }
            }

            // ON CHANGE
            $('.category_id').on('change', function(){
                fetch_by_category_and_brand();
            });
            $('.brand_id').on('change', function(){
                fetch_by_category_and_brand();
            });
            $('.product_id').on('change', function(){
                // check fields
                check_fields();
            });

            // ON CLICK
            // on fetch_special_discounts click
            $('.fetch_special_discounts').on('click', function(){
                var product_id = $('.product_id').val();
                fetch_product(product_id);

                // set title
                $('#specialDiscountModalLabel').html('Special Discounts for: '+(product.category? product.category.name + '-': '')+(product.brand? product.brand.name + '-': '') + product.article);

                // append entries
                $('.ledger_wrapper').html('');
                if(special_discounts.length < 1){
                    $('.ledger_wrapper').prepend('<tr class="table-warning"><td class="text-center" colspan=6>No special discounts found</td></tr>');
                }
                else{
                    console.log(special_discounts);
                    for(var i = 0; i < special_discounts.length; i++){
                        var id = special_discounts[i].id;
                        var customer = (special_discounts[i].customer? special_discounts[i].customer.name: '');
                        var market = ((special_discounts[i].customer && special_discounts[i].customer.market)? special_discounts[i].customer.market.name: '');
                        var area = ((special_discounts[i].customer && special_discounts[i].customer.market && special_discounts[i].customer.market.area)? special_discounts[i].customer.market.area.name: '');
                        var price = ((special_discounts[i].amount)? special_discounts[i].amount: '');
                        $('.ledger_wrapper').append('<tr class=""><td hidden><input type="number" class="special_discount_id" value="'+id+'" name="special_discount_ids[]"></input></td><td>'+customer+'</td><td>'+market+'</td><td>'+area+'</td><td>Rs. '+price+'</td><td><input class="adjusted_prices" type="number" min=0></input></td><td><button class="btn-success set_price" type="button">Set Price</button></td></tr>');
                    }
                }

                $('#specialDiscountModal').modal('show');
            });
            // on set_price click
            $('#specialDiscountModal').on('click', '.set_price', function(){
                var row = $(this).parent().parent();
                var special_discount_id = (row.find('input:first')).val();
                var adjusted_price = (row.find('input:last')).val();
                var price = (row.find('td').eq(4));

                // if price entered
                if(adjusted_price){
                    $.ajax({
                        url: '<?php echo(route("special_discount.update", 1)); ?>',
                        type: 'PUT',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            special_discount_id: special_discount_id,
                            amount: adjusted_price
                        },
                        dataType: 'JSON',
                        async: false,
                        success: function (data) {
                            
                        },
                        error: function(data){
                            price.text('Rs. ' + adjusted_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        }
                    });
                }
                // else
                else{
                    console.log('not found');
                }
            });
        });
    </script>

@endsection('content_body')
