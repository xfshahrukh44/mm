<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\AreaService;
use App\Services\MarketService;
use App\Services\ProductService;
use App\Services\SpecialDiscountService;
use App\Services\CustomerImageService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    private $customerService;
    private $areaService;
    private $marketService;
    private $productService;
    private $specialDiscountService;
    private $customerImageService;

    public function __construct(CustomerService $customerService, AreaService $areaService, MarketService $marketService, ProductService $productService, SpecialDiscountService $specialDiscountService, CustomerImageService $customerImageService)
    {
        $this->customerService = $customerService;
        $this->areaService = $areaService;
        $this->marketService = $marketService;
        $this->productService = $productService;
        $this->specialDiscountService = $specialDiscountService;
        $this->customerImageService = $customerImageService;
        $this->middleware('auth');
    }

    public function index()
    {
        if(!Gate::allows('can_customers')){
            return redirect()->route('search_marketing_tasks');
        }
        // customer status buttons filters on top
        if(array_key_exists('status_button', $_REQUEST)){
            $customers = $this->customerService->paginate_by_status(env('PAGINATE'), $_REQUEST['status_button']);
        }
        else{
            $customers = $this->customerService->paginate(env('PAGINATE'));
        }
        $areas = $this->areaService->all();
        $markets = $this->marketService->all();
        $products = $this->productService->all();
        return view('admin.customer.customer', compact('customers', 'areas', 'markets', 'products'));
    }

    public function all()
    {
        return $this->customerService->all();
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        if(!Gate::allows('can_add_customers')){
            return redirect()->route('search_marketing_tasks');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'market_id' => 'required|int',
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
        $req = Arr::except($request->all(),['shop_picture', 'shop_keeper_picture', 'customer_images']);
        // shop_picture
        if($request->shop_picture){
            $image = $request->shop_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_shops')->put($imageName, \File::get($image));
            $req['shop_picture'] = $imageName;
        }
        
        // shop_keeper_picture
        if($request->shop_keeper_picture){
            $image = $request->shop_keeper_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_shopkeepers')->put($imageName, \File::get($image));
            $req['shop_keeper_picture'] = $imageName;
        }

        // create customer
        $customer = ($this->customerService->create($req))['customer']['customer'];
        
        // customer_images (multiple)
        if($request->customer_images){
            $customer_images = [];
            foreach($request->customer_images as $customer_image){
                $image = $customer_image;
                $imageName = Str::random(10).'.png';
                Storage::disk('customer_images')->put($imageName, \File::get($image));
                array_push($customer_images, $imageName);
            }
            foreach($customer_images as $customer_image){
                $this->customerImageService->create([
                    'customer_id' => $customer->id,
                    'location' => $customer_image,
                ]);
            }
        }

        // special discount work
        if($request->products){
            // create special discounts
            for($i = 0; $i < count($request->products); $i++){
                // here 
                $this->specialDiscountService->create([
                    'customer_id' => $customer->id,
                    'product_id' => $request->products[$i],
                    'amount' => $request->amounts[$i]
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function show($id)
    {
        if(array_key_exists('id', $_REQUEST)){
            return $this->customerService->find($_REQUEST['id']);
        }
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
            Storage::disk('shops')->delete($customer->shop_picture);
            $image = $request->shop_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_shops')->put($imageName, \File::get($image));
            $req['shop_picture'] = $imageName;
        }
        
        // shop_keeper_picture
        if($request->shop_keeper_picture){
            Storage::disk('shopkeepers')->delete($customer->shop_keeper_picture);
            $image = $request->shop_keeper_picture;
            $imageName = Str::random(10).'.png';
            Storage::disk('public_shopkeepers')->put($imageName, \File::get($image));
            $req['shop_keeper_picture'] = $imageName;
        }

        $customer = ($this->customerService->update($req, $id))['customer']['customer'];

        // customer_images (multiple)
        if($request->customer_images){
            $customer_images = [];
            foreach($request->customer_images as $customer_image){
                $image = $customer_image;
                $imageName = Str::random(10).'.png';
                Storage::disk('customer_images')->put($imageName, \File::get($image));
                array_push($customer_images, $imageName);
            }
            foreach($customer_images as $customer_image){
                $this->customerImageService->create([
                    'customer_id' => $customer->id,
                    'location' => $customer_image,
                ]);
            }
        }

        // special discount work
        if($request->products){
            // delete old special discounts
            foreach($customer->special_discounts as $special_discount){
                $special_discount->delete();
            }
            // create new ones
            for($i = 0; $i < count($request->products); $i++){
                // here 
                $this->specialDiscountService->create([
                    'customer_id' => $customer->id,
                    'product_id' => $request->products[$i],
                    'amount' => $request->amounts[$i]
                ]);
            }
        }

        if($request->identifier == 'rider'){
            return $this->getRiders($request);
        }
        
        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->customerService->delete($id);

        return redirect()->back();
    }

    public function search_customers(Request $request)
    {
        $query = $request['query'];
        
        $customers = $this->customerService->search_customers($query);
        $areas = $this->areaService->all();
        $markets = $this->marketService->all();
        $products = $this->productService->all();

        return view('admin.customer.customer', compact('customers', 'areas', 'markets', 'products'));
    }

    public function fetch_customer_labels()
    {
        $customers = $this->customerService->all();
        $new_customers = [];
        foreach($customers as $customer){
            array_push($new_customers, [
                'label' => $customer->name,
                'value' => $customer->id
            ]);
        }

        return $new_customers;
    }

    public function customer_schedule()
    {
        if(!Gate::allows('isSuperAdmin')){
            return redirect()->route('search_marketing_tasks');
        }
        $areas = $this->areaService->all();
        $customers = $this->customerService->all();
        return view('admin.customer.customer_schedule', compact('areas', 'customers'));
    }
}
