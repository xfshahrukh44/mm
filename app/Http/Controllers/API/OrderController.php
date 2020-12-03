<?php

namespace App\Http\Controllers\API;

use App\Exceptions\Order\AllOrderException;
use App\Exceptions\Order\CreateOrderException;
use App\Exceptions\Order\DeletedOrderException;
use App\Exceptions\Order\UpdateOrderException;
use App\Exceptions\Group\AllGroupException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $orderService;
    private $customerService;

    public function __construct(OrderService $orderService, CustomerService $customerService)
    {
        $this->orderService = $orderService;
        $this->customerService = $customerService;
        $this->middleware('auth:api');
    }
    
    public function index()
    {
        return response()->json($this->orderService->all());
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'total' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // check if customer exists
        if( ($this->customerService->find($request->customer_id))['success'] == false ){
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ]);
        }

        $data = $this->orderService->create($request->all());

        return response()->json($data);
    }
    
    public function show($id)
    {
        return response()->json($this->orderService->find($id));
    }
    
    public function update(Request $request, $id)
    {
        if(auth()->user()->type != "superadmin")
        {
            return response()->json([
                'success' => false,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes',
            'total' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);
        
        // if customer_id given
        if($request->customer_id){
            // check if customer exists
            if( ($this->customerService->find($request->customer_id))['success'] == false ){
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found.'
                ]);
            }
        }

        $data = $this->orderService->update($request->all(), $id);

        return response()->json($data);
    }
    
    public function destroy($id)
    {
        return $this->orderService->delete($id);
    }
}
