<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\InvoiceService;

class HomeController extends Controller
{
    private $invoiceService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->middleware('auth');
        $this->invoiceService = $invoiceService;
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
}
