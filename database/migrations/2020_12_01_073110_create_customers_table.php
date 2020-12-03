<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('market_id');
            $table->bigInteger('business_to_date')->nullable();
            $table->bigInteger('outstanding_balance')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('floor')->nullable();
            $table->string('shop_name')->nullable();
            $table->string('shop_number')->nullable();
            $table->string('shop_picture')->nullable();
            $table->string('shop_keeper_picture')->nullable();
            $table->longText('payment_terms')->nullable();
            $table->string('cash_on_delivery')->nullable();
            $table->string('visiting_days')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('opening_balance')->nullable();
            $table->bigInteger('special_discount')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
