<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class FrontController extends Controller
{
    public function main(Request $request)
    {
        // dd($request->all());
        if(isset($request['query'])){
            $query = $request['query'];
            $products = Product::where('webpage_name', 'LIKE', '%'.$query.'%')
                                ->orWhere('webpage_description', 'LIKE', '%'.$query.'%')
                                ->paginate(12);
        }
        else{
            $products = Product::where('is_published', 1)->paginate(12);
        }
        return view('customer.main', compact('products'));
    }

    public function order_history(Request $request)
    {
        return view('customer.order_history');
    }

    public function individual_product(Request $request, $id)
    {
        $product = Product::find($id);
        if($product->is_published == 0){
            return redirect()->back();
        }
        return view('customer.product', compact('product'));
    }

    public function about_us(Request $request)
    {
        return view('customer.about_us');
    }

    public function coming_soon(Request $request)
    {
        return view('customer.coming_soon');
    }
}
