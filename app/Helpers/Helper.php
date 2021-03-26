<?php

use Carbon\Carbon;
use App\User;
use App\Models\Marketing;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;

function return_date($date)
{
    return Carbon::parse($date)->format('j F, Y. h:i a');
}

function return_date_wo_time($date){
    return Carbon::parse($date)->format('j F, Y.');
}

function return_date_pdf($date)
{
    return Carbon::parse($date)->format('j F, Y');
}

function return_todays_date()
{
    return Carbon::now();
}

function return_user_name($id)
{
    $user = User::find($id);
    return optional($user)->name;
}

function return_decimal_number($foo)
{
    return number_format((float)$foo, 2, '.', '');
}

function return_marketing_rider_for_customer($customer_id, $date)
{
    if(!$marketing = Marketing::where('customer_id', $customer_id)-> where('date', $date)->first()){
        return '';
    }
    if(!$rider = User::find($marketing->user_id)){
        return '';
    }

    return $rider->name;
}

function return_marketing_rider_for_receiving($receiving_id, $date)
{
    if(!$marketing = Marketing::where('receiving_id', $receiving_id)-> where('date', $date)->first()){
        return '';
    }
    if(!$rider = User::find($marketing->user_id)){
        return '';
    }
    return $rider->name;
}

function return_marketing_rider_for_invoice($invoice_id, $date)
{
    if(!$marketing = Marketing::where('invoice_id', $invoice_id)-> where('date', $date)->first()){
        return '';
    }
    if(!$rider = User::find($marketing->user_id)){
        return '';
    }
    return $rider->name;
}

function customer_shop_name($customer_id)
{
    $customer = Customer::find($customer_id);
    $shop = (($customer->shop_name) ? (' | ' . $customer->shop_name) : '');
    $market = (($customer->market && $customer->market->name) ? (' | ' . $customer->market->name) : '');
    $area = (($customer->market && $customer->market->area &&  $customer->market->area->name) ? (' | ' . $customer->market->area->name) : '');
    return $customer->name . $shop . $market . $area;
}

function count_by_status($status)
{
    return count(Customer::where('status', $status)->get());
}

function order_count_by_status($status)
{
    return count(Order::where('status', $status)->get());
}

function order_total_count_by_status($status)
{
    $orders = Order::where('status', $status)->get();
    $total = 0;
    foreach($orders as $order){
        $total += (($order->total) ? ($order->total) : 0);
    }
    return number_format($total, 2);
}

function last_order_dispatched_at($customer_id){
    $customer = Customer::find($customer_id);
    $customer_name = customer_shop_name($customer_id);
    $order = Order::where('customer_id', $customer_id)->where('deleted_at', NULL)->latest()->first();
    return ($order ? return_date_wo_time($order->dispatch_date) : '');
}

function set_status_by_invoiced_items($order_id){
    $order = Order::with('order_products')->find($order_id);

    if(!$order){
        return '';
    }

    $item_count = count($order->order_products);
    $invoiced_count = 0;
    foreach($order->order_products as $order_product){
        if($order_product->invoiced == 1){
            $invoiced_count += 1;
        }
    }

    if($invoiced_count == 0){
        // pending
        $order->status = 'pending';
        $order->invoiced_items = $invoiced_count;
    }
    else if($invoiced_count < $item_count){
        // incomplete
        $order->status = 'incomplete';
        $order->invoiced_items = $invoiced_count;
    }
    else{
        // complete
        $order->status = 'completed';
        $order->invoiced_items = $invoiced_count;
    }
    
    $order->saveQuietly();
}

