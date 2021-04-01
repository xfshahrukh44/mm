<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockOut;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Marketing;
use App\Models\Receiving;
use App\User;
use App\Services\InvoiceService;
use App\Services\InvoiceProductService;
use App\Services\ProductService;
use App\Services\CustomerService;
use App\Services\VendorService;
use App\Services\OrderService;
use Excel;
use App\Exports\ExpensesExport;
use App\Exports\LedgersExport;
use App\Exports\SalesExport;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\VendorExport;
use App\Exports\ProductExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    private $invoiceService;
    private $invoiceProductService;
    private $productService;
    private $customerService;
    private $vendorService;
    private $orderService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService, InvoiceProductService $invoiceProductService, ProductService $productService, CustomerService $customerService, VendorService $vendorService, OrderService $orderService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;
        $this->invoiceProductService = $invoiceProductService;
        $this->productService = $productService;
        $this->customerService = $customerService;
        $this->vendorService = $vendorService;
        $this->orderService = $orderService;
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
        // echo('Shahrukh Siddiqui - Core2Plus');
        // return "";

        $product = Product::where('article', '3R')->first();
        $product->quantity_in_hand = -33840;
        $product->cost_value = $product->quantity_in_hand * 60;
        $product->sales_value = $product->quantity_in_hand * 75;
        $product->saveQuietly();
        // $users = User::all();
        // foreach($users as $user){
        //     if($user->type == "superadmin"){
        //         set_superadmin_rights($user->id);
        //     }
        //     if($user->type == "user"){
        //         set_user_rights($user->id);
        //     }
        //     if($user->type == "rider"){
        //         set_basic_rights($user->id);
        //     }
        // }
    }

    public function generate_invoice_pdf($id)
    {
        if(!Gate::allows('can_print_invoices')){
            return redirect()->route('search_marketing_tasks');
        }
        return $this->invoiceService->generate_invoice_pdf($id);
    }

    public function sales_ledgers()
    {
        if(!Gate::allows('can_sales_ledgers')){
            return redirect()->route('search_marketing_tasks');
        }
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
            'total' => number_format($total, 2),
            'total_qty' => number_format($total_qty, 2)
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
            'total' => number_format($total, 2),
            'total_qty' => number_format($total_qty, 2)
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
            'total' => number_format($total, 2),
            'total_qty' => number_format($total_qty, 2)
        ];
    }

    public function combined_sales(Request $request)
    {
        // dd($request->all());
        // fetch all stock_outs by product_id and customer_id
        $stock_outs = StockOut::whereIn('customer_id', $request['customer_id'])
                                ->whereIn('product_id', $request['product_id'])
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
            'total' => number_format($total, 2),
            'total_qty' => number_format($total_qty, 2)
        ];
    }

    public function generate_expenses_excel(Request $request)
    {
        // dd($request->all());
        $records = explode('ayyrecordendayy', $request->records);
        $main_array = [];
        foreach($records as $record){
            $array = explode('ayycolumnendayy', $record);
            array_push($main_array, $array);
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
        $records = explode('ayyrecordendayy', $request->records);
        $main_array = [];
        foreach($records as $record){
            $array = explode('ayycolumnendayy', $record);
            array_push($main_array, $array);
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
        $records = explode('ayyrecordendayy', $request->records);
        $main_array = [];
        foreach($records as $record){
            $array = explode('ayycolumnendayy', $record);
            array_push($main_array, $array);
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
        // dd($request->all());
        if(!Gate::allows('can_excel_customers')){
            return redirect()->route('search_marketing_tasks');
        }
        if($request->status != NULL){
            $customers = $this->customerService->all_by_status($request->status);
        }
        else{
            $customers = $this->customerService->all();
        }
        $main_array = [];
        foreach($customers as $customer){
            array_push($main_array, [
                'Name' => $customer->name,
                'Type' => $customer->type,
                'Address' => ($customer->shop_name ? $customer->shop_name . ', ' : '') . (($customer->market && $customer->market->area) ? $customer->market->area->name . ', ' : '') . ($customer->market ? $customer->market->name . '.' : ''),
                'Contact' => $customer->contact_number,
                'Business to Date' => (intval($customer->business_to_date)),
                'Outstanding Balance' => (intval($customer->outstanding_balance)),
                'Last Order On' => last_order_dispatched_at($customer->id),
            ]);
        }
        
        $export = new CustomerExport($main_array);

        return Excel::download($export, 'Customers - ' . return_date_pdf(Carbon::now()) . (($request->status != NULL) ? ('('.$request->status.')') : '') . '.xls');
    }

    public function generate_vendors_excel(Request $request)
    {
        if(!Gate::allows('can_excel_vendors')){
            return redirect()->route('search_marketing_tasks');
        }
        $vendors = $this->vendorService->all();
        $main_array = [];
        foreach($vendors as $vendor){
            array_push($main_array, [
                'Name' => $vendor->name,
                'Address' => ($vendor->shop_name ? $vendor->shop_name . ', ' : '') . ($vendor->area ? $vendor->area->name . '.' : ''),
                'Contact' => $vendor->contact_number,
                'Business to Date' => (intval($vendor->business_to_date)),
                'Outstanding Balance' => (intval($vendor->outstanding_balance)),
            ]);
        }
        
        $export = new VendorExport($main_array);

        return Excel::download($export, 'Vendors - ' . return_date_pdf(Carbon::now()) . '.xls');
    }

    public function generate_products_excel(Request $request)
    {
        if(!Gate::allows('can_excel_products')){
            return redirect()->route('search_marketing_tasks');
        }
        $products = $this->productService->all();
        $main_array = [];
        foreach($products as $product){
            array_push($main_array, [
                'Category' => ($product->category ? $product->category->name : ''),
                'Brand' => ($product->brand ? $product->brand->name : ''),
                'Article' => $product->article,
                'Unit' => ($product->unit ? $product->unit->name : ''),
                'Gender' => $product->gender,
                'Purchase Price' => (intval($product->purchase_price)),
                'Consumer Selling Price' => (intval($product->consumer_selling_price)),
                'Retailer Selling Price' => (intval($product->retailer_selling_price)),
                'Quantity in Hand' => (intval($product->quantity_in_hand)),
                'Cost Value' => (intval($product->cost_value)),
                'Sales Value' => (intval($product->sales_value)),
                'Minimum Ordering Quanitity' => (intval($product->moq))
            ]);
        }
        
        $export = new ProductExport($main_array);

        return Excel::download($export, 'Products - ' . return_date_pdf(Carbon::now()) . '.xls');
    }

    public function generate_orders_excel(Request $request)
    {
        if(!Gate::allows('can_excel_orders')){
            return redirect()->route('search_marketing_tasks');
        }
        // prepare dataset for search
        $data = [];
        $data['query'] = $request->excel_query;
        $data['dispatch_date'] = $request->excel_date;

        $orders = $this->orderService->search_orders_all($data);

        $main_array = [];
        foreach($orders as $order){
            array_push($main_array, [
                'ID' => $order->id,
                'Date Punched' => $order->created_at,
                'Dispatch Date' => ($order->dispatch_date ? return_date_wo_time($order->dispatch_date) : ''),
                'Customer Name' => ($order->customer ? $order->customer->name : ''),
                'Phone' => ($order->customer ? $order->customer->contact_number : ''),
                'Address' => ($order->customer ? ($order->customer->shop_name . ' - ' . ($order->customer->market ? $order->customer->market->name : '') . ' - ' . ($order->customer->market && $order->customer->market->area ? $order->customer->market->area->name : '')) : ''),
                'Total' => ($order->total ? ($order->total) : ''),
                'Status' => ($order->status ? ($order->status) : ''),
                'Punched By' => ($order->created_by ? (return_user_name($order->created_by)) : ''),
                'Modified By' => ($order->modified_by ? (return_user_name($order->modified_by)) : '')
            ]);
        }
        
        $export = new OrderExport($main_array);

        return Excel::download($export, 'Orders - ' . return_date_pdf(Carbon::now()) . (($data['dispatch_date'] != NULL) ? ('('.$data['dispatch_date'].')') : '') . '.xls');
    }

    public function search_marketing(Request $request)
    {
        if(!Gate::allows('can_marketing_plan')){
            return redirect()->route('search_marketing_tasks');
        }
        if(array_key_exists('date', $request->all())){
            $date = Carbon::parse($request->date);
        }
        else{
            $date = Carbon::today();
        }
        $today =lcfirst($date->format('l'));
        $ymd = $date->format('Y-m-d');
        // $tomorrow =lcfirst(Carbon::tomorrow()->format('l'));

        // $riders = User::where('type', 'rider')->get();
        $riders = User::all();
        
        $customers = Customer::where('visiting_days', $today)->get();
        $customers_all = Customer::all();
        $customer_marketings = Marketing::whereNotNull('customer_id')->where('date', $date)->get();

        $receivings = Receiving::where('payment_date', $date)->get();
        $receivings_all = Receiving::whereNotNull('payment_date')->get();
        $receiving_marketings = Marketing::whereNotNull('receiving_id')->where('date', $date)->get();

        $invoices = Invoice::where('date', $ymd)->get();
        $invoices_all = Invoice::all();
        $invoice_marketings = Marketing::whereNotNull('invoice_id')->where('date', $date)->get();

        return view('admin.marketing.marketing', compact('customers', 'customers_all', 'customer_marketings', 'receivings', 'receivings_all', 'receiving_marketings', 'invoices', 'invoices_all', 'invoice_marketings', 'riders', 'date', 'ymd'));
    }

    public function assign_marketing_rider_for_customer(Request $request)
    {
        // fetch old and delete
        $marketing = Marketing::where('customer_id', $request->customer_id)
                                ->where('date', $request->date)
                                ->first();
        if($marketing){
            $marketing->forceDelete();
        }
        
        // create new
        Marketing::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->rider_id,
            'date' => $request->date
        ]);

        // get rider name
        $rider = User::find($request->rider_id);

        return $rider->name;
    }

    public function assign_marketing_rider_for_receiving(Request $request)
    {
        // fetch old and delete
        $marketing = Marketing::where('receiving_id', $request->receiving_id)
                                ->where('date', $request->date)
                                ->first();
        if($marketing){
            $marketing->forceDelete();
        }
        
        // create new
        Marketing::create([
            'receiving_id' => $request->receiving_id,
            'user_id' => $request->rider_id,
            'date' => $request->date
        ]);

        // get rider name
        $rider = User::find($request->rider_id);

        return $rider->name;
    }

    public function assign_marketing_rider_for_invoice(Request $request)
    {
        // fetch old and delete
        $marketing = Marketing::where('invoice_id', $request->invoice_id)
                                ->where('date', $request->date)
                                ->first();
        if($marketing){
            $marketing->forceDelete();
        }
        
        // create new
        Marketing::create([
            'invoice_id' => $request->invoice_id,
            'user_id' => $request->rider_id,
            'date' => $request->date
        ]);

        // get rider name
        $rider = User::find($request->rider_id);

        return $rider->name;
    }
    
    public function search_marketing_tasks(Request $request)
    {
        if(!Gate::allows('can_marketing_tasks')){
            return redirect()->route('login');
        }
        
        if(array_key_exists('date', $request->all())){
            $date = Carbon::parse($request->date);
        }
        else{
            $date = Carbon::today();
        }

        $ymd = $date->format('Y-m-d');

        $customer_marketings = Marketing::whereNotNull('customer_id')->where('date', $date)->where('user_id', auth()->user()->id)->get();
        $receiving_marketings = Marketing::whereNotNull('receiving_id')->where('date', $date)->where('user_id', auth()->user()->id)->get();
        $invoice_marketings = Marketing::whereNotNull('invoice_id')->where('date', $date)->where('user_id', auth()->user()->id)->get();

        return view('admin.marketing.task', compact('customer_marketings', 'receiving_marketings', 'invoice_marketings', 'date', 'ymd'));
    }
}
