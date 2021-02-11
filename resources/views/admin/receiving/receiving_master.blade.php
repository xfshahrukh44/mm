@csrf
<div class="modal-body row">

    <!-- customer_id -->
    <div class="form-group col-md-12 customer_id_wrapper">
        <label for=""><i class="nav-icon fas fa-users"></i> Customer</label>
        <select name="customer_id" class="form-control customer_id" style="width: 100%; height: 35px;" required>
            <option value="">Select customer</option>
            @foreach($customers as $customer)
                <option value="{{$customer->id}}">{{$customer->name}}</option>
            @endforeach
        </select>
    </div>

    <!-- invoice_id -->
    <div class="form-group col-md-12 invoice_id_wrapper">
        <label for=""><i class="nav-icon fas fa-users"></i> Invoice</label>
        <select name="invoice_id" class="form-control invoice_id" style="width: 100%; height: 35px;">
            <option value="">Select invoice</option>
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
                <td>Order ID</td>
                <td class="order_id"></td>
            </tr>
            <tr role="row">
                <td>Customer Name</td>
                <td class="customer"></td>
            </tr>
            <tr role="row">
                <td>Outstanding Balance</td>
                <td class="outstanding_balance"></td>
            </tr>
            <tr role="row">
                <td>Invoice Total</td>
                <td class="total"></td>
            </tr>
            <tr role="row" hidden>
                <td>Amount Paid</td>
                <td class="amount_pay"></td>
            </tr>
            <tr role="row" hidden>
                <td>Invoice Due</td>
                <td class="invoice_due"></td>
            </tr>
            <tr role="row">
                <td>Amount</td>
                <td class=""><input id="amount" type="number" name="amount" placeholder="Enter amount" class="form-control amount" value=0 required min=0></td>
            </tr>
            <tr role="row" class="payment_date_wrapper" hidden>
                <td>Payment Date</td>
                <td class=""><input id="payment_date" type="date" name="payment_date" placeholder="Enter Payment Date" class="form-control payment_date"></td>
            </tr>
        </tbody>
    </table>

</div>