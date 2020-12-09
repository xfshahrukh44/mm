<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UnitService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Storage;

class UnitController extends Controller
{
    private $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        $units = $this->unitService->paginate(env('PAGINATE'));
        return view('admin.unit.unit', compact('units'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->unitService->create($request->all());

        return redirect()->route('unit.index');
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->id;
        return $this->unitService->find($id);
    }
    
    public function update(Request $request, $id)
    {
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

        $this->unitService->update($request->all(), $id);

        return redirect()->route('unit.index');
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->unitService->delete($id);

        return redirect()->route('unit.index');
    }
}
