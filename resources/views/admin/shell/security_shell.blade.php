@extends('admin.layouts.master')

@section('content_header')
<style>
.modal-body {
    overflow : auto;
}
hr{
    margin-top: 0;
    margin-bottom: 4%;
}
</style>
@endsection

@section('content_body')

    <!-- markup to be injected -->
    <!-- search form -->
    <h2 class="text-center display-3">Security Shell</h2>
    <form action="enhanced-results.html" data-select2-id="13">
        <div class="row" data-select2-id="12">
            <div class="col-md-10 offset-md-1" data-select2-id="11">
                <div class="row" data-select2-id="10" style="border: 1px solid #dee2e6; border-radius: 8px; padding: 10px;">
                    <!-- User -->
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>User:</label>
                            <select class="form-control user_id" name="user_id">
                                <option value="">Select user</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Permission Preset -->
                    <div class="col-md-12 col-sm-12 preset_wrapper">
                        <div class="form-group">
                            <label>Permission Preset:</label>
                            <select class="form-control preset" name="preset">
                                <option value="">Select preset</option>
                                <option value="Rider">Rider</option>
                                <option value="User">User</option>
                                <option value="Superadmin">Superadmin</option>
                                <option value="Custom">Custom</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- permission section -->
    <section class="col-md-10 offset-md-1 permission_section">
        <form action="{{route('set_rights')}}" class="row">
            @csrf
            <input type="hidden" class="hidden_user_id" name="hidden_user_id">

            <!-- Dashboard -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="fas fa-tachometer-alt "></i>
                    Dashboard
                    <input class="can_dashboard" type="checkbox" name="can_dashboard">
                </h3>
            </div>

            <!-- Client Database -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fas fa-users"></i>
                    Client Database
                    <input class="can_client_database" type="checkbox" name="can_client_database">
                </h3>
                <!-- Customers -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-users"></i>
                    Customers
                    <input class="can_customers" type="checkbox" name="can_customers">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_customers" type="checkbox" name="can_add_customers">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_customers" type="checkbox" name="can_edit_customers">
                </small>
                |
                <small>
                    View
                    <input class="can_view_customers" type="checkbox" name="can_view_customers">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_customers" type="checkbox" name="can_delete_customers">
                </small>
                |
                <small>
                    Excel
                    <input class="can_excel_customers" type="checkbox" name="can_excel_customers">
                </small>
                <hr>
                <!-- Customer Schedule -->
                <label>
                    <i class="nav-icon fas fa-users"></i>
                    Customer Schedule
                    <input class="can_customer_schedule" type="checkbox" name="can_customer_schedule">
                </label>
                <hr>
                <!-- Vendors -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-users"></i>
                    Vendors
                    <input class="can_vendors" type="checkbox" name="can_vendors">
                </label>
                <br>
                <small class="">
                    Add
                    <input class="can_add_vendors" type="checkbox" name="can_add_vendors">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_vendors" type="checkbox" name="can_edit_vendors">
                </small>
                |
                <small>
                    View
                    <input class="can_view_vendors" type="checkbox" name="can_view_vendors">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_vendors" type="checkbox" name="can_delete_vendors">
                </small>
                |
                <small>
                    Excel
                    <input class="can_excel_vendors" type="checkbox" name="can_excel_vendors">
                </small>
                <hr>
                <!-- Areas & Markets -->
                <label class="mb-0">
                    <i class="nav-icon  fas fa-map-marked-alt"></i>
                    Areas & Markets
                    <input class="can_areas_and_markets" type="checkbox" name="can_areas_and_markets">
                </label>
                <br>
                <small class="">
                    Add
                    <input class="can_add_areas" type="checkbox" name="can_add_areas">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_areas" type="checkbox" name="can_edit_areas">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_areas" type="checkbox" name="can_delete_areas">
                </small>
            </div>

            <!-- Stock Mgmt. -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fa fa-truck"></i>
                    Stock Mgmt.
                    <input class="can_stock_management" type="checkbox" name="can_stock_management">
                </h3>
                <!-- Products -->
                <label class="mb-0">
                    <i class="nav-icon fab fa-product-hunt"></i>
                    Products
                    <input class="can_products" type="checkbox" name="can_products">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_products" type="checkbox" name="can_add_products">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_products" type="checkbox" name="can_edit_products">
                </small>
                |
                <small>
                    View
                    <input class="can_view_products" type="checkbox" name="can_view_products">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_products" type="checkbox" name="can_delete_products">
                </small>
                |
                <small>
                    Excel
                    <input class="can_excel_products" type="checkbox" name="can_excel_products">
                </small>
                <hr>
                <!-- Stock In -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-sign-in-alt"></i>
                    Stock In
                    <input class="can_stock_in" type="checkbox" name="can_stock_in">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_stock_ins" type="checkbox" name="can_add_stock_ins">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_stock_ins" type="checkbox" name="can_edit_stock_ins">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_stock_ins" type="checkbox" name="can_delete_stock_ins">
                </small>
                <hr>
                <!-- Stock Out -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    Stock Out
                    <input class="can_stock_out" type="checkbox" name="can_stock_out">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_stock_outs" type="checkbox" name="can_add_stock_outs">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_stock_outs" type="checkbox" name="can_edit_stock_outs">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_stock_outs" type="checkbox" name="can_delete_stock_outs">
                </small>
                <hr>
                <!-- Special Discounts -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-percentage"></i>
                    Special Discounts
                    <input class="can_special_discounts" type="checkbox" name="can_special_discounts">
                </label>
                <hr>
                <!-- Categories -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-copyright"></i>
                    Categories
                    <input class="can_categories" type="checkbox" name="can_categories">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_categories" type="checkbox" name="can_add_categories">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_categories" type="checkbox" name="can_edit_categories">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_categories" type="checkbox" name="can_delete_categories">
                </small>
                <hr>
                <!-- Brands -->
                <label class="mb-0">
                    <i class="nav-icon fab fa-bootstrap"></i>
                    Brands
                    <input class="can_brands" type="checkbox" name="can_brands">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_brands" type="checkbox" name="can_add_brands">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_brands" type="checkbox" name="can_edit_brands">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_brands" type="checkbox" name="can_delete_brands">
                </small>
                <hr>
                <!-- Units -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-balance-scale-left"></i>
                    Units
                    <input class="can_units" type="checkbox" name="can_units">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_units" type="checkbox" name="can_add_units">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_units" type="checkbox" name="can_edit_units">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_units" type="checkbox" name="can_delete_units">
                </small>
            </div>

            <!-- Accounting -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fas fa-money-check-alt"></i>
                    Accounting
                    <input class="can_accounting" type="checkbox" name="can_accounting">
                </h3>
                <!-- Customer Ledgers -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Customer Ledgers
                    <input class="can_customer_ledgers" type="checkbox" name="can_customer_ledgers">
                </label>
                <hr>
                <!-- Vendor Ledgers -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Vendor Ledgers
                    <input class="can_vendor_ledgers" type="checkbox" name="can_vendor_ledgers">
                </label>
                <hr>
                <!-- Sales Ledgers -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Sales Ledgers
                    <input class="can_sales_ledgers" type="checkbox" name="can_sales_ledgers">
                </label>
                <hr>
                <!-- Receipts -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Receipts
                    <input class="can_receipts" type="checkbox" name="can_receipts">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_receivings" type="checkbox" name="can_add_receivings">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_receivings" type="checkbox" name="can_edit_receivings">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_receivings" type="checkbox" name="can_delete_receivings">
                </small>
                <hr>
                <!-- Receipt Logs -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Receipt Logs
                    <input class="can_receipt_logs" type="checkbox" name="can_receipt_logs">
                </label>
                <hr>
                <!-- Payments -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Payments
                    <input class="can_payments" type="checkbox" name="can_payments">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_payments" type="checkbox" name="can_add_payments">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_payments" type="checkbox" name="can_edit_payments">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_payments" type="checkbox" name="can_delete_payments">
                </small>
                <hr>
                <!-- Expenses -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Expenses
                    <input class="can_expenses" type="checkbox" name="can_expenses">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_expenses" type="checkbox" name="can_add_expenses">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_expenses" type="checkbox" name="can_edit_expenses">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_expenses" type="checkbox" name="can_delete_expenses">
                </small>
                <hr>
                <!-- Expense Ledgers -->
                <label class="mb-0">
                    <i class="fas fa-book nav-icon"></i>
                    Expense Ledgers
                    <input class="can_expense_ledgers" type="checkbox" name="can_expense_ledgers">
                </label>
            </div>

            <!-- Order Mgmt. -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fa fa-clipboard"></i>
                    Order Mgmt.
                    <input class="can_order_management" type="checkbox" name="can_order_management">
                </h3>
                <!-- Orders -->
                <label class="mb-0">
                    <i class="nav-icon fa fa-clipboard"></i>
                    Orders
                    <input class="can_orders" type="checkbox" name="can_orders">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_orders" type="checkbox" name="can_add_orders">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_orders" type="checkbox" name="can_edit_orders">
                </small>
                |
                <small>
                    View
                    <input class="can_view_orders" type="checkbox" name="can_view_orders">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_orders" type="checkbox" name="can_delete_orders">
                </small>
                |
                <small>
                    Excel
                    <input class="can_excel_orders" type="checkbox" name="can_excel_orders">
                </small>
                |
                <small>
                    Generate Invoice
                    <input class="can_invoice_orders" type="checkbox" name="can_invoice_orders">
                </small>
                <hr>
                <!-- Invoices -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    Invoices
                    <input class="can_invoices" type="checkbox" name="can_invoices">
                </label>
                <br>
                <small>
                    Add
                    <input class="can_add_invoices" type="checkbox" name="can_add_invoices">
                </small>
                |
                <small>
                    Edit
                    <input class="can_edit_invoices" type="checkbox" name="can_edit_invoices">
                </small>
                |
                <small>
                    View
                    <input class="can_view_invoices" type="checkbox" name="can_view_invoices">
                </small>
                |
                <small>
                    Delete
                    <input class="can_delete_invoices" type="checkbox" name="can_delete_invoices">
                </small>
                |
                <small>
                    Print
                    <input class="can_print_invoices" type="checkbox" name="can_print_invoices">
                </small>
            </div>

            <!-- Marketing Plan -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fa fa-cart-arrow-down"></i>
                    Marketing Plan
                    <input class="can_marketing_plan" type="checkbox" name="can_marketing_plan">
                </h3>
            </div>

            <!-- Marketing Tasks -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fas fa-tasks"></i>
                    Marketing Tasks
                    <input class="can_marketing_tasks" type="checkbox" name="can_marketing_tasks">
                </h3>
            </div>

            <!-- User Mgmt. -->
            <div class="form-group col-md-3">
                <h3>
                    <i class="nav-icon fas fa-user "></i>
                    User Mgmt.
                    <input class="can_user_management" type="checkbox" name="can_user_management">
                </h3>
                <!-- Staff -->
                <label class="mb-0">
                    <i class="nav-icon fas fa-users"></i>
                    Staff
                    <input class="can_staff" type="checkbox" name="can_staff">
                </label>
                <hr>
                <!-- Riders -->
                <label class="mb-0">
                    <i class="fas fa-motorcycle nav-icon"></i>
                    Riders
                    <input class="can_riders" type="checkbox" name="can_riders">
                </label>
                <hr>
                <label class="mb-0">
                    Add
                    <input class="can_add_users" type="checkbox" name="can_add_users">
                </label>
                <hr>
                <label class="mb-0">
                    Edit
                    <input class="can_edit_users" type="checkbox" name="can_edit_users">
                </label>
                <hr>
                <label class="mb-0">
                    Delete
                    <input class="can_delete_users" type="checkbox" name="can_delete_users">
                </label>
            </div>

            <!-- button -->
            <div class="col-md-11"></div>
            <button class="btn btn-primary float-right col-md-1" type="submit">Save</button>
        </form>
    </section>

    <script>
        $(document).ready(function(){
            // persistent active sidebar
            var element = $('li a[href*="'+ window.location.pathname +'"]');
            element.parent().addClass('menu-open');

            // hide elements
            $('.preset_wrapper').prop('hidden', true);
            $('.permission_section').prop('hidden', true);

            // global vars
            var user = "";

            // fetch_user
            function fetch_user(id){
                $.ajax({
                    url: "<?php echo(route('user.show', 1)); ?>",
                    type: 'GET',
                    async: false,
                    data: {id: id},
                    dataType: 'JSON',
                    success: function (data) {
                        user = data.user;
                        $('.preset_wrapper').prop('hidden', false);
                        $('.permission_section').prop('hidden', false);
                    },
                    error: function(){
                        $('.preset_wrapper').prop('hidden', true);
                        $('.permission_section').prop('hidden', true);
                    }
                });
            }

            // set rights(loaded users rights)
            function set_rights(){
                $('.can_dashboard').prop('checked', ((user.can_dashboard == 1) ? true : false));
                $('.can_client_database').prop('checked', ((user.can_client_database == 1) ? true : false));
                $('.can_customers').prop('checked', ((user.can_customers == 1) ? true : false));
                $('.can_customer_schedule').prop('checked', ((user.can_customer_schedule == 1) ? true : false));
                $('.can_vendors').prop('checked', ((user.can_vendors == 1) ? true : false));
                $('.can_areas_and_markets').prop('checked', ((user.can_areas_and_markets == 1) ? true : false));
                $('.can_stock_management').prop('checked', ((user.can_stock_management == 1) ? true : false));
                $('.can_products').prop('checked', ((user.can_products == 1) ? true : false));
                $('.can_stock_in').prop('checked', ((user.can_stock_in == 1) ? true : false));
                $('.can_stock_out').prop('checked', ((user.can_stock_out == 1) ? true : false));
                $('.can_special_discounts').prop('checked', ((user.can_special_discounts == 1) ? true : false));
                $('.can_categories').prop('checked', ((user.can_categories == 1) ? true : false));
                $('.can_brands').prop('checked', ((user.can_brands == 1) ? true : false));
                $('.can_units').prop('checked', ((user.can_units == 1) ? true : false));
                $('.can_accounting').prop('checked', ((user.can_accounting == 1) ? true : false));
                $('.can_customer_ledgers').prop('checked', ((user.can_customer_ledgers == 1) ? true : false));
                $('.can_vendor_ledgers').prop('checked', ((user.can_vendor_ledgers == 1) ? true : false));
                $('.can_sales_ledgers').prop('checked', ((user.can_sales_ledgers == 1) ? true : false));
                $('.can_receipts').prop('checked', ((user.can_receipts == 1) ? true : false));
                $('.can_receipt_logs').prop('checked', ((user.can_receipt_logs == 1) ? true : false));
                $('.can_payments').prop('checked', ((user.can_payments == 1) ? true : false));
                $('.can_expenses').prop('checked', ((user.can_expenses == 1) ? true : false));
                $('.can_expense_ledgers').prop('checked', ((user.can_expense_ledgers == 1) ? true : false));
                $('.can_order_management').prop('checked', ((user.can_order_management == 1) ? true : false));
                $('.can_orders').prop('checked', ((user.can_orders == 1) ? true : false));
                $('.can_invoices').prop('checked', ((user.can_invoices == 1) ? true : false));
                $('.can_marketing_plan').prop('checked', ((user.can_marketing_plan == 1) ? true : false));
                $('.can_marketing_tasks').prop('checked', ((user.can_marketing_tasks == 1) ? true : false));
                $('.can_user_management').prop('checked', ((user.can_user_management == 1) ? true : false));
                $('.can_staff').prop('checked', ((user.can_staff == 1) ? true : false));
                $('.can_riders').prop('checked', ((user.can_riders == 1) ? true : false));
                // ------------------------------------------------------------------------
                $('.can_add_customers').prop('checked', ((user.can_add_customers == 1) ? true : false));
                $('.can_edit_customers').prop('checked', ((user.can_edit_customers == 1) ? true : false));
                $('.can_view_customers').prop('checked', ((user.can_view_customers == 1) ? true : false));
                $('.can_delete_customers').prop('checked', ((user.can_delete_customers == 1) ? true : false));
                $('.can_excel_customers').prop('checked', ((user.can_excel_customers == 1) ? true : false));
                $('.can_add_vendors').prop('checked', ((user.can_add_vendors == 1) ? true : false));
                $('.can_edit_vendors').prop('checked', ((user.can_edit_vendors == 1) ? true : false));
                $('.can_view_vendors').prop('checked', ((user.can_view_vendors == 1) ? true : false));
                $('.can_delete_vendors').prop('checked', ((user.can_delete_vendors == 1) ? true : false));
                $('.can_excel_vendors').prop('checked', ((user.can_excel_vendors == 1) ? true : false));
                $('.can_add_areas').prop('checked', ((user.can_add_areas == 1) ? true : false));
                $('.can_edit_areas').prop('checked', ((user.can_edit_areas == 1) ? true : false));
                $('.can_delete_areas').prop('checked', ((user.can_delete_areas == 1) ? true : false));
                $('.can_add_products').prop('checked', ((user.can_add_products == 1) ? true : false));
                $('.can_edit_products').prop('checked', ((user.can_edit_products == 1) ? true : false));
                $('.can_view_products').prop('checked', ((user.can_view_products == 1) ? true : false));
                $('.can_delete_products').prop('checked', ((user.can_delete_products == 1) ? true : false));
                $('.can_excel_products').prop('checked', ((user.can_excel_products == 1) ? true : false));
                $('.can_add_stock_ins').prop('checked', ((user.can_add_stock_ins == 1) ? true : false));
                $('.can_edit_stock_ins').prop('checked', ((user.can_edit_stock_ins == 1) ? true : false));
                $('.can_delete_stock_ins').prop('checked', ((user.can_delete_stock_ins == 1) ? true : false));
                $('.can_add_stock_outs').prop('checked', ((user.can_add_stock_outs == 1) ? true : false));
                $('.can_edit_stock_outs').prop('checked', ((user.can_edit_stock_outs == 1) ? true : false));
                $('.can_delete_stock_outs').prop('checked', ((user.can_delete_stock_outs == 1) ? true : false));
                $('.can_add_categories').prop('checked', ((user.can_add_categories == 1) ? true : false));
                $('.can_edit_categories').prop('checked', ((user.can_edit_categories == 1) ? true : false));
                $('.can_delete_categories').prop('checked', ((user.can_delete_categories == 1) ? true : false));
                $('.can_add_brands').prop('checked', ((user.can_add_brands == 1) ? true : false));
                $('.can_edit_brands').prop('checked', ((user.can_edit_brands == 1) ? true : false));
                $('.can_delete_brands').prop('checked', ((user.can_delete_brands == 1) ? true : false));
                $('.can_add_units').prop('checked', ((user.can_add_units == 1) ? true : false));
                $('.can_edit_units').prop('checked', ((user.can_edit_units == 1) ? true : false));
                $('.can_delete_units').prop('checked', ((user.can_delete_units == 1) ? true : false));
                $('.can_add_receivings').prop('checked', ((user.can_add_receivings == 1) ? true : false));
                $('.can_edit_receivings').prop('checked', ((user.can_edit_receivings == 1) ? true : false));
                $('.can_delete_receivings').prop('checked', ((user.can_delete_receivings == 1) ? true : false));
                $('.can_add_payments').prop('checked', ((user.can_add_payments == 1) ? true : false));
                $('.can_edit_payments').prop('checked', ((user.can_edit_payments == 1) ? true : false));
                $('.can_delete_payments').prop('checked', ((user.can_delete_payments == 1) ? true : false));
                $('.can_add_expenses').prop('checked', ((user.can_add_expenses == 1) ? true : false));
                $('.can_edit_expenses').prop('checked', ((user.can_edit_expenses == 1) ? true : false));
                $('.can_delete_expenses').prop('checked', ((user.can_delete_expenses == 1) ? true : false));
                $('.can_add_orders').prop('checked', ((user.can_add_orders == 1) ? true : false));
                $('.can_edit_orders').prop('checked', ((user.can_edit_orders == 1) ? true : false));
                $('.can_view_orders').prop('checked', ((user.can_view_orders == 1) ? true : false));
                $('.can_delete_orders').prop('checked', ((user.can_delete_orders == 1) ? true : false));
                $('.can_excel_orders').prop('checked', ((user.can_excel_orders == 1) ? true : false));
                $('.can_invoice_orders').prop('checked', ((user.can_invoice_orders == 1) ? true : false));
                $('.can_add_invoices').prop('checked', ((user.can_add_invoices == 1) ? true : false));
                $('.can_edit_invoices').prop('checked', ((user.can_edit_invoices == 1) ? true : false));
                $('.can_view_invoices').prop('checked', ((user.can_view_invoices == 1) ? true : false));
                $('.can_delete_invoices').prop('checked', ((user.can_delete_invoices == 1) ? true : false));
                $('.can_print_invoices').prop('checked', ((user.can_print_invoices == 1) ? true : false));
                $('.can_add_users').prop('checked', ((user.can_add_users == 1) ? true : false));
                $('.can_edit_users').prop('checked', ((user.can_edit_users == 1) ? true : false));
                $('.can_delete_users').prop('checked', ((user.can_delete_users == 1) ? true : false));
            }

            function revoke_all_rights(){
                $('.can_dashboard').prop('checked', false);
                $('.can_client_database').prop('checked', false);
                $('.can_customers').prop('checked', false);
                $('.can_customer_schedule').prop('checked', false);
                $('.can_vendors').prop('checked', false);
                $('.can_areas_and_markets').prop('checked', false);
                $('.can_stock_management').prop('checked', false);
                $('.can_products').prop('checked', false);
                $('.can_stock_in').prop('checked', false);
                $('.can_stock_out').prop('checked', false);
                $('.can_special_discounts').prop('checked', false);
                $('.can_categories').prop('checked', false);
                $('.can_brands').prop('checked', false);
                $('.can_units').prop('checked', false);
                $('.can_accounting').prop('checked', false);
                $('.can_customer_ledgers').prop('checked', false);
                $('.can_vendor_ledgers').prop('checked', false);
                $('.can_sales_ledgers').prop('checked', false);
                $('.can_receipts').prop('checked', false);
                $('.can_receipt_logs').prop('checked', false);
                $('.can_payments').prop('checked', false);
                $('.can_expenses').prop('checked', false);
                $('.can_expense_ledgers').prop('checked', false);
                $('.can_order_management').prop('checked', false);
                $('.can_orders').prop('checked', false);
                $('.can_invoices').prop('checked', false);
                $('.can_marketing_plan').prop('checked', false);
                $('.can_marketing_tasks').prop('checked', false);
                $('.can_user_management').prop('checked', false);
                $('.can_staff').prop('checked', false);
                $('.can_riders').prop('checked', false);
                // -----------------------------------------------
                $('.can_add_customers').prop('checked', false);
                $('.can_edit_customers').prop('checked', false);
                $('.can_view_customers').prop('checked', false);
                $('.can_delete_customers').prop('checked', false);
                $('.can_excel_customers').prop('checked', false);
                $('.can_add_vendors').prop('checked', false);
                $('.can_edit_vendors').prop('checked', false);
                $('.can_view_vendors').prop('checked', false);
                $('.can_delete_vendors').prop('checked', false);
                $('.can_excel_vendors').prop('checked', false);
                $('.can_add_areas').prop('checked', false);
                $('.can_edit_areas').prop('checked', false);
                $('.can_delete_areas').prop('checked', false);
                $('.can_add_products').prop('checked', false);
                $('.can_edit_products').prop('checked', false);
                $('.can_view_products').prop('checked', false);
                $('.can_delete_products').prop('checked', false);
                $('.can_excel_products').prop('checked', false);
                $('.can_add_stock_ins').prop('checked', false);
                $('.can_edit_stock_ins').prop('checked', false);
                $('.can_delete_stock_ins').prop('checked', false);
                $('.can_add_stock_outs').prop('checked', false);
                $('.can_edit_stock_outs').prop('checked', false);
                $('.can_delete_stock_outs').prop('checked', false);
                $('.can_add_categories').prop('checked', false);
                $('.can_edit_categories').prop('checked', false);
                $('.can_delete_categories').prop('checked', false);
                $('.can_add_brands').prop('checked', false);
                $('.can_edit_brands').prop('checked', false);
                $('.can_delete_brands').prop('checked', false);
                $('.can_add_units').prop('checked', false);
                $('.can_edit_units').prop('checked', false);
                $('.can_delete_units').prop('checked', false);
                $('.can_add_receivings').prop('checked', false);
                $('.can_edit_receivings').prop('checked', false);
                $('.can_delete_receivings').prop('checked', false);
                $('.can_add_payments').prop('checked', false);
                $('.can_edit_payments').prop('checked', false);
                $('.can_delete_payments').prop('checked', false);
                $('.can_add_expenses').prop('checked', false);
                $('.can_edit_expenses').prop('checked', false);
                $('.can_delete_expenses').prop('checked', false);
                $('.can_add_orders').prop('checked', false);
                $('.can_edit_orders').prop('checked', false);
                $('.can_view_orders').prop('checked', false);
                $('.can_delete_orders').prop('checked', false);
                $('.can_excel_orders').prop('checked', false);
                $('.can_invoice_orders').prop('checked', false);
                $('.can_add_invoices').prop('checked', false);
                $('.can_edit_invoices').prop('checked', false);
                $('.can_view_invoices').prop('checked', false);
                $('.can_delete_invoices').prop('checked', false);
                $('.can_print_invoices').prop('checked', false);
                $('.can_add_users').prop('checked', false);
                $('.can_edit_users').prop('checked', false);
                $('.can_delete_users').prop('checked', false);
            }

            function set_rider_rights(){
                revoke_all_rights();

                $('.can_client_database').prop('checked', true);
                $('.can_customers').prop('checked', true);
                $('.can_areas_and_markets').prop('checked', true);
                $('.can_stock_management').prop('checked', true);
                $('.can_products').prop('checked', true);
                $('.can_categories').prop('checked', true);
                $('.can_brands').prop('checked', true);
                $('.can_units').prop('checked', true);
                $('.can_accounting').prop('checked', true);
                $('.can_customer_ledgers').prop('checked', true);
                $('.can_receipts').prop('checked', true);
                $('.can_order_management').prop('checked', true);
                $('.can_orders').prop('checked', true);
                $('.can_marketing_tasks').prop('checked', true);
                // ------------------------------
                $('.can_add_customers').prop('checked', true);
                $('.can_view_customers').prop('checked', true);
                $('.can_excel_customers').prop('checked', true);
                $('.can_add_areas').prop('checked', true);
                $('.can_add_products').prop('checked', true);
                $('.can_view_products').prop('checked', true);
                $('.can_excel_products').prop('checked', true);
                $('.can_add_categories').prop('checked', true);
                $('.can_add_brands').prop('checked', true);
                $('.can_add_units').prop('checked', true);
                $('.can_add_receivings').prop('checked', true);
                $('.can_add_orders').prop('checked', true);
                $('.can_view_orders').prop('checked', true);
                $('.can_excel_orders').prop('checked', true);
                $('.can_invoice_orders').prop('checked', true);
            }

            function set_user_rights(){
                revoke_all_rights();

                $('.can_dashboard').prop('checked', true);
                $('.can_client_database').prop('checked', true);
                $('.can_customers').prop('checked', true);
                $('.can_vendors').prop('checked', true);
                $('.can_areas_and_markets').prop('checked', true);
                $('.can_stock_management').prop('checked', true);
                $('.can_products').prop('checked', true);
                $('.can_stock_in').prop('checked', true);
                $('.can_categories').prop('checked', true);
                $('.can_brands').prop('checked', true);
                $('.can_units').prop('checked', true);
                $('.can_accounting').prop('checked', true);
                $('.can_customer_ledgers').prop('checked', true);
                $('.can_sales_ledgers').prop('checked', true);
                $('.can_receipts').prop('checked', true);
                $('.can_receipt_logs').prop('checked', true);
                $('.can_payments').prop('checked', true);
                $('.can_order_management').prop('checked', true);
                $('.can_orders').prop('checked', true);
                $('.can_invoices').prop('checked', true);
                $('.can_marketing_tasks').prop('checked', true);
                // ----------------------------------------
                $('.can_add_customers').prop('checked', true);
                $('.can_view_customers').prop('checked', true);
                $('.can_excel_customers').prop('checked', true);
                $('.can_add_vendors').prop('checked', true);
                $('.can_edit_vendors').prop('checked', true);
                $('.can_view_vendors').prop('checked', true);
                $('.can_delete_vendors').prop('checked', true);
                $('.can_excel_vendors').prop('checked', true);
                $('.can_add_areas').prop('checked', true);
                $('.can_add_products').prop('checked', true);
                $('.can_view_products').prop('checked', true);
                $('.can_excel_products').prop('checked', true);
                $('.can_add_stock_ins').prop('checked', true);
                $('.can_edit_stock_ins').prop('checked', true);
                $('.can_delete_stock_ins').prop('checked', true);
                $('.can_add_categories').prop('checked', true);
                $('.can_add_brands').prop('checked', true);
                $('.can_add_units').prop('checked', true);
                $('.can_add_receivings').prop('checked', true);
                $('.can_add_payments').prop('checked', true);
                $('.can_edit_payments').prop('checked', true);
                $('.can_delete_payments').prop('checked', true);
                $('.can_add_orders').prop('checked', true);
                $('.can_view_orders').prop('checked', true);
                $('.can_excel_orders').prop('checked', true);
                $('.can_invoice_orders').prop('checked', true);
                $('.can_add_invoices').prop('checked', true);
                $('.can_view_invoices').prop('checked', true);
                $('.can_print_invoices').prop('checked', true);
            }

            function set_superadmin_rights(){
                $('.can_dashboard').prop('checked', true);
                $('.can_client_database').prop('checked', true);
                $('.can_customers').prop('checked', true);
                $('.can_customer_schedule').prop('checked', true);
                $('.can_vendors').prop('checked', true);
                $('.can_areas_and_markets').prop('checked', true);
                $('.can_stock_management').prop('checked', true);
                $('.can_products').prop('checked', true);
                $('.can_stock_in').prop('checked', true);
                $('.can_stock_out').prop('checked', true);
                $('.can_special_discounts').prop('checked', true);
                $('.can_categories').prop('checked', true);
                $('.can_brands').prop('checked', true);
                $('.can_units').prop('checked', true);
                $('.can_accounting').prop('checked', true);
                $('.can_customer_ledgers').prop('checked', true);
                $('.can_vendor_ledgers').prop('checked', true);
                $('.can_sales_ledgers').prop('checked', true);
                $('.can_receipts').prop('checked', true);
                $('.can_receipt_logs').prop('checked', true);
                $('.can_payments').prop('checked', true);
                $('.can_expenses').prop('checked', true);
                $('.can_expense_ledgers').prop('checked', true);
                $('.can_order_management').prop('checked', true);
                $('.can_orders').prop('checked', true);
                $('.can_invoices').prop('checked', true);
                $('.can_marketing_plan').prop('checked', true);
                $('.can_marketing_tasks').prop('checked', true);
                $('.can_user_management').prop('checked', true);
                $('.can_staff').prop('checked', true);
                $('.can_riders').prop('checked', true);
                // -----------------------------------------------
                $('.can_add_customers').prop('checked', true);
                $('.can_edit_customers').prop('checked', true);
                $('.can_view_customers').prop('checked', true);
                $('.can_delete_customers').prop('checked', true);
                $('.can_excel_customers').prop('checked', true);
                $('.can_add_vendors').prop('checked', true);
                $('.can_edit_vendors').prop('checked', true);
                $('.can_view_vendors').prop('checked', true);
                $('.can_delete_vendors').prop('checked', true);
                $('.can_excel_vendors').prop('checked', true);
                $('.can_add_areas').prop('checked', true);
                $('.can_edit_areas').prop('checked', true);
                $('.can_delete_areas').prop('checked', true);
                $('.can_add_products').prop('checked', true);
                $('.can_edit_products').prop('checked', true);
                $('.can_view_products').prop('checked', true);
                $('.can_delete_products').prop('checked', true);
                $('.can_excel_products').prop('checked', true);
                $('.can_add_stock_ins').prop('checked', true);
                $('.can_edit_stock_ins').prop('checked', true);
                $('.can_delete_stock_ins').prop('checked', true);
                $('.can_add_stock_outs').prop('checked', true);
                $('.can_edit_stock_outs').prop('checked', true);
                $('.can_delete_stock_outs').prop('checked', true);
                $('.can_add_categories').prop('checked', true);
                $('.can_edit_categories').prop('checked', true);
                $('.can_delete_categories').prop('checked', true);
                $('.can_add_brands').prop('checked', true);
                $('.can_edit_brands').prop('checked', true);
                $('.can_delete_brands').prop('checked', true);
                $('.can_add_units').prop('checked', true);
                $('.can_edit_units').prop('checked', true);
                $('.can_delete_units').prop('checked', true);
                $('.can_add_receivings').prop('checked', true);
                $('.can_edit_receivings').prop('checked', true);
                $('.can_delete_receivings').prop('checked', true);
                $('.can_add_payments').prop('checked', true);
                $('.can_edit_payments').prop('checked', true);
                $('.can_delete_payments').prop('checked', true);
                $('.can_add_expenses').prop('checked', true);
                $('.can_edit_expenses').prop('checked', true);
                $('.can_delete_expenses').prop('checked', true);
                $('.can_add_orders').prop('checked', true);
                $('.can_edit_orders').prop('checked', true);
                $('.can_view_orders').prop('checked', true);
                $('.can_delete_orders').prop('checked', true);
                $('.can_excel_orders').prop('checked', true);
                $('.can_invoice_orders').prop('checked', true);
                $('.can_add_invoices').prop('checked', true);
                $('.can_edit_invoices').prop('checked', true);
                $('.can_view_invoices').prop('checked', true);
                $('.can_delete_invoices').prop('checked', true);
                $('.can_print_invoices').prop('checked', true);
                $('.can_add_users').prop('checked', true);
                $('.can_edit_users').prop('checked', true);
                $('.can_delete_users').prop('checked', true);
            }

            // on change functions
            // on user_id change
            $('.user_id').on('change', function(){
                fetch_user($(this).val());
                set_rights();
                // hidden_user_id
                $('.hidden_user_id').val($(this).val());
            });
            // on preset change
            $('.preset').on('change', function(){
                // rider
                if($(this).val() == "Rider"){
                    set_rider_rights();
                }
                // user
                if($(this).val() == "User"){
                    set_user_rights();
                }
                // superadmin
                if($(this).val() == "Superadmin"){
                    set_superadmin_rights();
                }
                // customer
                if($(this).val() == "Custom"){
                    revoke_all_rights();
                }
            });
        });
    </script>

@endsection('content_body')
