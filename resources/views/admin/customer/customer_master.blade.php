@csrf
<div class="modal-body row">
    <!-- name -->
    <div class="form-group col-md-6">
        <label for="">Name</label>
        <input id="name" type="text" name="name" placeholder="Enter name" class="form-control name" required max="50">
    </div>
    <!-- contact_number -->
    <div class="form-group col-md-6">
        <label for="">Contact #</label>
        <input id="contact_number" type="text" name="contact_number" placeholder="Enter Contact #" class="form-control contact_number" required max="50">
    </div>
    <!-- whatsapp_number -->
    <div class="form-group col-md-6">
        <label for="">Whatsapp #</label>
        <input id="whatsapp_number" type="text" name="whatsapp_number" placeholder="Enter Contact #" class="form-control contact_number" required max="50">
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
        <select id="market_id" name="market_id" class="form-control market_id" style="width: 100%; height: 35px;">
            <option value="">Select market</option>
        </select>
    </div>
    <!-- business_to_date -->
    <div class="form-group col-md-6">
        <label for="">Business to Date</label>
        <input id="business_to_date" type="text" name="business_to_date" placeholder="Enter Business to Date" class="form-control business_to_date" required max="50">
    </div>
    <!-- outstanding_balance -->
    <div class="form-group col-md-6">
        <label for="">Outstanding Balance</label>
        <input id="outstanding_balance" type="text" name="outstanding_balance" placeholder="Enter Outstanding Balance" class="form-control outstanding_balance" required max="50">
    </div>
    <!-- shop_picture -->
    <div class="form-group col-md-6">
        <label for="">Shop Picture</label>
        <input id="shop_picture" type="file" name="shop_picture" placeholder="Upload Shop Picture"
        class="form-control">
    </div>
    <!-- shop_keeper_picture -->
    <div class="form-group col-md-6">
        <label for="">Shopkeeper Picture</label>
        <input id="shop_keeper_picture" type="file" name="shop_keeper_picture" placeholder="Upload Shopkeeper Picture"
        class="form-control">
    </div>
</div>