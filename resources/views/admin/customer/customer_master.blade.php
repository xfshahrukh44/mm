@csrf
<div class="modal-body row">
    <!-- name -->
    <div class="form-group col-md-3">
        <label for="">Name</label>
        <input id="name" type="text" name="name" placeholder="Enter name" class="form-control name" required>
    </div>
    <!-- contact_number -->
    <div class="form-group col-md-3">
        <label for="">Contact #</label>
        <input id="contact_number" type="text" name="contact_number" placeholder="Enter Contact #" class="form-control contact_number" required>
    </div>
    <!-- whatsapp_number -->
    <div class="form-group col-md-3">
        <label for="">Whatsapp #</label>
        <input id="whatsapp_number" type="text" name="whatsapp_number" placeholder="Enter Whatsapp #" class="form-control whatsapp_number" required>
    </div>
    <!-- shop_keeper_picture -->
    <div class="form-group col-md-3">
        <label for="">Shopkeeper Picture</label>
        <input id="shop_keeper_picture" type="file" name="shop_keeper_picture" placeholder="Upload Shopkeeper Picture"
        class="form-control">
    </div>
    <!-- shop_name -->
    <div class="form-group col-md-3">
        <label for="">Shop Name</label>
        <input id="shop_name" type="text" name="shop_name" placeholder="Enter Shop Name" class="form-control shop_name" required>
    </div>
    <!-- shop_number -->
    <div class="form-group col-md-3">
        <label for="">Shop #</label>
        <input id="shop_number" type="text" name="shop_number" placeholder="Enter Shop #" class="form-control shop_number" required>
    </div>
    <!-- floor -->
    <div class="form-group col-md-3">
        <label for="">Floor #</label>
        <input id="floor" type="text" name="floor" placeholder="Enter Floor #" class="form-control floor" required>
    </div>
    <!-- shop_picture -->
    <div class="form-group col-md-3">
        <label for="">Shop Picture</label>
        <input id="shop_picture" type="file" name="shop_picture" placeholder="Upload Shop Picture"
        class="form-control">
    </div>
    <!-- area_id -->
    <div class="form-group col-md-6">
        <label for="">Area</label>
        <select id="area_id" name="area_id" class="form-control area_id" style="width: 100%; height: 35px;">
            <option value="">Select area</option>
            @foreach($areas as $area)
                <option value="{{$area->id}}">{{$area->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- market_id -->
    <div class="form-group col-md-6">
        <label for="">Market</label>
        <select id="market_id" name="market_id" class="form-control market_id" style="width: 100%; height: 35px;" required>
            <option value="">Select market</option>
        </select>
    </div>
    <!-- status -->
    <div class="form-group col-md-4">
        <label for="">Status</label>
        <select id="status" name="status" class="form-control status" style="width: 100%; height: 35px;">
            <option value="">Select Method</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="interested">Interested</option>
            <option value="follow_up">Follow up</option>
            <option value="not_interested">Not Interested</option>
        </select>
    </div>
    <!-- visiting_days -->
    <div class="form-group col-md-4">
        <label for="">Visting Days</label>
        <select id="visiting_days" name="visiting_days" class="form-control visiting_days" style="width: 100%; height: 35px;">
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
    <div class="form-group col-md-4">
        <label for="">Cash on Delivery</label>
        <select id="cash_on_delivery" name="cash_on_delivery" class="form-control cash_on_delivery" style="width: 100%; height: 35px;">
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
        <input id="opening_balance" type="number" min=0 name="opening_balance" placeholder="Enter Opening Balance" class="form-control opening_balance" required>
    </div>
    <!-- business_to_date -->
    <div class="form-group col-md-3">
        <label for="">Business to Date</label>
        <input id="business_to_date" type="number" min=0 name="business_to_date" placeholder="Enter Business to Date" class="form-control business_to_date" required>
    </div>
    <!-- outstanding_balance -->
    <div class="form-group col-md-3">
        <label for="">Outstanding Balance</label>
        <input id="outstanding_balance" type="number" min=0 name="outstanding_balance" placeholder="Enter Outstanding Balance" class="form-control outstanding_balance" required>
    </div>
    <!-- special_discount -->
    <div class="form-group col-md-3">
        <label for="">Special Discount</label>
        <input id="special_discount" type="number" min=0 name="special_discount" placeholder="Enter Special Discount" class="form-control special_discount" required>
    </div>
    <!-- payment_terms -->
    <div class="form-group col-md-12">
        <label for="">Payment Terms</label>
        <textarea id="payment_terms" type="text" name="payment_terms" placeholder="Enter Payment Terms" class="form-control payment_terms" required></textarea>
    </div>
</div>