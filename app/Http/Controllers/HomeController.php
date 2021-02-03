<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockOut;
use App\Models\Order;
use App\Services\InvoiceService;
use App\Services\InvoiceProductService;
use App\Services\ProductService;
use App\Services\CustomerService;
use App\Services\VendorService;
use Excel;
use App\Exports\ExpensesExport;
use App\Exports\LedgersExport;
use App\Exports\SalesExport;
use App\Exports\CustomerExport;
use App\Exports\VendorExport;
use App\Exports\ProductExport;
use Carbon\Carbon;

class HomeController extends Controller
{
    private $invoiceService;
    private $invoiceProductService;
    private $productService;
    private $customerService;
    private $vendorService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService, InvoiceProductService $invoiceProductService, ProductService $productService, CustomerService $customerService, VendorService $vendorService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;
        $this->invoiceProductService = $invoiceProductService;
        $this->productService = $productService;
        $this->customerService = $customerService;
        $this->vendorService = $vendorService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard.dashboard');
    }

    public function plug_n_play(Request $request)
    {
        // dd($request->all());
        // $products = Product::where('type', 'other')->get();
        // foreach($products as $product){
        //     $product->gender = 'both';
        //     $product->save();
        // }

        $today =lcfirst(Carbon::today()->format('l'));
        $tomorrow =lcfirst(Carbon::tomorrow()->format('l'));
        dd($today, $tomorrow);
    }

    public function generate_invoice_pdf($id)
    {
        return $this->invoiceService->generate_invoice_pdf($id);
    }

    public function sales_ledgers()
    {
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        return view('admin.sales.sales_search', compact('customers', 'products'));
    }

    public function all_sales(Request $request)
    {
        // fetch all stock_outs by date range
        $stock_outs = StockOut::where('transaction_date', '>=', $request['date_from'])
                                ->where('transaction_date', '<=', $request['date_to'])
                                ->get();

        // generate array
        $sales = [];
        foreach($stock_outs as $stock_out){
            if(!$customer = Customer::withTrashed()->find($stock_out->customer_id)){
                continue;
            }
            if(!$product = Product::withTrashed()->find($stock_out->product_id)){
                continue;
            }
            $product_name = ($product->category ? $product->category->name : '').($product->brand ? '-'.$product->brand->name : '').($product->article ? '-'.$product->article : '');
            $customer_name = $customer->name . ($customer->market ? ('-'.$customer->market->name) : '') . (($customer->market && $customer->market->area) ? ('-'.$customer->market->area->name) : '');
            array_push($sales, [
                'customer' => $customer_name,
                'product' => $product_name,
                'quantity' => $stock_out->quantity,
                'price' => $stock_out->price,
                'transaction_date' => $stock_out->transaction_date,
            ]);
        }

        // calculate total from sales
        $total = 0;
        $total_qty = 0;
        foreach($sales as $sale){
            $total += ($sale['quantity'] * $sale['price']);
            $total_qty += $sale['quantity'];
        }

        return [
            'sales' => $sales,
            'total' => $total,
            'total_qty' => $total_qty
        ];
    }

    public function customer_wise_sales(Request $request)
    {
        // fetch all stock_outs by customer_id
        $stock_outs = StockOut::whereIn('customer_id', $request['customer_id'])
                                ->where('transaction_date', '>=', $request['date_from'])
                                ->where('transaction_date', '<=', $request['date_to'])
                                ->get();
        
        // generate array
        $sales = [];
        foreach($stock_outs as $stock_out){
            if(!$customer = Customer::withTrashed()->find($stock_out->customer_id)){
                continue;
            }
            if(!$product = Product::withTrashed()->find($stock_out->product_id)){
                continue;
            }
            
            $customer_name = $customer->name . ($customer->market ? ('-'.$customer->market->name) : '') . (($customer->market && $customer->market->area) ? ('-'.$customer->market->area->name) : '');
            $product_name = ($product->category ? $product->category->name : '').($product->brand ? '-'.$product->brand->name : '').($product->article ? '-'.$product->article : '');
            array_push($sales, [
                'customer' => $customer_name,
                'product' => $product_name,
                'quantity' => $stock_out->quantity,
                'price' => $stock_out->price,
                'transaction_date' => $stock_out->transaction_date,
            ]);
        }

        // calculate total from sales
        $total = 0;
        $total_qty = 0;
        foreach($sales as $sale){
            $total += ($sale['quantity'] * $sale['price']);
            $total_qty += $sale['quantity'];
        }
        
        return [
            'sales' => $sales,
            'total' => $total,
            'total_qty' => $total_qty
        ];
    }

    public function product_wise_sales(Request $request)
    {
        // fetch all stock_outs by product_id
        $stock_outs = StockOut::whereIn('product_id', $request['product_id'])
                                ->where('transaction_date', '>=', $request['date_from'])
                                ->where('transaction_date', '<=', $request['date_to'])
                                ->get();

        // generate array
        $sales = [];
        foreach($stock_outs as $stock_out){
            if(!$customer = Customer::withTrashed()->find($stock_out->customer_id)){
                continue;
            }
            if(!$product = Product::withTrashed()->find($stock_out->product_id)){
                continue;
            }
            
            $customer_name = $customer->name . ($customer->market ? ('-'.$customer->market->name) : '') . (($customer->market && $customer->market->area) ? ('-'.$customer->market->area->name) : '');
            $product_name = ($product->category ? $product->category->name : '').($product->brand ? '-'.$product->brand->name : '').($product->article ? '-'.$product->article : '');
            array_push($sales, [
                'customer' => $customer_name,
                'product' => $product_name,
                'quantity' => $stock_out->quantity,
                'price' => $stock_out->price,
                'transaction_date' => $stock_out->transaction_date,
            ]);
        }

        // calculate total from sales
        $total = 0;
        $total_qty = 0;
        foreach($sales as $sale){
            $total += ($sale['quantity'] * $sale['price']);
            $total_qty += $sale['quantity'];
        }

        return [
            'sales' => $sales,
            'total' => $total,
            'total_qty' => $total_qty
        ];
    }

    public function combined_sales(Request $request)
    {
        // fetch all stock_outs by product_id and customer_id
        $stock_outs = StockOut::whereIn('customer_id', $request['customer_id'])
                                ->orWhereIn('product_id', $request['product_id'])
                                ->where('transaction_date', '>=', $request['date_from'])
                                ->where('transaction_date', '<=', $request['date_to'])
                                ->get();

        // generate array
        $sales = [];
        foreach($stock_outs as $stock_out){
            if(!$customer = Customer::withTrashed()->find($stock_out->customer_id)){
                continue;
            }
            if(!$product = Product::withTrashed()->find($stock_out->product_id)){
                continue;
            }
            
            $customer_name = $customer->name . ($customer->market ? ('-'.$customer->market->name) : '') . (($customer->market && $customer->market->area) ? ('-'.$customer->market->area->name) : '');
            $product_name = ($product->category ? $product->category->name : '').($product->brand ? '-'.$product->brand->name : '').($product->article ? '-'.$product->article : '');
            array_push($sales, [
                'customer' => $customer_name,
                'product' => $product_name,
                'quantity' => $stock_out->quantity,
                'price' => $stock_out->price,
                'transaction_date' => $stock_out->transaction_date,
            ]);
        }

        // calculate total from sales
        $total = 0;
        $total_qty = 0;
        foreach($sales as $sale){
            $total += ($sale['quantity'] * $sale['price']);
            $total_qty += $sale['quantity'];
        }

        return [
            'sales' => $sales,
            'total' => $total,
            'total_qty' => $total_qty
        ];
    }

    public function generate_expenses_excel(Request $request)
    {
        // dd($request->all());
        $main_array = [];
        for($i = 0; $i < count($request->transaction_dates); $i++){
            array_push($main_array, [
                'Transaction Date' => $request->transaction_dates[$i],
                'Amount' => $request->amounts[$i],
                'Details' => $request->details[$i]
            ]);
        }
        array_push($main_array, [
            'Transaction Date' => "Total",
            'Amount' => $request->total,
            'Details' => "",
        ]);
        
        $export = new ExpensesExport($main_array);

        return Excel::download($export, $request->title . '.xls');
    }

    public function generate_ledgers_excel(Request $request)
    {
        // dd($request->all());
        $main_array = [];
        for($i = 0; $i < count($request->transaction_dates); $i++){
            array_push($main_array, [
                'Transaction Date' => $request->transaction_dates[$i],
                'Details' => $request->details[$i],
                'Amount' => $request->amounts[$i],
                'Type' => $request->types[$i]
            ]);
        }
        array_push($main_array, [
            'Transaction Date' => "",
            'Details' => 'Outstanding Balance',
            'Amount' => $request->outstanding_balance,
            'Type' => ""
        ]);
        
        $export = new LedgersExport($main_array);

        return Excel::download($export, $request->title . ' ('.return_date_pdf(Carbon::now()).')' . '.xls');
    }

    public function generate_sales_excel(Request $request)
    {
        // dd($request->all());
        $main_array = [];
        for($i = 0; $i < count($request->transaction_dates); $i++){
            array_push($main_array, [
                'Transaction Date' => $request->transaction_dates[$i],
                'Customer' => $request->customers[$i],
                'Product' => $request->products[$i],
                'Price' => $request->prices[$i],
                'Quantity' => $request->quantities[$i]
            ]);
        }
        array_push($main_array, [
            'Transaction Date' => "",
            'Customer' => "",
            'Product' => 'Total',
            'Price' => $request->total,
            'Quantity' => $request->total_qty
        ]);
        
        $export = new SalesExport($main_array);

        return Excel::download($export, $request->title . '.xls');
    }

    public function generate_customers_excel(Request $request)
    {
        $customers = $this->customerService->all();
        $main_array = [];
        foreach($customers as $customer){
            array_push($main_array, [
                'Name' => $customer->name,
                'Address' => ($customer->shop_name ? $customer->shop_name . ', ' : '') . (($customer->market && $customer->market->area) ? $customer->market->area->name . ', ' : '') . ($customer->market ? $customer->market->name . '.' : ''),
                'Contact' => $customer->contact_number,
                'Business to Date' => number_format(intval($customer->business_to_date)),
                'Outstanding Balance' => number_format(intval($customer->outstanding_balance)),
            ]);
        }
        
        $export = new CustomerExport($main_array);

        return Excel::download($export, 'Customers - ' . return_date_pdf(Carbon::now()) . '.xls');
    }

    public function generate_vendors_excel(Request $request)
    {
        $vendors = $this->vendorService->all();
        $main_array = [];
        foreach($vendors as $vendor){
            array_push($main_array, [
                'Name' => $vendor->name,
                'Address' => ($vendor->shop_name ? $vendor->shop_name . ', ' : '') . ($vendor->area ? $vendor->area->name . '.' : ''),
                'Contact' => $vendor->contact_number,
                'Business to Date' => number_format(intval($vendor->business_to_date)),
                'Outstanding Balance' => number_format(intval($vendor->outstanding_balance)),
            ]);
        }
        
        $export = new VendorExport($main_array);

        return Excel::download($export, 'Vendors - ' . return_date_pdf(Carbon::now()) . '.xls');
    }

    public function generate_products_excel(Request $request)
    {
        $products = $this->productService->all();
        $main_array = [];
        foreach($products as $product){
            array_push($main_array, [
                'Category' => ($product->category ? $product->category->name : ''),
                'Brand' => ($product->brand ? $product->brand->name : ''),
                'Article' => $product->article,
                'Unit' => ($product->unit ? $product->unit->name : ''),
                'Gender' => $product->gender,
                'Purchase Price' => number_format(intval($product->purchase_price)),
                'Consumer Selling Price' => number_format(intval($product->consumer_selling_price)),
                'Retailer Selling Price' => number_format(intval($product->retailer_selling_price)),
                'Quantity in Hand' => number_format(intval($product->quantity_in_hand)),
                'Cost Value' => number_format(intval($product->cost_value)),
                'Sales Value' => number_format(intval($product->sales_value)),
                'Minimum Ordering Quanitity' => number_format(intval($product->moq))
            ]);
        }
        
        $export = new ProductExport($main_array);

        return Excel::download($export, 'Products - ' . return_date_pdf(Carbon::now()) . '.xls');
    }

    public function marketing()
    {
        $today =lcfirst(Carbon::today()->format('l'));
        $tomorrow =lcfirst(Carbon::tomorrow()->format('l'));

        $customers = Customer::where('visiting_days', $today)->get();
        $orders = Order::where('dispatch_date', Carbon::now()->format('Y-m-d'))->get();

        return view('admin.marketing.marketing', compact('customers', 'orders'));
    }
}
