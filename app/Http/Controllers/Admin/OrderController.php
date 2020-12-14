<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    private $orderService;
    private $customerService;
    private $productService;

    public function __construct(OrderService $orderService, CustomerService $customerService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $orders = $this->orderService->paginate(env('PAGINATE'));
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        return view('admin.order.order', compact('orders', 'customers', 'products'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'total' => 'sometimes',
            'status' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->orderService->create($request->all());

        return redirect()->route('order.index');
    }
    
    public function show($id)
    {
        return $this->orderService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $order = ($this->show($id))['order'];

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes',
            'total' => 'sometimes',
            'status' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        
        $this->orderService->update($request->all(), $id);

        return redirect()->route('order.index');
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->orderService->delete($id);

        return redirect()->route('order.index');
    }

    public function search_orders(Request $request)
    {
        $query = $request['query'];
        
        $orders = $this->orderService->search_orders($query);
        $customers = $this->customerService->all();
        $products = $this->productService->all();

        return view('admin.order.order', compact('orders', 'customers', 'products'));
    }
}
