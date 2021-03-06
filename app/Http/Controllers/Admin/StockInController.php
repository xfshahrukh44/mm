<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockInService;
use App\Services\ProductService;
use App\Services\VendorService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class StockInController extends Controller
{
    private $stockInService;
    private $productService;
    private $vendorService;

    public function __construct(StockInService $stockInService, ProductService $productService, VendorService $vendorService)
    {
        $this->stockInService = $stockInService;
        $this->productService = $productService;
        $this->vendorService = $vendorService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(!Gate::allows('can_stock_in')){
            return redirect()->route('search_marketing_tasks');
        }
        $stockIns = $this->stockInService->paginate(env('PAGINATE'));
        $products = $this->productService->all();
        $vendors = $this->vendorService->all();
        return view('admin.stockIn.stockIn', compact('stockIns', 'products', 'vendors'));
    }
    
    public function store(Request $request)
    {
        if(!Gate::allows('can_add_stock_ins')){
            return redirect()->route('search_marketing_tasks');
        }
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|int',
            'vendor_id' => 'sometimes',
            'quantity' => 'required',
            'rate' => 'required',
            'amount' => 'required',
            'transaction_date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->stockInService->create($request->all());

        return redirect()->back();
    }
    
    public function show($id)
    {
        return $this->stockInService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        if(!Gate::allows('can_edit_stock_ins')){
            return redirect()->route('search_marketing_tasks');
        }
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
            'vendor_id' => 'sometimes',
            'quantity' => 'sometimes',
            'rate' => 'required',
            'amount' => 'required',
            'transaction_date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->stockInService->update($request->all(), $id);

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        if(!Gate::allows('can_delete_stock_ins')){
            return redirect()->route('search_marketing_tasks');
        }
        $id = $request->hidden;

        $this->stockInService->delete($id);

        return redirect()->back();
    }

    public function search_stockIns(Request $request)
    {
        $query = $request['query'];
        
        $stockIns = $this->stockInService->search_stockIns($query);
        $products = $this->productService->all();
        $vendors = $this->vendorService->all();

        return view('admin.stockIn.stockIn', compact('stockIns', 'products', 'vendors'));
    }
}
