@csrf
<div class="modal-body row">

    <!-- product_id -->
    <div class="form-group col-md-12">
        <label for="">Customer</label>
        <select id="product_id" name="product_id" class="form-control product_id" style="width: 100%; height: 35px;">
            <option value="">Select product</option>
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->article}}</option>
            @endforeach
        </select>
    </div>

    <!-- quantity -->
    <div class="form-group col-md-6">
        <label for="">Quantity</label>
        <input id="quantity" type="number" name="quantity" placeholder="Enter quantity" class="form-control quantity" required min=0>
    </div>

    <!-- transaction_date -->
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Transaction Date:</label>
            <input name="transaction_date" class="form-control transaction_date" id="transaction_date" type="date">
        </div>
    </div>

</div>