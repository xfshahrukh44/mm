<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\UserService;

class DashboardController extends Controller
{
    private $customerService;
    private $productService;
    private $userService;

    public function __construct(CustomerService $customerService, ProductService $productService, UserService $userService)
    {
        $this->customerService = $customerService;
        $this->productService = $productService;
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = $this->customerService->all();
        $products = $this->productService->all();
        $staff = $this->userService->all_staff();
        $riders = $this->userService->all_riders();
        return view('admin.dashboard.dashboard', compact('customers', 'products', 'staff', 'riders'));   
    }
}
