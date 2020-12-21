@csrf
<div class="modal-body">
    <div class="col-md-12">
        <div class="row">
            <!-- product -->
            <div class="form-group col-md-4">
                <label>Product:</label> <br>
            </div>
            <!-- Selling price -->
            <div class="form-group col-md-4">
                <label for="">Selling Price:</label>
            </div>
            <!-- quantity -->
            <div class="form-group col-md-3">
                <label for="">Quantity:</label>
            </div>
            <!-- add child -->
            <div class="form-group col-md-0 add_button ml-1" style="display: table; vertical-align: middle;">
                <a class="btn btn-primary">
                    <i class="fas fa-plus" style="color:white;"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Children -->
    <div class="col-md-12 field_wrapper">
        <div class="row">
            <!-- product -->
            <div class="col-md-4">
                <div class="ui-widget">
                    <input class="form-control product_search" name="products[]">
                    <input class="hidden_product_search" type="hidden" name="hidden_product_ids[]">
                </div>
            </div>
            <!-- price -->
            <div class="form-group col-md-4">
                <input type="number" class="form-control prices" name="prices[]" required min=0>
            </div>
            <!-- quantity -->
            <div class="form-group col-md-3">
                <input type="number" class="form-control quantities" name="quantities[]" required min=0 value=0>
            </div>
        </div>
    </div>
</div>