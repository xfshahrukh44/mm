<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function($user)
        {
            return $user->type === 'superadmin';
        });

        Gate::define('isRider', function($user)
        {
            return $user->type === 'rider';
        });

        Gate::define('isUser', function($user)
        {
            return $user->type === 'user';
        });

        // permissions
        Gate::define('can_dashboard', function($user)
        {
            return $user->can_dashboard === 1;
        });

        Gate::define('can_client_database', function($user)
        {
            return $user->can_client_database === 1;
        });

        Gate::define('can_customers', function($user)
        {
            return $user->can_customers === 1;
        });

        Gate::define('can_customer_schedule', function($user)
        {
            return $user->can_customer_schedule === 1;
        });

        Gate::define('can_vendors', function($user)
        {
            return $user->can_vendors === 1;
        });

        Gate::define('can_areas_and_markets', function($user)
        {
            return $user->can_areas_and_markets === 1;
        });

        Gate::define('can_stock_management', function($user)
        {
            return $user->can_stock_management === 1;
        });

        Gate::define('can_products', function($user)
        {
            return $user->can_products === 1;
        });

        Gate::define('can_stock_in', function($user)
        {
            return $user->can_stock_in === 1;
        });

        Gate::define('can_stock_out', function($user)
        {
            return $user->can_stock_out === 1;
        });

        Gate::define('can_special_discounts', function($user)
        {
            return $user->can_special_discounts === 1;
        });

        Gate::define('can_categories', function($user)
        {
            return $user->can_categories === 1;
        });

        Gate::define('can_brands', function($user)
        {
            return $user->can_brands === 1;
        });

        Gate::define('can_units', function($user)
        {
            return $user->can_units === 1;
        });

        Gate::define('can_accounting', function($user)
        {
            return $user->can_accounting === 1;
        });

        Gate::define('can_customer_ledgers', function($user)
        {
            return $user->can_customer_ledgers === 1;
        });

        Gate::define('can_vendor_ledgers', function($user)
        {
            return $user->can_vendor_ledgers === 1;
        });

        Gate::define('can_sales_ledgers', function($user)
        {
            return $user->can_sales_ledgers === 1;
        });

        Gate::define('can_receipts', function($user)
        {
            return $user->can_receipts === 1;
        });

        Gate::define('can_receipt_logs', function($user)
        {
            return $user->can_receipt_logs === 1;
        });

        Gate::define('can_payments', function($user)
        {
            return $user->can_payments === 1;
        });

        Gate::define('can_expenses', function($user)
        {
            return $user->can_expenses === 1;
        });

        Gate::define('can_expense_ledgers', function($user)
        {
            return $user->can_expense_ledgers === 1;
        });

        Gate::define('can_order_management', function($user)
        {
            return $user->can_order_management === 1;
        });

        Gate::define('can_orders', function($user)
        {
            return $user->can_orders === 1;
        });

        Gate::define('can_invoices', function($user)
        {
            return $user->can_invoices === 1;
        });

        Gate::define('can_marketing_plan', function($user)
        {
            return $user->can_marketing_plan === 1;
        });

        Gate::define('can_marketing_tasks', function($user)
        {
            return $user->can_marketing_tasks === 1;
        });

        Gate::define('can_security_shell', function($user)
        {
            return $user->can_security_shell === 1;
        });

        Gate::define('can_user_management', function($user)
        {
            return $user->can_user_management === 1;
        });

        Gate::define('can_staff', function($user)
        {
            return $user->can_staff === 1;
        });

        Gate::define('can_riders', function($user)
        {
            return $user->can_riders === 1;
        });
        // ----------------------------------------------------------------------------------------------------------------
        // ----------------------------------------------------------------------------------------------------------------
        // ----------------------------------------------------------------------------------------------------------------
        // ----------------------------------------------------------------------------------------------------------------
        Gate::define('can_add_customers', function($user)
        {
            return $user->can_add_customers === 1;
        });

        Gate::define('can_edit_customers', function($user)
        {
            return $user->can_edit_customers === 1;
        });

        Gate::define('can_view_customers', function($user)
        {
            return $user->can_view_customers === 1;
        });

        Gate::define('can_delete_customers', function($user)
        {
            return $user->can_delete_customers === 1;
        });

        Gate::define('can_excel_customers', function($user)
        {
            return $user->can_excel_customers === 1;
        });

        Gate::define('can_add_vendors', function($user)
        {
            return $user->can_add_vendors === 1;
        });

        Gate::define('can_edit_vendors', function($user)
        {
            return $user->can_edit_vendors === 1;
        });

        Gate::define('can_view_vendors', function($user)
        {
            return $user->can_view_vendors === 1;
        });

        Gate::define('can_delete_vendors', function($user)
        {
            return $user->can_delete_vendors === 1;
        });

        Gate::define('can_excel_vendors', function($user)
        {
            return $user->can_excel_vendors === 1;
        });

        Gate::define('can_add_areas', function($user)
        {
            return $user->can_add_areas === 1;
        });

        Gate::define('can_edit_areas', function($user)
        {
            return $user->can_edit_areas === 1;
        });

        Gate::define('can_delete_areas', function($user)
        {
            return $user->can_delete_areas === 1;
        });

        Gate::define('can_add_products', function($user)
        {
            return $user->can_add_products === 1;
        });

        Gate::define('can_edit_products', function($user)
        {
            return $user->can_edit_products === 1;
        });

        Gate::define('can_view_products', function($user)
        {
            return $user->can_view_products === 1;
        });

        Gate::define('can_delete_products', function($user)
        {
            return $user->can_delete_products === 1;
        });

        Gate::define('can_excel_products', function($user)
        {
            return $user->can_excel_products === 1;
        });

        Gate::define('can_add_stock_ins', function($user)
        {
            return $user->can_add_stock_ins === 1;
        });

        Gate::define('can_edit_stock_ins', function($user)
        {
            return $user->can_edit_stock_ins === 1;
        });

        Gate::define('can_delete_stock_ins', function($user)
        {
            return $user->can_delete_stock_ins === 1;
        });

        Gate::define('can_add_stock_outs', function($user)
        {
            return $user->can_add_stock_outs === 1;
        });

        Gate::define('can_edit_stock_outs', function($user)
        {
            return $user->can_edit_stock_outs === 1;
        });

        Gate::define('can_delete_stock_outs', function($user)
        {
            return $user->can_delete_stock_outs === 1;
        });

        Gate::define('can_add_categories', function($user)
        {
            return $user->can_add_categories === 1;
        });

        Gate::define('can_edit_categories', function($user)
        {
            return $user->can_edit_categories === 1;
        });

        Gate::define('can_delete_categories', function($user)
        {
            return $user->can_delete_categories === 1;
        });

        Gate::define('can_add_brands', function($user)
        {
            return $user->can_add_brands === 1;
        });

        Gate::define('can_edit_brands', function($user)
        {
            return $user->can_edit_brands === 1;
        });

        Gate::define('can_delete_brands', function($user)
        {
            return $user->can_delete_brands === 1;
        });

        Gate::define('can_add_units', function($user)
        {
            return $user->can_add_units === 1;
        });

        Gate::define('can_edit_units', function($user)
        {
            return $user->can_edit_units === 1;
        });

        Gate::define('can_delete_units', function($user)
        {
            return $user->can_delete_units === 1;
        });

        Gate::define('can_add_receivings', function($user)
        {
            return $user->can_add_receivings === 1;
        });

        Gate::define('can_edit_receivings', function($user)
        {
            return $user->can_edit_receivings === 1;
        });

        Gate::define('can_delete_receivings', function($user)
        {
            return $user->can_delete_receivings === 1;
        });

        Gate::define('can_add_payments', function($user)
        {
            return $user->can_add_payments === 1;
        });

        Gate::define('can_edit_payments', function($user)
        {
            return $user->can_edit_payments === 1;
        });

        Gate::define('can_delete_payments', function($user)
        {
            return $user->can_delete_payments === 1;
        });

        Gate::define('can_add_expenses', function($user)
        {
            return $user->can_add_expenses === 1;
        });

        Gate::define('can_edit_expenses', function($user)
        {
            return $user->can_edit_expenses === 1;
        });

        Gate::define('can_delete_expenses', function($user)
        {
            return $user->can_delete_expenses === 1;
        });

        Gate::define('can_add_orders', function($user)
        {
            return $user->can_add_orders === 1;
        });

        Gate::define('can_edit_orders', function($user)
        {
            return $user->can_edit_orders === 1;
        });

        Gate::define('can_view_orders', function($user)
        {
            return $user->can_view_orders === 1;
        });

        Gate::define('can_delete_orders', function($user)
        {
            return $user->can_delete_orders === 1;
        });

        Gate::define('can_excel_orders', function($user)
        {
            return $user->can_excel_orders === 1;
        });

        Gate::define('can_invoice_orders', function($user)
        {
            return $user->can_invoice_orders === 1;
        });

        Gate::define('can_add_invoices', function($user)
        {
            return $user->can_add_invoices === 1;
        });

        Gate::define('can_edit_invoices', function($user)
        {
            return $user->can_edit_invoices === 1;
        });

        Gate::define('can_view_invoices', function($user)
        {
            return $user->can_view_invoices === 1;
        });

        Gate::define('can_delete_invoices', function($user)
        {
            return $user->can_delete_invoices === 1;
        });

        Gate::define('can_print_invoices', function($user)
        {
            return $user->can_print_invoices === 1;
        });

        Gate::define('can_add_users', function($user)
        {
            return $user->can_add_users === 1;
        });

        Gate::define('can_edit_users', function($user)
        {
            return $user->can_edit_users === 1;
        });

        Gate::define('can_delete_users', function($user)
        {
            return $user->can_delete_users === 1;
        });
    }
}
