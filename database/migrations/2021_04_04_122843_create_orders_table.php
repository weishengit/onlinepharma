<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('status');
            $table->string('message')->nullable();
            $table->string('customer');
            $table->string('address');
            $table->string('contact');
            $table->string('scid');
            $table->string('scid_image');
            $table->string('prescription_image');
            $table->string('cashier');
            $table->string('delivery_mode');
            $table->integer('total_items');
            $table->string('vatable_sale');
            $table->string('vat_ammount');
            $table->string('vat_exempt');
            $table->string('zero_rated');
            $table->string('subtotal');
            $table->integer('is_sc');
            $table->string('sc_discount');
            $table->string('other_discount_rate');
            $table->string('other_discount');
            $table->string('amount_due');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
