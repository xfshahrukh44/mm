<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockOut;
use App\Services\InvoiceService;
use App\Services\InvoiceProductService;
use App\Services\ProductService;
use App\Services\CustomerService;
use Excel;
use App\Exports\ExpensesExport;

class HomeController extends Controller
{
    private $invoiceService;
    private $invoiceProductService;
    private $productService;
    private $customerService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService, InvoiceProductService $invoiceProductService, ProductService $productService, CustomerService $customerService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;
        $this->invoiceProductService = $invoiceProductService;
        $this->productService = $productService;
        $this->customerService = $customerService;
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
        dd($request->all());
        $products = Product::where('type', 'other')->get();
        foreach($products as $product){
            $product->gender = 'both';
            $product->save();
        }
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
            $market = $customer->market ? ('-'.$customer->market->name) : '';
            $area = $customer->market && $customer->market->area ? ('-'.$customer->market->area->name) : '';
            $customer_name = $customer->name . $market . $area;
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
            $market = $customer->market ? ('-'.$customer->market->name) : '';
            $area = $customer->market && $customer->market->area ? ('-'.$customer->market->area->name) : '';
            $customer_name = $customer->name . $market . $area;
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
            $market = $customer->market ? ('-'.$customer->market->name) : '';
            $area = $customer->market && $customer->market->area ? ('-'.$customer->market->area->name) : '';
            $customer_name = $customer->name . $market . $area;
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
            $market = $customer->market ? ('-'.$customer->market->name) : '';
            $area = $customer->market && $customer->market->area ? ('-'.$customer->market->area->name) : '';
            $customer_name = $customer->name . $market . $area;
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
        $transaction_dates = [];
        $amounts = [];
        $details = [];
        $main_array = [];
        foreach($request->expenses as $expense){
            // array_push($transaction_dates, return_date_pdf($expense['created_at']) . (($request->wild_card == 1) ? (' ('.$expense['type'].')') : ''));
            // array_push($amounts, $expense['amount']);
            // array_push($details, $expense['detail']);

            array_push($main_array, [
                'Transaction Date' => return_date_pdf($expense['created_at']) . (($request->wild_card == 1) ? (' ('.$expense['type'].')') : ''),
                'Amount' => $expense['amount'],
                'Details' => $expense['detail']
            ]);
        }
        // $main_array = [
        //     'Transaction Date' => $transaction_dates,
        //     'Amount' => $amounts,
        //     'Details' => $details
        // ];
        
        $export = new ExpensesExport($main_array);

        // return (new ExpensesExport($main_array))->store($request->title . '.csv', 'shops');

        return Excel::download($export, $request->title . '.csv');
    }
}
