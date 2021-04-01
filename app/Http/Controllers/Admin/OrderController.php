<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\OrderProductService;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    private $orderService;
    private $customerService;
    private $productService;
    private $orderProductService;
    private $userService;

    public function __construct(OrderService $orderService, CustomerService $customerService, ProductService $productService, OrderProductService $orderProductService, UserService $userService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->orderProductService = $orderProductService;
        $this->userService = $userService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(!Gate::allows('can_orders')){
            return redirect()->route('search_marketing_tasks');
        }
        $orders = $this->orderService->paginate(env('PAGINATE'));
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        // $riders = $this->userService->all_riders();
        $riders = $this->userService->all();
        return view('admin.order.order', compact('orders', 'customers', 'products', 'riders'));
    }

    public function all()
    {
        return $this->orderService->all();
    }
    
    public function store(Request $request)
    {
        if(!Gate::allows('can_add_orders')){
            return redirect()->route('search_marketing_tasks');
        }
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'total' => 'sometimes',
            'status' => 'sometimes',
            'payment' => 'sometimes',
            'amount_pay' => 'sometimes',
            'dispatch_date' => 'sometimes',
            'image' => 'sometimes',
            'description' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // check status
        if($request->has('pending_status'))
            $request['status'] = 'pending';
        if($request->has('completed_status'))
            $request['status'] = 'completed';

        // image work
        $req = Arr::except($request->all(),['image']);
        // image
        if($request->image){
            // dd(Storage::disk('order_images'));
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('order_images')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // create order
        $order = ($this->orderService->create($req))['order']['order'];
        
        if($request->products){
            for($i = 0; $i < count($request->products); $i++){
                $this->orderProductService->create([
                    'order_id' => $order['id'],
                    'product_id' => $request->hidden_product_ids[$i],
                    'quantity' => $request->quantities[$i],
                    'price' => $request->prices[$i],
                ]);
            }
        }
        
        return redirect()->back();
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->order_id;
        return $this->orderService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        if(!Gate::allows('can_edit_orders')){
            return redirect()->route('search_marketing_tasks');
        }
        $id = $request->hidden;
        $order = ($this->orderService->find($id))['order'];

        // if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        // {
        //     return response()->json([
        //         'success' => FALSE,
        //         'message' => 'Not allowed.'
        //     ]);
        // }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes',
            'total' => 'sometimes',
            'status' => 'sometimes',
            'payment' => 'sometimes',
            'amount_pay' => 'sometimes',
            'dispatch_date' => 'sometimes',
            'image' => 'sometimes',
            'description' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        
        // image work
        $req = Arr::except($request->all(),['image']);

        // image
        if($request->image){
            Storage::disk('order_images')->delete($customer->image);
            $image = $request->image;
            $imageName = Str::random(10).'.png';
            Storage::disk('order_images')->put($imageName, \File::get($image));
            $req['image'] = $imageName;
        }

        // update order
        $this->orderService->update($req, $id);

        if($request->products){
            // delete old
            foreach($order->order_products as $order_product){
                if($order_product->invoiced == 0){
                    $order_product->delete();
                }
            }
            // create new
            for($i = 0; $i < count($request->products); $i++){
                $this->orderProductService->create([
                    'order_id' => $order['id'],
                    'product_id' => $request->hidden_product_ids[$i],
                    'quantity' => $request->quantities[$i],
                    'price' => $request->prices[$i],
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        if(!Gate::allows('can_delete_orders')){
            return redirect()->route('search_marketing_tasks');
        }
        $id = $request->hidden;

        $this->orderService->delete($id);

        return redirect()->back();
    }

    public function search_orders(Request $request)
    {
        $data = [];
        $data['query'] = $request['query'];
        $data['dispatch_date'] = $request['dispatch_date'];
        
        $orders = $this->orderService->search_orders($data);
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        // $riders = $this->userService->all_riders();
        $riders = $this->userService->all();

        return view('admin.order.order', compact('orders', 'customers', 'products', 'riders'));
    }

    public function fetch_order_products(Request $request)
    {
        $order = ($this->orderService->find($request->order_id))['order'];

        return $order->order_products;
    }

    public function ready_to_dispatch(Request $request)
    {
        return $this->orderService->ready_to_dispatch($request->order_id);
    }
}
