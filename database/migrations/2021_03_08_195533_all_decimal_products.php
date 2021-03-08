<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllDecimalProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('purchase_price', 20,2)->nullable()->change();
            $table->decimal('consumer_selling_price', 20,2)->nullable()->change();
            $table->decimal('retailer_selling_price', 20,2)->nullable()->change();
            $table->decimal('opening_quantity', 20,2)->nullable()->change();
            $table->decimal('moq', 20,2)->nullable()->change();
            $table->decimal('quantity_in_hand', 20,2)->nullable()->change();
            $table->decimal('cost_value', 20,2)->nullable()->change();
            $table->decimal('sales_value', 20,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
