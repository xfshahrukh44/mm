<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersPermissionColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('can_dashboard')->nullable()->default(0);
            $table->integer('can_client_database')->nullable()->default(0);
            $table->integer('can_customers')->nullable()->default(0);
            $table->integer('can_customer_schedule')->nullable()->default(0);
            $table->integer('can_vendors')->nullable()->default(0);
            $table->integer('can_areas_and_markets')->nullable()->default(0);
            $table->integer('can_stock_management')->nullable()->default(0);
            $table->integer('can_products')->nullable()->default(0);
            $table->integer('can_stock_in')->nullable()->default(0);
            $table->integer('can_stock_out')->nullable()->default(0);
            $table->integer('can_special_discounts')->nullable()->default(0);
            $table->integer('can_categories')->nullable()->default(0);
            $table->integer('can_brands')->nullable()->default(0);
            $table->integer('can_units')->nullable()->default(0);
            $table->integer('can_accounting')->nullable()->default(0);
            $table->integer('can_customer_ledgers')->nullable()->default(0);
            $table->integer('can_vendor_ledgers')->nullable()->default(0);
            $table->integer('can_sales_ledgers')->nullable()->default(0);
            $table->integer('can_receipts')->nullable()->default(0);
            $table->integer('can_receipt_logs')->nullable()->default(0);
            $table->integer('can_payments')->nullable()->default(0);
            $table->integer('can_expenses')->nullable()->default(0);
            $table->integer('can_expense_ledgers')->nullable()->default(0);
            $table->integer('can_order_management')->nullable()->default(0);
            $table->integer('can_orders')->nullable()->default(0);
            $table->integer('can_invoices')->nullable()->default(0);
            $table->integer('can_marketing_plan')->nullable()->default(0);
            $table->integer('can_marketing_tasks')->nullable()->default(0);
            $table->integer('can_security_shell')->nullable()->default(0);
            $table->integer('can_user_management')->nullable()->default(0);
            $table->integer('can_staff')->nullable()->default(0);
            $table->integer('can_riders')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
