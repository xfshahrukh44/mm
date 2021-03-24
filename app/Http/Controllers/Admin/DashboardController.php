<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\VendorService;
use App\Services\ProductService;
use App\Services\UserService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use App\Services\ReceivingService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    private $customerService;
    private $vendorService;
    private $productService;
    private $userService;
    private $invoiceService;
    private $orderService;
    private $receivingService;
    private $paymentService;

    public function __construct(CustomerService $customerService, VendorService $vendorService, ProductService $productService, UserService $userService, InvoiceService $invoiceService, OrderService $orderService, ReceivingService $receivingService, PaymentService $paymentService)
    {
        $this->customerService = $customerService;
        $this->vendorService = $vendorService;
        $this->productService = $productService;
        $this->userService = $userService;
        $this->invoiceService = $invoiceService;
        $this->orderService = $orderService;
        $this->receivingService = $receivingService;
        $this->paymentService = $paymentService;
        $this->middleware('auth');
    }

    public function index()
    {
        if(!Gate::allows('can_dashboard')){
            return redirect()->route('search_marketing_tasks');
        }
        $customers = $this->customerService->all();
        $vendors = $this->vendorService->all();
        $products = $this->productService->all();
        $staff = $this->userService->all_staff();
        $riders = $this->userService->all_riders();
        $total_invoices = count($this->invoiceService->all());
        $total_orders = count($this->orderService->all());
        $total_receivings = count($this->receivingService->all());
        $total_payments = count($this->paymentService->all());

        // total cost value and total sales value
        $total_cost_value = 0;
        $total_sales_value = 0;
        foreach($products as $product){
            $total_cost_value += $product->cost_value;
            $total_sales_value += $product->sales_value;
        }

        // total receivables and total payables
        $total_receivables = 0;
        $total_payables = 0;
        foreach($customers as $customer){
            $total_receivables += ($customer->outstanding_balance ? $customer->outstanding_balance : 0);
        }
        foreach($vendors as $vendor){
            $total_payables += ($vendor->outstanding_balance ? $vendor->outstanding_balance : 0);
        }

        // return_decimal_number
        $total_cost_value = number_format($total_cost_value, 2);
        $total_sales_value = number_format($total_sales_value, 2);
        $total_receivables = number_format($total_receivables, 2);
        $total_payables = number_format($total_payables, 2);

        return view('admin.dashboard.dashboard', compact('customers', 'vendors', 'products', 'staff', 'riders', 'total_cost_value', 'total_sales_value', 'total_receivables', 'total_payables', 'total_invoices', 'total_orders', 'total_receivings', 'total_payments'));   
    }
}
