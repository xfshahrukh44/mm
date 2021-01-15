<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\VendorService;
use App\Services\ProductService;
use App\Services\UserService;

class DashboardController extends Controller
{
    private $customerService;
    private $vendorService;
    private $productService;
    private $userService;

    public function __construct(CustomerService $customerService, VendorService $vendorService, ProductService $productService, UserService $userService)
    {
        $this->customerService = $customerService;
        $this->vendorService = $vendorService;
        $this->productService = $productService;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = $this->customerService->all();
        $vendors = $this->vendorService->all();
        $products = $this->productService->all();
        $staff = $this->userService->all_staff();
        $riders = $this->userService->all_riders();

        // total cost value and total sales value
        $total_cost_value = 0;
        $total_sales_value = 0;
        foreach($products as $product){
            $total_cost_value += $product->purchase_price;
            $total_sales_value += $product->consumer_selling_price;
        }
        $total_cost_value = $total_cost_value / count($products);
        $total_sales_value = $total_sales_value / count($products);

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
        $total_cost_value = return_decimal_number($total_cost_value);
        $total_sales_value = return_decimal_number($total_sales_value);
        $total_receivables = return_decimal_number($total_receivables);
        $total_payables = return_decimal_number($total_payables);

        return view('admin.dashboard.dashboard', compact('customers', 'vendors', 'products', 'staff', 'riders', 'total_cost_value', 'total_sales_value', 'total_receivables', 'total_payables'));   
    }
}
