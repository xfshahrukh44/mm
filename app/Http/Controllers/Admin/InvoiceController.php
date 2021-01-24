<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\InvoiceProductService;
use App\Services\OrderProductService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{

    private $invoiceService;
    private $customerService;
    private $productService;
    private $invoiceProductService;
    private $orderProductService;
    private $orderService;

    public function __construct(InvoiceService $invoiceService, CustomerService $customerService, ProductService $productService, InvoiceProductService $invoiceProductService, OrderProductService $orderProductService, OrderService $orderService)
    {
        $this->invoiceService = $invoiceService;
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->invoiceProductService = $invoiceProductService;
        $this->orderProductService = $orderProductService;
        $this->orderService = $orderService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $invoices = $this->invoiceService->paginate(env('PAGINATE'));
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        return view('admin.invoice.invoice', compact('invoices', 'customers', 'products'));
    }

    public function all()
    {
        return $this->invoiceService->all();
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'order_id' => 'sometimes',
            'rider_id' => 'sometimes',
            'total' => 'sometimes',
            'payment' => 'sometimes',
            'amount_pay' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // create invoice
        $invoice = ($this->invoiceService->create($request->all()))['invoice']['invoice'];

        // children
        $invoiced_items = 0;
        if($request->products){
            for($i = 0; $i < count($request->products); $i++){
                // mark order product as invoiced
                $this->orderProductService->update([
                    'invoiced' => 1
                ], $request->order_products_ids[$i]);
                // increment invoiced_items
                $invoiced_items += 1;

                // create invoice product
                $this->invoiceProductService->create([
                    'invoice_id' => $invoice['id'],
                    'product_id' => $request->hidden_product_ids[$i],
                    'quantity' => $request->quantities[$i],
                    'price' => $request->prices[$i],
                ]);
            }
        }

        // update order with invoiced_items
        $this->orderService->update([
            'invoiced_items' => $invoiced_items
        ], $request->order_id);

        return redirect()->back();
        // return $this->invoiceService->generate_invoice_pdf($invoice->id);
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->invoice_id;
        return $this->invoiceService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        $id = $request->hidden;
        $invoice = ($this->show($id))['invoice'];

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'sometimes',
            'order_id' => 'sometimes',
            'rider_id' => 'sometimes',
            'total' => 'sometimes',
            'payment' => 'sometimes',
            'amount_pay' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        
        $this->invoiceService->update($request->all(), $id);

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->invoiceService->delete($id);

        return redirect()->back();
    }

    public function search_invoices(Request $request)
    {
        $query = $request['query'];
        
        $invoices = $this->invoiceService->search_invoices($query);
        $customers = $this->customerService->all();
        $products = $this->productService->all();

        return view('admin.invoice.invoice', compact('invoices', 'customers', 'products'));
    }

    public function fetch_invoice_products(Request $request)
    {
        $invoice = ($this->invoiceService->find($request->invoice_id))['invoice'];

        return $invoice->invoice_products;
    }
}
