<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersPermissionColumns2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
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
            $table->integer('can_add_customers')->nullable()->default(0);
            $table->integer('can_edit_customers')->nullable()->default(0);
            $table->integer('can_view_customers')->nullable()->default(0);
            $table->integer('can_delete_customers')->nullable()->default(0);
            $table->integer('can_excel_customers')->nullable()->default(0);
            $table->integer('can_add_vendors')->nullable()->default(0);
            $table->integer('can_edit_vendors')->nullable()->default(0);
            $table->integer('can_view_vendors')->nullable()->default(0);
            $table->integer('can_delete_vendors')->nullable()->default(0);
            $table->integer('can_excel_vendors')->nullable()->default(0);
            $table->integer('can_add_areas')->nullable()->default(0);
            $table->integer('can_edit_areas')->nullable()->default(0);
            $table->integer('can_delete_areas')->nullable()->default(0);
            $table->integer('can_add_products')->nullable()->default(0);
            $table->integer('can_edit_products')->nullable()->default(0);
            $table->integer('can_view_products')->nullable()->default(0);
            $table->integer('can_delete_products')->nullable()->default(0);
            $table->integer('can_excel_products')->nullable()->default(0);
            $table->integer('can_add_stock_ins')->nullable()->default(0);
            $table->integer('can_edit_stock_ins')->nullable()->default(0);
            $table->integer('can_delete_stock_ins')->nullable()->default(0);
            $table->integer('can_add_stock_outs')->nullable()->default(0);
            $table->integer('can_edit_stock_outs')->nullable()->default(0);
            $table->integer('can_delete_stock_outs')->nullable()->default(0);
            $table->integer('can_add_categories')->nullable()->default(0);
            $table->integer('can_edit_categories')->nullable()->default(0);
            $table->integer('can_delete_categories')->nullable()->default(0);
            $table->integer('can_add_brands')->nullable()->default(0);
            $table->integer('can_edit_brands')->nullable()->default(0);
            $table->integer('can_delete_brands')->nullable()->default(0);
            $table->integer('can_add_units')->nullable()->default(0);
            $table->integer('can_edit_units')->nullable()->default(0);
            $table->integer('can_delete_units')->nullable()->default(0);
            $table->integer('can_add_receivings')->nullable()->default(0);
            $table->integer('can_edit_receivings')->nullable()->default(0);
            $table->integer('can_delete_receivings')->nullable()->default(0);
            $table->integer('can_add_payments')->nullable()->default(0);
            $table->integer('can_edit_payments')->nullable()->default(0);
            $table->integer('can_delete_payments')->nullable()->default(0);
            $table->integer('can_add_expenses')->nullable()->default(0);
            $table->integer('can_edit_expenses')->nullable()->default(0);
            $table->integer('can_delete_expenses')->nullable()->default(0);
            $table->integer('can_add_orders')->nullable()->default(0);
            $table->integer('can_edit_orders')->nullable()->default(0);
            $table->integer('can_view_orders')->nullable()->default(0);
            $table->integer('can_delete_orders')->nullable()->default(0);
            $table->integer('can_excel_orders')->nullable()->default(0);
            $table->integer('can_invoice_orders')->nullable()->default(0);
            $table->integer('can_add_invoices')->nullable()->default(0);
            $table->integer('can_edit_invoices')->nullable()->default(0);
            $table->integer('can_view_invoices')->nullable()->default(0);
            $table->integer('can_delete_invoices')->nullable()->default(0);
            $table->integer('can_print_invoices')->nullable()->default(0);
            $table->integer('can_add_users')->nullable()->default(0);
            $table->integer('can_edit_users')->nullable()->default(0);
            $table->integer('can_delete_users')->nullable()->default(0);
        });
    }
}
