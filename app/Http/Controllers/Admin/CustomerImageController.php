<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerImageService;

class CustomerImageController extends Controller
{
    private $customerImageService;

    public function __construct(CustomerImageService $customerImageService)
    {
        $this->customerImageService = $customerImageService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        
    }
    
    public function store(Request $request)
    {
        
    }
    
    public function show($id)
    {
        
    }
    
    public function update(Request $request, $id)
    {
        
    }
    
    public function destroy($id)
    {
        if(array_key_exists('customer_image_id', $_REQUEST)){
            $id = $_REQUEST['customer_image_id'];
        }

        return $this->customerImageService->delete($id);
    }
}
