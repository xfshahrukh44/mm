@csrf
<div class="modal-body row">

    <!-- vendor_id -->
    <div class="form-group col-md-12 vendor_id_wrapper">
        <label for=""><i class="nav-icon fas fa-users"></i> Vendor</label>
        <select id="vendor_id" name="vendor_id" class="form-control vendor_id" style="width: 100%; height: 35px;">
            <option value="">Select vendor</option>
            @foreach($vendors as $vendor)
                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
            @endforeach
        </select>
    </div>
    
    <!-- order_id -->
    <!-- <div class="form-group col-md-2">
        <label for="">Order ID</label>
        <input id="order_id" type="number" name="order_id" class="form-control order_id" readonly>
    </div> -->

    <!-- customer -->
    <!-- <div class="form-group col-md-2">
        <label for="">Customer Name</label>
        <input id="customer" type="text" name="customer" class="form-control customer" readonly>
    </div> -->

    <!-- outstanding_balance -->
    <!-- <div class="form-group col-md-2">
        <label for="">Outstanding Balance</label>
        <input id="outstanding_balance" type="number" name="outstanding_balance" class="form-control outstanding_balance" readonly>
    </div> -->

    <!-- total -->
    <!-- <div class="form-group col-md-2">
        <label for="">Invoice Total</label>
        <input id="total" type="number" name="total" class="form-control total" readonly>
    </div> -->

    <!-- amount_pay -->
    <!-- <div class="form-group col-md-2">
        <label for="">Amount Paid</label>
        <input id="amount_pay" type="number" name="amount_pay" class="form-control amount_pay" readonly>
    </div> -->

    <!-- amount -->
    <!-- <div class="form-group col-md-2">
        <label for="">Amount</label>
        <input id="amount" type="number" name="amount" placeholder="Enter amount" class="form-control amount" required min=0>
    </div> -->

    <table class="table table-bordered table-striped">
        <tbody>
            <tr role="row">
                <td>Outstanding Balance</td>
                <td class="outstanding_balance"></td>
            </tr>
            <tr role="row">
                <td>Amount</td>
                <td class=""><input id="amount" type="number" name="amount" placeholder="Enter amount" class="form-control amount" required min=0></td>
            </tr>
        </tbody>
    </table>

</div>