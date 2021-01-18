<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VendorService;
use App\Services\AreaService;
use App\Services\MarketService;
use App\Services\ProductService;
use App\Services\SpecialDiscountService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class VendorController extends Controller
{
    private $vendorService;
    private $areaService;
    private $marketService;
    private $productService;
    private $specialDiscountService;

    public function __construct(VendorService $vendorService, AreaService $areaService, MarketService $marketService, ProductService $productService, SpecialDiscountService $specialDiscountService)
    {
        $this->vendorService = $vendorService;
        $this->areaService = $areaService;
        $this->marketService = $marketService;
        $this->productService = $productService;
        $this->specialDiscountService = $specialDiscountService;
        $this->middleware('auth');
    }

    public function index()
    {
        $vendors = $this->vendorService->paginate(env('PAGINATE'));
        $areas = $this->areaService->all();
        $markets = $this->marketService->all();
        $products = $this->productService->all();
        return view('admin.vendor.vendor', compact('vendors', 'areas', 'markets', 'products'));
    }

    public function all()
    {
        return $this->vendorService->all();
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'area_id' => 'sometimes',
            'address' => 'sometimes',
            'business_to_date' => 'sometimes',
            'outstanding_balance' => 'sometimes',
            'contact_number' => 'sometimes',
            'whatsapp_number' => 'sometimes',
            'type' => 'sometimes',
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
        
        $this->vendorService->create($req);

        // return redirect()->route('vendor.index');
        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->vendorService->find($_REQUEST['id']);
        }
        return $this->vendorService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $vendor = ($this->show($id))['vendor'];

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'area_id' => 'sometimes',
            'address' => 'sometimes',
            'business_to_date' => 'sometimes',
            'outstanding_balance' => 'sometimes',
            'contact_number' => 'sometimes',
            'whatsapp_number' => 'sometimes',
            'type' => 'sometimes',
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
            Storage::disk('shops')->delete($vendor->shop_picture);
            $image = $request->shop_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('shops')->put($imageName, \File::get($image));
            $req['shop_picture'] = $imageName;
        }
        
        // shop_keeper_picture
        if($request->shop_keeper_picture){
            Storage::disk('shopkeepers')->delete($vendor->shop_keeper_picture);
            $image = $request->shop_keeper_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('shopkeepers')->put($imageName, \File::get($image));
            $req['shop_keeper_picture'] = $imageName;
        }

        // $vendor = ($this->vendorService->update($req, $id))['vendor']['vendor'];
        $this->vendorService->update($req, $id);

        // return redirect()->route('vendor.index');
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->vendorService->delete($id);

        // return redirect()->route('vendor.index');
        return redirect()->back();
    }

    public function search_vendors(Request $request)
    {
        $query = $request['query'];
        
        $vendors = $this->vendorService->search_vendors($query);
        $areas = $this->areaService->all();
        $markets = $this->marketService->all();

        return view('admin.vendor.vendor', compact('vendors', 'areas', 'markets'));
    }

    public function fetch_vendor_labels()
    {
        $vendors = $this->vendorService->all();
        $new_vendors = [];
        foreach($vendors as $vendor){
            array_push($new_vendors, [
                'label' => $vendor->name,
                'value' => $vendor->id
            ]);
        }

        return $new_vendors;
    }
}
