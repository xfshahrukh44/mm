@csrf
<div class="modal-body row">
    <!-- name -->
    <div class="form-group col-md-3">
        <label for="">Name</label>
        <input type="text" name="name" placeholder="Enter name" class="form-control name" required>
    </div>
    <!-- contact_number -->
    <div class="form-group col-md-2">
        <label for="">Contact #</label>
        <input type="text" name="contact_number" placeholder="Enter Contact #" class="form-control contact_number">
    </div>
    <!-- whatsapp_number -->
    <div class="form-group col-md-2">
        <label for="">Whatsapp #</label>
        <input type="text" name="whatsapp_number" placeholder="Enter Whatsapp #" class="form-control whatsapp_number">
    </div>
    <!-- type -->
    <div class="form-group col-md-2">
        <label for="">Customer Type</label>
        <select name="type" class="form-control type" style="width: 100%; height: 35px;">
            <option value="">Select Customer Type</option>
            <option value="consumer">Consumer</option>
            <option value="retailer">Retailer</option>
        </select>
    </div>
    <!-- shop_keeper_picture -->
    <div class="form-group col-md-3">
        <label for="">Shopkeeper Picture</label>
        <input type="file" name="shop_keeper_picture" placeholder="Upload Shopkeeper Picture"
        class="form-control">
    </div>
    <!-- shop_name -->
    <div class="form-group col-md-3">
        <label for="">Shop Name</label>
        <input type="text" name="shop_name" placeholder="Enter Shop Name" class="form-control shop_name">
    </div>
    <!-- shop_number -->
    <div class="form-group col-md-3">
        <label for="">Shop #</label>
        <input type="text" name="shop_number" placeholder="Enter Shop #" class="form-control shop_number">
    </div>
    <!-- floor -->
    <div class="form-group col-md-3">
        <label for="">Floor #</label>
        <input type="text" name="floor" placeholder="Enter Floor #" class="form-control floor">
    </div>
    <!-- shop_picture -->
    <div class="form-group col-md-3">
        <label for="">Shop Picture</label>
        <input type="file" name="shop_picture" placeholder="Upload Shop Picture"
        class="form-control">
    </div>
    <!-- area_id -->
    <div class="form-group col-md-6">
        <label for=""><i class="nav-icon  fas fa-map-marked-alt"></i> Area</label>
        <select name="area_id" class="form-control area_id" style="width: 100%; height: 35px;">
            <option value="">Select area</option>
            @foreach($areas as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- market_id -->
    <div class="form-group col-md-6">
        <label for=""><i class="nav-icon  fas fa-map-marked-alt"></i> Market</label>
        <select name="market_id" class="form-control market_id" style="width: 100%; height: 35px;">
            <option value="">Select market</option>
        </select>
    </div>
    <!-- status -->
    <div class="form-group col-md-3">
        <label for="">Status</label>
        <select name="status" class="form-control status" style="width: 100%; height: 35px;">
            <option value="">Select Method</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="interested">Interested</option>
            <option value="follow_up">Follow up</option>
            <option value="not_interested">Not Interested</option>
        </select>
    </div>
    <!-- visiting_days -->
    <div class="form-group col-md-3">
        <label for="">Visting Days</label>
        <select name="visiting_days" class="form-control visiting_days" style="width: 100%; height: 35px;">
            <option value="">Select Day</option>
            <option value="monday">Monday</option>
            <option value="tuesday">Tuesday</option>
            <option value="wednesday">Wednesday</option>
            <option value="thursday">Thursday</option>
            <option value="friday">Friday</option>
            <option value="saturday">Saturday</option>
            <option value="sunday">Sunday</option>
        </select>
    </div>
    <!-- cash_on_delivery -->
    <div class="form-group col-md-3">
        <label for="">Cash on Delivery</label>
        <select name="cash_on_delivery" class="form-control cash_on_delivery" style="width: 100%; height: 35px;">
            <option value="">Select Method</option>
            <option value="credit">Credit</option>
            <option value="bill_to_bill">Bill to Bill</option>
            <option value="weekly">Weekly</option>
            <option value="after_15_days">After 15 Days</option>
            <option value="50%_on_delivery">50% on Delivery</option>
        </select>
    </div>
    <!-- opening_balance -->
    <div class="form-group col-md-3">
        <label for="">Opening Balance</label>
        <input type="number" name="opening_balance" placeholder="Enter Opening Balance" class="form-control opening_balance" value=0>
    </div>
    <!-- business_to_date -->
    <div class="form-group col-md-3" hidden>
        <label for="">Business to Date</label>
        <input type="number" min=0 name="business_to_date" placeholder="Enter Business to Date" class="form-control business_to_date" value=0>
    </div>
    <!-- outstanding_balance -->
    <div class="form-group col-md-3" hidden>
        <label for="">Outstanding Balance</label>
        <input type="number" min=0 name="outstanding_balance" placeholder="Enter Outstanding Balance" class="form-control outstanding_balance" value=0>
    </div>
    <!-- special_discount -->
    <div class="form-group col-md-3" hidden>
        <label for="">Special Discount</label>
        <input type="number" min=0 name="special_discount" placeholder="Enter Special Discount" class="form-control special_discount" value=0>
    </div>
    <!-- payment_terms -->
    <div class="form-group col-md-12">
        <label for="">Payment Terms</label>
        <textarea type="text" name="payment_terms" placeholder="Enter Payment Terms" class="form-control payment_terms"></textarea>
    </div>

    <hr>
    <h3>Special Discounted Prices</h3>
    <hr>
     <!-- Children Labels -->
     <div class="col-md-12">
        <div class="row">
            <!-- product -->
            <div class="form-group col-md-6">
                <label>Product:</label> <br>
            </div>
            <!-- Discounted Price -->
            <div class="form-group col-md-5">
                <label for="">Discounted Price:</label>
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
            <div class="col-md-6 form-group">
                <select name="products[]" class="form-control products" style="width: 100%; max-height: 20px;">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->article}}</option>
                    @endforeach
                </select>
            </div>
            <!-- amount -->
            <div class="form-group col-md-5">
                <input type="number" class="form-control amounts" name="amounts[]" min=0>
            </div>
            <!-- remove child -->
            <div class="form-group col-md-0 remove_button ml-1" style="display: table; vertical-align: middle;">
                <a class="btn btn-primary">
                    <i class="fas fa-minus" style="color:white;"></i>
                </a>
            </div>
        </div>
    </div>
</div>