function revoke_all_rights($user_id){
    $user = User::find($user_id);
    if(!$user){
        return 0;
    }

    $user->can_dashboard = 0;
    $user->can_client_database = 0;
    $user->can_customers = 0;
    $user->can_customer_schedule = 0;
    $user->can_vendors = 0;
    $user->can_areas_and_markets = 0;
    $user->can_stock_management = 0;
    $user->can_products = 0;
    $user->can_stock_in = 0;
    $user->can_stock_out = 0;
    $user->can_special_discounts = 0;
    $user->can_categories = 0;
    $user->can_brands = 0;
    $user->can_units = 0;
    $user->can_accounting = 0;
    $user->can_customer_ledgers = 0;
    $user->can_vendor_ledgers = 0;
    $user->can_sales_ledgers = 0;
    $user->can_receipts = 0;
    $user->can_receipt_logs = 0;
    $user->can_payments = 0;
    $user->can_expenses = 0;
    $user->can_expense_ledgers = 0;
    $user->can_order_management = 0;
    $user->can_orders = 0;
    $user->can_invoices = 0;
    $user->can_marketing_plan = 0;
    $user->can_marketing_tasks = 0;
    $user->can_security_shell = 0;
    $user->can_user_management = 0;
    $user->can_staff = 0;
    $user->can_riders = 0;
    // -----------------------------------------
    $user->can_add_customers = 0;
    $user->can_edit_customers = 0;
    $user->can_view_customers = 0;
    $user->can_delete_customers = 0;
    $user->can_excel_customers = 0;
    $user->can_add_vendors = 0;
    $user->can_edit_vendors = 0;
    $user->can_view_vendors = 0;
    $user->can_delete_vendors = 0;
    $user->can_excel_vendors = 0;
    $user->can_add_areas = 0;
    $user->can_edit_areas = 0;
    $user->can_delete_areas = 0;
    $user->can_add_products = 0;
    $user->can_edit_products = 0;
    $user->can_view_products = 0;
    $user->can_delete_products = 0;
    $user->can_excel_products = 0;
    $user->can_add_stock_ins = 0;
    $user->can_edit_stock_ins = 0;
    $user->can_delete_stock_ins = 0;
    $user->can_add_stock_outs = 0;
    $user->can_edit_stock_outs = 0;
    $user->can_delete_stock_outs = 0;
    $user->can_add_categories = 0;
    $user->can_edit_categories = 0;
    $user->can_delete_categories = 0;
    $user->can_add_brands = 0;
    $user->can_edit_brands = 0;
    $user->can_delete_brands = 0;
    $user->can_add_units = 0;
    $user->can_edit_units = 0;
    $user->can_delete_units = 0;
    $user->can_add_receivings = 0;
    $user->can_edit_receivings = 0;
    $user->can_delete_receivings = 0;
    $user->can_add_payments = 0;
    $user->can_edit_payments = 0;
    $user->can_delete_payments = 0;
    $user->can_add_expenses = 0;
    $user->can_edit_expenses = 0;
    $user->can_delete_expenses = 0;
    $user->can_add_orders = 0;
    $user->can_edit_orders = 0;
    $user->can_view_orders = 0;
    $user->can_delete_orders = 0;
    $user->can_excel_orders = 0;
    $user->can_invoice_orders = 0;
    $user->can_add_invoices = 0;
    $user->can_edit_invoices = 0;
    $user->can_view_invoices = 0;
    $user->can_delete_invoices = 0;
    $user->can_print_invoices = 0;
    $user->can_add_users = 0;
    $user->can_edit_users = 0;
    $user->can_delete_users = 0;

    $user->saveQuietly();
    return 0;
}

function set_basic_rights($user_id){
    $user = User::find($user_id);
    if(!$user){
        return 0;
    }

    // revoke all rights first
    revoke_all_rights($user_id);

    $user->can_client_database = 1;
    $user->can_customers = 1;
    $user->can_areas_and_markets = 1;
    $user->can_stock_management = 1;
    $user->can_products = 1;
    $user->can_categories = 1;
    $user->can_brands = 1;
    $user->can_units = 1;
    $user->can_accounting = 1;
    $user->can_customer_ledgers = 1;
    $user->can_receipts = 1;
    $user->can_order_management = 1;
    $user->can_orders = 1;
    $user->can_marketing_tasks = 1;
    // -----------------------------------------
    $user->can_add_customers = 1;
    $user->can_view_customers = 1;
    $user->can_excel_customers = 1;
    $user->can_add_areas = 1;
    $user->can_add_products = 1;
    $user->can_view_products = 1;
    $user->can_excel_products = 1;
    $user->can_add_categories = 1;
    $user->can_add_brands = 1;
    $user->can_add_units = 1;
    $user->can_add_receivings = 1;
    $user->can_add_orders = 1;
    $user->can_view_orders = 1;
    $user->can_excel_orders = 1;
    $user->can_invoice_orders = 1;

    $user->saveQuietly();
}

