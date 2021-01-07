<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SpecialDiscountService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SpecialDiscountController extends Controller
{
    private $specialDiscountService;

    public function __construct(SpecialDiscountService $specialDiscountService)
    {
        $this->specialDiscountService = $specialDiscountService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $specialDiscounts = $this->specialDiscountService->paginate(env('PAGINATE'));
        return view('admin.specialDiscount.specialDiscount', compact('specialDiscounts'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'product_id' => 'required',
            'amount' => 'required',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->specialDiscountService->create($request->all());

        return redirect()->route('specialDiscount.index');
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->id;
        return $this->specialDiscountService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes',
            'product_id' => 'sometimes',
            'amount' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->specialDiscountService->update($request->all(), $id);

        return redirect()->route('specialDiscount.index');
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->specialDiscountService->delete($id);

        return redirect()->route('specialDiscount.index');
    }
}
