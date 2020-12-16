<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockInService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class StockInController extends Controller
{
    private $stockInService;
    private $productService;

    public function __construct(StockInService $stockInService, ProductService $productService)
    {
        $this->stockInService = $stockInService;
        $this->productService = $productService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $stockIns = $this->stockInService->paginate(env('PAGINATE'));
        $products = $this->productService->all();
        return view('admin.stockIn.stockIn', compact('stockIns', 'products'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|int',
            'quantity' => 'required',
            'transaction_date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->stockInService->create($request->all());

        return redirect()->route('stock_in.index');
    }
    
    public function show($id)
    {
        return $this->stockInService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $stockIn = ($this->show($id))['stockIn'];

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'sometimes|int',
            'quantity' => 'sometimes',
            'transaction_date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->stockInService->update($request->all(), $id);

        return redirect()->route('stock_in.index');
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->stockInService->delete($id);

        return redirect()->route('stock_in.index');
    }

    public function search_stockIns(Request $request)
    {
        $query = $request['query'];
        
        $stockIns = $this->stockInService->search_stockIns($query);
        $products = $this->productService->all();

        return view('admin.stockIn.stockIn', compact('stockIns', 'products'));
    }
}