function set_user_rights($user_id){
    $user = User::find($user_id);
    if(!$user){
        return 0;
    }

    // revoke all rights first
    revoke_all_rights($user_id);

    $user->can_dashboard = 1;
    $user->can_client_database = 1;
    $user->can_customers = 1;
    $user->can_vendors = 1;
    $user->can_areas_and_markets = 1;
    $user->can_stock_management = 1;
    $user->can_products = 1;
    $user->can_stock_in = 1;
    $user->can_categories = 1;
    $user->can_brands = 1;
    $user->can_units = 1;
    $user->can_accounting = 1;
    $user->can_customer_ledgers = 1;
    $user->can_sales_ledgers = 1;
    $user->can_receipts = 1;
    $user->can_receipt_logs = 1;
    $user->can_payments = 1;
    $user->can_order_management = 1;
    $user->can_orders = 1;
    $user->can_invoices = 1;
    $user->can_marketing_tasks = 1;
    // -----------------------------------------
    $user->can_add_customers = 1;
    $user->can_view_customers = 1;
    $user->can_excel_customers = 1;
    $user->can_add_vendors = 1;
    $user->can_edit_vendors = 1;
    $user->can_view_vendors = 1;
    $user->can_delete_vendors = 1;
    $user->can_excel_vendors = 1;
    $user->can_add_areas = 1;
    $user->can_add_products = 1;
    $user->can_view_products = 1;
    $user->can_excel_products = 1;
    $user->can_add_stock_ins = 1;
    $user->can_edit_stock_ins = 1;
    $user->can_delete_stock_ins = 1;
    $user->can_add_categories = 1;
    $user->can_add_brands = 1;
    $user->can_add_units = 1;
    $user->can_add_receivings = 1;
    $user->can_add_payments = 1;
    $user->can_edit_payments = 1;
    $user->can_delete_payments = 1;
    $user->can_add_orders = 1;
    $user->can_view_orders = 1;
    $user->can_excel_orders = 1;
    $user->can_invoice_orders = 1;
    $user->can_add_invoices = 1;
    $user->can_view_invoices = 1;
    $user->can_print_invoices = 1;

    $user->saveQuietly();
    return 0;
}

function set_superadmin_rights($user_id){
    $user = User::find($user_id);
    if(!$user){
        return 0;
    }

    $user->can_dashboard = 1;
    $user->can_client_database = 1;
    $user->can_customers = 1;
    $user->can_customer_schedule = 1;
    $user->can_vendors = 1;
    $user->can_areas_and_markets = 1;
    $user->can_stock_management = 1;
    $user->can_products = 1;
    $user->can_stock_in = 1;
    $user->can_stock_out = 1;
    $user->can_special_discounts = 1;
    $user->can_categories = 1;
    $user->can_brands = 1;
    $user->can_units = 1;
    $user->can_accounting = 1;
    $user->can_customer_ledgers = 1;
    $user->can_vendor_ledgers = 1;
    $user->can_sales_ledgers = 1;
    $user->can_receipts = 1;
    $user->can_receipt_logs = 1;
    $user->can_payments = 1;
    $user->can_expenses = 1;
    $user->can_expense_ledgers = 1;
    $user->can_order_management = 1;
    $user->can_orders = 1;
    $user->can_invoices = 1;
    $user->can_marketing_plan = 1;
    $user->can_marketing_tasks = 1;
    $user->can_security_shell = 1;
    $user->can_user_management = 1;
    $user->can_staff = 1;
    $user->can_riders = 1;
    // -----------------------------------------
    $user->can_add_customers = 1;
    $user->can_edit_customers = 1;
    $user->can_view_customers = 1;
    $user->can_delete_customers = 1;
    $user->can_excel_customers = 1;
    $user->can_add_vendors = 1;
    $user->can_edit_vendors = 1;
    $user->can_view_vendors = 1;
    $user->can_delete_vendors = 1;
    $user->can_excel_vendors = 1;
    $user->can_add_areas = 1;
    $user->can_edit_areas = 1;
    $user->can_delete_areas = 1;
    $user->can_add_products = 1;
    $user->can_edit_products = 1;
    $user->can_view_products = 1;
    $user->can_delete_products = 1;
    $user->can_excel_products = 1;
    $user->can_add_stock_ins = 1;
    $user->can_edit_stock_ins = 1;
    $user->can_delete_stock_ins = 1;
    $user->can_add_stock_outs = 1;
    $user->can_edit_stock_outs = 1;
    $user->can_delete_stock_outs = 1;
    $user->can_add_categories = 1;
    $user->can_edit_categories = 1;
    $user->can_delete_categories = 1;
    $user->can_add_brands = 1;
    $user->can_edit_brands = 1;
    $user->can_delete_brands = 1;
    $user->can_add_units = 1;
    $user->can_edit_units = 1;
    $user->can_delete_units = 1;
    $user->can_add_receivings = 1;
    $user->can_edit_receivings = 1;
    $user->can_delete_receivings = 1;
    $user->can_add_payments = 1;
    $user->can_edit_payments = 1;
    $user->can_delete_payments = 1;
    $user->can_add_expenses = 1;
    $user->can_edit_expenses = 1;
    $user->can_delete_expenses = 1;
    $user->can_add_orders = 1;
    $user->can_edit_orders = 1;
    $user->can_view_orders = 1;
    $user->can_delete_orders = 1;
    $user->can_excel_orders = 1;
    $user->can_invoice_orders = 1;
    $user->can_add_invoices = 1;
    $user->can_edit_invoices = 1;
    $user->can_view_invoices = 1;
    $user->can_delete_invoices = 1;
    $user->can_print_invoices = 1;
    $user->can_add_users = 1;
    $user->can_edit_users = 1;
    $user->can_delete_users = 1;

    $user->saveQuietly();
    return 0;
}