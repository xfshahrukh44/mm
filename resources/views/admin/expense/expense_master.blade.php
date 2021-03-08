@csrf
<div class="modal-body row">

    <!-- type -->
    <div class="form-group col-md-4">
        <label for="">Type</label>
        <select id="type" name="type" class="form-control type" style="width: 100%; height: 35px;">
            <option value="">Select type</option>
            <option value="Transport">Transport</option>
            <option value="Riders Fuel">Riders Fuel</option>
            <option value="Marketing expense">Marketing expense</option>
            <option value="Salary & wages">Salary & wages</option>
            <option value="Staff entertainment">Staff entertainment</option>
            <option value="Lunch">Lunch</option>
            <option value="Repair and maintenance">Repair and maintenance</option>
            <option value="Other charges">Other charges</option>
            <option value="Commission">Commission</option>
            <option value="Stock damage">Stock damage</option>
            <option value="Stock misplace">Stock misplace</option>
            <option value="Stock theft">Stock theft</option>
            <option value="Customer discount">Customer discount</option>
            <option value="Bad Debt">Bad Debt</option>
        </select>
    </div>

    <!-- amount -->
    <div class="form-group col-md-4">
        <label for="">Amount</label>
        <input id="amount" type="number" name="amount" placeholder="Enter amount" class="form-control amount" required min=0>
    </div>

    <!-- date -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Transaction Date:</label>
            <input name="date" class="form-control date" id="date" type="date">
        </div>
    </div>

    <!-- detail -->
    <div class="form-group col-md-12">
        <label for="">Detail</label>
        <textarea type="text" name="detail" placeholder="Enter Details" class="form-control detail"></textarea>
    </div>

    <!-- customer_id -->
    <div class="form-group col-md-12 customer_wrapper" hidden>
        <label for="">Customer</label>
        <select id="customer_id" name="customer_id" class="form-control customer_id" style="width: 100%; height: 35px;">
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{$customer->id}}">{{customer_shop_name($customer->id)}}</option>
            @endforeach
        </select>
    </div>

</div>