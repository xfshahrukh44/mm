@extends('customer.app')

@section('content')
    <div class="row  mt-5 ">
        <div class="col-lg-6 col-md-12 col-sm-12 col-12 justify-content-center">
        <img src="{{asset('img/products') . '/' . $product->product_picture}}" class="img-fluid ml-2 " width="600" height="600">
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 col-12 justify-content-center mt-3">
            <h5 class=" ">{{$product->webpage_name}}</h6>
            <p class="card-text">
                {{$product->webpage_description}}
            </p>
            <!-- <h6 class="">1 unit</h4> -->
            <h5 class="mt-4 text-success">{{'Rs. ' . number_format($product->webpage_price, 2)}}</h5>
            <!-- <label>Quantity </label> -->
            @if(auth()->user() && auth()->user()->type == "customer")
                <br>
                <button type="button" onclick="addTheValue(-1)" class="btn btn-sm btn-danger mt-2"> <i class="fa fa-minus"></i> </button>
                <b id="firstValue" style="padding: 10px;">0</b>
                <button type="button" onclick="addTheValue(1)" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> </button>
                <br>
                <button type="button" onclick="addTheValue(1)" class="btn  btn-success mt-5"><i class="fa fa-cart-plus"></i> Add to Cart  </button>
            @endif
        </div>
    </div>
@endsection