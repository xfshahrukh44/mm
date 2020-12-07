<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\AreaService;
use App\Services\MarketService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class CustomerController extends Controller
{
    private $customerService;
    private $areaService;
    private $marketService;

    public function __construct(CustomerService $customerService, AreaService $areaService, MarketService $marketService)
    {
        $this->customerService = $customerService;
        $this->areaService = $areaService;
        $this->marketService = $marketService;
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = $this->customerService->paginate(env('PAGINATE'));
        $areas = $this->areaService->all();
        $markets = $this->marketService->all();
        return view('admin.customer.customer', compact('customers', 'areas', 'markets'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'market_id' => 'required|int',
            'business_to_date' => 'sometimes',
            'outstanding_balance' => 'sometimes',
            'contact_number' => 'sometimes',
            'whatsapp_number' => 'sometimes',
            'floor' => 'sometimes',
            'shop_name' => 'sometimes',
            'shop_number' => 'sometimes',
            'shop_picture' => 'sometimes',
            'shop_keeper_picture' => 'sometimes',
            'payment_terms' => 'sometimes',
            'cash_on_delivery' => 'sometimes',
            'visiting_days' => 'sometimes',
            'status' => 'sometimes',
            'opening_balance' => 'sometimes',
            'special_discount' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // image work
        $req = Arr::except($request->all(),['shop_picture', 'shop_keeper_picture']);
        // shop_picture
        if($request->shop_picture){
            $image = $request->shop_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('shops')->put($imageName, \File::get($image));
            $req['shop_picture'] = $imageName;
        }
        
        // shop_keeper_picture
        if($request->shop_keeper_picture){
            $image = $request->shop_keeper_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('shopkeepers')->put($imageName, \File::get($image));
            $req['shop_keeper_picture'] = $imageName;
        }

        $this->customerService->create($req);

        return redirect()->route('customer.index');
    }
    
    public function show($id)
    {
        return $this->customerService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $customer = ($this->show($id))['customer'];

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'market_id' => 'required|int',
            'business_to_date' => 'sometimes',
            'outstanding_balance' => 'sometimes',
            'contact_number' => 'sometimes',
            'whatsapp_number' => 'sometimes',
            'floor' => 'sometimes',
            'shop_name' => 'sometimes',
            'shop_number' => 'sometimes',
            'shop_picture' => 'sometimes',
            'shop_keeper_picture' => 'sometimes',
            'payment_terms' => 'sometimes',
            'cash_on_delivery' => 'sometimes',
            'visiting_days' => 'sometimes',
            'status' => 'sometimes',
            'opening_balance' => 'sometimes',
            'special_discount' => 'sometimes',
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        
        // image work
        $req = Arr::except($request->all(),['shop_picture', 'shop_keeper_picture']);

        // shop_picture
        if($request->shop_picture){
            Storage::disk('shops')->delete($customer->shop_picture);
            $image = $request->shop_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('shops')->put($imageName, \File::get($image));
            $req['shop_picture'] = $imageName;
        }
        
        // shop_keeper_picture
        if($request->shop_keeper_picture){
            Storage::disk('shopkeepers')->delete($customer->shop_keeper_picture);
            $image = $request->shop_keeper_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('shopkeepers')->put($imageName, \File::get($image));
            $req['shop_keeper_picture'] = $imageName;
        }

        $this->customerService->update($req, $id);

        if($request->identifier == 'rider'){
            return $this->getRiders($request);
        }

        return redirect()->route('customer.index');
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->customerService->delete($id);

        return redirect()->route('customer.index');
    }

    public function search_customers(Request $request)
    {
        $query = $request['query'];
        
        $customers = $this->customerService->search_customers($query);
        $areas = $this->areaService->all();
        $markets = $this->marketService->all();

        return view('admin.customer.customer', compact('customers', 'areas', 'markets'));
    }
}
