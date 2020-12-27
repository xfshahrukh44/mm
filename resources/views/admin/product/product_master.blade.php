@csrf
<div class="modal-body row">
    <!-- article -->
    <div class="form-group col-md-6">
        <label for="">Name</label>
        <input id="article" type="text" name="article" placeholder="Enter article" class="form-control article" required>
    </div>
    <!-- product_picture -->
    <div class="form-group col-md-6">
        <label for="">Product Picture</label>
        <input id="product_picture" type="file" name="product_picture" placeholder="Upload Product Picture"
        class="form-control">
    </div>

    <!-- category_id -->
    <div class="form-group col-md-4">
        <label for=""><i class="nav-icon fas fa-copyright"></i> Category</label>
        <!-- Add new -->
        <a href="#" class="add_category float-right mt-2">
            <i class="nav-icon fa fa-plus green"></i>
        </a>
        <select id="category_id" name="category_id" class="form-control category_id" style="width: 100%; height: 35px;">
            <option value="">Select category</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- brand_id -->
    <div class="form-group col-md-4">
        <label for=""><i class="nav-icon fab fa-bootstrap"></i> Brand</label>
        <!-- Add new -->
        <a href="#" class="add_brand float-right mt-2">
            <i class="nav-icon fa fa-plus green"></i>
        </a>
        <select id="brand_id" name="brand_id" class="form-control brand_id" style="width: 100%; height: 35px;">
            <option value="">Select brand</option>
            @foreach($brands as $brand)
                <option value="{{$brand->id}}">{{$brand->name}}</option>
            @endforeach
        </select>
    </div>
    <!-- unit_id -->
    <div class="form-group col-md-4">
        <label for=""><i class="nav-icon fas fa-balance-scale-left"></i> Unit</label>
        <!-- Add new -->
        <a href="#" class="add_unit float-right mt-2">
            <i class="nav-icon fa fa-plus green"></i>
        </a>
        <select id="unit_id" name="unit_id" class="form-control unit_id" style="width: 100%; height: 35px;">
            <option value="">Select unit</option>
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
        </select>
    </div>

    <!-- purchase_price -->
    <div class="form-group col-md-3">
        <label for="">Purchase Price</label>
        <input id="purchase_price" type="number" min=0 name="purchase_price" placeholder="Enter Purchase Price" class="form-control purchase_price" required value=0>
    </div>
    <!-- selling_price -->
    <div class="form-group col-md-3">
        <label for="">Selling Price</label>
        <input id="selling_price" type="number" min=0 name="selling_price" placeholder="Enter Selling Price" class="form-control selling_price" required value=0>
    </div>
    <!-- cost_value -->
    <div class="form-group col-md-3">
        <label for="">Cost Value</label>
        <input id="cost_value" type="number" min=0 name="cost_value" placeholder="Enter Cost Value" class="form-control cost_value" required value=0>
    </div>
    <!-- sales_value -->
    <div class="form-group col-md-3">
        <label for="">Sales Value</label>
        <input id="sales_value" type="number" min=0 name="sales_value" placeholder="Enter Sales Value" class="form-control sales_value" required value=0>
    </div>

    <!-- opening_quantity -->
    <div class="form-group col-md-6">
        <label for="">Opening Quantity</label>
        <input id="opening_quantity" type="number" min=0 name="opening_quantity" placeholder="Enter Opening Quantity" class="form-control opening_quantity" required value=0>
    </div>
    <!-- moq -->
    <div class="form-group col-md-6">
        <label for="">Minimum Ordering Quantity</label>
        <input id="moq" type="number" min=0 name="moq" placeholder="Enter Minimum Ordering Quantity" class="form-control moq" required value=0>
    </div>
</div>