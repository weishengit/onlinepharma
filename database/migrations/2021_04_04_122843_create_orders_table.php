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
            $table->id();
            $table->foreignId('user_id');
            $table->string('status');
            $table->string('ref_no');
            $table->string('message')->nullable();
            $table->string('customer')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('scid')->nullable();
            $table->string('scid_image')->nullable();
            $table->string('prescription_image')->nullable();
            $table->string('cashier')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->integer('delivery_fee')->nullable();
            $table->integer('total_items')->nullable();
            $table->decimal('vatable_sale')->nullable();
            $table->decimal('vat_amount')->nullable();
            $table->decimal('vat_exempt')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->integer('is_sc')->nullable();
            $table->decimal('sc_discount')->nullable();
            $table->decimal('other_discount_rate')->nullable();
            $table->string('other_discount')->nullable();
            $table->decimal('amount_due')->nullable();
            $table->integer('is_void');
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
