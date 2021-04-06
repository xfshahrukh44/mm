@extends('customer.app')

@section('content')
    <div class="row mt-5">
        @foreach($products as $product)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a style="color: inherit;" href="{{route('individual_product', $product->id)}}">
                    <div class="card">
                        <img src="{{asset('img/products') . '/' . $product->product_picture}}" class="card-img-top" alt="..."/>
                        <div class="card-body">
                            <h6 class="card-title">{{$product->webpage_name}}</h6>
                            <p class="card-text">
                                {{$product->webpage_description}}
                            </p>
                            <div class="btn-wrapper text-center text-sm d-flex">
                                @if(auth()->user() && auth()->user()->type == "customer")
                                    <a class="btn button_orange ml-2 third text-white d-flex" href="{{route('individual_product', $product->id)}}">Add to Cart</a>
                                @endif
                                <a class="btn btn-success text-sm">{{'Rs. ' . number_format($product->webpage_price, 2)}}</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="card-footer ml-auto">
        @if(count($products) > 0)
        {{$products->appends(request()->except('page'))->links()}}
        @endif
    </div>
@endsection