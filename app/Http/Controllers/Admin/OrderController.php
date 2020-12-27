<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\OrderProductService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    private $orderService;
    private $customerService;
    private $productService;
    private $orderProductService;

    public function __construct(OrderService $orderService, CustomerService $customerService, ProductService $productService, OrderProductService $orderProductService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->orderProductService = $orderProductService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $orders = $this->orderService->paginate(env('PAGINATE'));
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        return view('admin.order.order', compact('orders', 'customers', 'products'));
    }

    public function all()
    {
        return $this->orderService->all();
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'total' => 'sometimes',
            'status' => 'sometimes',
            'payment' => 'sometimes',
            'amount_pay' => 'sometimes',
            'dispatch_date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // check status
        if($request->has('pending_status'))
            $request['status'] = 'pending';
        if($request->has('completed_status'))
            $request['status'] = 'completed';

        // $order = [
        //     'customer_id' => $request->customer_id,
        //     'total' => $request->total,
        //     'status' => $request->status,
        //     'orderProducts' => []
        // ];
        // array_push($order['orderProducts'], ["item" => "a", "qty" => 4]);
        // for($i = 0; $i < count($request->products); $i++){
        //     array_push($order['orderProducts'], [

        //     ]);
        // }
        // dd($request->all());

        // create order
        $order = ($this->orderService->create($request->all()))['order']['order'];

        // dd($order);

        if($request->products){
            for($i = 0; $i < count($request->products); $i++){
                $this->orderProductService->create([
                    'order_id' => $order['id'],
                    'product_id' => $request->hidden_product_ids[$i],
                    'quantity' => $request->quantities[$i]
                ]);
            }
        }
        
        // dd($order);
        // create order products
        // for($i = 0; $i < count($request->products); $i++){
            
        // }


        return redirect()->route('order.index');
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->order_id;
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
            'status' => 'sometimes',
            'payment' => 'sometimes',
            'amount_pay' => 'sometimes',
            'dispatch_date' => 'sometimes'
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

    public function fetch_order_products(Request $request)
    {
        $order = ($this->orderService->find($request->order_id))['order'];

        return $order->order_products;
    }
}
