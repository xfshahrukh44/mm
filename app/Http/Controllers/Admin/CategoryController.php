<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{

    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(!Gate::allows('can_categories')){
            return redirect()->route('search_marketing_tasks');
        }
        $categories = $this->categoryService->paginate(env('PAGINATE'));
        return view('admin.category.category', compact('categories'));
    }
    
    public function store(Request $request)
    {
        if(!Gate::allows('can_add_categories')){
            return redirect()->route('search_marketing_tasks');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->categoryService->create($request->all());

        return redirect()->back();
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->id;
        return $this->categoryService->find($id);
    }
    
    public function update(Request $request, $id)
    {
        if(!Gate::allows('can_edit_categories')){
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

        $this->categoryService->update($request->all(), $id);

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        if(!Gate::allows('can_delete_categories')){
            return redirect()->route('search_marketing_tasks');
        }
        $id = $request->hidden;

        $this->categoryService->delete($id);

        return redirect()->back();
    }
}
