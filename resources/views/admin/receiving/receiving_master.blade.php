@csrf
<div class="modal-body row">

    <!-- invoice_id -->
    <div class="form-group col-md-12 invoice_id_wrapper">
        <label for=""><i class="nav-icon fas fa-users"></i> Invoice</label>
        <select id="invoice_id" name="invoice_id" class="form-control invoice_id" style="width: 100%; height: 35px;">
            <option value="">Select invoice</option>
            @foreach($invoices as $invoice)
                <option value="{{$invoice->id}}">{{$invoice->id}}</option>
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
            <tr role="row">
                <td>Amount Paid</td>
                <td class="amount_pay"></td>
            </tr>
            <tr role="row">
                <td>Invoice Due</td>
                <td class="invoice_due"></td>
            </tr>
            <tr role="row">
                <td>Amount</td>
                <td class=""><input id="amount" type="number" name="amount" placeholder="Enter amount" class="form-control amount" required min=0></td>
            </tr>
        </tbody>
    </table>

</div>