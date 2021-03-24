<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MarketService;
use Illuminate\Support\Facades\Validator;

class MarketController extends Controller
{
    private $marketService;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function show($id)
    {
        //
    }
    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    public function fetch_specific_markets(Request $request)
    {
        return $this->marketService->fetch_specific_markets($request->area_id);
    }

    public function fetch_customer_count(Request $request)
    {
        return $this->marketService->fetch_customer_count($request->market_id);
    }

    public function set_customer_schedule(Request $request)
    {
        if(!Gate::allows('can_customer_schedule')){
            return redirect()->route('search_marketing_tasks');
        }
        return $this->marketService->set_customer_schedule($request->all());
    }
}
