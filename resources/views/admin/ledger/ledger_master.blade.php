@csrf
<div class="modal-body row">

    <!-- customer_id -->
    <div class="form-group col-md-12">
        <label for=""><i class="nav-icon fas fa-users"></i> Customer</label>
        <select id="customer_id" name="customer_id" class="form-control customer_id" style="width: 100%; height: 35px;">
            <option value="">Select customer</option>
            @foreach($customers as $customer)
                <option value="{{$customer->id}}">{{$customer->name}}</option>
            @endforeach
        </select>
    </div>

    <!-- amount -->
    <div class="form-group col-md-4">
        <label for="">Amount</label>
        <input id="amount" type="number" name="amount" placeholder="Enter amount" class="form-control amount" required min=0>
    </div>

    <!-- type -->
    <div class="form-group col-md-4">
        <label for="">Type</label>
        <select id="type" name="type" class="form-control type" style="width: 100%; height: 35px;">
            <option value="">Select type</option>
            <option value="cash">Cash</option>
            <option value="credit">Credit</option>
        </select>
    </div>

    <!-- transaction_date -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Transaction Date:</label>
            <input name="transaction_date" class="form-control transaction_date" id="transaction_date" type="date">
        </div>
    </div>

</div>