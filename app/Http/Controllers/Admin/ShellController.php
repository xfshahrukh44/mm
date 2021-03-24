<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\Gate;

class ShellController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth');
    }

    public function shell()
    {
        $users = $this->userService->all();
        return view('admin.shell.security_shell', compact('users'));
    }

    public function set_rights(Request $request)
    {
        $req = [
            'can_dashboard' => 0,
            'can_client_database' => 0,
            'can_customers' => 0,
            'can_customer_schedule' => 0,
            'can_vendors' => 0,
            'can_areas_and_markets' => 0,
            'can_stock_management' => 0,
            'can_products' => 0,
            'can_stock_in' => 0,
            'can_stock_out' => 0,
            'can_special_discounts' => 0,
            'can_categories' => 0,
            'can_brands' => 0,
            'can_units' => 0,
            'can_accounting' => 0,
            'can_customer_ledgers' => 0,
            'can_vendor_ledgers' => 0,
            'can_sales_ledgers' => 0,
            'can_receipts' => 0,
            'can_receipt_logs' => 0,
            'can_payments' => 0,
            'can_expenses' => 0,
            'can_expense_ledgers' => 0,
            'can_order_management' => 0,
            'can_orders' => 0,
            'can_invoices' => 0,
            'can_marketing_plan' => 0,
            'can_marketing_tasks' => 0,
            'can_user_management' => 0,
            'can_staff' => 0,
            'can_riders' => 0,
            // -----------------------------------
            'can_add_customers' => 0,
            'can_edit_customers' => 0,
            'can_view_customers' => 0,
            'can_delete_customers' => 0,
            'can_excel_customers' => 0,
            'can_add_vendors' => 0,
            'can_edit_vendors' => 0,
            'can_view_vendors' => 0,
            'can_delete_vendors' => 0,
            'can_excel_vendors' => 0,
            'can_add_areas' => 0,
            'can_edit_areas' => 0,
            'can_delete_areas' => 0,
            'can_add_products' => 0,
            'can_edit_products' => 0,
            'can_view_products' => 0,
            'can_delete_products' => 0,
            'can_excel_products' => 0,
            'can_add_stock_ins' => 0,
            'can_edit_stock_ins' => 0,
            'can_delete_stock_ins' => 0,
            'can_add_stock_outs' => 0,
            'can_edit_stock_outs' => 0,
            'can_delete_stock_outs' => 0,
            'can_add_categories' => 0,
            'can_edit_categories' => 0,
            'can_delete_categories' => 0,
            'can_add_brands' => 0,
            'can_edit_brands' => 0,
            'can_delete_brands' => 0,
            'can_add_units' => 0,
            'can_edit_units' => 0,
            'can_delete_units' => 0,
            'can_add_receivings' => 0,
            'can_edit_receivings' => 0,
            'can_delete_receivings' => 0,
            'can_add_payments' => 0,
            'can_edit_payments' => 0,
            'can_delete_payments' => 0,
            'can_add_expenses' => 0,
            'can_edit_expenses' => 0,
            'can_delete_expenses' => 0,
            'can_add_orders' => 0,
            'can_edit_orders' => 0,
            'can_view_orders' => 0,
            'can_delete_orders' => 0,
            'can_excel_orders' => 0,
            'can_invoice_orders' => 0,
            'can_add_invoices' => 0,
            'can_edit_invoices' => 0,
            'can_view_invoices' => 0,
            'can_delete_invoices' => 0,
            'can_print_invoices' => 0,
            'can_add_users' => 0,
            'can_edit_users' => 0,
            'can_delete_users' => 0,
        ];
        $keys = [
            'can_dashboard',
            'can_client_database',
            'can_customers',
            'can_customer_schedule',
            'can_vendors',
            'can_areas_and_markets',
            'can_stock_management',
            'can_products',
            'can_stock_in',
            'can_stock_out',
            'can_special_discounts',
            'can_categories',
            'can_brands',
            'can_units',
            'can_accounting',
            'can_customer_ledgers',
            'can_vendor_ledgers',
            'can_sales_ledgers',
            'can_receipts',
            'can_receipt_logs',
            'can_payments',
            'can_expenses',
            'can_expense_ledgers',
            'can_order_management',
            'can_orders',
            'can_invoices',
            'can_marketing_plan',
            'can_marketing_tasks',
            'can_user_management',
            'can_staff',
            'can_riders',
            // -------------------------------------------
            'can_add_customers',
            'can_edit_customers',
            'can_view_customers',
            'can_delete_customers',
            'can_excel_customers',
            'can_add_vendors',
            'can_edit_vendors',
            'can_view_vendors',
            'can_delete_vendors',
            'can_excel_vendors',
            'can_add_areas',
            'can_edit_areas',
            'can_delete_areas',
            'can_add_products',
            'can_edit_products',
            'can_view_products',
            'can_delete_products',
            'can_excel_products',
            'can_add_stock_ins',
            'can_edit_stock_ins',
            'can_delete_stock_ins',
            'can_add_stock_outs',
            'can_edit_stock_outs',
            'can_delete_stock_outs',
            'can_add_categories',
            'can_edit_categories',
            'can_delete_categories',
            'can_add_brands',
            'can_edit_brands',
            'can_delete_brands',
            'can_add_units',
            'can_edit_units',
            'can_delete_units',
            'can_add_receivings',
            'can_edit_receivings',
            'can_delete_receivings',
            'can_add_payments',
            'can_edit_payments',
            'can_delete_payments',
            'can_add_expenses',
            'can_edit_expenses',
            'can_delete_expenses',
            'can_add_orders',
            'can_edit_orders',
            'can_view_orders',
            'can_delete_orders',
            'can_excel_orders',
            'can_invoice_orders',
            'can_add_invoices',
            'can_edit_invoices',
            'can_view_invoices',
            'can_delete_invoices',
            'can_print_invoices',
            'can_add_users',
            'can_edit_users',
            'can_delete_users',
        ];

        // prepare keys
        foreach($keys as $key){
            if(isset($request[$key])){
                $req[$key] = 1;
            }
            else{
                $req[$key] = 0;
            }
        }

        if(!$user = User::find($request->hidden_user_id)){
            return 0;
        }

        // $this->userService->update($req, $request->hidden_user_id);
        $user->update($req);

        return $this->shell();
    }
}
