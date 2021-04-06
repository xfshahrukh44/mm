<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderProductService;

class OrderProductController extends Controller
{
    private $orderProductService;

    public function __construct(OrderProductService $orderProductService)
    {
        $this->orderProductService = $orderProductService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        
    }
    
    public function store(Request $request)
    {
        
    }
    
    public function show($id)
    {
        
    }
    
    public function update(Request $request, $id)
    {
        
    }
    
    public function destroy($id)
    {
        
    }

    public function toggle_is_available(Request $request)
    {
        return $this->orderProductService->toggle_is_available($request->order_product_id);
    }
}
