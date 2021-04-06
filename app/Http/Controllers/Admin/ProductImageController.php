<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductImageService;

class ProductImageController extends Controller
{
    private $productImageService;

    public function __construct(ProductImageService $productImageService)
    {
        $this->productImageService = $productImageService;
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
        if(array_key_exists('product_image_id', $_REQUEST)){
            $id = $_REQUEST['product_image_id'];
        }

        return $this->productImageService->delete($id);
    }
}
