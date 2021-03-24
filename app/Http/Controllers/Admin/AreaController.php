<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AreaService;
use App\Services\MarketService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class AreaController extends Controller
{
    private $areaService;
    private $marketService;

    public function __construct(AreaService $areaService, MarketService $marketService)
    {
        $this->areaService = $areaService;
        $this->marketService = $marketService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(!Gate::allows('can_areas_and_markets')){
            return redirect()->route('search_marketing_tasks');
        }
        $areas = $this->areaService->paginate(env('PAGINATE'));
        return view('admin.area.area', compact('areas'));
    }
    
    public function store(Request $request)
    {
        if(!Gate::allows('can_add_areas')){
            return redirect()->route('search_marketing_tasks');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // CREATE AREA
        $area = ($this->areaService->create($request->all()))['area']['area'];

        // check if markets' info provided
        if($request->market_names)
        {
            // create markets
            foreach($request->market_names as $market_name)
            {
                $this->marketService->create([
                    'name' => $market_name,
                    'area_id' => $area->id
                ]);
            }
        }

        return redirect()->back();
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->id;
        return $this->areaService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        // dd($request->all());
        if(!Gate::allows('can_edit_areas')){
            return redirect()->route('search_marketing_tasks');
        }
        $id = $request->hidden;

        if(!(auth()->user()->id == $id || auth()->user()->type == "superadmin"))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Not allowed.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        // UPDATE AREA
        $area = ($this->areaService->update($request->all(), $id))['updated_area']['area'];

        // check if markets' info provided
        if($request->market_names)
        {
            // delete old
            foreach($area->markets as $market){
                if(in_array($market->id, $request->market_ids)){
                    continue;
                }
                else{
                    $market->delete();
                }
            }
            // create new
            for($i = 0; $i < count($request->market_names); $i++) {
                // if id null create
                if($request->market_ids[$i] == NULL){
                    $this->marketService->create([
                        'name' => $request->market_names[$i],
                        'area_id' => $area->id
                    ]);
                }
                // else update
                else{
                    $this->marketService->update([
                        'name' => $request->market_names[$i],
                    ], $request->market_ids[$i]);
                }
            }
        }

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        if(!Gate::allows('can_delete_areas')){
            return redirect()->route('search_marketing_tasks');
        }
        $id = $request->hidden;

        $this->areaService->delete($id);

        return redirect()->back();
    }
}
