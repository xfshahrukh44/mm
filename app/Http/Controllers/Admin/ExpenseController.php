<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExpenseService;
use App\Services\CustomerService;
use App\Services\LedgerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use App\Models\Expense;

class ExpenseController extends Controller
{
    private $expenseService;
    private $customerService;
    private $ledgerService;

    public function __construct(ExpenseService $expenseService, CustomerService $customerService, LedgerService $ledgerService)
    {
        $this->expenseService = $expenseService;
        $this->customerService = $customerService;
        $this->ledgerService = $ledgerService;
        $this->middleware('auth');
    }
    
    public function index()
    {
        if(!Gate::allows('isSuperAdmin')){
            return redirect()->route('search_marketing_tasks');
        }
        $customers = $this->customerService->all();
        $expenses = $this->expenseService->paginate(env('PAGINATE'));
        return view('admin.expense.expense', compact('expenses', 'customers'));
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'detail' => 'sometimes',
            'type' => 'sometimes',
            'amount' => 'sometimes',
            'date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);


        // $this->expenseService->create($request->all());
        $expense = Expense::create($request->all());

        // if bad debt or cus discount
        if(array_key_exists('customer_id', $request->all())){
            $this->ledgerService->create([
                'expense_id' => $expense->id,
                'customer_id' => $request->customer_id,
                'type' => 'credit',
                'amount' => $request->amount
            ]);
        }


        return redirect()->back();
    }
    
    public function show(Request $request, $id)
    {
        $id = $request->id;
        return $this->expenseService->find($id);
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
            'detail' => 'sometimes',
            'type' => 'sometimes',
            'amount' => 'sometimes',
            'date' => 'sometimes'
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(), 400);

        $this->expenseService->update($request->all(), $id);

        return redirect()->back();
    }
    
    public function destroy(Request $request, $id)
    {
        $id = $request->hidden;

        $this->expenseService->delete($id);

        return redirect()->back();
    }

    public function fetch_expenses(Request $request)
    {
        $data['type'] = $request->type;
        $data['date_from'] = $request->date_from;
        $data['date_to'] = $request->date_to;

        return $this->expenseService->fetch_expenses($data);
    }
}
